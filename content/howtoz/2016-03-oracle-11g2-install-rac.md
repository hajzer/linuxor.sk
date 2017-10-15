<pre>

================================================================================================================
 Instalacia OracleDB 11g2 - Oracle RDBM (Oracle RAC)
================================================================================================================


    Oracle Database Software (RAC 11.2.0.4)
    --------------------------------------------------------------------------------------------------------
    - ORACLE_BASE: /data/u01/app/oracle
    - ORACLE_HOME: /data/u01/app/oracle/db11204
    - Owner: oracle (Primary Group: oinstall, Secondary Group: asmdba, dba)
    - Permissions: 755
    - Oracle Inventory Location: /data/u01/app/oraInventory
 
    - Database Name: clsdb
    - Listener: opdb (TCP:1525)
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [1] Instalacia Oracle RDBM (Database Software)
================================================================================================================


    [1.1] Instalacia Oracle Database Software
    --------------------------------------------------------------------------------------------------------
    Na PC z ktoreho vykonavame instalaciu je potrebne spustit X server.
    --------------------------------------------------------------------------------------------------------
    # su - oracle
    # cd /data/install/database/
    # ./runInstaller
    --------------------------------------------------------------------------------------------------------

    Configure Security Updates
    --------------------------
    Email                                                                : oraadmin@domena.sk
    I wish to receive security updates via My Oracle Support             : uncheck/nezaskrtnut/nevyplnat
    --------------------------------------------------------------------------------------------------------


    Connection Failed
    -----------------
    Connection Method: Proxy
    I want to remain uninformed of critical security issues in my configuration: check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Download Software Updates
    -------------------------
    Skip software updates                                                : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Installation Option
    -------------------
    Install database software only                                       : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Grid Installation Options
    -------------------------
    Oracle Real Application Cluster database installation                : check/zaskrtnut
    Select nodes (in addition to the local node) in the cluster where the installer should install Oracle RAC:
    Check: oradb01
    Check: oradb02


    SSH Connectivity
    ----------------
    Oznacime obe Oracle nody, vyplnime nasledovne hodnoty a stlacime "Setup" a nasledne "Test"
    OS Username                                                          : oracle
    OS Password                                                          : Ora.password.123
    User home is shared by the selected nodes                            : UNCHECK
    Reuse private and public keys existing in the user home              : CHECK
    --------------------------------------------------------------------------------------------------------


    Product Languages
    -----------------
    Selected Languages                                                   : English
    --------------------------------------------------------------------------------------------------------


    Database Edition
    ----------------
    Standard Edition (4,6 GB)                                            : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Installation Location
    ---------------------
    Oracle Base                                                          : /data/u01/app/oracle
    Software Location                                                    : /data/u01/app/oracle/db11204
    --------------------------------------------------------------------------------------------------------


    Operating System Groups
    -----------------------
    Database Administrator (OSDBA) Group                                 : dba
    Database Operator (OSOPER) Group (Optional)                          : oinstall
    --------------------------------------------------------------------------------------------------------


    Summary
    -------
    Install                                                              : klik
    --------------------------------------------------------------------------------------------------------


    Instalacia
    ----------
    Pri konci instalacii instalator vyzadoval spustit nasledovne skripty na oboch Oracle nodoch pod uzivatelom root.
    --------------------------------------------------------------------------------------------------------


    Spustenie skriptu "root.sh" pod uzivatelom "root" na vsetkych Oracle Nodoch (ORADB01, ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB01# /data/u01/app/oracle/db11204/root.sh
    ORADB02# /data/u01/app/oracle/db11204/root.sh
    --------------------------------------------------------------------------------------------------------
    Performing root user operation for Oracle 11g
    
    The following environment variables are set as:
        ORACLE_OWNER= oracle
        ORACLE_HOME=  /data/u01/app/oracle/db11204
    
    Enter the full pathname of the local bin directory: [/usr/local/bin]:
    The contents of "dbhome" have not changed. No need to overwrite.
    The contents of "oraenv" have not changed. No need to overwrite.
    The contents of "coraenv" have not changed. No need to overwrite.
    
    Entries will be added to the /etc/oratab file as needed by
    Database Configuration Assistant when a database is created
    Finished running generic part of root script.
    Now product-specific root actions will be performed.
    Finished product-specific root actions.
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [2] Vytvorenie noveho Oracle Listener-a (TCP:1525) s nazvom "CLSDB" pre novu databazu (DB: CLSDB)
================================================================================================================


    [2.1] Spustime Oracle sietoveho konfiguracneho asistenta (Oracle Net Configuration Assistant)
    -------------------------------------------------------------------------------------------------------- 
    Na PC z ktoreho vykonavame instalaciu je potrebne spustit X server.
    --------------------------------------------------------------------------------------------------------
    ORADB01# su - oracle
    ORADB01# netca
    --------------------------------------------------------------------------------------------------------

    Select the type of Oracle Net Services configuration:
    -----------------------------------------------------
    Cluster configuration                                                : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Choose the configuration you would like to do:
    ----------------------------------------------
    Listener configuration                                               : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Select what you want to do:
    ---------------------------
    Add                                                                  : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Listener name:
    --------------
    Listener name                                                        : CLSDB
    --------------------------------------------------------------------------------------------------------


    Selected Protocols:
    -------------------
    Selected Protocols                                                   : TCP
    --------------------------------------------------------------------------------------------------------


    TCP port selection:
    -------------------
    Use another port number                                              : 1525
    --------------------------------------------------------------------------------------------------------


    Would you like to configure another listener?
    ---------------------------------------------
    No                                                                   : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [3] Vytvorenie novych ASM skupin pre novu databazu (DB: CLSDB)
================================================================================================================


    [3.1] Spustime Oracle ASM konfiguracneho asistenta (Oracle ASM Configuration Assistant)
    -------------------------------------------------------------------------------------------------------- 
    Na PC z ktoreho vykonavame instalaciu je potrebne spustit X server.
    --------------------------------------------------------------------------------------------------------
    ORADB01# su - grid
    ORADB01# asmca
    --------------------------------------------------------------------------------------------------------

    Zalozka "Disk Groups":
    ----------------------
    Create: klik
    --------------------------------------------------------------------------------------------------------


    Create Disk Group
    -----------------
    Disk Group Name                                                      : DATA
    Redundancy                                                           : External (None)
    Select Member Disks                                                  : 
    +--------------------------------------------------------------------------------+
    | Disk Path           | Header Status    | Disk Name  | Size (MB)  | Quorum      |
    +--------------------------------------------------------------------------------+
    | ORCL:ASMDISK2       | PROVISIONED      |            | 102399     | NotChecked  |
    | ORCL:ASMDISK3       | PROVISIONED      |            | 102399     | NotChecked  |
    +--------------------------------------------------------------------------------+


    Create Disk Group
    -----------------
    Disk Group Name                                                      : FRA
    Redundancy                                                           : External (None)
    Select Member Disks                                                  : 
    +--------------------------------------------------------------------------------+
    | Disk Path           | Header Status    | Disk Name  | Size (MB)  | Quorum      |
    +--------------------------------------------------------------------------------+
    | ORCL:ASMDISK4       | PROVISIONED      |            | 204799     | NotChecked  |
    +--------------------------------------------------------------------------------+


    Create Disk Group
    -----------------
    Disk Group Name                                                      : ONTRLG
    Redundancy                                                           : External (None)
    Select Member Disks                                                  : 
    +--------------------------------------------------------------------------------+
    | Disk Path           | Header Status    | Disk Name  | Size (MB)  | Quorum      |
    +--------------------------------------------------------------------------------+
    | ORCL:ASMDISK5       | PROVISIONED      |            | 20479      | NotChecked  |
    +--------------------------------------------------------------------------------+


================================================================================================================
 [4] Vytvorenie novej databazy (DB: CLSDB)
================================================================================================================


    [4.1] Spustime Oracle databazoveho konfiguracneho asistenta (Oracle Database Configuration Assistant)
    -------------------------------------------------------------------------------------------------------- 
    Na PC z ktoreho vykonavame instalaciu je potrebne spustit X server.
    --------------------------------------------------------------------------------------------------------
    ORADB01# su - oracle
    ORADB01# dbca
    --------------------------------------------------------------------------------------------------------

    Create database
    ---------------
    Select the database type that you would like to create or administer : Oracle Real Application Clusters (RAC) database
    --------------------------------------------------------------------------------------------------------


    Operations
    ----------
    Create a Database                                                    : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Database Templates
    ------------------
    Custom Database                                                      : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Database Identification
    -----------------------
    Configuration Type                                                   : Admin-Managed: check/zaskrtnut
    Global Database Name                                                 : clsdb.domena.sk
    SID Prefix                                                           : clsdb
    Select the nodes on which you wany to create the cluster database    : oradb01, oradb02
    --------------------------------------------------------------------------------------------------------


    Management Options
    ------------------
    Configure Enterprise Manager                                         : check/zaskrtnut
    Configure Database Control for local management                      : check/zaskrtnut
    Enable Daily Disk Backup to Recovery Area                            : uncheck/nezaskrtnut
    --------------------------------------------------------------------------------------------------------


    Database Credentials
    --------------------
    Use the Same Administrative Password for All Accounts                : check/zaskrtnut
    Password                                                             : dbPassword123
    --------------------------------------------------------------------------------------------------------


    Database File Locations
    -----------------------
    Use Oracle-Managed Files                                             : check/zaskrtnut
    Database Area                                                        : +DATA  

    (Ak po kliknuti na "Browse" nevidiet ASM skupiny je potrebne nastavit setuid bit na binarke "oracle" -> /data/u01/app/grid11204/bin/oracle)
    REF: https://support.oracle.com/epmos/faces/DocumentDisplay?_afrLoop=186207167629801&id=1177483.1&_afrWindowMode=0&_adf.ctrl-state=989is2rso_408
                               # cd <Grid_Home>/bin
                               # chmod 6751 oracle
                               # ls -l oracle
    --------------------------------------------------------------------------------------------------------


    ASM Credentials
    ---------------
    Specify ASMSNMP password specific to ASM                             : Asm.password.123
    --------------------------------------------------------------------------------------------------------


    Recovery Configuration
    ----------------------
    Specify Fast Recovery Area                                           : check/zaskrtnut
    Fast Recovery Area                                                   : +FRA
    Enable Archiving                                                     : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Initialization Parameters
    -------------------------

    Zalozka Memory
    --------------
    Typical                                                              : check/zaskrtnut
    Memory Size (SGA and PGA)                                            : 6307 MB
    Percentage                                                           : 80 %
    Use Automatic Memory Management                                      : uncheck/nezaskrtnut
    --------------------------------------------------------------------------------------------------------

    Zalozka Sizing
    --------------
    Block Size                                                           : 8192 Bytes
    Processes                                                            : 350
    --------------------------------------------------------------------------------------------------------

    Zalozka Character Sets
    ----------------------
    Use Unicode (AL32UTF8)                                               : check/zaskrtnut
    National Character Set                                               : UTF8 - Unicode 3.0 UTF-8 Universal character ser, CESU-8 compliant
    Default Language                                                     : American
    Default Territory                                                    : United States
    --------------------------------------------------------------------------------------------------------

    Zalozka Connection Mode
    -----------------------
    Dedicated Server Mode                                                : check/zaskrtnut
    --------------------------------------------------------------------------------------------------------


    Database Storage
    ----------------
    Pouzite predvolene hodnoty, nevykonana ziadna zmena.
    --------------------------------------------------------------------------------------------------------


    Creation Options
    ----------------
    Create Database                                                      : check/zaskrtnut
    Generate Database Creation Scripts                                   : check/zaskrtnut
    Destination Directory                                                : /data/u01/app/oracle/admin/clsdb/scripts
    --------------------------------------------------------------------------------------------------------


    Klik Finish
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [5] Overenie stavu novo vytvorenej databazy "CLSDB"
================================================================================================================


    [5.1] Overenie stavu novo vytvorenej databazy "CLSDB" pomocou nastroja "srvctl"
    --------------------------------------------------------------------------------------------------------
    ORADB01# su - oracle
    ORADB01# srvctl config database -d clsdb
    --------------------------------------------------------------------------------------------------------
    Database unique name: clsdb
    Database name: clsdb
    Oracle home: /data/u01/app/oracle/db11204
    Oracle user: oracle
    Spfile: +DATA/clsdb/spfileclsdb.ora
    Domain: domena.sk
    Start options: open
    Stop options: immediate
    Database role: PRIMARY
    Management policy: AUTOMATIC
    Server pools: clsdb
    Database instances: clsdb1,clsdb2
    Disk Groups: DATA,FRA
    Mount point paths:
    Services:
    Type: RAC
    Database is administrator managed
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [5] Prostredie uzivatela "oracle"
================================================================================================================


    [5.1] Pre uzivatela "oracle" vytvorime BASH profil (~/.bash_profile) na prvom Oracle node (ORADB01)
    --------------------------------------------------------------------------------------------------------
    ORADB01# vi /home/oracle/.bash_profile 
    --------------------------------------------------------------------------------------------------------
    # Specificke nastavenia pre uzivatela "oracle"
    umask 022
    
    # Get the aliases and functions
    if [ -f ~/.bashrc ]; then
    . ~/.bashrc
    fi
    
    
    # User specific environment and startup programs
    if [ $USER = “oracle” ]; then
    if [ $SHELL = “/bin/ksh” ]; then
    ulimit -p 16384
    ulimit -n 65536
    else
    ulimit -u 16384 -n 65536
    fi
    fi
    
    # Oracle Settings
    TMP=/tmp; export TMP
    TMPDIR=$TMP; export TMPDIR
    
    ORACLE_HOSTNAME=oradb01.domena.sk; export ORACLE_HOSTNAME
    ORACLE_UNQNAME=clsdb; export ORACLE_UNQNAME
    ORACLE_BASE=/data/u01/app/oracle; export ORACLE_BASE
    ORACLE_SID=clsdb1; export ORACLE_SID
    ORACLE_HOME=/data/u01/app/oracle/db11204; export ORACLE_HOME
    ORACLE_TERM=xterm; export ORACLE_TERM
    GRID_HOME=/data/u01/app/grid11204; export GRID_HOME
    DB_HOME=$ORACLE_BASE/db11204; export DB_HOME
    
    
    LD_LIBRARY_PATH=$ORACLE_HOME/lib:/lib:/usr/lib; export LD_LIBRARY_PATH
    CLASSPATH=$ORACLE_HOME/JRE:$ORACLE_HOME/jlib:$ORACLE_HOME/rdbms/jlib; export CLASSPATH
    
    BASE_PATH=/usr/sbin:$PATH:$HOME/bin; export BASE_PATH
    PATH=$ORACLE_HOME/bin:$BASE_PATH; export PATH
    
    alias sql='sqlplus / as sysdba'
    alias grid_env='. /home/oracle/grid_env'
    alias db_env='. /home/oracle/db_env'
    --------------------------------------------------------------------------------------------------------


    [5.2] Pre uzivatela "oracle" upravime BASH profil (~/.bash_profile) na druhom Oracle node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# vi /home/oracle/.bash_profile
    --------------------------------------------------------------------------------------------------------
    ...
    ORACLE_HOSTNAME=oradb02.domena.sk; export ORACLE_HOSTNAME
    ORACLE_SID=clsdb2; export ORACLE_SID
    ...
    --------------------------------------------------------------------------------------------------------


    [5.3] Pre uzivatela "oracle" vytvorime subor s premennymi prostredia pre Oracle GRID na prvom Oracle node (ORADB01)
    --------------------------------------------------------------------------------------------------------
    ORADB01# vi /home/oracle/grid_env
    --------------------------------------------------------------------------------------------------------
    ORACLE_SID=+ASM1; export ORACLE_SID
    ORACLE_HOME=$GRID_HOME; export ORACLE_HOME
    PATH=$ORACLE_HOME/bin:$BASE_PATH; export PATH
    
    LD_LIBRARY_PATH=$ORACLE_HOME/lib:/lib:/usr/lib; export LD_LIBRARY_PATH
    CLASSPATH=$ORACLE_HOME/JRE:$ORACLE_HOME/jlib:$ORACLE_HOME/rdbms/jlib; export CLASSPATH
    --------------------------------------------------------------------------------------------------------


    [5.4] Pre uzivatela "oracle" vytvorime subor s premennymi prostredia pre Oracle GRID na druhom Oracle node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# vi /home/oracle/grid_env
    --------------------------------------------------------------------------------------------------------
    ORACLE_SID=+ASM2; export ORACLE_SID
    ...
    --------------------------------------------------------------------------------------------------------


    [5.5] Pre uzivatela "oracle" vytvorime subor s premennymi prostredia pre Oracle DB na prvom Oracle node (ORADB01)
    --------------------------------------------------------------------------------------------------------
    ORADB01# vi /home/oracle/db_env
    --------------------------------------------------------------------------------------------------------
    ORACLE_SID=clsdb1; export ORACLE_SID
    ORACLE_HOME=$DB_HOME; export ORACLE_HOME
    PATH=$ORACLE_HOME/bin:$BASE_PATH; export PATH
    
    LD_LIBRARY_PATH=$ORACLE_HOME/lib:/lib:/usr/lib; export LD_LIBRARY_PATH
    CLASSPATH=$ORACLE_HOME/JRE:$ORACLE_HOME/jlib:$ORACLE_HOME/rdbms/jlib; export CLASSPATH
    --------------------------------------------------------------------------------------------------------


    [5.6] Pre uzivatela "oracle" vytvorime subor s premennymi prostredia pre Oracle DB na druhom Oracle node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# vi /home/oracle/db_env
    --------------------------------------------------------------------------------------------------------
    ORACLE_SID=clsdb2; export ORACLE_SID
    ...
    --------------------------------------------------------------------------------------------------------


    [5.7] Otestovanie prostredi Oracle GRID (grid_env) a Oracle DB (db_env)
    --------------------------------------------------------------------------------------------------------
    # su - oracle
    # echo $ORACLE_HOME
    /data/u01/app/oracle/db11204
    
    # grid_env
    # echo $ORACLE_HOME
    /data/u01/app/grid11204
    
    # db_env
    # echo $ORACLE_HOME
    /data/u01/app/oracle/db11204
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [6] Prostredie uzivatela "grid"
================================================================================================================


    [6.1] Pre uzivatela "grid" vytvorime BASH profil (~/.bash_profile) na prvom Oracle node (ORADB01)
    --------------------------------------------------------------------------------------------------------
    ORADB01# vi /home/grid/.bash_profile 
    --------------------------------------------------------------------------------------------------------
    # Specificke nastavenia pre uzivatela "grid"
    umask 022
    
    # Get the aliases and functions
    if [ -f ~/.bashrc ]; then
    . ~/.bashrc
    fi
    
    # User specific environment and startup programs
    if [ $USER = “grid” ]; then
    if [ $SHELL = “/bin/ksh” ]; then
    ulimit -p 16384
    ulimit -n 65536
    else
    ulimit -u 16384 -n 65536
    fi
    fi
    
    # Grid Settings
    TMP=/tmp; export TMP
    TMPDIR=$TMP; export TMPDIR
    
    ORACLE_HOSTNAME=oradb01.domena.sk; export ORACLE_HOSTNAME
    ORACLE_UNQNAME=clsdb; export ORACLE_UNQNAME
    ORACLE_BASE=/data/u01/app/grid; export ORACLE_BASE
    GRID_HOME=/data/u01/app/grid11204; export GRID_HOME
    ORACLE_HOME=$GRID_HOME; export ORACLE_HOME
    ORACLE_SID=+ASM1; export ORACLE_SID
    ORACLE_TERM=xterm; export ORACLE_TERM
    
    LD_LIBRARY_PATH=$ORACLE_HOME/lib:/lib:/usr/lib; export LD_LIBRARY_PATH
    CLASSPATH=$ORACLE_HOME/JRE:$ORACLE_HOME/jlib:$ORACLE_HOME/rdbms/jlib; export CLASSPATH
    
    BASE_PATH=/usr/sbin:$PATH:$HOME/bin; export BASE_PATH
    PATH=$ORACLE_HOME/bin:$BASE_PATH; export PATH

    alias sql='sqlplus / as sysasm'
    --------------------------------------------------------------------------------------------------------


    [6.2] Pre uzivatela "grid" vytvorime BASH profil (~/.bash_profile) na druhom Oracle node (ORADB02)
    --------------------------------------------------------------------------------------------------------
    ORADB02# vi /home/grid/.bash_profile 
    --------------------------------------------------------------------------------------------------------
    ORACLE_HOSTNAME=oradb02.domena.sk; export ORACLE_HOSTNAME
    ORACLE_SID=+ASM2; export ORACLE_SID
    --------------------------------------------------------------------------------------------------------

</pre>