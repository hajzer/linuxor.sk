

## UTS (UNIX Time-sharing System) menné priestory v OS Linux

**FILE:** 2016-linux-namespaces-uts.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1  


## 1 Úvod

Menný priestor UTS (UNIX Time-sharing System) slúži na izoláciu dvoch systémových identifikátorov a to názov servera (nodename/hostname) a názov domény (domainname), ktoré vracia systemové volanie "uname()". 

![mnt_namespace](http://www.linuxor.sk/howtoz/images/uts_namespace_v01.png)


## 2 Základná práca s UTS mennými priestormi

### 2.1 Overenie názvu servera v systémovom (default) mennom priestore

V terminály 1 (TERM1) overíme názov servera.

<pre>
TERM1# uname -n
----------------------------------------------------------------------------------------------------------------
server1.domena.sk
</pre>


### 2.2 Vytvorenie nového UTS menného priestoru

V terminály 2 (TERM2) vytvoríme nový UTS menný priestor.

<pre>
[1]TERM2# unshare -u /bin/bash
[2]TERM2# echo $$
----------------------------------------------------------------------------------------------------------------
6012
[3]TERM2# hostname uts1.domena.sk
[4]TERM2# uname -n
----------------------------------------------------------------------------------------------------------------
uts1.domena.sk
</pre>

- [1] - Vytvoríme UTS menný priestor (-u) v ktorom spustíme príkazový interpreter BASH.
- [2] - Zistíme PID BASH procesu.  
- [3] - V novom UTS mennom priestore zmeníme názov servera na "uts.domena.sk".  
- [4] - V novom UTS mennom priestore overíme názov servera.  


### 2.3 Overenie vzniku nového UTS menného priestoru

V terminály 1 (TERM1) overíme vytvorenie nového UTS menného priestoru pomocou utilitky **"namespaces-info.sh"**. Vypíšeme len non-default menné priestory (prepínač -n).

<pre>
TERM1# ./namespaces-info.sh -n
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
6012       | 5995       | uts:[4026532424]     | /bin/bash
---------- + ---------- + -------------------- + ----------------------------------------
</pre>
