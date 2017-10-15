<pre>

================================================================================================================
 Instalacia a konfiguracia Symantec Backup Exec Linux klienta pre zalohovanie OS a Oracle RAC databazy
================================================================================================================


    Symantec Backup Exec Linux agent
    --------------------------------------------------------------------------------------------------------
    - Server: Vsetky Oracle RAC servery
    - OS: SUSE 11 SP3
    - Symantec BE Linux agent verzia: /var/VRTSralus/ralus.ver
      ralus=1180.3142
      mdm=MDM_v42.2.3019
      vxms=VxMS_4.4_045
    - Log adresar: /var/VRTSralus
    - Konfiguracny subor: /etc/VRTSralus/ralus.cfg
    - Riadiaci skript: /etc/init.d/VRTSralus.init
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [1] Instalacia Symantec Backup Exec Linux agenta
================================================================================================================


    [1.0] Instalacne ISO medium Symantec Backup Exec Linux agenta umiestnime do instalacneho adresara (/data/install)
          a nasledne ho pripojime do systemu (/media/iso)
    --------------------------------------------------------------------------------------------------------
    # mkdir /media/iso
    # cd /data/install
    # unzip ./Backup_Exec_15_14.2_FP5_MultiPlatforms_Multilingual.zip
    # mount ./Backup_Exec_15_14.2_FP5_MultiPlatforms_Multilingual.iso /media/iso -t iso9660 -o loop
    --------------------------------------------------------------------------------------------------------


    [1.1] Instalacny archiv (TAR.GZ) umiestnime na lokalny disk a rozbalime ho
    --------------------------------------------------------------------------------------------------------
    # cp /media/iso/LinuxMac/RALUS_RMALS_RAMS-1180.3142.tar.gz /data/install
    # cd /data/install
    # tar -xvf ./RALUS_RMALS_RAMS-1180.3142.tar.gz
    --------------------------------------------------------------------------------------------------------


    [1.2] Spustime instalaciu Symantec Backup Exec Linux agenta
    --------------------------------------------------------------------------------------------------------
    Poznamka1: Pre 64 bitove systemy je to "RALUS64".
    Poznamka2: Pre 32 bitove systemy je to "RALUSx86".
    --------------------------------------------------------------------------------------------------------
    # cd /data/install/RALUS64
    # ./installralus
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    Enter the system names separated by spaces on which to install RALUS: (ORADB01) - [ORADB01-BCK] [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    Checking system communication:
    
        Checking OS version on ORADB01-BCK ...................................................................................................................... Linux 3.0.76-0.11-default
        Checking system support for ORADB01-BCK .............................................................................................. Linux 3.0.76-0.11-default supported by RALUS
    
    Initial system check completed successfully.
    
    Press [Return] to continue: [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    installralus will install the following RALUS packages on Linux target system: ORADB01-BCK
    
    VRTSralus        Symantec Backup Exec Agent for Linux
    
    Press [Return] to continue: [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    Checking system installation requirements:
    
    Checking RALUS installation requirements on Linux target systems: ORADB01-BCK
    
    Checking RALUS installation requirements on ORADB01-BCK:
    
        Checking file system space ............................................................................................................................... required space is available
    
    Installation requirements checks completed successfully.
    
    Press [Return] to continue: [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    To perform backups, you must have a 'beoper' user group configured with root account priviledges on the system. The 'beoper' user group can be created on all systems except NIS Servers.
    
    After pressing [Return], the system 'ORADB01-BCK' will be scanned to detect a 'beoper' user group with root account privileges. It will also scan for a NIS server.
    
    Press [Return] to continue: [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
        Checking for NIS server: ......................................................................................................................................................... No
    
        Checking for 'beoper' user group: .......................................................................................................................................... Not Found
        Checking for 'root' user membership in 'beoper' user group: ................................................................................................................ Not Found
    
    You can create 'beoper' user group manually or you can choose to have it created automatically.
    
    Do you want installer to create 'beoper' user group on 'ORADB01-BCK'? [y, n] (y) [ENTER]
    Do you want to use specific group ID when creating 'beoper' user group? [y, n] (n) [y]
    Enter group ID for 'beoper' user group: [666] [ENTER]

    Creating group 'beoper'with group ID '666': ..................................................................................................................................... Done

    Do you want to add the 'root' user to 'beoper' user group? [y, n] (y) [ENTER]

    Adding 'root' user to 'beoper' user group: ..................................................................................................................................... Done

    Press [Return] to continue: [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    Checking Symantec Backup Exec Agent for Linux on ORADB01-BCK:
    
        Checking VRTSralus package ............................................................................................................................................. not installed
    
    Press [Return] to continue: [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    Installing Symantec Backup Exec Agent for Linux on ORADB01-BCK:
    
        Installing VRTSralus 14.2.1180-3142 on ORADB01-BCK .................................................................................................................. done 1 of 1 steps
    
    Symantec Backup Exec Agent for Linux installation completed successfully.
    
    Press [Return] to continue: [ENTER]
    --------------------------------------------------------------------------------------------------------

    --------------------------------------------------------------------------------------------------------
    Configuring Symantec Backup Exec Agent for Linux:
    
        Creating configuration files on ORADB01-BCK .................................................................................................................................. Done
    
    The agent installer can automatically start the agent after the installation completes. Do you want to automatically start the agent on 'ORADB01-BCK'? [y, n] (y) [ENTER]

    Starting agent on ORADB01-BCK .................................................................................................................................................... Done

    To establish a trust between the Backup Exec server and the agent, move to the Backup Exec server and add the agent computer to the list of servers.
    
    To add the agent computer, click Add on the Backup and Restore tab.
    
    Symantec Backup Exec Agent for Linux configured successfully.
    
    Press [Return] to continue: [ENTER]

    The response file is saved at:
    
        /var/tmp/vxif/installralus1025131129/installralus1025131129.response
    
    The installralus log is saved at:
    
        /var/tmp/vxif/installralus1025131129/installralus.log
    --------------------------------------------------------------------------------------------------------


    [1.3] Preverenie ci instalator vytvoril lokalnu skupinu "beoper" a ci do nej zaradil lokalneho uzivatela "root"
    --------------------------------------------------------------------------------------------------------
    # cat /etc/group | grep beoper
    --------------------------------------------------------------------------------------------------------
    beoper:!:666:root,oracle
    --------------------------------------------------------------------------------------------------------


    [1.4] Pre pristup na Linux servery sa bude pouzivat lokalny ucet "be" a preto ho vytvorime a zaradime do
          lokalnej skupiny "beoper"
    --------------------------------------------------------------------------------------------------------
    # Yast
    # Security and Users -> User and Group Management
    # Zaradime uzivatela "be" do skupiny "beoper"
    --------------------------------------------------------------------------------------------------------


    [1.5] Preverenie ktore lokalne ucty su clenom lokalnej skupiny "beoper"
    --------------------------------------------------------------------------------------------------------
    # cat /etc/group | grep beoper
    --------------------------------------------------------------------------------------------------------
    beoper:!:666:be,root,oracle
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [2] Konfiguracia Symantec Backup Exec Linux agenta - zapnutie logovania
================================================================================================================


    [2.1] Vo funkcii "start" v ramci riadiaceho skriptu (/etc/init.d/VRTSralus.init) doplnime argument pre
          zapnutie logovania (standardny Symantec adresar -> /var/VRTSralus)
    --------------------------------------------------------------------------------------------------------
    # vi /etc/init.d/VRTSralus.init
    --------------------------------------------------------------------------------------------------------
    # POVODNE
    # /opt/VRTSralus/bin/beremote >/var/VRTSralus/beremote.service.log 2>/var/VRTSralus/beremote.service.log &

    # UPRAVENE
    /opt/VRTSralus/bin/beremote --log-file-auto >/var/VRTSralus/beremote.service.log 2>/var/VRTSralus/beremote.service.log &
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [3] Konfiguracia Symantec Backup Exec Linux agenta - pokrocilejsia konfiguracia
================================================================================================================


    [3.1] Do konfiguracneho suboru Symantec agenta pridame alebo zmenime hodnoty direktiv uzitocnych pre ladenie konfiguracie.
    --------------------------------------------------------------------------------------------------------
    # vi /etc/VRTSralus/ralus.cfg
    --------------------------------------------------------------------------------------------------------
    Software\Symantec\Backup Exec For Windows\Backup Exec\Debug\AgentConfig=1
    Software\Symantec\Backup Exec For Windows\Backup Exec\Debug\VXBSAlevel=5
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\Logging\RANT NDMP Debug Level=1
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\Agents\Agent Directory List 1=mng-backupsrv01-bck.domena.sk
    --------------------------------------------------------------------------------------------------------


    [3.2] Popis uzitocnych konfiguracnych direktiv pre Symantec Backup Exec Linux a Oracle agenta
    --------------------------------------------------------------------------------------------------------
    # Logovanie operacii vykonanych v konfiguracnom nastroji Symantec agenta (AgentConfig), ktore vykonavaju Oracle operacie (0=vypnute, 1=zapnute)
    Software\Symantec\Backup Exec For Windows\Backup Exec\Debug\AgentConfig=1
    
    # Logovanie Oracle operacii (0=vypnute, 5=normal, 6=advanced) Symantec agentom
    Software\Symantec\Backup Exec For Windows\Backup Exec\Debug\VXBSAlevel=5
    
    # Zapnutie publikovania informacii smerom na vsetky Backup Exec server/y (0=publikovanie len na prvy uspesny server v "Agent Directory List", 1=publikovanie vzdy na vsetky servery)
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\Agents\Advertise All=1
    
    # Povolenie/zakazanie publikovania informacii smerom na Backup Exec server/y (0=zapnute publikovanie, 1=vypnute publikovanie)
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\Agents\Advertising Disabled=0
    
    # Zoznam Backup Exec server/ov (IP, FQDN, NETBIOS meno) do ktorych bude Symantec agent publikovat informacie
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\Agents\Agent Directory List 1=10.161.1.14
    
    # Uroven logovania NDMP informacii (0=iba NDMP chyby, 1=chyby a upozornenia, 2=vsetko) Symantec agentom
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\Logging\RANT NDMP Debug Level=1
    
    # Konfiguracia enkodovania znakov
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\RALUS\Encoder=LATIN-1
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [4] Konfiguracia Symantec Backup Exec Linux agenta - prerequizity pre zalohovanie Oracle RAC
================================================================================================================


    [4.1] Subor s informaciami o Oracle DB a ASM instanciach (/etc/oratab) prekopirujeme do konfiguracneho
          adresara Symantec agenta pod nazvom "beoratab" (/etc/VRTSralus/beoratab) a nastavime spravneho
          vlastnika a opravnenia.
    --------------------------------------------------------------------------------------------------------
    # cp /etc/oratab /etc/VRTSralus/beoratab
    # chown root:beoper /etc/VRTSralus/beoratab
    # chmod g+rw /etc/VRTSralus/beoratab
    --------------------------------------------------------------------------------------------------------


    [4.2] Symantec subor s informaciami o Oracle DB a ASM instanciach (/etc/VRTSralus/beoratab) upravime tak
          aby ohsahoval spravne ORACLE_SID informacie platne pre dany Oracle server.
    --------------------------------------------------------------------------------------------------------
    ORADB01# vi /etc/VRTSralus/beoratab
    --------------------------------------------------------------------------------------------------------
    # POVODNE
    # +ASM1:/data/u01/app/grid11204:N                 # line added by Agent
    # clsopdb:/data/u01/app/oracle/db11204:N          # line added by Agent

    # UPRAVENE
    +ASM1:/data/u01/app/grid11204:N                   # line added by Agent
    clsopdb1:/data/u01/app/oracle/db11204:N           # line added by Agent
    --------------------------------------------------------------------------------------------------------
    ORADB02# vi /etc/VRTSralus/beoratab
    --------------------------------------------------------------------------------------------------------
    # POVODNE
    # +ASM2:/data/u01/app/grid11204:N                 # line added by Agent
    # clsopdb:/data/u01/app/oracle/db11204:N          # line added by Agent

    # UPRAVENE
    +ASM2:/data/u01/app/grid11204:N                   # line added by Agent
    clsopdb2:/data/u01/app/oracle/db11204:N           # line added by Agent
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [5] Konfiguracia Symantec Backup Exec Linux agenta - zalohovanie Oracle RAC
================================================================================================================


    [5.1] Konfiguracia Symantec agenta (Oracle databazovy pristup) pod uzivatelom "root".
    --------------------------------------------------------------------------------------------------------
    # su - 
    # cd /opt/VRTSralus/bin
    # ./AgentConfig
    --------------------------------------------------------------------------------------------------------
    Symantec Backup Exec Remote Agent Utility
         Choose one of the following options:
         1. Configure database access
         2. Configure Oracle instance information
         3. Quit
     Please enter your selection: 1
    --------------------------------------------------------------------------------------------------------
    Configuring machine information
         Choose one of the following options:
         1. Add system credentials for Oracle operations
         2. Edit system credentials used for Oracle operations
         3. Remove system credentials used for Oracle operations
         4. View system credentials used for Oracle operations
         5. Quit
     Please enter your selection: 1
     Enter a user name that has local system credentials: oracle
     Enter the password: Ora.password.123
     Re-enter password: Ora.password.123
     Validating credentials.......
     Do you want to use a custom port to connect to the Backup Exec server during Oracle operations? (Y/N): n
     Commit Oracle operation settings to the configuration file? (Y/N): y
    --------------------------------------------------------------------------------------------------------
    Configuring machine information
         Choose one of the following options:
         1. Add system credentials for Oracle operations
         2. Edit system credentials used for Oracle operations
         3. Remove system credentials used for Oracle operations
         4. View system credentials used for Oracle operations
         5. Quit
     Please enter your selection: 4

     Entry 1
          ObjectName: DBAID
          Port: 5633
     Entry 2
          ObjectName: Machine
          HostUsername: oracle
          Port: 5633
    --------------------------------------------------------------------------------------------------------


    [5.2] Konfiguracia Symantec agenta (Informacie o Oracle instanciach) pod uzivatelom "root".
    Poznamka1: Tato cast konfiguracie zabezpecuje pristup na Oracle RAC instanciu/e a preto je nutne pouzit
               Oracle ucet "sys".
    --------------------------------------------------------------------------------------------------------
    # su - 
    # cd /opt/VRTSralus/bin
    # ./AgentConfig
    --------------------------------------------------------------------------------------------------------
    Symantec Backup Exec Remote Agent Utility
         Choose one of the following options:
         1. Configure database access
         2. Configure Oracle instance information
         3. Quit
     Please enter your selection: 2
    --------------------------------------------------------------------------------------------------------
    Configuring the Oracle Agent
         Choose one of the following options:
         1. Add a new Oracle instance to protect
         2. Edit an existing Oracle instance
         3. Delete an existing Oracle instance
         4. View Oracle instance entries that have been added in the Remote Agent Utility
         5. Quit
     Please enter your selection: 1
     Select an Oracle instance to configure
              Entry 1. clsopdb1
              Enter the number 0 to go back
         Enter your selection: 1
         Enter the Oracle database SYSDBA user name: sys
         Enter the Oracle database SYSDBA password: dbPassword123
         Re-enter password: dbPassword123
         Validating credentials.......
         Enter the Backup Exec server name or IP address: mng-backupsrv01-bck.domena.sk
         Do you use a recovery catalog? (Y/N):n
         Do you want to use a customized job template? (Y/N): n
         Commit Oracle operation settings to the configuration file? (Y/N): y
    --------------------------------------------------------------------------------------------------------
    Configuring the Oracle Agent
         Choose one of the following options:
         1. Add a new Oracle instance to protect
         2. Edit an existing Oracle instance
         3. Delete an existing Oracle instance
         4. View Oracle instance entries that have been added in the Remote Agent Utility
         5. Quit
         Please enter your selection: 4

         Entry 1
              ObjectName: clsopdb1
              DatabaseLogin: sys
              MediaServerName: mng-backupsrv01-bck.domena.sk
              JobTemplate: Default
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [6] Konfiguracia Symantec Backup Exec servera - prerequizity pre zalohovanie Oracle RAC
================================================================================================================


    [6.0] Pred konfiguraciou Backup Exec servera je nutne zistit jednoznacny identifikator Oracle RAC databazy (DB=clsopdb).
          Jednoznacny identifikator Oracle RAC databazy "clsopdb" je "1514125476". V ramci konfiguracie Backup Exec
          servera pouzije ako virtualny Oracle RAC nod hodnotu "RAC-clsopdb-1514125476".
    --------------------------------------------------------------------------------------------------------
    # su - oracle
    # sqlplus / as sysdba
    --------------------------------------------------------------------------------------------------------
    SQL> connect system/dbPassword123@clsopdb;
    Connected.
    SQL> select DBID, NAME from v$database;
    
          DBID NAME
    ---------- ---------
    1514125476 CLSDB
    --------------------------------------------------------------------------------------------------------


    [6.1] Nasim cielom je vykonavat zalohovacie aktivity v ramci Oracle RAC databazy "clsopdb" pod DB uzivatelom
          "BACKUP_EXEC" a preto je nutne vytvorit tento DB ucet v Oracle RAC a nastavit pre neho pozadovane 
           opravnenia potrebne pre prevadzku/fungovanie Symantec Backup Exec zalohovania.
    --------------------------------------------------------------------------------------------------------
    # su - oracle
    # sqlplus / as sysdba
    --------------------------------------------------------------------------------------------------------
    SQL> connect system/dbPassword123@clsopdb;
    Connected.
    SQL> CREATE USER BACKUP_EXEC IDENTIFIED BY ORACLE;
    SQL> GRANT UNLIMITED TABLESPACE TO BACKUP_EXEC;
    SQL> GRANT AQ_ADMINISTRATOR_ROLE TO BACKUP_EXEC;
    SQL> GRANT CONNECT TO BACKUP_EXEC;
    SQL> ALTER USER BACKUP_EXEC DEFAULT ROLE ALL;
    SQL> ALTER USER BACKUP_EXEC DEFAULT TABLESPACE SYSTEM;
    SQL> disconnect
    --------------------------------------------------------------------------------------------------------
    # sqlplus / as sysdba
    --------------------------------------------------------------------------------------------------------
    SQL> connect sys/dbPassword123@clsopdb as sysdba;
    SQL> GRANT SYSDBA TO BACKUP_EXEC;
    --------------------------------------------------------------------------------------------------------


    [6.2] Pre virtualny Oracle RAC nod "RAC-clsopdb-1514125476" je potrebne nastavit DNS zaznamy, aby sa
          Backup Exec Server vedel na tento virtualny Oracle nod pripojit. Tato konfiguracia sa da docielit
          dvoma sposobmi:
          - Nastavit lokalny suborovy resolver na Backup Exec Servery (C:\Windows\System32\drivers\etc\hosts).
          - Nastavit tieto DNS zaznamy na urovni DNS servera. Nizsie uvedena konfiguracia prezentuje tuto moznost.
    --------------------------------------------------------------------------------------------------------
    DNS-SERVER# vi /etc/knot/domena.sk.zone
    --------------------------------------------------------------------------------------------------------
    ; Oracle RAC - zaznamy pre Symantec Backup Exec (Oracle RAC databaza s nazvom "CLSDB" a DBID "1514125476")
    rac-clsopdb-1514125476    A    10.40.192.11
    rac-clsopdb-1514125476    A    10.40.192.12
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [7] Konfiguracia Symantec Backup Exec servera - zalohovanie Oracle RAC
================================================================================================================


    [7.0] Ak mame Oracle RAC servery nakonfigurovane tak, ze Oracle Produkcna siet (PUBLIC, SCAN a VIP IP adresy)
          je pre aplikacne servery v podstate Back-End siet cize nie je priamo dostupna je potrebne na Symantec
          Backup Exec servery nastavit v ramci lokalneho suboroveho resolvera (C:\Windows\System32\drivers\etc\hosts)
          take IP adresy, ktore su cez siet dostupne.
    --------------------------------------------------------------------------------------------------------
    # notepad C:\Windows\System32\drivers\etc\hosts
    --------------------------------------------------------------------------------------------------------
    10.161.1.11 oradb01.domena.sk oradb01
    10.161.1.12 oradb02.domena.sk oradb02
    --------------------------------------------------------------------------------------------------------


    [7.1] Konfiguracia vsetkych uctov (okrem uzivatela "root") v ramci Backup Exec servera, ktore su na 
          Linuxovych serveroch zaradene v lokalnej skupiny "beoper". V nasom pripade to su lokalne ucty "be" a 
          "oracle", ale aj Oracle databazove ucty "sys" a "BACKUP_EXEC".
    --------------------------------------------------------------------------------------------------------
    Configuration and Settings -> Logon Accounts -> Manage Logon Accounts -> Add
    --------------------------------------------------------------------------------------------------------
    User name                        : be
    Password                         : toortoor
    Account name                     : local/be
    This is restricted logon account : uncheck/nezaskrtnute
    This is my default account       : uncheck/nezaskrtnute
    --------------------------------------------------------------------------------------------------------
    User name                        : oracle
    Password                         : Ora.password.123
    Account name                     : local/oracle
    This is restricted logon account : uncheck/nezaskrtnute
    This is my default account       : uncheck/nezaskrtnute
    --------------------------------------------------------------------------------------------------------
    User name                        : sys
    Password                         : dbPassword123
    Account name                     : clsopdb/sys
    This is restricted logon account : uncheck/nezaskrtnute
    This is my default account       : uncheck/nezaskrtnute
    --------------------------------------------------------------------------------------------------------
    User name                        : BACKUP_EXEC
    Password                         : ORACLE
    Account name                     : clsopdb/BACKUP_EXEC
    This is restricted logon account : uncheck/nezaskrtnute
    This is my default account       : uncheck/nezaskrtnute
    --------------------------------------------------------------------------------------------------------


    [7.2] Do zoznamu Oracle nodov pridame vsetky Oracle RAC nody/servery ako aj virtualny Oracle RAC nod 
          (RAC-clsopdb-1514125476), vid. bod [6].
    --------------------------------------------------------------------------------------------------------
    Configuration and Settings -> Backup Exec Settings -> Oracle
    +-------------------------------+--------------------------------------------------------------------------+
    | Server name                   | Logon account                                                            |
    +-------------------------------+--------------------------------------------------------------------------+
    | RAC-clsopdb-1514125476        | local/oracle                                                             |
    | ORADB01.domena.sk        | local/oracle                                                             |
    | ORADB02.domena.sk        | local/oracle                                                             |
    +-------------------------------+--------------------------------------------------------------------------+


================================================================================================================
 [8] Konfiguracia Symantec Backup Exec Linux agenta - restart agenta
================================================================================================================


    [8.1] Na Linux servery vykoname restart Symantec agenta. Po tejto operacii by sa mali Oracle RAC servery ako
          aj Oracle RAC virtualny nod objavit v ramci Symantec Backup Exec servera.
    --------------------------------------------------------------------------------------------------------
    # /etc/init.d/VRTSralus.init restart
    --------------------------------------------------------------------------------------------------------


    V ramci Backup Exec servera sa objavia nasledovne servery:
    --------------------------------------------------------------------------------------------------------
    - ORADB01-BCK.domena.sk (zdetekovane ako Windows)
    - ORADB02-BCK.domena.sk (zdetekovane ako Windows)
    - ORADB01.domena.sk     (zdetekovane ako Linux)
    - ORADB02.domena.sk     (zdetekovane ako Linux)
    - RAC-clsopdb-1514125476     (zdetekovane ako Oracle RAC)
    --------------------------------------------------------------------------------------------------------


    [8.2] Nakolko my chceme pouzivat iba backend zalohovaciu siet (-BCK) odstranime servery bez suffixu "-BCK" konkretne:
    --------------------------------------------------------------------------------------------------------
    - ORADB01.domena.sk     (zdetekovane ako Linux)
    - ORADB02.domena.sk     (zdetekovane ako Linux)
    --------------------------------------------------------------------------------------------------------


    [8.3] Backup Exec Linux agent pri restarte opatovne informuje Backup Exec server/y o serveroch, ktore sme odstranili v 
    bode [8.2]. Z tohto dovodu musime vypnut informovanie/advertising Backup Exec servera/ov Symantec Backup Exec
    Linux klientom v ramci konfiguracie agenta. Je to nutne aj z toho dovodu, ze prihlasovanie sa do Oracle RAC
    databazy "clsopdb" je problematicke/nefunkcne a nie je mozne ani vypisat zoznam DB objektov (TableSpaces, Archivne logy, ...).
    --------------------------------------------------------------------------------------------------------
    # vi /etc/VRTSralus/ralus.cfg
    --------------------------------------------------------------------------------------------------------
    Software\Symantec\Backup Exec For Windows\Backup Exec\Engine\Agents\Advertising Disabled=1
    --------------------------------------------------------------------------------------------------------


    [8.4] Na Linux servery vykoname restart Symantec agenta.
    --------------------------------------------------------------------------------------------------------
    # /etc/init.d/VRTSralus.init restart
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [9] Konfiguracia Symantec Backup Exec servera - zalohovanie Oracle RAC - finalne zmeny
================================================================================================================


    [9.0] V ramci BACKUP EXEC servera pridame Oracle servery.
    --------------------------------------------------------------------------------------------------------
    Backup and Restore -> Add Server -> Linux Computer
    +-------------------------------+--------------------------------------------------------------------------+
    | Server name                   | Logon account                                                            |
    +-------------------------------+--------------------------------------------------------------------------+
    | ORADB01-BCK.domena.sk    | local/oracle                                                             |
    | ORADB02-BCK.domena.sk    | local/oracle                                                             |
    +-------------------------------+--------------------------------------------------------------------------+


    [9.1] Symantec Backup Exec po vytvoreni Oracle RAC virtualneho nodu "RAC-clsopdb-1514125476"
          nenastavi spravny "Logon Account" (nastavi ho na "System Logon Account") aj napriek tomu, ze sme v bode 
          [7.2] nastavili spravny ucet (local/oracle). Z tohto dovodu je nutne to v ramci Backup Exec servera opravit.
    --------------------------------------------------------------------------------------------------------
    Backup and Restore -> 2x klik na Virtualny Oracle RAC nod "RAC-clsopdb-1514125476" -> Properties -> Logon Account
    --------------------------------------------------------------------------------------------------------
    Povodne  -> "System Logon Account"
    Upravene -> "local/oracle"
    --------------------------------------------------------------------------------------------------------
    Backup and Restore -> 2x klik na Oracle RAC nod "ORADB01.domena.sk" -> Logon Account
    --------------------------------------------------------------------------------------------------------
    Povodne  -> "System Logon Account"
    Upravene -> "local/oracle"
    --------------------------------------------------------------------------------------------------------


    [9.2] Po operacii [9.1] je nutne aktualizovat/refresh informacii pre Oracle RAC nody a 
          Oracle RAC virtualny nod "RAC-clsopdb-1514125476".
    --------------------------------------------------------------------------------------------------------
    Backup and Restore -> 1x klik na Oracle RAC nod "ORADB01.domena.sk" -> 1x klik na Refresh tlacidlo
    Backup and Restore -> 1x klik na Virtualny Oracle RAC nod "RAC-clsopdb-1514125476" -> 1x klik na Refresh tlacidlo
    --------------------------------------------------------------------------------------------------------


    [9.3] Po operacii [9.2] je nutne zmenit pristupove heslo do Oracle RAC databazy "clsopdb".
    Poznamka: Z testovania vyplynulo, ze aj ked je Oracle DB ucet "BACKUP_EXEC" pre databazu "clsopdb" spravny
              a funguje nie je mozne ho pouzivat (je nutne pouzit ucet "sys") lebo Backup Exec Server naraba
              s pristupovymi udajmi velmi velmi zvlastne. Z tohto dovodu je nutne nastavit tento ucet ako je
              popisane v bode [9.4].
    --------------------------------------------------------------------------------------------------------
    Backup and Restore -> 2x klik na Virtualny Oracle RAC nod "RAC-clsopdb-1514125476" -> Credentials -> Oracle Database "clsopdb"
    --------------------------------------------------------------------------------------------------------
    Povodne  -> "use server's logon account"
    Upravene -> "clsopdb/BACKUP_EXEC"
    --------------------------------------------------------------------------------------------------------


    [9.4] Nastavenia vyplyvajuce z poznamky z bodu [9.3]
    --------------------------------------------------------------------------------------------------------
    Backup and Restore -> 2x klik na Virtualny Oracle RAC nod "RAC-clsopdb-1514125476" -> Credentials -> Oracle Database "clsopdb"
    --------------------------------------------------------------------------------------------------------
    Povodne  -> "use server's logon account"
    Upravene -> "clsopdb/sys"
    --------------------------------------------------------------------------------------------------------


    [9.5] Po operacii [9.3] je nutne zmenit pristupove heslo na Oracle RAC servery (zalohovanie OS).
    --------------------------------------------------------------------------------------------------------
    Backup and Restore -> 2x klik na Oracle RAC nod "ORADB01.domena.sk" -> Logon Account + Credentials
    Backup and Restore -> 2x klik na Oracle RAC nod "ORADB02.domena.sk" -> Logon Account + Credentials
    --------------------------------------------------------------------------------------------------------
    Povodne  -> "use server's logon account"
    Upravene -> "local/be"
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [X] Zaujimave odkazy na internete
================================================================================================================


    Poznamka1: Informacie v odkazoch neobsahuju vysvetelenie detailov a niektore konfiguracie su vyslovene zavadzajuce.
    Poznamka2: Na internete som, ale nenasiel lepsie informacie k zalohovaniu Oracle RAC pomocou Symantec Backup Exec.
    --------------------------------------------------------------------------------------------------------
    https://dba010.wordpress.com/2013/02/27/create-oracle-backup-job-in-backup-exec/
    https://www.veritas.com/support/en_US/article.TECH49969
    https://vox.veritas.com/t5/Backup-Exec/Backup-of-Oracle-RAC-cluster-is-displayed-as/td-p/516167
    https://www.weichert.it/de/oracle_rac_backup_ueber_backup_exec/

</pre>
