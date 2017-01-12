

## Diagnostika využívania pamäte procesov v OS Linux


**FILE:** 2017-linux-memory-process-stats.md  
**DATE:** 01/2017  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1  


## 1 Nástroje na diagnostiku využívania pamäte v OS Linux


- [ps - standardny prikaz Linux OS](http://man7.org/linux/man-pages/man1/ps.1.html)  
ps displays information about a selection of the active processes. If you want a repetitive update of the selection and the displayed information, use top(1) instead.


- [pmap - standardny prikaz Linux OS](http://man7.org/linux/man-pages/man1/pmap.1.html)  
The pmap command reports the memory map of a process or processes.
    

- [smem](https://www.selenic.com/smem/)  
smem is a tool that can give numerous reports on memory usage on Linux systems. Unlike existing tools, smem can report proportional set size (PSS), which is a more meaningful representation of the amount of memory used by libraries and applications in a virtual memory system. Because large portions of physical memory are typically 
shared among multiple applications, the standard measure of memory usage known as resident set size (RSS) will significantly overestimate memory usage. PSS instead measures each application's "fair share" of each shared area to give a realistic measure.


- [ps_mem.py](http://www.pixelbeat.org/scripts/ps_mem.py)  
[github raw - ps_mem.py](https://raw.githubusercontent.com/pixelb/ps_mem/master/ps_mem.py)  
Try to determine how much RAM is currently being used per program. Note per _program_, not per process. So for example this script will report RAM used by all httpd process together. In detail it reports: sum(private RAM for program processes) + sum(Shared RAM for program processes). The shared RAM is problematic to calculate, and this script automatically selects the most accurate method available for your kernel.


## 2 Interpretovanie pamäťových informácii z nástrojov na diagnostiku využívania pamäte


Krátke intro k interpretovaniu pamäťových informácii z nástrojov na diagnostiku využívania pamäte:


- **VSS (Virtual Set Size) / VSZ (Virtual Memory Size):**  
Veľkosť/kapacita celej virtuálnej pamäte procesu resp. dostupného adresného priestoru procesu. Inak povedané je to celková veľkosť virtuálnej pamäte procesu bez ohľadu na to či sú pamäťové stránky načítané do fyzickej pamäte alebo nie. Problémom tohoto ukazovateľa je to, že obsahuje aj veľkosť pamäte, ktorá sice bola alokovaná napríklad pomocou "malloc()", ale nebolo do nej zatiaľ nič zapísané. Z uvedeného vyplýva, že tento ukazovateľ nie je veľmi vhodný na určenie reálneho využívania pamäte nejakým programom/procesom.


- **RSS (Resident Set Size):**  
Veľkosť/kapacita aktuálne využitej pamäte pre proces. Čiže veľkosť pamäte procesu, ktorá je       aktuálne uložená v RAM. Inak povedané, je to celkový počet pamäťových stránok pre proces, ktoré sú aktuálne načítané do fyzickej pamäte. Problémom tohoto ukazovateľa je to, že obsahuje aj veľkosť pamäte, ktorá je použitá pre zdieľané knižnice, ktoré proces používa. To znamená, že ak máme zdieľanú knižnicu "lib", ktorú používajú 2 programy ("proces1" a "proces2") tak je pre knižnicu "lib" alokovaná veľkosť pamäte "V", ale iba raz. Ak by sme k výpočtu využívania pamäte pre programy "proces1" a "proces2" pristupovali tak, že by sme len zrátali veľkosti hodnôt RSS, tak by sme zbytočne (a nesprávne) narátali dva krát viac zdieľanej pamäte. Z uvedeného vyplýva, že tento ukazovateľ nie je veľmi vhodný na určenie reálneho využívania pamäte jedným programom/procesom.


- **PSS (Proportional Set Size):**  
Veľmi podobný ukazovateľ ako je ukazovateľ RSS s tým rozdielom, že veľkosť pamäte, ktorá je alokovaná pre zdieľané knižnice je podelená počtom procesov, ktoré danú zdieľanú knižnicu používajú. To znamená, že ak máme zdieľanú knižnicu "lib", ktorá zaberá v pamäti veľkosť 100 KB a využívajú ju 2 programy ("proces1" a "proces2") bude hodnota ukazovateľa PSS=100/2=50KB. Z uvedeného vyplýva, že tento ukazovateľ je lepší ako ukazovateľ RSS, ale tak isto nie je veľmi vhodný na určenie reálneho využívania pamäte jedným programom/procesom. Najvhodnejšie použitie tohoto ukazovateľa je spočítanie hodnôt tohoto ukazovateľa pre všetky procesy čo nám dá dobrý pohľad na aktuálne využívanie pamäte celého systému.


- **USS (Unique set size):**  
 Veľkosť/kapacita aktuálne využitej privátnej pamäte pre proces. Čiže veľkosť pamäte, ktorá je unikátna pre daný proces. Z uvedeného vyplýva, že tento ukazovateľ je najvhodnejší na určenie reálneho využívania pamäte jedným programom/procesom.


Nástroje slúžiace na zobrazovanie informácií o využívaní pamäte používajú vo výpisoch rôzne/odlišné názvy stĺpcov pre tie isté informácie. Nasledujúca tabuľka sumarizuje tieto odlišnosti.


<pre>
+--------------------+---------+-------------------+---------+-------------------------------+
| Program\Ukazovateľ | VSS     | RSS               | PSS     | USS                           |
+--------------------+---------+-------------------+---------+-------------------------------+
| ps                 | VSZ     | RSS               | -       | -                             |
+--------------------+---------+-------------------+---------+-------------------------------+
| pmap -x            | Kbytes  | RSS               | -       | -                             | 
+--------------------+---------+-------------------+---------+-------------------------------+
| pmap -X            | Size    | RSS               | PSS     | -                             |
+--------------------+---------+-------------------+---------+-------------------------------+
| pmap -XX           | Size    | RSS               | PSS     | Private_Clean + Private_Dirty |
+--------------------+---------+-------------------+---------+-------------------------------+
| smem               | VSS     | RSS               | PSS     | USS                           |
+--------------------+---------+-------------------+---------+-------------------------------+
| ps_mem.py          | -       | Shared + Private  | Shared  | Private                       |
+--------------------+---------+-------------------+---------+-------------------------------+
</pre>


Spustenie nástrojov "ps", "smem", "pmap" a "ps_mem.py" tak, aby výstupné informácie boli podľa možností čo najviac podobné/rovnaké je zobrazené v bodoch [2.1] až [2.4].


### 2.1 Spustenie nástroja "ps" a zobrazenie informácii o pamäti pre proces s PID=100886


<pre>
# ps -eo pid,comm,vsz,rss,drs,trs -q 100886
----------------------------------------------------------------------------------------------------------------
PID    COMMAND            VSZ   RSS
100886 mc              163996  5364
</pre>



### 2.2 Spustenie nástroja "smem" a zobrazenie informácií o pamäti pre proces s PID=100886


> Poznámka 1: Neviem z akého dôvodu nástroj "smem" do výstupu vždy zaradí aj záznam/riadok pre samotný proces "smem", ktorý je napísaný v jazyku Python a teda riadok 2 obsahuje pamäťové informácie pre Python interpreter.


> Poznámka 2: Na základe Poznámky 1 by možno bolo vhodné, aby som si napísal svoj vlastný nástroj.


<pre>
# ./smem -c 'pid name maps vss uss pss rss' -P /usr/bin/mc
----------------------------------------------------------------------------------------------------------------
PID    Name                      Maps      VSS      USS      PSS      RSS
100886 mc                         118   164000     2932     3213     5364
101585 python                      82   146072     4660     5342     6836
</pre>


### 2.3 Spustenie nástroja "pmap" a zobrazenie informácií o pamäti pre proces s PID=100886

> Poznámka: Výstup je dosť komplexný a dlhý. Z tohoto dôvodu sú zobrazené len prvé dva a posledné dva riadky.


<pre>
# pmap -XX 100886 | head -n 2;  pmap -XX 100886 | tail -n 2;
----------------------------------------------------------------------------------------------------------------
100886:   /usr/bin/mc -P /tmp/mc-root/mc.pwd.100867
         Address Perm   Offset Device    Inode   Size  Rss  Pss Shared_Clean Shared_Dirty Private_Clean Private_Dirty Referenced Anonymous AnonHugePages Swap KernelPageSize MMUPageSize Locked
                                               ====== ==== ==== ============ ============ ============= ============= ========== ========= ============= ==== ============== =========== ======
                                               164000 5364 3210         2432            0          1200          1732       5364      1732             0    0            472         472      0
</pre>


### 2.4 Spustenie nástroja "ps_mem.py" a zobrazenie informácií o pamäti pre proces s PID=100886


<pre>
# ./ps_mem.py -p 100886
----------------------------------------------------------------------------------------------------------------
 Private  +   Shared  =  RAM used       Program

  2.9 MiB + 340.0 KiB =   3.2 MiB       mc
---------------------------------
                          3.2 MiB
</pre>


## 3 Inštalácia a ukážka použitia nástroja "smem"


### 3.1 Stiahnutie a "nainštalovanie" nástroja "smem"

<pre>
# cd /install
# wget https://www.selenic.com/smem/download/smem-1.4.tar.gz
# tar -xvzf ./smem-1.4.tar.gz
</pre>


### 3.2 Spustenie nástroja "smem"

<pre>
# cd /install/smem-1.4
# ./smem
</pre>


## 4 Inštalácia a ukážka použitia nástroja "ps_mem.py"

### 4.1 Stiahnutie a "nainštalovanie" nástroja "ps_mem.py"

<pre>
# cd /install
# wget https://raw.githubusercontent.com/pixelb/ps_mem/master/ps_mem.py
# chmod +x ps_mem.py
# ./ps_mem.py
</pre>


### 4.2 Spustenie nástroja "ps_mem.py" pre proces s PID=100886

<pre>
# /install/ps_mem.py -p 100886
</pre>


### 4.3 Spustenie nástroja "ps_mem.py" pre proces s PID=100886 pričom výstup bude aktualizovaný každú sekundu

<pre>
# /install/ps_mem.py -p 100886 -w 1
</pre>


## 5 Reálne použitie nástroja "smem" pre meranie využívania pamäte procesom "mc" (Midnight Commander)


Pre meranie využívania pamäte procesom "mc" budeme používať dve log súbory:

<pre>
+----+--------------------------------+---------------+
| ID | Súbor                          | Veľkosť       |
+----+--------------------------------+---------------+
|  1 | /var/log/messages-20161114     | 1,5 MB        |
+----+--------------------------------+---------------+
|  2 | /var/log/messages-20161120     | 588 KB        |
+----+--------------------------------+---------------+
</pre>

Testovanie merania využívania pamäte Linux procesom "mc" bolo vykonané v nasledovných krokoch:


### 5.1 - Výstup z príkazu zobrazuje aktuálne pamäťové nároky procesu "mc" (Midnight Commander). Vidíme, že hodnota USS pre proces "mc" má hodnotu 2,9 MB.

<pre>
Zobrazenie využívania pamäte
          - pre konkretny proces (-P)
          - vypiseme sumar/total (-t)
          - vypiseme jednotky K,M,G,... (-k)
          - vypiseme stlpce "pid", "name", "maps", "vss", "uss", "pss", "rss", "swap" (-c) 
----------------------------------------------------------------------------------------------------------------
# ./smem -c 'pid name maps vss uss pss rss swap' -P /usr/bin/mc -t -k
----------------------------------------------------------------------------------------------------------------
   PID Name                      Maps      VSS      USS      PSS      RSS     Swap
100886 mc                         118   160.2M     2.9M     3.1M     5.2M        0
101240 python                      81   142.7M     4.6M     5.2M     6.7M        0
----------------------------------------------------------------------------------------------------------------
     2                            199   302.9M     7.4M     8.4M    11.9M        0
</pre>


### 5.2 - Výstup z príkazu zobrazuje aktuálne pamäťové nároky procesu "mc" (Midnight Commander) v ktorom je otvorené súbor s ID 1 na editovanie. Vidíme, že hodnota USS pre proces "mc" sa zvýšila z hodnoty 2,9 na 4,2 MB.


<pre>
# ./smem -c 'pid name maps vss uss pss rss swap' -P /usr/bin/mc -t -k
----------------------------------------------------------------------------------------------------------------
   PID Name                      Maps      VSS      USS      PSS      RSS     Swap
100886 mc                         118   161.7M     4.2M     4.5M     6.6M        0
101245 python                      81   142.7M     4.6M     5.2M     6.7M        0
----------------------------------------------------------------------------------------------------------------
     2                            199   304.4M     8.8M     9.8M    13.3M        0
</pre>


### 5.3 - Výstup z príkazu zobrazuje aktuálne pamäťové nároky procesu "mc" (Midnight Commander) po ukončení editovania súboru s ID 1. Vidíme, že proces "mc" uvoľnil alokovanú pamäť pre editovanie súboru a že hodnota USS je porovnateľná s výstupom [5.1].


<pre>
[5.3]# ./smem -c 'pid name maps vss uss pss rss swap' -P /usr/bin/mc -t -k
----------------------------------------------------------------------------------------------------------------
   PID Name                      Maps      VSS      USS      PSS      RSS     Swap
100886 mc                         118   160.2M     2.9M     3.1M     5.2M        0
101250 python                      81   142.7M     4.6M     5.2M     6.7M        0
----------------------------------------------------------------------------------------------------------------
     2                            199   302.9M     7.4M     8.4M    11.9M        0
</pre>


### 5.4 - Výstup z príkazu zobrazuje aktuálne pamäťové nároky procesu "mc" (Midnight Commander) v ktorom je otvorený súbor s ID 2 na editovanie. Vidíme, že hodnota USS pre proces "mc" sa zvýšila z hodnoty 2,9 na 3,4 MB.


<pre>
[5.4]# ./smem -c 'pid name maps vss uss pss rss swap' -P /usr/bin/mc -t -k
----------------------------------------------------------------------------------------------------------------
   PID Name                      Maps      VSS      USS      PSS      RSS     Swap
100886 mc                         118   160.7M     3.4M     3.6M     5.7M        0
101273 python                      81   142.7M     4.6M     5.2M     6.7M        0
----------------------------------------------------------------------------------------------------------------
     2                            199   303.4M     7.9M     8.9M    12.4M        0
</pre>


### 5.5 - Výstup z príkazu zobrazuje aktuálne pamäťové nároky procesu "mc" (Midnight Commander) po ukončení editovania súboru s ID 2. Vidíme, že proces "mc" uvoľnil alokovanú pamäť pre editovanie súboru a že hodnota USS je porovnateľná s výstupom [5.1] resp. [5.3].


<pre>
[5.5]# ./smem -c 'pid name maps vss uss pss rss swap' -P /usr/bin/mc -t -k
----------------------------------------------------------------------------------------------------------------
   PID Name                      Maps      VSS      USS      PSS      RSS     Swap
100886 mc                         118   160.2M     2.9M     3.1M     5.2M        0
101275 python                      81   142.7M     4.6M     5.2M     6.7M        0
----------------------------------------------------------------------------------------------------------------
     2                            199   302.9M     7.4M     8.4M    11.9M        0
</pre>


### 5.6 - Výstup z príkazu zobrazuje aktuálne pamäťové nároky procesu "mc" (Midnight Commander) s tým, že zobrazí aj všetky mapovania pre daný proces.


<pre>
Zobrazíme použitie pamäte :
    - pre konkrétny proces (-P)
    - vypíšeme sumár/total (-t)
    - vypíšeme jednotky K,M,G,... (-k)
    - vypíšeme zoznam všetkých mapovaní (-m)
    - vypíšeme stĺpce "pids", "map", "vss", "uss", "pss", "rss", "swap" (-c) 
----------------------------------------------------------------------------------------------------------------
# ./smem -c 'pids map vss uss pss rss swap' -m -P /usr/bin/mc -t -k
----------------------------------------------------------------------------------------------------------------
PIDs Map                                           VSS      USS      PSS      RSS     Swap
   2 [vdso]                                      16.0K        0        0     8.0K        0
   2 [vsyscall]                                   8.0K        0        0        0        0
   1 /usr/lib64/gconv/gconv-modules.cache        28.0K        0     3.0K    24.0K        0
   2 /usr/lib/locale/locale-archive             202.3M        0     7.0K    84.0K        0
   1 /usr/lib64/libcom_err.so.2.1                 2.0M     8.0K     8.0K    16.0K        0
   1 /usr/lib64/libkeyutils.so.1.5                2.0M     8.0K     8.0K    16.0K        0
   1 /usr/lib64/libpcre.so.1.2.0                  2.4M     8.0K     8.0K    16.0K        0
   1 /usr/lib64/libutil-2.17.so                   2.0M     8.0K     8.0K    12.0K        0
   1 /usr/lib64/libz.so.1.2.7                     2.1M     8.0K     8.0K    20.0K        0
   1 /usr/lib64/libkrb5support.so.0.1             2.1M     8.0K     9.0K    24.0K        0
   1 /usr/lib64/libselinux.so.1                   2.1M     8.0K     9.0K    40.0K        0
   1 /usr/bin/python2.7                          12.0K     8.0K    10.0K    12.0K        0
   1 /usr/lib64/libgmodule-2.0.so.0.4600.2        2.0M     8.0K    10.0K    20.0K        0
   1 /usr/lib64/libnss_files-2.17.so              2.1M     8.0K    10.0K    40.0K        0
   1 /usr/lib64/libnss_dns-2.17.so                2.0M     8.0K    11.0K    20.0K        0
   1 /usr/lib64/python2.7/lib-dynload/_functo     2.0M     8.0K    12.0K    16.0K        0
   1 /usr/lib64/libk5crypto.so.3.1                2.2M    12.0K    13.0K    32.0K        0
   1 /usr/lib64/python2.7/lib-dynload/_locale     2.0M     8.0K    16.0K    24.0K        0
   1 /usr/lib64/python2.7/lib-dynload/grpmodu     2.0M    16.0K    16.0K    16.0K        0
   2 /usr/lib64/libdl-2.17.so                     4.0M    16.0K    16.0K    32.0K        0
   1 /usr/lib64/libgssapi_krb5.so.2.2             2.3M    12.0K    17.0K    64.0K        0
   1 /usr/lib64/python2.7/lib-dynload/_heapq.     2.0M    12.0K    18.0K    24.0K        0
   1 /usr/lib64/libresolv-2.17.so                 2.1M     8.0K    19.0K    64.0K        0
   1 /usr/lib64/libgpm.so.2.1.0                   2.0M    20.0K    20.0K    20.0K        0
   1 /usr/lib64/python2.7/lib-dynload/_collec     2.0M    12.0K    20.0K    28.0K        0
   1 /usr/lib64/python2.7/lib-dynload/_struct     2.0M    12.0K    20.0K    28.0K        0
   1 /usr/lib64/python2.7/lib-dynload/stropmo     2.0M    12.0K    20.0K    28.0K        0
   1 /usr/lib64/python2.7/lib-dynload/timemod     2.0M    12.0K    20.0K    28.0K        0
   2 /usr/lib64/libpthread-2.17.so                4.2M    16.0K    20.0K   136.0K        0
   2 /usr/lib64/ld-2.17.so                      272.0K    16.0K    23.0K   244.0K        0
   2 /usr/lib64/libm-2.17.so                      6.0M    16.0K    24.0K   148.0K        0
   1 /usr/lib64/python2.7/lib-dynload/operato     2.0M    12.0K    26.0K    40.0K        0
   1 /usr/lib64/python2.7/lib-dynload/itertoo     2.1M    24.0K    36.0K    48.0K        0
   1 /usr/lib64/libssh2.so.1.0.1                  2.2M    40.0K    40.0K    40.0K        0
   1 /usr/lib64/libssl.so.1.0.1e                  2.4M    44.0K    55.0K   124.0K        0
   2 [stack]                                    272.0K    64.0K    64.0K    64.0K        0
   1 /usr/lib64/libkrb5.so.3.3                    2.9M    68.0K    82.0K   212.0K        0
   2 /usr/lib64/libc-2.17.so                      7.5M    48.0K   111.0K     1.4M        0
   1 /usr/lib64/libcrypto.so.1.0.1e               3.9M   152.0K   199.0K   564.0K        0
   1 /usr/lib64/libglib-2.0.so.0.4600.2           3.2M    72.0K   199.0K   528.0K        0
   1 /usr/lib64/libslang.so.2.2.4                 3.1M   528.0K   528.0K   528.0K        0
   1 /usr/bin/mc                                  1.1M   704.0K   704.0K   704.0K        0
   1 /usr/lib64/libpython2.7.so.1.0               3.7M   232.0K   800.0K     1.3M        0
   2 <anonymous>                                  2.3M     1.8M     1.8M     1.8M        0
   2 [heap]                                       3.7M     3.4M     3.4M     3.4M        0
--------------------------------------------------------------------------------------------
  56 45                                         302.8M     7.4M     8.4M    11.9M        0
</pre>

