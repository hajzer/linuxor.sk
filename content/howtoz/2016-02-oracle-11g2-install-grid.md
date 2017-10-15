<pre>

================================================================================================================
 Instalacia OracleDB 11g2 - Oracle klaster sluzby (Oracle Grid Infrastructure)
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
    - Cluster Name: clsdb 
      (V nazve klastra nesmu byt niektore znaky ako napriklad "-". Odporucam zadat ako nazov klastra jedno slovo.)
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [1] Instalacia Oracle Grid Infrastructure
================================================================================================================


    [1.1] Instalacia Oracle Grid Infrastructure
    --------------------------------------------------------------------------------------------------------
    Na PC z ktoreho vykonavame instalaciu je potrebne spustit X server.
    --------------------------------------------------------------------------------------------------------
    # su - grid
    # cd /data/install/grid
    # ./runInstaller
    --------------------------------------------------------------------------------------------------------

    Installation options
    -------------------
    Select one of the following options: Skip software updates
    --------------------------------------------------------------------------------------------------------


    Installation Type
    -----------------
    Select any of the following installation options: Install and Configure Oracle Grid Infrastructure for a Cluster
    --------------------------------------------------------------------------------------------------------


    Cluster Configuration
    ---------------------
    Advanced Installation
    --------------------------------------------------------------------------------------------------------


    Product Languages
    -----------------
    Selected languages: English
    --------------------------------------------------------------------------------------------------------


    Grid Plug and Play
    ------------------
    Cluster Name  : clsdb
    SCAN Name     : oradb-scan
    SCAN Port     : 1521
    Configure GNS : uncheck/nezaskrtnut/nevyplnat
    --------------------------------------------------------------------------------------------------------


    Cluster Node Information
    -----------------------------------------------------
    Public Hostname    | Virtual Hostname
    -----------------------------------------------------
    oradb01.domena.sk  | oradb01-vip.domena.sk
    oradb02.domena.sk  | oradb02-vip.domena.sk

    SSH Connectivity
    ----------------
    Oznacime obe Oracle nody, vyplnime nasledovne hodnoty a stlacime "Setup" a nasledne "Test"
    OS Username : grid
    OS Password : Gri.password.123
    User home is shared by the selected nodes              : UNCHECK
    Reuse private and public keys existing in the user home: CHECK
    --------------------------------------------------------------------------------------------------------


    Network Interface Usage
    ---------------------------------------------------
    Interface Name  | Subnet         | Interface Type
    ---------------------------------------------------
    eth0            | 10.10.30.0     | Do Not Use  
    eth1            | 10.40.120.0    | Public
    eth2            |                | Do Not Use
    eth3            | 10.10.40.0     | Do Not Use  
    eth3            | 10.10.20.0     | Private  
    eth4            | 10.10.50.0     | Do Not Use  
    --------------------------------------------------------------------------------------------------------


    Storage Option
    --------------
    Oracle Automatic Storage Management (Oracle ASM)
    --------------------------------------------------------------------------------------------------------


    Create ASM Disk Group
    ---------------------
    Disk Group Name : OCR
    Redundancy      : External
    AU Size         : 1 MB
    Candidate disk  : ORCL:ASMDISK1
    --------------------------------------------------------------------------------------------------------


    ASM Password (pre ucty "SYS" a "ASMSNMP")
    -----------------------------------------
    Use Same Password for these accounts : CHECK
    Specify Password: Asm.password.123
    Confirm Password: Asm.password.123
    --------------------------------------------------------------------------------------------------------


    Failure Isolation
    -----------------
    Do not use Intelligent Platform Management Interface (IPMI): CHECK
    --------------------------------------------------------------------------------------------------------


    Operating System Groups
    -----------------------
    Oracle ASM Administrator (OSASM) Group                : asmadmin
    Oracle ASM DBA (OSDBA for ASM) Group                  : asmdba
    Oracle ASM Operator (OSOPER for ASM) Group (Optional) : oinstall
    --------------------------------------------------------------------------------------------------------


    Installation Location
    ---------------------
    Oracle Base       : /data/u01/app/grid
    Software Location : /data/u01/app/grid11204
    --------------------------------------------------------------------------------------------------------


    Create Inventory
    ----------------
    Inventory Directory : /data/u01/app/oraInventory
    --------------------------------------------------------------------------------------------------------


    Prerequisite Checks (Tieto kontroly ostali v stave Failed)
    ----------------------------------------------------------
    Vsetky prerequizity su splnene.
    --------------------------------------------------------------------------------------------------------


    Install Product
    ---------------
    Klik -> Install
    --------------------------------------------------------------------------------------------------------


    Instalacia
    ----------
    Pri konci instalacii instalator vyzadoval spustit nasledovne skripty na oboch Oracle nodoch pod uzivatelom root.
    --------------------------------------------------------------------------------------------------------


    Spustenie skriptu "orainstRoot.sh" pod uzivatelom "root" na prvom Oracle Node (ORADB01)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/oraInventory/orainstRoot.sh
    --------------------------------------------------------------------------------------------------------
    Changing permissions of /data/u01/app/oraInventory.
    Adding read,write permissions for group.
    Removing read,write,execute permissions for world.

    Changing groupname of /data/u01/app/oraInventory to oinstall.
    The execution of the script is complete.
    --------------------------------------------------------------------------------------------------------


    Spustenie skriptu "orainstRoot.sh" pod uzivatelom "root" na druhom Oracle Node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# /data/u01/app/oraInventory/orainstRoot.sh
    --------------------------------------------------------------------------------------------------------
    Changing permissions of /data/u01/app/oraInventory.
    Adding read,write permissions for group.
    Removing read,write,execute permissions for world.

    Changing groupname of /data/u01/app/oraInventory to oinstall.
    The execution of the script is complete.
    --------------------------------------------------------------------------------------------------------


    Spustenie skriptu "root.sh" pod uzivatelom "root" na prvom Oracle node (ORADB01)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------
    [OUTPUT1] - Na konci tohto suboru sa nachadza kompletny vystup z prikazu.
    --------------------------------------------------------------------------------------------------------


    Spustenie skriptu "root.sh" pod uzivatelom "root" na druhom Oracle node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------
    [OUTPUT1] - Na konci tohto suboru sa nachadza kompletny vystup z prikazu.
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [2] Instalacia Oracle Grid zaplaty "1747594" pre SUSE 11 SP3 - aby zbehol skript "/data/u01/app/grid11204/root.sh"
================================================================================================================


    Instalacia Oracle Grid zaplaty "1747594" pre SUSE 11 SP3 - aby zbehol skript "/data/u01/app/grid11204/root.sh"
    ********************************************************************************************************
    suse11sp3 execute root.sh treatment failure bug
    REF: http://dreamsanqin.blog.51cto.com/845412/1659545
    ********************************************************************************************************


    Rozbalime ZIP archiv a Oracle Grid zaplatou pre SUSE 11 SP3
    --------------------------------------------------------------------------------------------------------
    # cd /data/install
    # unzip ./p17475946_112040_Linux-x86-64.zip
    # chmod -R 777 ./17475946/
    --------------------------------------------------------------------------------------------------------


    Pred tym ako aplikujeme patch "1747594" je nutne aktualizovat nastroj "opatch"
    Rozbalime ZIP archiv s aktualizaciou nastroja "opatch"
    REF: https://www.jamescoyle.net/how-to/1692-upgrade-oracle-opatch-version
    --------------------------------------------------------------------------------------------------------
    # cd /data/install
    # unzip ./p6880880_112000_Linux-x86-64.zip
    --------------------------------------------------------------------------------------------------------


    Staru verziu nastroja "opatch" premenujeme
    --------------------------------------------------------------------------------------------------------
    # mv /data/u01/app/grid11204/OPatch /data/u01/app/grid11204/OPatch-old
    --------------------------------------------------------------------------------------------------------


    Novu verziu prekopirujeme na povodne miesto a nastavime vlastnika (grid) a opravnenia (755)
    --------------------------------------------------------------------------------------------------------
    # cp -R /data/install/OPatch /data/u01/app/grid11204/
    # chown -R grid:oinstall /data/u01/app/grid11204/OPatch
    # chmod -R 755 /data/u01/app/grid11204/OPatch
    --------------------------------------------------------------------------------------------------------


    Prepneme sa na uzivatela "grid" a aplikujeme patch "1747594" a patchsety "20760982" a "20996923"
    --------------------------------------------------------------------------------------------------------
    # su -
    # chown grid /data/u01/app/grid11204/
    # chown -R grid /data/u01/app/grid11204/bin/
    # chown -R grid /data/u01/app/grid11204/lib/
    # su - grid
    # cd /data/u01/app/grid11204/OPatch/
    # ./opatch napply -oh /data/u01/app/grid11204 -local /data/install/17475946


    Spustenie skriptov "orainstRoot.sh" a "root.sh" pod uzivatelom "root" na prvom Oracle node (ORADB01).
    Skript "root.sh" je nutne spustit najprv na prvom node a musi sa ukoncit uspesne a az nasledne je mozne 
    spustit skript na druhom node. Ak by sme ale mali 4 nody je mozne tento skript spustit simultanne na nodoch
    2 a 3, ale na prvom a poslednom node to nie je mozne a musi sa pockat pokial na tychto nodoch skript 
    dobehne uspesne.
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/oraInventory/orainstRoot.sh
    ORADB01# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------
    [OUTPUT2] - Na konci tohto suboru sa nachadza kompletny vystup z prikazu.
    --------------------------------------------------------------------------------------------------------


    Spustenie skriptov "orainstRoot.sh" a "root.sh" pod uzivatelom "root" na druhom Oracle node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# /data/u01/app/oraInventory/orainstRoot.sh
    ORADB02# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------
    [OUTPUT3] - Na konci tohto suboru sa nachadza kompletny vystup z prikazu.
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [3] Overenie stavu instalacie
================================================================================================================


    [3.1] Preverenie stavu klastra
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/bin/crsctl check cluster -all
    --------------------------------------------------------------------------------------------------------
    **************************************************************
    oradb01:
    CRS-4537: Cluster Ready Services is online
    CRS-4529: Cluster Synchronization Services is online
    CRS-4533: Event Manager is online
    **************************************************************
    oradb02:
    CRS-4537: Cluster Ready Services is online
    CRS-4529: Cluster Synchronization Services is online
    CRS-4533: Event Manager is online
    **************************************************************
    --------------------------------------------------------------------------------------------------------


    [3.2] Preverene stavu klastrovanych zdrojov (resource)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/bin/crsctl status resource -t
    --------------------------------------------------------------------------------------------------------
    --------------------------------------------------------------------------------
    NAME           TARGET  STATE        SERVER                   STATE_DETAILS
    --------------------------------------------------------------------------------
    Local Resources
    --------------------------------------------------------------------------------
    ora.LISTENER.lsnr
                   ONLINE  ONLINE       oradb01
                   ONLINE  ONLINE       oradb02
    ora.OCR.dg
                   ONLINE  ONLINE       oradb01
                   ONLINE  ONLINE       oradb02
    ora.asm
                   ONLINE  ONLINE       oradb01               Started
                   ONLINE  ONLINE       oradb02               Started
    ora.gsd
                   OFFLINE OFFLINE      oradb01
                   OFFLINE OFFLINE      oradb02
    ora.net1.network
                   ONLINE  ONLINE       oradb01
                   ONLINE  ONLINE       oradb02
    ora.ons
                   ONLINE  ONLINE       oradb01
                   ONLINE  ONLINE       oradb02
    ora.registry.acfs
                   ONLINE  ONLINE       oradb01
                   ONLINE  ONLINE       oradb02
    --------------------------------------------------------------------------------
    Cluster Resources
    --------------------------------------------------------------------------------
    ora.LISTENER_SCAN1.lsnr
          1        ONLINE  ONLINE       oradb02
    ora.LISTENER_SCAN2.lsnr
          1        ONLINE  ONLINE       oradb01
    ora.LISTENER_SCAN3.lsnr
          1        ONLINE  ONLINE       oradb01
    ora.cvu
          1        ONLINE  ONLINE       oradb01
    ora.oc4j
          1        ONLINE  ONLINE       oradb01
    ora.oradb01.vip
          1        ONLINE  ONLINE       oradb01
    ora.oradb02.vip
          1        ONLINE  ONLINE       oradb02
    ora.scan1.vip
          1        ONLINE  ONLINE       oradb02
    ora.scan2.vip
          1        ONLINE  ONLINE       oradb01
    ora.scan3.vip
          1        ONLINE  ONLINE       oradb01
    --------------------------------------------------------------------------------------------------------


    [3.3] Preverenie stavu sluzieb synchronizacie casu klastra (Cluster Time Synchronization Services)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/bin/crsctl check ctss
    --------------------------------------------------------------------------------------------------------
    CRS-4700: The Cluster Time Synchronization Service is in Observer mode.
    --------------------------------------------------------------------------------------------------------


    [3.4] Preverenie stavu synchronizacnych sluzieb klastra (Cluster Synchronization Services)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/bin/crsctl check css
    --------------------------------------------------------------------------------------------------------
    CRS-4529: Cluster Synchronization Services is online
    --------------------------------------------------------------------------------------------------------


    [3.5] Preverenie stavu spravcu udalosti (Event Manager)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/bin/crsctl check evm
    --------------------------------------------------------------------------------------------------------
    CRS-4533: Event Manager is online
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [4] Dekonfiguracia a opatovna Rekonfiguracia Oracle klastrovacieho SW (Oracle Grid Infrastructure)
     !!! Tato kapitola je len pre pripad, ze laborujeme s instalaciou Oracle klastrovacieho SW/stacku. !!!
================================================================================================================


    [4.1] DEKONFIGURACIA CRS
    --------------------------------------------------------------------------------------------------------
    REF: http://www.ewan.cc/?q=node/109
    --------------------------------------------------------------------------------------------------------
    ORADB02# /data/u01/app/grid11204/crs/install/rootcrs.pl -deconfig -force -verbose
    ORADB01# /data/u01/app/grid11204/crs/install/rootcrs.pl -deconfig -force -verbose -keepdg -lastnode


    [4.2] Stare GPnP profily si odlozime nabok. Vykoname na vsetkych Oracle nodoch.
    --------------------------------------------------------------------------------------------------------
    ORADB01# cd /data/u01/app/grid11204/gpnp
    ORADB01# mv -i profiles/peer/profile.xml profiles/peer/profile.xml.0
    ORADB01# mv -i oradb01/profiles/peer/profile.xml oradb01/profiles/peer/profile.xml.0

    ORADB02# cd /data/u01/app/grid11204/gpnp
    ORADB02# mv -i profiles/peer/profile.xml profiles/peer/profile.xml.0
    ORADB02# mv -i oradb02/profiles/peer/profile.xml oradb02/profiles/peer/profile.xml.0
    --------------------------------------------------------------------------------------------------------


    [4.3] REKONFIGURACIA CRS
    --------------------------------------------------------------------------------------------------------
    Vytvorime zalohu CRS konfiguracnych parametrov, ktore boli pouzite pocas instalacie. V pripade potreby Create a backup of the CRS configuration parameters used during the installation, and make our network subnet change.
    --------------------------------------------------------------------------------------------------------
    ORADB01# cd /data/u01/app/grid11204/crs/install
    ORADB01# cp -pi crsconfig_params crsconfig_params.0

    ORADB02# cd /data/u01/app/grid11204/crs/install
    ORADB02# cp -pi crsconfig_params crsconfig_params.0
    --------------------------------------------------------------------------------------------------------


    [4.4] Opatovna instalacia pomocou responFile suboru
    --------------------------------------------------------------------------------------------------------
    ORADB01# su - grid
    ORADB01# /data/install/grid/runInstaller -responseFile /data/install/grid.rsp
    GUI# NEXT NEXT NEXT
    --------------------------------------------------------------------------------------------------------


!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                                                   TOTO NIE
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


================================================================================================================
 [X] Instalacia Oracle Grid kumulativnych zaplat "20760982" a "20996923" - aby zbehol skript "/data/u01/app/grid11204/root.sh"
     Nefunkcnost skriptov "root.sh" na druhom node ako aj nefunkcnost samotneho zaradenia druheho Oracle nodu do klastra
     bolo sposobene tym, ze Hyper-V siete, ktore su naviazane na tzv. "Cloud Root Network" nepodporuju Multicast a Broadcast,
     ktore Oracle klaster pouziva na internu komunikaciu medzi nodmi Oracle klastra.
================================================================================================================


    [X.1] Aplikovanie Oracle patchsetov "20760982" a "20996923"
    --------------------------------------------------------------------------------------------------------
    # su -
    # chown grid /data/u01/app/grid11204/
    # chown -R grid /data/u01/app/grid11204/bin/
    # chown -R grid /data/u01/app/grid11204/lib/
    # su - grid
    # cd /data/u01/app/grid11204/OPatch/
    # ./opatch napply -oh /data/u01/app/grid11204 -local /data/install/20760982


    # su - 
    # chown -R grid /data/u01/app/grid11204/crs/
    # chown -R grid /data/u01/app/grid11204/jlib/
    # su - grid
    # cd /data/u01/app/grid11204/OPatch/
    # ./opatch napply -oh /data/u01/app/grid11204 -local /data/install/20996923
    --------------------------------------------------------------------------------------------------------


    [X.2] Spustenie skriptov "orainstRoot.sh" a "root.sh" pod uzivatelom "root" na prvom Oracle node (ORADB01)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/oraInventory/orainstRoot.sh
    ORADB01# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------


    [X.3] Spustenie skriptov "orainstRoot.sh" a "root.sh" pod uzivatelom "root" na druhom Oracle node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# /data/u01/app/oraInventory/orainstRoot.sh
    ORADB02# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------


!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                                                   TOTO NIE
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!



    [OUTPUT1] Chybove hlasenie po spusteni skriptu "root.sh" na prvom Oracle node (ORADB01) bez patcha "1747594".
              Rovnake hlasenie je aj na druhom Oracle node (ORADB02).
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/root.sh
    ORADB02# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------
    Performing root user operation for Oracle 11g

    The following environment variables are set as:
        ORACLE_OWNER= grid
        ORACLE_HOME=  /data/u01/app/grid11204

    Enter the full pathname of the local bin directory: [/usr/local/bin]:
       Copying dbhome to /usr/local/bin ...
       Copying oraenv to /usr/local/bin ...
       Copying coraenv to /usr/local/bin ...

    Creating /etc/oratab file...
    Entries will be added to the /etc/oratab file as needed by
    Database Configuration Assistant when a database is created
    Finished running generic part of root script.
    Now product-specific root actions will be performed.
    Using configuration parameter file: /data/u01/app/grid11204/crs/install/crsconfig_params
    Creating trace directory
    User ignored Prerequisites during installation
    Installing Trace File Analyzer
    OLR initialization - successful
      root wallet
      root wallet cert
      root cert export
      peer wallet
      profile reader wallet
      pa wallet
      peer wallet keys
      pa wallet keys
      peer cert request
      pa cert request
      peer cert
      pa cert
      peer root cert TP
      profile reader root cert TP
      pa root cert TP
      peer pa cert TP
      pa peer cert TP
      profile reader pa cert TP
      profile reader peer cert TP
      peer user cert
      pa user cert
    Adding Clusterware entries to inittab
    USM driver install actions failed
    /data/u01/app/grid11204/perl/bin/perl -I/data/u01/app/grid11204/perl/lib -I/data/u01/app/grid11204/crs/install /data/u01/app/grid11204/crs/install/rootcrs.pl execution failed
    --------------------------------------------------------------------------------------------------------



    [OUTPUT2] Korektne/Uspesne hlasenie po spusteni skriptu "root.sh" na prvom Oracle node (ORADB01) s aplikovanym patchom "1747594".
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------
    Performing root user operation for Oracle 11g
    
    The following environment variables are set as:
        ORACLE_OWNER= grid
        ORACLE_HOME=  /data/u01/app/grid11204
    
    Enter the full pathname of the local bin directory: [/usr/local/bin]:
    The contents of "dbhome" have not changed. No need to overwrite.
    The contents of "oraenv" have not changed. No need to overwrite.
    The contents of "coraenv" have not changed. No need to overwrite.
    
    
    Creating /etc/oratab file...
    Entries will be added to the /etc/oratab file as needed by
    Database Configuration Assistant when a database is created
    Finished running generic part of root script.
    Now product-specific root actions will be performed.
    Using configuration parameter file: /data/u01/app/grid11204/crs/install/crsconfig_params
    Creating trace directory
    Installing Trace File Analyzer
    OLR initialization - successful
      root wallet
      root wallet cert
      root cert export
      peer wallet
      profile reader wallet
      pa wallet
      peer wallet keys
      pa wallet keys
      peer cert request
      pa cert request
      peer cert
      pa cert
      peer root cert TP
      profile reader root cert TP
      pa root cert TP
      peer pa cert TP
      pa peer cert TP
      profile reader pa cert TP
      profile reader peer cert TP
      peer user cert
      pa user cert
    Adding Clusterware entries to inittab
    CRS-2672: Attempting to start 'ora.mdnsd' on 'oradb01'
    CRS-2676: Start of 'ora.mdnsd' on 'oradb01' succeeded
    CRS-2672: Attempting to start 'ora.gpnpd' on 'oradb01'
    CRS-2676: Start of 'ora.gpnpd' on 'oradb01' succeeded
    CRS-2672: Attempting to start 'ora.cssdmonitor' on 'oradb01'
    CRS-2672: Attempting to start 'ora.gipcd' on 'oradb01'
    CRS-2676: Start of 'ora.cssdmonitor' on 'oradb01' succeeded
    CRS-2676: Start of 'ora.gipcd' on 'oradb01' succeeded
    CRS-2672: Attempting to start 'ora.cssd' on 'oradb01'
    CRS-2672: Attempting to start 'ora.diskmon' on 'oradb01'
    CRS-2676: Start of 'ora.diskmon' on 'oradb01' succeeded
    CRS-2676: Start of 'ora.cssd' on 'oradb01' succeeded
    
    ASM created and started successfully.
    
    Disk Group OCR created successfully.
    
    clscfg: -install mode specified
    Successfully accumulated necessary OCR keys.
    Creating OCR keys for user 'root', privgrp 'root'..
    Operation successful.
    CRS-4256: Updating the profile
    Successful addition of voting disk 07a27ef0779b4fe0bfd96bb6368b5bab.
    Successfully replaced voting disk group with +OCR.
    CRS-4256: Updating the profile
    CRS-4266: Voting file(s) successfully replaced
    ##  STATE    File Universal Id                File Name Disk group
    --  -----    -----------------                --------- ---------
     1. ONLINE   07a27ef0779b4fe0bfd96bb6368b5bab (ORCL:ASMDISK1) [OCR]
    Located 1 voting disk(s).
    CRS-2672: Attempting to start 'ora.OCR.dg' on 'oradb01'
    CRS-2676: Start of 'ora.OCR.dg' on 'oradb01' succeeded
    Configure Oracle Grid Infrastructure for a Cluster ... succeeded
    --------------------------------------------------------------------------------------------------------



    [OUTPUT3] Korektne/Uspesne hlasenie po spusteni skriptu "root.sh" na prvom Oracle node (ORADB02) s aplikovanym patchom "1747594".
    --------------------------------------------------------------------------------------------------------
    ORADB02# /data/u01/app/grid11204/root.sh
    --------------------------------------------------------------------------------------------------------
    Performing root user operation for Oracle 11g
    
    The following environment variables are set as:
        ORACLE_OWNER= grid
        ORACLE_HOME=  /data/u01/app/grid11204
    
    Enter the full pathname of the local bin directory: [/usr/local/bin]:
    The contents of "dbhome" have not changed. No need to overwrite.
    The contents of "oraenv" have not changed. No need to overwrite.
    The contents of "coraenv" have not changed. No need to overwrite.
    
    
    Creating /etc/oratab file...
    Entries will be added to the /etc/oratab file as needed by
    Database Configuration Assistant when a database is created
    Finished running generic part of root script.
    Now product-specific root actions will be performed.
    Using configuration parameter file: /data/u01/app/grid11204/crs/install/crsconfig_params
    Creating trace directory
    Installing Trace File Analyzer
    OLR initialization - successful
    Adding Clusterware entries to inittab
    CRS-4402: The CSS daemon was started in exclusive mode but found an active CSS daemon on node oradb01, number 1, and is terminating
    An active cluster was found during exclusive startup, restarting to join the cluster
    Configure Oracle Grid Infrastructure for a Cluster ... succeeded
    --------------------------------------------------------------------------------------------------------


</pre>