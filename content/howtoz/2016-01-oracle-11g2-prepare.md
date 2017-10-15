<pre>

================================================================================================================
 Instalacia OracleDB 11g2 v RAC zapojeni s pouzitim Oracle ASM na SUSE Linux Enterprise Server 11 SP3
================================================================================================================


    GRID Infrastructure Software (Clusterware + ASM)
    --------------------------------------------------------------------------------------------------------
    - Server: All the RAC Nodes
    - ORACLE_BASE: /data/u01/app/grid
    - ORACLE_HOME: /data/u01/app/grid11204
    - Owner: grid (Primary Group: oinstall, Secondary Group: asmadmin, asmdba)
    - Permissions: 755
    - OCR/Voting Disk Storage Type: ASM
    - Oracle Inventory Location: /data/u01/app/oraInventory
    --------------------------------------------------------------------------------------------------------


    Oracle Database Software (RAC 11.2.0.4)
    --------------------------------------------------------------------------------------------------------
    - ORACLE_BASE: /data/u01/app/oracle
    - ORACLE_HOME: /data/u01/app/oracle/db11204
    - Owner: oracle (Primary Group: oinstall, Secondary Group: asmdba, dba)
    - Permissions: 755
    - Oracle Inventory Location: /data/u01/app/oraInventory
 
    - Database Name: csldb
    - Listener: opdb (TCP:1525)
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [1] Instalacia softverovych balickov pre ucely prevadzky Oracle DB
================================================================================================================


    4.3 Package Requirements - SUSE Linux Enterprise Server 11
    REF: https://docs.oracle.com/cd/E11882_01/install.112/e24326/toc.htm#BHCGJCEA
    ********************************************************************************************************
    - binutils-2.19
    - gcc-4.3
    - gcc-32bit-4.3
    - gcc-c++-4.3
    - glibc-2.9
    - glibc-32bit-2.9
    - glibc-devel-2.9
    - glibc-devel-32bit-2.9
    - ksh-93t
    - libaio-0.3.104
    - libaio-32bit-0.3.104
    - libaio-devel-0.3.104
    - libaio-devel-32bit-0.3.104
    - libstdc++33-3.3.3
    - libstdc++33-32bit-3.3.3
    - libstdc++43-4.3.3_20081022
    - libstdc++43-32bit-4.3.3_20081022
    - libstdc++43-devel-4.3.3_20081022
    - libstdc++43-devel-32bit-4.3.3_20081022
    - libgcc43-4.3.3_20081022
    - libstdc++-devel-4.3
    - make-3.81
    - sysstat-8.1.5
    ********************************************************************************************************


    [1.1] Instalacia zakladnych balickov pre ucely prevadzky Oracle DB
    --------------------------------------------------------------------------------------------------------
    # zypper install binutils
    # zypper install gcc
    # zypper install gcc-32bit
    # zypper install gcc-c++
    # zypper install glibc
    # zypper install glibc-32bit
    # zypper install glibc-devel
    # zypper install glibc-devel-32bit
    # zypper install ksh
    # zypper install libaio
    # zypper install libaio-32bit
    # zypper install libaio-devel
    # zypper install libaio-devel-32bit
    # zypper install libstdc++33
    # zypper install libstdc++33-32bit
    # zypper install libstdc++43
    # zypper install libstdc++43-32bit
    # zypper install libstdc++43-devel
    # zypper install libstdc++43-devel-32bit
    # zypper install libgcc43
    # zypper install libstdc++-devel
    # zypper install make
    # zypper install sysstat
    --------------------------------------------------------------------------------------------------------


    [1.2] Overenie, ze v systeme sa nachadzaju zakladne balicky potrebne pre instalaciu Oracle
    --------------------------------------------------------------------------------------------------------
    # rpm -q --qf '%{NAME}-%{VERSION}-%{RELEASE}(%{ARCH})\n' binutils gcc gcc-32bit gcc-c++ glibc glibc-32bit \
      glibc-devel glibc-devel-32bit ksh libaio libaio-32bit libaio-devel libaio-devel-32bit libstdc++33       \
      libstdc++33-32bit libstdc++43 libstdc++43-32bit libstdc++43-devel libstdc++43-devel-32bit libgcc43      \
      libstdc++-devel make sysstat


    4.5.1 Additional Software Requirements - 4.5.1 Oracle ODBC Drivers - SUSE Linux Enterprise Server 11
    REF: https://docs.oracle.com/cd/E11882_01/install.112/e24326/toc.htm#BHCFGFBH
    ********************************************************************************************************
    - unixODBC-2.2.12 or later
    - unixODBC-devel-2.2.12 or later
    - unixODBC-32bit-2.2.12 (32-bit) or later
    ********************************************************************************************************


    [1.3] Instalacia dodatocnych balickov pre ucely prevadzky Oracle DB
    --------------------------------------------------------------------------------------------------------
    # zypper install unixODBC
    # zypper install unixODBC-devel
    # zypper install unixODBC-32bit
    --------------------------------------------------------------------------------------------------------


    [1.4] Overenie, ze v systeme sa nachadzaju dodatocne balicky potrebne pre Oracle
    --------------------------------------------------------------------------------------------------------
    # rpm -q --qf '%{NAME}-%{VERSION}-%{RELEASE}(%{ARCH})\n' unixODBC unixODBC-devel unixODBC-32bit
    --------------------------------------------------------------------------------------------------------


    [1.5] Pre ucely instalacie je nutne nainstalovat X Window Server (Xorg) a kniznicu libcap1
    --------------------------------------------------------------------------------------------------------
    # zypper install xorg-x11
    # zypper install libcap1
    --------------------------------------------------------------------------------------------------------


    [1.6] Overenie, ze v systeme sa nachadzaju X Window Server balicky potrebne pre instalaciu Oracle
    --------------------------------------------------------------------------------------------------------
    # rpm -q --qf '%{NAME}-%{VERSION}-%{RELEASE}(%{ARCH})\n' xorg-x11 libcap1
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [2] Vytvorenie lokalnych uzivatelov a skupin pre prevadzku Oracle DB
================================================================================================================


    5 Creating Required Operating System Groups and Users
    REF: https://docs.oracle.com/cd/E11882_01/install.112/e24326/toc.htm#BHCBCFDI
    ********************************************************************************************************


    [2.1] Vytvorenie lokalnych uctov (oracle,grid) a zaradenie ich do potrebnych skupin pre ucely prevadzky Oracle DB
    --------------------------------------------------------------------------------------------------------
    # groupadd -g 30001 oinstall
    # groupadd -g 30002 asmadmin
    # groupadd -g 30003 asmdba
    # groupadd -g 30004 dba
    # useradd -g oinstall -G asmadmin,asmdba -u 30101 grid
    # useradd -g oinstall -G dba,asmdba -u 30102 oracle
    # passwd oracle
    New password: Ora.password.123
    # passwd grid
    New password: Gri.password.123
    --------------------------------------------------------------------------------------------------------


    [2.2] Instalacia pozadovaneho balicka "cvuqdisk" (potrebne nainstalovat po vytvoreni skupiny "oinstall").
          Balicek sa nachadza na instalacnom mediu Oracle DB.
    --------------------------------------------------------------------------------------------------------
    # cd /data/install/database/rpm
    # rpm -ivh ./cvuqdisk-1.0.9-1.rpm
    --------------------------------------------------------------------------------------------------------


    [2.3] Instalacia dalsich pozadovanych balickov pre ucely prevadzky Oracle RAC + ASM
    --------------------------------------------------------------------------------------------------------
    REF: ASMLIB -> http://www.oracle.com/technetwork/server-storage/linux/downloads/sles11-099661.html
    --------------------------------------------------------------------------------------------------------
    # zypper install numactl
    # wget http://oss.oracle.com/projects/oracleasm-support/dist/files/RPMS/sles11/amd64/2.1.8/oracleasm-support-2.1.8-1.SLE11.x86_64.rpm
    # wget http://download.oracle.com/otn_software/asmlib/oracleasmlib-2.0.4-1.sle11.x86_64.rpm
    # rpm -ivh ./oracleasm-support-2.1.8-1.SLE11.x86_64.rpm
    # zypper install oracleasm
    # rpm -ivh ./oracleasmlib-2.0.4-1.sle11.x86_64.rpm


================================================================================================================
 [3] Konfiguracia prostredia OS pre prevadzku Oracle DB
================================================================================================================


    ********************************************************************************************************
    6 Configuring Kernel Parameters and Resource Limits
    REF: https://docs.oracle.com/cd/E11882_01/install.112/e24326/toc.htm#BHCCADGD
    ********************************************************************************************************
    /etc/sysctl.conf
    ********************************************************************************************************
    fs.aio-max-nr = 1048576
    fs.file-max = 6815744
    kernel.shmall = 2097152
    kernel.shmmax = 536870912
    kernel.shmmni = 4096
    kernel.sem = 250 32000 100 128
    net.ipv4.ip_local_port_range = 9000 65500
    net.core.rmem_default = 262144
    net.core.rmem_max = 4194304
    net.core.wmem_default = 262144
    net.core.wmem_max = 1048576
    ********************************************************************************************************


    ********************************************************************************************************
    Optimal SHMMAX for Oracle
    http://www.dba-oracle.com/t_optimal_shmmax.htm
    ********************************************************************************************************


    ********************************************************************************************************
    kernel shared memory calculator (shmsetup.sh)
    REF: https://gist.github.com/jodell/1285137
    ********************************************************************************************************
    SHMMAX is the maximum size of a single shared memory segment set in “bytes”.
    SHMALL is the total size of Shared Memory Segments System wide set in “pages”.
    ********************************************************************************************************


    [3.1] Spustime skript na vypocet parametrov (shmall,shmax) pre zdielanu pamat (shared memory)
    --------------------------------------------------------------------------------------------------------
    # ./shmsetup.sh
    --------------------------------------------------------------------------------------------------------
    # Maximum shared segment size in bytes
    kernel.shmmax = 4124028928
    # Maximum number of shared memory segments in pages
    kernel.shmall = 1006843
    --------------------------------------------------------------------------------------------------------
    POZOR!!!! Instalator nasledne upozornil, ze hodnota "kernel.shmax" nie je spravna. Podla neho ma byt 4124030976.
    POZOR!!!! Instalator nasledne upozornil, ze hodnota "kernel.shmall" nie je spravna. Podla neho ma byt 2097152.


    [3.2] Konfiguracia parametrov jadra pre ucely prevadzky Oracle DB
    --------------------------------------------------------------------------------------------------------
    # vi /etc/sysctl.conf
    --------------------------------------------------------------------------------------------------------
    ...
    # Konfiguracia parametrov jadra pre ucely prevadzky Oracle DB
    fs.aio-max-nr = 1048576
    fs.file-max = 6815744
    kernel.shmall = 2097152
    kernel.shmmax = 4124030976
    kernel.shmmni = 4096
    kernel.sem = 250 32000 100 128
    net.ipv4.ip_local_port_range = 9000 65500
    net.core.rmem_default = 262144
    net.core.rmem_max = 4194304
    net.core.wmem_default = 262144
    net.core.wmem_max = 1048576

    # Pre lokalnu skupinu oinstall (30001) povolime vytvarat zdielane pamatove segmenty (Plati len pre SUSE Linux.)
    # Instalacia.
    vm.hugetlb_shm_group=30001

    # Pre lokalnu skupinu dba (30004) povolime vytvarat zdielane pamatove segmenty (Plati len pre SUSE Linux.)
    # Prevadzka.
    vm.hugetlb_shm_group=30004

    # V tomto pripade sa ako Oracle interconnect pouziva adapter "eth3" (eth3:INT)
    net.ipv4.conf.eth3.rp_filter = 0
    net.ipv4.icmp_echo_ignore_broadcasts = 0
    --------------------------------------------------------------------------------------------------------


    [3.3] Aktivujeme zmenene parametre jadra z bodu [3.2]
    --------------------------------------------------------------------------------------------------------
    # sysctl -p
    --------------------------------------------------------------------------------------------------------


    [3.4] Konfiguracia limitov pre ucely prevadzky Oracle DB
    --------------------------------------------------------------------------------------------------------
    # vi /etc/security/limits.conf
    --------------------------------------------------------------------------------------------------------
    ...
    # Konfiguracia limitov (minimalne hodnoty) pre ucely prevadzky Oracle DB
    # oracle  soft    nproc   2047
    # oracle  hard    nproc   16384
    # oracle  soft    nofile  1024
    # oracle  hard    nofile  65536
    # oracle  soft    as      unlimited
    # oracle  hard    as      unlimited
    oracle   soft   nofile    131072
    oracle   hard   nofile    131072
    oracle   soft   nproc    131072
    oracle   hard   nproc    131072
    oracle  soft    as      unlimited
    oracle  hard    as      unlimited
    oracle   soft   core    unlimited
    oracle   hard   core    unlimited
    oracle   soft   memlock    3500000
    oracle   hard   memlock    3500000
    grid   soft   nofile    131072
    grid   hard   nofile    131072
    grid   soft   nproc    131072
    grid   hard   nproc    131072
    grid   soft    as      unlimited
    grid   hard    as      unlimited
    grid   soft   core    unlimited
    grid   hard   core    unlimited
    grid   soft   memlock    3500000
    grid   hard   memlock    3500000
    --------------------------------------------------------------------------------------------------------


    [3.5] Upravime globalne systemove (system wide) premenne prostredia (Plati pre interpreter BASH a KSH.)
    --------------------------------------------------------------------------------------------------------
    # vi /etc/profile.local
    --------------------------------------------------------------------------------------------------------
    # Konfiguracia globalnych systemovych premennych pre ucely prevadzky Oracle DB (BASH interpreter)
    if [ $USER = "oracle" ]; then
       if [ $SHELL = "/bin/bash" ]; then
       # TOTO SOM MUSEL ZAKOMENTOVAT   ulimit -p 131072
          ulimit -n 131072
       else
          ulimit -u 131072 -n 131072
       fi
    fi

    if [ $USER = "grid" ]; then
       if [ $SHELL = "/bin/bash" ]; then
       # TOTO SOM MUSEL ZAKOMENTOVAT    ulimit -p 131072
          ulimit -n 131072
       else
          ulimit -u 131072 -n 131072
       fi
    fi
    --------------------------------------------------------------------------------------------------------


    [3.5.1] Nastavime spravne opravnenia na subor "/etc/profile.local"
    --------------------------------------------------------------------------------------------------------
    # chmod 644 /etc/profile.local
    --------------------------------------------------------------------------------------------------------


    [3.6] Konfiguracia/doplnenie (na koniec suboru) PAM pre ucely prevadzky Oracle DB
    --------------------------------------------------------------------------------------------------------
    # vi  /etc/pam.d/login
    --------------------------------------------------------------------------------------------------------
    ...
    # Konfiguracia PAM pre ucely prevadzky Oracle DB
    session     required       pam_limits.so
    --------------------------------------------------------------------------------------------------------


    [3.7] Konfiguracia lokalnych hostname zaznamov
          Tuto konfiguraciu aktualne nepouzivam nakolko vsetky zaznamy su v DNS.
    --------------------------------------------------------------------------------------------------------
    # vi /etc/hosts
    --------------------------------------------------------------------------------------------------------
    # Loopback nesmie mat na sebe naviazany nazov servera. Klastrovacie sluzby Oraclu su z toho nestastne
    # a klaster sa nerozbehne (minimalne na druhom a dalsich nodoch).
    127.0.0.1       localhost.localdomain localhost

    # Oracle RAC - public IP
    10.10.10.11    oradb01.domena.sk oradb01
    10.10.10.12    oradb02.domena.sk oradb02

    # Oracle RAC - virtual IP
    10.10.10.21    oradb01-vip.domena.sk oradb01-vip
    10.10.10.22    oradb02-vip.domena.sk oradb02-vip

    # Oracle RAC - scan IP
    10.10.10.31    oradb-scan.domena.sk oradb-scan
    10.10.10.32    oradb-scan.domena.sk oradb-scan
    10.10.10.33    oradb-scan.domena.sk oradb-scan

    # Oracle RAC - interconnect IP
    10.10.20.11     oradb01-int.domena.sk oradb01-int
    10.10.20.12     oradb02-int.domena.sk oradb02-int

    # Oracle RAC - symantec backend
    10.10.30.11    oradb01-bck.domena.sk oradb01-bck
    10.10.30.12    oradb02-bck.domena.sk oradb02-bck

    # Oracle RAC - symantec backend (pre pripad, ze bude Oracle Listener pocuvat aj na tychto adresach)
    # 10.10.30.21    oradb01-bck-vip.domena.sk oradb01-bck-vip
    # 10.10.30.22    oradb02-bck-vip.domena.sk oradb02-bck-vip

    # Oracle RAC - OS/DB management
    10.10.40.11    oradb01-mng.domena.sk oradb01-mng
    10.10.40.12    oradb02-mng.domena.sk oradb02-mng

    # Oracle RAC - OS/DB management (pre pripad, ze bude Oracle Listener pocuvat aj na tychto adresach)
    # 10.10.40.21    oradb01-mng-vip.domena.sk oradb01-mng-vip
    # 10.10.40.22    oradb02-mng-vip.domena.sk oradb02-mng-vip
    --------------------------------------------------------------------------------------------------------


    [3.8] Pre ucty "grid" a "oracle" nastavime umask
    --------------------------------------------------------------------------------------------------------
    # su - grid
    # vi .bash_profile
    --------------------------------------------------------------------------------------------------------
    umask 022
    --------------------------------------------------------------------------------------------------------
    # su - oracle
    # vi .bash_profile
    --------------------------------------------------------------------------------------------------------
    umask 022
    --------------------------------------------------------------------------------------------------------


    [3.9] Nastavime spravny DNS server/y
    --------------------------------------------------------------------------------------------------------
    # vi /etc/resolv.conf
    --------------------------------------------------------------------------------------------------------
    search domena.sk
    nameserver 10.10.40.13
    --------------------------------------------------------------------------------------------------------


    [3.10] Nastavime synchronizaciu casu (NTP server) - Nastavene pomocou SUSE konfiguracneho nastroja "Yast"
    --------------------------------------------------------------------------------------------------------
    # vi /etc/ntp.conf
    --------------------------------------------------------------------------------------------------------
    ...
    server 10.10.40.13  iburst
    ...
    --------------------------------------------------------------------------------------------------------


    [3.11] V ramci NTP servera nastavime postupne (nie skokove) dostavovanie casu (prepinac "-x")
    --------------------------------------------------------------------------------------------------------
    # vi /etc/sysconfig/ntp
    --------------------------------------------------------------------------------------------------------
    ...
    NTPD_OPTIONS="-x -g -u ntp:ntp"
    ...
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [4] Vytvorenie logickej particie "data" v logickom zvazku (skupine) "DATA" -> Oracle Install Destination
================================================================================================================


    [4.1] Inicializacia disku alebo particie pre pouzitie v LVM
    --------------------------------------------------------------------------------------------------------
    # pvcreate /dev/sdb
    --------------------------------------------------------------------------------------------------------


    [4.2] Vytvorenie logickeho zvazku (skupiny) s nazvom 'DATA' pricom pouzijeme disk sdb
    --------------------------------------------------------------------------------------------------------
    # vgcreate DATA /dev/sdb
    --------------------------------------------------------------------------------------------------------


    [4.3] Informacie o logickom zvazku (skupine) s nazvom 'DATA'
    --------------------------------------------------------------------------------------------------------
    # vgdisplay -v DATA
    --------------------------------------------------------------------------------------------------------


    [4.4] Vytvorenie 99 GB logickej particie s nazvom 'data' v logickom zvazku 'DATA'
    --------------------------------------------------------------------------------------------------------
    # lvcreate -L 99G -n data DATA
    --------------------------------------------------------------------------------------------------------


    [4.5] Vytvorenie suboroveho systemu ext3 na logickej particii '/dev/DATA/data
    --------------------------------------------------------------------------------------------------------
    # mkfs.ext3 /dev/DATA/data
    --------------------------------------------------------------------------------------------------------


    [4.6] Rozlozenie diskovych particii / automaticke pripajanie po starte OS
    --------------------------------------------------------------------------------------------------------
    # vi /etc/fstab
    --------------------------------------------------------------------------------------------------------
    /dev/SYSTEM/swap1                                            swap                 swap       defaults                                  0 0
    /dev/SYSTEM/root                                             /                    ext3       acl,user_xattr                            1 1
    /dev/disk/by-id/scsi-360022480eee5727b536ee6bcb234826e-part1 /boot                ext3       acl,user_xattr                            1 2
    /dev/SYSTEM/home                                             /home                ext3       nosuid,nodev,noexec,acl,user_xattr        1 2
    /dev/SYSTEM/tmp                                              /tmp                 ext3       nosuid,nodev,acl,user_xattr               1 2
    /dev/SYSTEM/usr                                              /usr                 ext3       nodev,acl,user_xattr                      1 2
    /dev/SYSTEM/var                                              /var                 ext3       nodev,acl,user_xattr                      1 2
    /dev/SYSTEM/varlog                                           /var/log             ext3       nosuid,nodev,noexec,acl,user_xattr        1 2
    /dev/SYSTEM/varlogaudit                                      /var/log/audit       ext3       nosuid,nodev,noexec,acl,user_xattr        1 2
    /dev/SYSTEM/vartmp                                           /var/tmp             ext3       nosuid,nodev,noexec,acl,user_xattr        1 2
    proc                                                         /proc                proc       defaults                                  0 0
    sysfs                                                        /sys                 sysfs      noauto                                    0 0
    debugfs                                                      /sys/kernel/debug    debugfs    noauto                                    0 0
    devpts                                                       /dev/pts             devpts     mode=0620,gid=5                           0 0

    # Oracle Install Destination
    /dev/mapper/DATA-data                                        /data                ext3       nodev,acl,user_xattr                      0 0
    --------------------------------------------------------------------------------------------------------


    [4.7] Vytvorenie adresara pre pripojny bod /data
    --------------------------------------------------------------------------------------------------------
    # mkdir -p /data
    --------------------------------------------------------------------------------------------------------


    [4.8] Pripojenie vsetkych pripojnych bodov, ktore su definovane v "/etc/fstab"
    --------------------------------------------------------------------------------------------------------
    # mount -a
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [5] Priprava a vytvorenie zdielanych diskov ASM
================================================================================================================


    [5.0] Pre ucely instalacie OracleDB (RAC+ASM) budeme potrebovat nasledovne blokove zariadenia
    --------------------------------------------------------------------------------------------------------
    Nazov         | Kapacita    | Pripojny bod | Ucel                             | ASM DISK
    --------------------------------------------------------------------------------------------------------
    ORADB-CRS     | 1073 MB     | NA           | Cluster Registry (CRS)           | ASMDISK1
    ORADB-DATA01  | 107,4 GB    | NA           | Oracle Data Disk1 (ASM)          | ASMDISK2
    ORADB-DATA02  | 107,4 GB    | NA           | Oracle Data Disk2 (ASM)          | ASMDISK3
    ORADB-FRA     | 214,7 GB    | NA           | Fast Recovery Area (FRA)         | ASMDISK4
    ORADB-ONTRLG  | 21,5 GB     | NA           | Online Transakcne Logy (ONTRLG)  | ASMDISK5
    --------------------------------------------------------------------------------------------------------


    [5.1] Pre blokove zariadenie "/dev/sdc" vytvorime primarnu Linux (type=83) particiu
    --------------------------------------------------------------------------------------------------------
    # fdisk /dev/sdc
    --------------------------------------------------------------------------------------------------------
    Command (m for help): n
    Command action (e=extended, p=primary): p
    Partition number (1-4, default 1): 1
    First sector (2048-2095103, default 2048): ENTER
    Last sector, +sectors or +size{K,M,G} (2048-2095103, default 2095103): ENTER
    --------------------------------------------------------------------------------------------------------


    [5.2] Vytvorenie particii vykoname pre vsetky zdielane blokove zariadenia, ktore maju sluzit ako ASM DISKY
    --------------------------------------------------------------------------------------------------------
    # fdisk /dev/sdd
    # fdisk /dev/sde
    # fdisk /dev/sdf
    # fdisk /dev/sdg
    --------------------------------------------------------------------------------------------------------
    Postup rovnaky ako v bode [6.1].
    --------------------------------------------------------------------------------------------------------


    [5.3] Na vsetkych Oracle nodoch aktualizujeme informacie jadra o zmeny vykonane v tabulkach particii
    --------------------------------------------------------------------------------------------------------
    # partprobe
    --------------------------------------------------------------------------------------------------------


    [5.4] Nakonfigurujeme ASMLIB na vsetkych Oracle nodoch
    --------------------------------------------------------------------------------------------------------
    # oracleasm configure -i
    --------------------------------------------------------------------------------------------------------
    Default user to own the driver interface []: grid
    Default group to own the driver interface []: asmadmin
    Start Oracle ASM library driver on boot (y/n) [n]: y
    Scan for Oracle ASM disks on boot (y/n) [y]: y
    Writing Oracle ASM library driver configuration: done
    --------------------------------------------------------------------------------------------------------


    [5.5] Nacitame ASMLIB modul na vsetkych Oracle nodoch
    --------------------------------------------------------------------------------------------------------
    # oracleasm init
    --------------------------------------------------------------------------------------------------------
    Creating /dev/oracleasm mount point: /dev/oracleasm
    Loading module "oracleasm": oracleasm
    Configuring "oracleasm" to use device physical block size
    Mounting ASMlib driver filesystem: /dev/oracleasm
    --------------------------------------------------------------------------------------------------------


    [5.6] Vytvorime ASM DISKY na jednom z Oracle nodov
    --------------------------------------------------------------------------------------------------------
    # oracleasm createdisk ASMDISK1 /dev/ORADB-CRS
    # oracleasm createdisk ASMDISK2 /dev/ORADB-DATA01
    # oracleasm createdisk ASMDISK3 /dev/ORADB-DATA02
    # oracleasm createdisk ASMDISK4 /dev/ORADB-FRA
    # oracleasm createdisk ASMDISK5 /dev/ORADB-ONTRLG
    --------------------------------------------------------------------------------------------------------


    [5.7] Vykoname scan ASM DISKOV a vypiseme zoznam vsetkych ASM DISKOV na vsetkych Oracle nodoch
    --------------------------------------------------------------------------------------------------------
    # oracleasm scandisks
    # oracleasm listdisks
    --------------------------------------------------------------------------------------------------------
    ASMDISK1
    ASMDISK2
    ASMDISK3
    ASMDISK4
    ASMDISK5
    --------------------------------------------------------------------------------------------------------


    [5.8] Overime ci nove ASM DISKY budu najdene ASM kniznicami (Oracle ASMLIB) na vsetkych Oracle nodoch pocas instalacie GRID infrastruktury
    --------------------------------------------------------------------------------------------------------
    # oracleasm-discover 'ORCL:*'
    --------------------------------------------------------------------------------------------------------
    Using ASMLib from /opt/oracle/extapi/64/asm/orcl/1/libasm.so
    [ASM Library - Generic Linux, version 2.0.4 (KABI_V2)]
    Discovered disk: ORCL:ASMDISK1 [2095104 blocks (1072693248 bytes), maxio 128]
    Discovered disk: ORCL:ASMDISK2 [419428352 blocks (214747316224 bytes), maxio 128]
    Discovered disk: ORCL:ASMDISK3 [209713152 blocks (107373133824 bytes), maxio 128]
    Discovered disk: ORCL:ASMDISK4 [209713152 blocks (107373133824 bytes), maxio 128]
    Discovered disk: ORCL:ASMDISK5 [41940992 blocks (21473787904 bytes), maxio 128]
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [6] Konfiguracia diskoveho subsystemu pre ucely prevadzky Oracle DB
================================================================================================================


    [6.0] Pre ucely instalacie OracleDB (RAC + ASM) budeme potrebovat nasledovne blokove zariadenia
    --------------------------------------------------------------------------------------------------------
    Nazov         | Kapacita    | Pripojny bod | Ucel                             | Servery ORADB01,02
    --------------------------------------------------------------------------------------------------------
    ORADB-INSTALL | 107,4 GB    | /data        | Oracle Install Destination       | Pre kazdy server vlastny = 2x.
    ORADB-CRS     | 1073 MB     | NA           | Cluster Registry (CRS)           | Zdielany oboma servermi = 1x.
    ORADB-DATA01  | 107,4 GB    | NA           | Oracle Data Disk1 (ASM)          | Zdielany oboma servermi = 1x.
    ORADB-DATA02  | 107,4 GB    | NA           | Oracle Data Disk2 (ASM)          | Zdielany oboma servermi = 1x.
    ORADB-FRA     | 214,7 GB    | NA           | Fast Recovery Area (FRA)         | Zdielany oboma servermi = 1x.
    ORADB-ONTRLG  | 21,5 GB     | NA           | Online Transakcne Logy (ONTRLG)  | Zdielany oboma servermi = 1x.
    --------------------------------------------------------------------------------------------------------


    [6.1] Preverime ake blokove zariadenia mame na servery ORADB01 dostupne
    --------------------------------------------------------------------------------------------------------
    # ls -ld /sys/block/sd*/device
    --------------------------------------------------------------------------------------------------------
    lrwxrwxrwx 1 root root 0 Sep 26 11:40 /sys/block/sda/device -> ../../../2:0:0:0
    lrwxrwxrwx 1 root root 0 Sep 26 11:40 /sys/block/sdb/device -> ../../../3:0:1:0 -> ORADB-INSTALL
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdc/device -> ../../../5:0:0:0 -> ORADB-CRS
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdd/device -> ../../../5:0:0:1 -> ORADB-DATA01
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sde/device -> ../../../5:0:0:2 -> ORADB-DATA02
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdf/device -> ../../../5:0:0:3 -> ORADB-FRA
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdg/device -> ../../../5:0:0:4 -> ORADB-ONTRLG
    --------------------------------------------------------------------------------------------------------


    [6.2] Na servery ORADB01 preverime jednoznacne identifikatory pre blokove zariadenia, ktore sa nasledne 
          pouziju v UDEV pravidlach
    --------------------------------------------------------------------------------------------------------
    # /lib/udev/scsi_id -g -u /dev/sdc
    14f504e46494c455255443464486a2d4b5775472d584a424d

    # /lib/udev/scsi_id -g -u /dev/sdd
    14f504e46494c45525757386a6e6a2d454b64722d42326733

    # /lib/udev/scsi_id -g -u /dev/sde
    14f504e46494c45524a47466644452d584b466b2d45433474

    # /lib/udev/scsi_id -g -u /dev/sdf
    14f504e46494c45525577536271332d54646c4a2d6a58494a

    # /lib/udev/scsi_id -g -u /dev/sdg
    14f504e46494c455244386a6e36682d334a6e442d47703477
    --------------------------------------------------------------------------------------------------------


    [6.3] Preverime ake blokove zariadenia mame na servery ORADB02 dostupne
    --------------------------------------------------------------------------------------------------------
    # ls -ld /sys/block/sd*/device
    --------------------------------------------------------------------------------------------------------
    lrwxrwxrwx 1 root root 0 Sep 26 11:40 /sys/block/sda/device -> ../../../2:0:0:0
    lrwxrwxrwx 1 root root 0 Sep 26 11:40 /sys/block/sdb/device -> ../../../3:0:1:0 -> ORADB-INSTALL
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdc/device -> ../../../5:0:0:0 -> ORADB-CRS
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdd/device -> ../../../5:0:0:1 -> ORADB-DATA01
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sde/device -> ../../../5:0:0:2 -> ORADB-DATA02
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdf/device -> ../../../5:0:0:3 -> ORADB-FRA
    lrwxrwxrwx 1 root root 0 Oct  4 12:22 /sys/block/sdg/device -> ../../../5:0:0:4 -> ORADB-ONTRLG
    --------------------------------------------------------------------------------------------------------


    [6.4] Na servery ORADB02 preverime jednoznacne identifikatory pre blokove zariadenia, ktore sa nasledne
          pouziju v UDEV pravidlach.
    --------------------------------------------------------------------------------------------------------
    # /lib/udev/scsi_id -g -u /dev/sdc
    14f504e46494c455255443464486a2d4b5775472d584a424d

    # /lib/udev/scsi_id -g -u /dev/sdd
    14f504e46494c45525757386a6e6a2d454b64722d42326733

    # /lib/udev/scsi_id -g -u /dev/sde
    14f504e46494c45524a47466644452d584b466b2d45433474

    # /lib/udev/scsi_id -g -u /dev/sdf
    14f504e46494c45525577536271332d54646c4a2d6a58494a

    # /lib/udev/scsi_id -g -u /dev/sdg
    14f504e46494c455244386a6e36682d334a6e442d47703477
    --------------------------------------------------------------------------------------------------------


    [6.5] Pre potreby Oracle ASM je nutne nastavit spravneho vlastnika (grid) a skupinu (asmadmin) na zdielanych
          blokovych zariadenia (iSCSI LUN-y), ktore su planovane pre ASM.
    --------------------------------------------------------------------------------------------------------
    # vi /etc/udev/rules.d/59-persistent-disk.rules
    --------------------------------------------------------------------------------------------------------
    # Prva particia na blokovom zariadeni s ID "14f504e46494c455255443464486a2d4b5775472d584a424d" sa bude volat "ORADB-CRS" a "ASMDISK1".
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c455255443464486a2d4b5775472d584a424d", SYMLINK+="ASMDISK1", OWNER="grid", GROUP="asmadmin", MODE="0660"
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c455255443464486a2d4b5775472d584a424d", SYMLINK+="ORADB-CRS", OWNER="grid", GROUP="asmadmin", MODE="0660"

    # Prva particia na blokovom zariadeni s ID "14f504e46494c45525757386a6e6a2d454b64722d42326733" sa bude volat "ORADB-DATA01" a "ASMDISK2".
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c45525757386a6e6a2d454b64722d42326733", SYMLINK+="ASMDISK2", OWNER="grid", GROUP="asmadmin", MODE="0660"
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c45525757386a6e6a2d454b64722d42326733", SYMLINK+="ORADB-DATA01", OWNER="grid", GROUP="asmadmin", MODE="0660"

    # Prva particia na blokovom zariadeni s ID "14f504e46494c45524a47466644452d584b466b2d45433474" sa bude volat "ORADB-DATA02" a "ASMDISK3".
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c45524a47466644452d584b466b2d45433474", SYMLINK+="ASMDISK3", OWNER="grid", GROUP="asmadmin", MODE="0660"
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c45524a47466644452d584b466b2d45433474", SYMLINK+="ORADB-DATA02", OWNER="grid", GROUP="asmadmin", MODE="0660"

    # Prva particia na blokovom zariadeni s ID "14f504e46494c45525577536271332d54646c4a2d6a58494a" sa bude volat "ORADB-FRA" a "ASMDISK4".
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c45525577536271332d54646c4a2d6a58494a", SYMLINK+="ASMDISK4", OWNER="grid", GROUP="asmadmin", MODE="0660"
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c45525577536271332d54646c4a2d6a58494a", SYMLINK+="ORADB-FRA", OWNER="grid", GROUP="asmadmin", MODE="0660"

    # Prva particia na blokovom zariadeni s ID "14f504e46494c455244386a6e36682d334a6e442d47703477" sa bude volat "ORADB-ONTRLG" a "ASMDISK5".
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c455244386a6e36682d334a6e442d47703477", SYMLINK+="ASMDISK5", OWNER="grid", GROUP="asmadmin", MODE="0660"
    KERNEL=="sd?1", SUBSYSTEM=="block", PROGRAM=="/lib/udev/scsi_id -g -u -d /dev/$parent", RESULT=="14f504e46494c455244386a6e36682d334a6e442d47703477", SYMLINK+="ORADB-ONTRLG", OWNER="grid", GROUP="asmadmin", MODE="0660"
    --------------------------------------------------------------------------------------------------------


    [6.6] Ak by sa pouzivala MPIO vrstva (DM multipath) UDEV pravidla by vyzerali nasledovne.
    --------------------------------------------------------------------------------------------------------
    # vi /etc/udev/rules.d/12-persistent-disk.rules
    --------------------------------------------------------------------------------------------------------
    ...
    # Nastavenie vlastnika (grid) a skupiny (dba) pre Oracle na Multipath blokovych zariadeniach
    ENV{DM_NAME}=="ORADB01-ORA-INSTALL", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    ENV{DM_NAME}=="ORADB-CRS", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    ENV{DM_NAME}=="ORADB-DATA1", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    ENV{DM_NAME}=="ORADB-DATA2", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    ENV{DM_NAME}=="ORADB-DATA3", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    ENV{DM_NAME}=="ORADB-DATA4", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    ENV{DM_NAME}=="ORADB-FRA", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    ENV{DM_NAME}=="ORADB-ONTRLG", OWNER:="grid", GROUP:="asmadmin", MODE:="660"
    
    LABEL="dm_end"
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [7] Vytvorenie adresarovej struktury pre ucely prevadzky Oracle DB
================================================================================================================


    7 Creating Required Directories
    REF: https://docs.oracle.com/cd/E11882_01/install.112/e24326/toc.htm#CEGEGDBA
    ********************************************************************************************************


    [7.1] Vytvorenie adresarovej struktury pre ucely prevadzky Oracle DB
    --------------------------------------------------------------------------------------------------------
    # mkdir -p /data/u01/app/grid11204
    # mkdir -p /data/u01/app/grid
    # chown -R grid:oinstall /data/u01
    # mkdir -p /data/u01/app/oracle
    # chown oracle:oinstall /data/u01/app/oracle
    # chmod -R 775 /data/u01
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [8] SSH ekvivalencia pre ucty "grid" a "oracle"
================================================================================================================


    [8.1] SSH ekvivalenciu nastavime pocas instalacie Oracle Grid Infrastrukture
    --------------------------------------------------------------------------------------------------------
    Vid. dokument "LH-2016_02_Oracle-11g2_install_GRID.txt" a v tomto momente vytvorime iba SSH kluce.
    --------------------------------------------------------------------------------------------------------


    [8.1.1] Vytvorenie SSH klucov pre uzivatela "oracle" na vsetkych Oracle nodoch
    --------------------------------------------------------------------------------------------------------
    ORADB01,02# su - oracle
    ORADB01,02# mkdir ~/.ssh
    ORADB01,02# chmod 700 ~/.ssh
    ORADB01,02# ssh-keygen -t rsa
    ORADB01,02# ssh-keygen -t dsa


    [8.1.2] Vytvorenie SSH klucov pre uzivatela "grid" na vsetkych Oracle nodoch
    --------------------------------------------------------------------------------------------------------
    ORADB01,02# su - grid
    ORADB01,02# mkdir ~/.ssh
    ORADB01,02# chmod 700 ~/.ssh
    ORADB01,02# ssh-keygen -t rsa
    ORADB01,02# ssh-keygen -t dsa


    [8.2] Na servery ORADB01 otestujeme funkcionalitu bezhesloveho SSH prihlasovania pre ucet "oracle"
    --------------------------------------------------------------------------------------------------------
    ORADB01# su - oracle
    ORADB01# ssh ORADB02 date
    ORADB01# ssh ORADB02-int date
    ORADB01# ssh ORADB02.domena.sk date

    ORADB01# su - grid
    ORADB01# ssh ORADB02 date
    ORADB01# ssh ORADB02-int date
    ORADB01# ssh ORADB02.domena.sk date


    [8.3] Na servery ORADB01 a ORADB02 otestujeme funkcionalitu bezhesloveho SSH prihlasovania
    --------------------------------------------------------------------------------------------------------
    ORADB02# su - oracle
    ORADB02# ssh ORADB01 date
    ORADB02# ssh ORADB01-int date
    ORADB02# ssh ORADB01.domena.sk date

    ORADB02# su - grid
    ORADB02# ssh ORADB01 date
    ORADB02# ssh ORADB01-int date
    ORADB02# ssh ORADB01.domena.sk date

</pre>