

## Úvod do menných priestorov v OS Linux

**FILE:** 2016-linux-namespaces-intro.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1  


## 1 Základné pojmy menných priestorov v OS Linux (Linux namespaces)

Menné priestory (namespaces) v operačnom systemé Linux slúžia na oddelenie/izoláciu prevádzkovaných programov/procesov. Oddelenie/izolácia umožnuje programu/procesu mať iný/rozdielny pohľad na systém resp. systemové prostriedky ako ostatné programy/procesy. Menné priestory môžu byť použité na rôzne účely, ale hlavne použitie
našli v implementácií kontajnerizačných technológií. Prvé menné priestory (MNT namespace) boli do jadra pridané už v roku 2002. Najnovším prírastkom (2016) v Linux-ovom jadre sú menné priestory pre riadiace skupiny (CGROUP namespace). Aktuálne je v Linux-ovom jadre implementovaných nasledovných 7 menných priestorov.

<pre>
+-----------+------------------+---------+-------+-----------------------+-------------------------------------+
| Namespace | Clone Flag       | Kernel  | Rok   | Vyzadovane schopnosti | Izoluje                             |
|           |                  |         |       | capabilities          |                                     |
+-----------+------------------+---------+-------+-----------------------+-------------------------------------+
| MNT       | CLONE_NEWNS      | 2.4.19  | 2002  | CAP_SYS_ADMIN         | Mount points                        |
| UTS       | CLONE_NEWUTS     | 2.6.19  | 2006  | CAP_SYS_ADMIN         | Hostname and NIS domain name        |
| PID	    | CLONE_NEWPID     | 2.6.24  | 2008  | CAP_SYS_ADMIN         | Process IDs                         |
| NET	    | CLONE_NEWNET     | 2.6.29  | 2009  | CAP_SYS_ADMIN         | Network devices, stacks, ports, ... |
| IPC	    | CLONE_NEWIPC     | 2.6.30  | 2009  | CAP_SYS_ADMIN         | System V IPC, POSIX message queues  |
| USER	    | CLONE_NEWUSER    | 3.8     | 2013  | Nie su vyzadovane     | User and group IDs                  |
| CGROUP    | CLONE_NEWCGROUP  | 4.6     | 2016  | CAP_SYS_ADMIN         | Cgroup root directory               |
+-----------+------------------+---------+-------+-----------------------+-------------------------------------+
</pre>


Uvažované, ale zatiaľ neimplementované menné priestory sú nasledovné:  
\- Security namespace  
\- Security keys namespace  
\- Device namespace  
\- Time namespace  

> REF: [2006 - Multiple Instances of the Global Linux Namespaces ](https://www.landley.net/kdocs/ols/2006/ols2006v1-pages-101-112.pdf)


### 1.1 Základný popis a účel jednotlivých menných priestorov

- **Menný priestor MNT (Mount points and filesystems namespace)**  
Slúži na izoláciu prípojných bodov, ktoré vidí proces alebo skupina procesov takže programy/procesy v rozdielnych MNT menných priestoroch môžu mať rozdielny pohľad na hierarchiu súborového systému. Táto izolácia je podobná izolácii, ktorú umožnuje systemové volanie "chroot()" s tým rozdielom, že MNT menný priestor by mal byť na tieto účely bezpečnejšou a flexibilnejšou voľbou.

- **Menný priestor UTS (UNIX Time-sharing System namespace)**  
Slúži na izoláciu dvoch systémových identifikátorov a to názov servera (nodename/hostname) a názov domény (domainname), ktoré vracia systemové volanie "uname()". 

- **Menné priestor PID (Process identifier namespace)**  
Slúži na izoláciu identifikačných čísiel procesov (PID=Proces IDentifier). Programy/procesy, ktoré sa nachádzajú v rozdielnych PID menných priestoroch môžu mať rovnaký identifikátor procesu (rovnaké PID číslo).

- **Menné priestor NET (Network stack namespace)**  
Slúži na izoláciu sieťových systémových prostriedkov. Každý sieťový menný priestor má svoje sieťové zariadenia/adaptéry, IP adresy, smerovacie tabuľky, čísla portov a vlastný adresár "/proc/net".

- **Menné priestor IPC (Interprocess communication namespace)**  
Slúži na izoláciu IPC zdrojov, konkrétne System V IPC objekty a POSIX fronty sprav (POSIX message queues). Každý IPC menný priestor disponuje vlastnou sadou System V IPC identifikátorov a vlastnou sadou POSIX front správ.

- **Menný priestor USER (Users and groups namespace)**  
Slúži na izoláciu užívateľských (UID) a skupinových (GID) identifikátorov. Umožnuje, aby UID a GID identifikátory boli rozdielne vo vnútri menného priestoru a mimo neho. Čiže vo vnútri menného priestoru sa može pouzívať jedna sada UID a GID identifikátorov a mimo menného priestoru sa používa druhá/iná sada UID a GID identifikátorov.

- **Menný priestor CGROUP (Cgroup root directory)**  
Slúži na izoláciu riadiacich skupín (control groups) pre program/proces. Každý CGROUP menné priestor disponuje vlastným koreňovým cgroup adresárom (cgroup root directory).


### 1.2 API menných priestorov

API menných priestorov pozostáva z troch systémových volaní:

- **clone()**  
Slúži na vytváranie nového procesu v novom mennom priestore. Jedná sa o všeobecnejšiu verziu
systémového volania **"fork()"**, pričom funkcionalita je riadená pomocou argumentu **"flags"**.

- **"unshare()"**  
Slúži na vytváranie nového menného priestoru, ale nevytvára nový proces. Existujúci      program/proces priradí do nového menného priestoru. Hlavným účelom tohoto systémového volania je umožniť programu/procesu riadiť kontext zdieľania bez vytvárania nového procesu.

- **"setns()"**  
Slúži na zmenu menného priestoru pre program/proces. Inými slovami toto systémove volanie
umožnuje deasociovat program/proces z jednej inštancie konkrétneho typu menného priestoru (napr. z MNT menného priestoru) a reasociovať ho s inou inštanciou toho istého typu menného priestoru, čiže **"presun"** programu/procesu z MNT menného priestoru X do MNT menného priestoru Y.


## 2 Práca s mennými priestormi v OS Linux (Linux namespaces) - default namespaces

Preveríme aké menné priestory sú priradené Linux INIT procesu (init alebo systemd proces).
Tieto menné priestory sú predvolené/default. Využívajú ich všetky procesy, viď. príklad SSHD 
servera nižšie, ktorým nie sú priradené špecifické priestory.

<pre>
# ls -lh /proc/1/ns/
----------------------------------------------------------------------------------------------------------------
lrwxrwxrwx. 1 root root 0 Nov  8 09:54 ipc -> ipc:[4026531839]
lrwxrwxrwx. 1 root root 0 Nov  8 09:54 mnt -> mnt:[4026531840]
lrwxrwxrwx. 1 root root 0 Nov  8 09:54 net -> net:[4026531956]
lrwxrwxrwx. 1 root root 0 Nov  8 09:54 pid -> pid:[4026531836]
lrwxrwxrwx. 1 root root 0 Nov  8 09:54 user -> user:[4026531837]
lrwxrwxrwx. 1 root root 0 Nov  8 09:54 uts -> uts:[4026531838]
</pre>


Preveríme aké menné priestory sú priradené Linux SSHD procesu ($SSHD_PID). Zistíme si PID sshd procesu a vypíšeme zoznam priradených menných priestorov pre tento proces/PID.

<pre>
# SSHD_PID=`ps xa | grep -m 1 /usr/sbin/sshd | awk '{print $1}'`; ls -lh /proc/$SSHD_PID/ns/
----------------------------------------------------------------------------------------------------------------
lrwxrwxrwx. 1 root root 0 Nov  8 10:04 ipc -> ipc:[4026531839]
lrwxrwxrwx. 1 root root 0 Nov  8 10:04 mnt -> mnt:[4026531840]
lrwxrwxrwx. 1 root root 0 Nov  8 10:04 net -> net:[4026531956]
lrwxrwxrwx. 1 root root 0 Nov  8 10:04 pid -> pid:[4026531836]
lrwxrwxrwx. 1 root root 0 Nov  8 10:04 user -> user:[4026531837]
lrwxrwxrwx. 1 root root 0 Nov  8 10:04 uts -> uts:[4026531838]
</pre>


## 3 Predstavenie nástroja "namespaces-info.sh"

Počas štúdia menných priestorov som vytvoril jednoduchý nástroj/skript pre príkazový interpreter BASH s názvom **"namespaces-info.sh"**. Umožnuje vypísať základné informácie o menných priestoroch. Samotný skrip je umiestnený na GitHub portále -> [github - bash-namespaces-info](https://github.com/hajzer/bash-namespaces-info)

Syntax skriptu **"bash-namespaces-info.sh"** je nasledovná:

<pre>
-d      Vypíše systémove/default (parent) menné priestory
-a      Vypíše zoznam všetkých menných priestorov pre všetky procesy (PIDs)
-n      Vypíše zoznam nesystémových/nondefault menných priestorov pre všetky procesy (PIDs)
-p PID  Vypíše zoznam menných priestorov pre proces (PID)
-v      Vypíše verziu skriptu
</pre>


Príklad spustenia skriptu **"namespaces-info.sh"** s prepínačom **"-d"**.

<pre>
# /root/namespaces-info.sh -d
--------------- + --------------------------
Linux Namespace | System default namespaces
--------------- + --------------------------
IPC  namespace  | ipc:[4026531839]
MNT  namespace  | mnt:[4026531840]
NET  namespace  | net:[4026531956]
PID  namespace  | pid:[4026531836]
USER namespace  | user:[4026531837]
UTS  namespace  | uts:[4026531838]
--------------- + --------------------------
</pre>


Príklad spustenia skriptu **"namespaces-info.sh"** s prepínačom **"-a"**.

<pre>
# /root/namespaces-info.sh -a
---------- + ---------- + -------------------- + -------- + ----------------------------------------
PID        | PPID       | NAMESPACE            | DEFAULT  | COMMAND
---------- + ---------- + -------------------- + -------- + ----------------------------------------
1          |      0     | ipc:[4026531839]     | YES      | /usr/lib/systemd/systemd --switched-root
1          |      0     | mnt:[4026531840]     | YES      | /usr/lib/systemd/systemd --switched-root
1          |      0     | net:[4026531956]     | YES      | /usr/lib/systemd/systemd --switched-root
1          |      0     | pid:[4026531836]     | YES      | /usr/lib/systemd/systemd --switched-root
1          |      0     | user:[4026531837]    | YES      | /usr/lib/systemd/systemd --switched-root
1          |      0     | uts:[4026531838]     | YES      | /usr/lib/systemd/systemd --switched-root
---------- + ---------- + -------------------- + -------- + ----------------------------------------
2          |      0     | ipc:[4026531839]     | YES      | [kthreadd]
2          |      0     | mnt:[4026531840]     | YES      | [kthreadd]
2          |      0     | net:[4026531956]     | YES      | [kthreadd]
2          |      0     | pid:[4026531836]     | YES      | [kthreadd]
2          |      0     | user:[4026531837]    | YES      | [kthreadd]
2          |      0     | uts:[4026531838]     | YES      | [kthreadd]
---------- + ---------- + -------------------- + -------- + ----------------------------------------
</pre>


Príklad spustenia skriptu **"namespaces-info.sh"** s prepínačom **"-n"**.

<pre>
# /root/namespaces-info.sh -n
---------- + ---------- + -------------------- + -------- + ----------------------------------------
PID        | PPID       | NAMESPACE            | DEFAULT  | COMMAND
---------- + ---------- + -------------------- + -------- + ----------------------------------------
18         |      2     | mnt:[4026531856]     | NO       | [kdevtmpfs]
---------- + ---------- + -------------------- + -------- + ----------------------------------------
582        |      1     | mnt:[4026532423]     | NO       | /usr/lib/systemd/systemd-udevd
---------- + ---------- + -------------------- + -------- + ----------------------------------------
718        |      1     | mnt:[4026532450]     | NO       | /usr/bin/vmtoolsd
---------- + ---------- + -------------------- + -------- + ----------------------------------------
750        |      1     | mnt:[4026532451]     | NO       | /usr/sbin/NetworkManager --no-daemon
---------- + ---------- + -------------------- + -------- + ----------------------------------------
9870       |    750     | mnt:[4026532451]     | NO       | /sbin/dhclient -d -q -sf /usr/libexec/nm
---------- + ---------- + -------------------- + -------- + ----------------------------------------
72966      |   9926     | mnt:[4026532578]     | NO       | bash
72966      |   9926     | net:[4026532452]     | NO       | bash
---------- + ---------- + -------------------- + -------- + ----------------------------------------
72975      |   9945     | mnt:[4026532579]     | NO       | bash
72975      |   9945     | net:[4026532510]     | NO       | bash
---------- + ---------- + -------------------- + -------- + ----------------------------------------
</pre>


Príklad spustenia skriptu **"namespaces-info.sh"** s prepínačom **"-p"**.

<pre>
# /root/lh-ns.sh -p 72975
---------- + ---------- + -------------------- + -------- + ----------------------------------------
PID        | PPID       | NAMESPACE            | DEFAULT  | COMMAND
---------- + ---------- + -------------------- + -------- + ----------------------------------------
72975      |   9945     | ipc:[4026531839]     | YES      | bash
72975      |   9945     | mnt:[4026532579]     | NO       | bash
72975      |   9945     | net:[4026532510]     | NO       | bash
72975      |   9945     | pid:[4026531836]     | YES      | bash
72975      |   9945     | user:[4026531837]    | YES      | bash
72975      |   9945     | uts:[4026531838]     | YES      | bash
---------- + ---------- + -------------------- + -------- + ----------------------------------------
</pre>
