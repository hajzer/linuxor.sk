

## NET (Network stack namespace) menné priestory v OS Linux

**FILE:** 2016-linux-namespaces-net.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1  


## 1 Úvod

Menný priestor NET (Network stack namespace) slúži na izoláciu sieťových systémových prostriedkov. Každý sieťový menný priestor má svoje sieťové zariadenia/adaptéry, IP adresy, smerovacie tabuľky, čísla portov a vlastný adresár "/proc/net".

![mnt_namespace](http://www.linuxor.sk/content/howtoz/images/net_namespace_v01.png)


## 2 Základná práca s NET mennými priestormi



### 2.1 Vytvorenie nových NET menných priestorov

Vytvoríme dva sieťové (NET) menné priestory pričom prvý sa bude volať **"ns1"** a druhý **"ns2"**.

<pre>
# ip netns add ns1
# ip netns add ns2
</pre>



### 2.2 Overenie vzniku nových sieťových (NET) menných priestorov

<pre>
# ls -l /var/run/netns
----------------------------------------------------------------------------------------------------------------
-r--r--r--. 1 root root 0 Nov 10 12:28 ns1
-r--r--r--. 1 root root 0 Nov 10 12:28 ns2
</pre>



### 2.3 Vypísanie zoznamu všetkých sieťových (NET) menných priestorov

Pomocou príkazu **"ip"** vypíšeme zoznam všetkých sieťových (NET) menných priestorov.

<pre>
# ip netns list
----------------------------------------------------------------------------------------------------------------
ns2
ns1
----------------------------------------------------------------------------------------------------------------
# ip netns list-id
----------------------------------------------------------------------------------------------------------------
nsid 0 (iproute2 netns name: ns1)
nsid 1 (iproute2 netns name: ns2)
</pre>



### 2.4 Sledovanie vytvárania/mazania sieťových (NET) menných priestorov

Pomocou príkazu **"ip"** s parametrami **"netns monitor"** je možné monitorovať vytváranie a mazanie sieťových menných priestorov.

<pre>
# ip netns monitor
----------------------------------------------------------------------------------------------------------------
delete ns2
add ns2
</pre>



### 2.5 Spustenie procesov v sieťových (NET) menných priestoroch


Nasledovný príklad znázorňuje spustenie BASH procesu v mennom priestore s názvom **"ns1"**.


<pre>
[1]TERM1# ip netns exec ns1 bash
[2]TERM1# echo $$
----------------------------------------------------------------------------------------------------------------
27768
----------------------------------------------------------------------------------------------------------------
[3]TERM1# ifconfig -a
----------------------------------------------------------------------------------------------------------------
lo: flags=8<LOOPBACK>  mtu 65536
        loop  txqueuelen 1  (Local Loopback)
        RX packets 0  bytes 0 (0.0 B)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 0  bytes 0 (0.0 B)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0
</pre>

- [1] - V sieťovom mennom priestore **"ns1"** spustíme (exec) príkaz "bash".  
V podstate sa **"presunieme"** do menného priestoru **"ns1"** a všetky nasledovné príkazy sú vykonané v tomto mennom priestore.  
- [2] - Zistíme PID BASH procesu.  
- [3] - Vypíšeme zoznam všetkých sieťových adaptérov, ktoré sú dostupné v mennom priestore **"ns1"**.

V druhom terminály (TERM2) overíme vytvorenie nového sieťového menného priestoru pomocou utilitky **"namespaces-info.sh"**. Vypíšeme len non-default menné priestory (prepínač -n). Vidíme, že pre náš BASH proces (27768) boli vytvorené 2 menné priestory (MNT a NET).

<pre>
TERM2# ./namespaces-info.sh -n
----------------------------------------------------------------------------------------------------------------
---------- + ---------- + -------------------- + ----------------------------------------
PID        | PPID       | NAMESPACE            | COMMAND
---------- + ---------- + -------------------- + ----------------------------------------
18         | 2          | mnt:[4026531856]     | [kdevtmpfs]
---------- + ---------- + -------------------- + ----------------------------------------
585        | 1          | mnt:[4026532423]     | /usr/lib/systemd/systemd-udevd
---------- + ---------- + -------------------- + ----------------------------------------
720        | 1          | mnt:[4026532450]     | /usr/bin/vmtoolsd
---------- + ---------- + -------------------- + ----------------------------------------
755        | 1          | mnt:[4026532451]     | /usr/sbin/NetworkManager
---------- + ---------- + -------------------- + ----------------------------------------
854        | 755        | mnt:[4026532451]     | /sbin/dhclient
---------- + ---------- + -------------------- + ----------------------------------------
27768      | 21524      | mnt:[4026532584]     | bash
27768      | 21524      | net:[4026532455]     | bash
---------- + ---------- + -------------------- + ----------------------------------------
</pre>


V predchadzajúcom príklade sme vypísali všetky non-default menné priestory. Pri každom mennom priestore sa nachádza i-node číslo. Sieťový menný priestor **"net:[4026532455]"** ma i-node číslo **"4026532455"** a je to i-node číslo súboru 
**"/var/run/netns/ns1"**. Pre overenie vypíšeme číslo i-nodu súboru **"/var/run/netns/ns1"**.

<pre>
# ls -lhi /var/run/netns/
----------------------------------------------------------------------------------------------------------------
4026532455 -r--r--r--. 1 root root 0 Nov 15 13:59 ns1
</pre>



### 2.6 Odstránenie/zmazanie sieťových (NET) menných priestoroch


Pomocou príkazu **"ip"** odstránime sieťový (NET) menný priestor s názvom **"ns1"**.

<pre>
# ip netns del ns1
</pre>

Ak je menný priestor odstránený/vymazaný, tak všetky migrovateľné sieťové adaptéry sú presunuté do default (systémového) sieťového priestoru.



### 2.7 Migrovateľné sieťové zariadenia (adaptéry) medzi sieťovými (NET) mennými priestormi

Sieťové adaptéry/zariadenia, ktoré sú migrovateľné medzi sieťovými priestormi sú také, ktoré majú nastavenú funkciu zariadenia **"netns-local"** na hodnotu **"off"**, inými slovami nie sú lokálne:  
\-- netns-local: off -> migrovateľný adaptér  
\-- netns-local: on  -> nemigrovateľný adaptér (lokálny adaptér)


Pomocou príkazu **"ethtool"** môžeme overiť, ktoré adaptéry sú migrovateľné. Nasledujúci príklad znázorňuje overenie migrovateľnosti adaptéra **"ens33"**. Z výstupu je zrejmé, že adaptér **"ens33"** je migrovateľný (nie je tzv. lokálny) lebo hodnota premennej **"netns-local"** má hodnotu **"off"**.

<pre>
# ethtool -k ens33 | grep netns-local
----------------------------------------------------------------------------------------------------------------
netns-local: off [fixed]
</pre>

