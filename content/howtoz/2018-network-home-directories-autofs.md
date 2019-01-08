

## Sieťové domáce adresáre v OS Linux


**FILE:** 2018-network-home-directories-autofs.md  
**DATE:** 01/2018  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1  



## 1 Úvod

Tento článoček pojednáva o automatickom pripájaní sieťových (CIFS) domácich adresárov užívateľov  k serveru (Server3) pomocou softvéru automounter (AUTOFS), pričom sieťové domáce adresáre bude poskytovať server (Server2) na ktorom bude prevádzkovaný softvér SAMBA. Sieťový domáci adresár užívateľa bude pripojený len po úspešnej kerberos autentizácii. Z uvedeného vyplýva, že užívatelia ako aj obe servery (Server2 a Server3) musia nejakým spôsobom vedieť pracovať s Kerberos tiketmi nakoľko pristupujúci server (Server3) využije Kerberos tiket užívateľa na autentizáciu voči SAMBA serveru (Server2). Najjednoduchším spôsobom ako to zabezpečit je zaradenie oboch serverov do Windows domény a užívateľov udržiavať v adresárovej službe Microsoft Active Directory. Z tohto dôvodu bude v riešení vystupovať aj Windows server (Server1) s nainštalovanou službou Microsoft Active Directory na ktorom bude vytvorená Windows doména **DOMENA.SK**. Pre testovacie účely bol ako operačný systém použitý RHEL 7.4.



## 2 Komponenty

**Server1 (Doménový radič)** - Tento server bude slúžiť ako Microsoft Active Directory server resp. ako doménovy radič (Domain Controller).

**Server2 (Súborový server)** - Tento server bude slúžiť ako sieťový server poskytujúci služby sieťových domácich adresárov pričom ako sieťový súborový systém bude použity CIFS (Common Internet File System). Pre zabezpečenie funkcie sieťových domácich adrésárov bude použitý softvér SAMBA. Tento server bude zaradený do Windows domény **DOMENA.SK**.

**Server3 (Užívateľský server)** - Na tento server sa pripájajú užívatelia systému pomocou protokolov SSH alebo SCP. Do tohto systému sa budú sieťové domáce adresára jednotlivých užívateľov pripájať. Pre zabezpečenie funkcie pripájania sieťových adresárov bude použitý softvér Automouner (AUTOFS). Tento server bude zaradený do Windows domény **DOMENA.SK**. Integráciu systému s Microsoft Active Directory bude zabezpečovať systémový softvér SSSD.

> **Poznámka1:** Inštalácia a konfigurácia Active Directory (Server1) nie je predmetom tohoto článku.

> **Poznámka2:** Inštalácia a konfigurácia integrácie Linux serverov s Microsoft Active Directory (softvér SSSD) nie je predmetom tohoto článku.   



## 3 Súborový server (Server2)


### 3.1 Inštalácia potrebného softvéru (SAMBA)

<pre>
# yum install samba
</pre>


### 3.2 Konfigurácia systému SAMBA

Vytvorenie adresárovej štruktúry pre domáce adresáre užívateľov.

<pre>
# mkdir -p /homedirs/user1
# mkdir -p /homedirs/user2
# mkdir -p /homedirs/User3
...
</pre>

Zmena oprávnení na domácich adresároch užívateľov.

<pre>
# chown user1:group /homedirs/user1
# chmod 0700 /homedirs/user1
# chown user2:group /homedirs/user2
# chmod 0700 /homedirs/user2
# chown user3:group /homedirs/user3
# chmod 0700 /homedirs/user3
...
</pre>

Konfigurácia softvéru SAMBA.

<pre>
# vi /etc/samba/smb.conf
-------------------------------------------------------------------------
[global]
        workgroup = DOMENA
        client signing = yes
        client use spnego = yes
        server signing = mandatory
        kerberos method = secrets and keytab
        log file = /var/log/samba/log.%m
        log level = 0
        realm = DOMENA.SK
        security = ads

[homedirs]
        comment = Users Network home directories
        path = /homedirs
        writable = yes
        read only = no
        force create mode = 0600
        create mask = 0700
        directory mask = 0700
        force directory mode = 0700
        access based share enum = yes
</pre>


Štart systému SAMBA.

<pre>
# systemctl start smb
</pre>

Zapnutie štartovania systému SAMBA po štarte OS.

<pre>
# systemctl enable smb
</pre>



## 4 Užívateľský Server (Server3) - Varianta1

Varianta1 pojednáva o scenári v ktorom sa na užívateľský server pripájajú celé domáce adresáre  užívateľov priamo do adresára **/home/**, čiže domáci adresár (časť **user**) užívateľa **/home/user** je umiestnený na súborovom servery. 


### 4.1 Inštalácia potrebného softvéru (AUTOFS)

<pre>
# yum install autofs
# yum install cifs-utils
</pre>


### 4.2 Užívateľský priestor - "request-key" a "cifs.upcall"

Pre správnu funkčnosť pripájania sieťového súborového systému CIFS s použitím kerberos autentizácie je nutné mať v systéme správnu konfiguráciu užívateľského priestoru (user space). Dôvod tejto konfigurácie je ten, že keď jadro OS vykonáva pripájanie (mount) CIFS sieťového súborového systému potrebuje mať prístup ku kerberos tiketom, ktoré sa ale nachádzajú v užívateľskom priestore (štandardne v prípojnom bode /tmp). Na to, aby jadro OS získalo potrebné kerberos tikety spustí program **request-key** a na základe konfigurácie (konfigurácia sa nachádza v súbore **/etc/request-key.conf**) zistí čo má s danou požiadavkou robiť a teda ako sa má dostať ku kerberos tiketom. V prípade pripájania CIFS s kerberos autentizáciou program **request-key** na základe konfigurácie spustí pomocný program **cifs-upcall**.


#### 4.2.1 Kontrola systému na požadovanú konfiguráciu v užívateľskom priestore

Skontrolujeme či náš systém disponuje požadovanou konfiguráciou užívateľského priestoru. V operačnom systéme RHEL 7 nie je nutná konfigurácia užívateľského priestoru nakoľko táto konfigurácia sa do systému dostane nainštalovaním balíčka **cifs-utils**. V našom prípade je nutný iba súbor **cifs.spnego** pretože používame SPNEGO (Windows doménovú) autentizáciu (kerberizovanú). 

<pre>
# ls -lh /etc/request-key.d/
-------------------------------------------------------------------------
-rw-r--r-- 1 root root 50 Apr  3  2017 cifs.idmap.conf
-rw-r--r-- 1 root root 52 Nov 23 17:04 cifs.spnego.conf
</pre>


#### 4.2.2 Úprava konfigurácie v užívateľskom priestore

Ak súbory z bodu **4.2.1** existujú vykonáme úpravu konfigurácie (doplnenie prepínača **-t**).

<pre>
# vi /etc/request-key.d/cifs.spnego.conf
-------------------------------------------------------------------------
ORIGINAL: create cifs.spnego     *       *               /usr/sbin/cifs.upcall %k
CHANGED : create cifs.spnego     *       *               /usr/sbin/cifs.upcall -t %k
</pre>


#### 4.2.3 Vytvorenie konfigurácie v užívateľskom priestore

Ak súbory z bodu **4.2.1** neexistujú vytvoríme požadovanú konfiguráciu tak, že doplníme konfiguračný súbor **/etc/request-key.conf**.

<pre>
# vi /etc/request-key.conf
-------------------------------------------------------------------------
...
# LH-ON
create cifs.idmap      *       *               /usr/sbin/cifs.idmap %k
create cifs.spnego     *       *               /usr/sbin/cifs.upcall -t %k
</pre>


### 4.3 Konfigurácia automounter (AUTOFS)

Úprava **master** konfiguračného súboru systému AUTOFS.

<pre>
# vi /etc/auto.master
-------------------------------------------------------------------------
+auto.master
...
# Pripojny bod do | Detailne instrukcie | Dalsie parametre.
# ktoreho chceme  | pre pripojenie sa   |
# pripojit.       | nachadzaju tu.      |
/home              /etc/auto.cifshome    --timeout 20
</pre>

Vytvorenie špecifického (s detailnými inštrukciami pripojenia) konfiguračného súboru pre účely pripájania domácich sieťových adresárov.

<pre>
# vi /etc/auto.cifshome
-------------------------------------------------------------------------
* -fstype=cifs,sec=krb5i,uid=$UID,gid=$GID,cruid=$UID,file_mode=0600,dir_mode=0700 ://CIFS_SERVER/homedirs/&
</pre>



## 4 Užívateľský Server (Server3) - Varianta2

Varianta2 pojednáva o scenári v ktorom sa na užívateľský server pripájajú celé domáce adresáre  užívateľov (pripájané priamo do adresára **/home/user**). 

### 3.2 Konfigurácia systému AUTOFS

Kedže systém AUTOFS ma obmedzenia v použití zástupných znakov (wildcards) v 

#### 3.2.1 Skript "home-cifs-link.sh"

