<pre>

================================================================================================================
 Instalacia a konfiguracia Autoritativneho DNS servera "knot" (Debian Linux 8.5)
================================================================================================================


================================================================================================================
 [1] Instalacia Autoritativneho DNS servera "knot"
================================================================================================================


    [1.1] Nainstalujeme balicek s autoritativnym DNS serverom "knot"
    --------------------------------------------------------------------------------------------------------
    # apt-get install knot
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [2] Zakladna konfiguracia Autoritativneho DNS servera "knot"
================================================================================================================


    [2.1] Do konfiguracie DNS servera doplnime informacie o novych zonach (konfiguracna sekcia "zones { ... }"). 
          Tato konfiguracie obsahuje nasledovne zony:

          +---------------------------+-----------------------------------------------------------------------+
          | DNS zona                  | Zonovy subor                                                          |
          +---------------------------+-----------------------------------------------------------------------+
          | domena.sk                 | /etc/knot/domena.sk.zone                                              |
          | 10.10.10.in-addr.arpa     | /etc/knot/10.10.10.in-addr.arpa                                       |
          | 20.10.10.in-addr.arpa     | /etc/knot/20.10.10.in-addr.arpa                                       |
          | 30.10.10.in-addr.arpa     | /etc/knot/30.10.10.in-addr.arpa                                       |
          | 40.10.10.in-addr.arpa     | /etc/knot/40.10.10.in-addr.arpa                                       |
          +---------------------------+-----------------------------------------------------------------------+


    [2.2] Uprava konfiguracie DNS servera "knot" - doplnenie informacie o zonach.
    --------------------------------------------------------------------------------------------------------
    # vi /etc/knot/knot.conf
    --------------------------------------------------------------------------------------------------------
    ...

    # Definicia knot aliasov pre IP adresy.
    # Nadefinujeme si len jeden server a to server na ktorom je nainstalovany samotny DNS server "knot". Pre server "tento-server" povolime nasledne DNS zonovy prenos (zone transfer).
    remotes {
      tento-server {
        address 10.10.40.13@53;
      }
    }

    ...


    zones {
    
    # DNS zona "domena.sk", ktora pouziva zonovy subor "/etc/knot/domena.sk.zone" a povoluje prenos zony (zone transfer), ktory je inicializovany so samotneho DNS servera (tento-server).
    domena.sk {
        file "/etc/knot/domena.sk.zone";
        xfr-out tento-server;
    }

  
    # Reverzna DNS zona "10.10.10.in-addr.arpa", ktora pouziva zonovy subor "/etc/knot/10.10.10.in-addr.arpa" a povoluje prenos zony (zone transfer), ktory je inicializovany so samotneho DNS servera (tento-server).
    10.10.10.in-addr.arpa {
        file "/etc/knot/10.10.10.in-addr.arpa";
        xfr-out tento-server;
    }
    
    # Reverzna DNS zona "20.10.10.in-addr.arpa", ktora pouziva zonovy subor "/etc/knot/20.10.10.in-addr.arpa" a povoluje prenos zony (zone transfer), ktory je inicializovany so samotneho DNS servera (tento-server).
    20.10.10.in-addr.arpa {
        file "/etc/knot/20.10.10.in-addr.arpa";
        xfr-out tento-server;
    }
    
    # Reverzna DNS zona "30.10.10.in-addr.arpa", ktora pouziva zonovy subor "/etc/knot/30.10.10.in-addr.arpa" a povoluje prenos zony (zone transfer), ktory je inicializovany so samotneho DNS servera (tento-server).
    30.10.10.in-addr.arpa {
        file "/etc/knot/30.10.10.in-addr.arpa";
        xfr-out tento-server;
    }
    
    # Reverzna DNS zona "40.10.10.in-addr.arpa", ktora pouziva zonovy subor "/etc/knot/40.10.10.in-addr.arpa" a povoluje prenos zony (zone transfer), ktory je inicializovany so samotneho DNS servera (tento-server).
    40.10.10.in-addr.arpa {
        file "/etc/knot/40.10.10.in-addr.arpa";
        xfr-out tento-server;
    }

    ...
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [3] Konfiguracia zony "domena.sk"
================================================================================================================


    [3.1] Konfiguracia DNS zony "domena.sk".
    --------------------------------------------------------------------------------------------------------
    # vi /etc/knot/domena.sk.zone
    --------------------------------------------------------------------------------------------------------
    $ORIGIN domena.sk.
    $TTL 3600
    @       SOA     dns1.domena.sk. hostmaster.domena.sk. (
                    2016102609      ; serial
                    6h              ; refresh
                    1h              ; retry
                    1w              ; expire
                    1d )            ; minimum
            NS      dns1
    
    dns1    A       10.10.40.13
    
    ; Oracle RAC - public IP
    oradb01          A    10.10.10.11
    oradb02          A    10.10.10.12
    
    ; Oracle RAC - virtual IP
    oradb01-vip      A    10.10.10.21
    oradb02-vip      A    10.10.10.22
    
    ; Oracle RAC - scan IP
    oradb-scan       A    10.10.10.31
    oradb-scan       A    10.10.10.32
    oradb-scan       A    10.10.10.33
    
    ; Oracle RAC - interconnect IP
    oradb01-int      A    10.10.20.11
    oradb02-int      A    10.10.20.12
    
    ; Oracle RAC - symantec backend
    oradb01-bck      A    10.10.30.11
    oradb02-bck      A    10.10.30.12

    ; Oracle RAC - OS/DB management
    oradb01-mng      A    10.10.40.11
    oradb02-mng      A    10.10.40.12
    oradb01-iscsi    A    10.10.50.11
    
    ; Oracle RAC - zaznamy pre Symantec Backup Exec (Oracle RAC databaza s nazvom "CLSDB" a DBID "1514125476")
    rac-clsopdb-1514125476    A    10.10.30.11
    rac-clsopdb-1514125476    A    10.10.30.12

    ; mng-backupsrv01
    mng-backupsrv01        A    10.10.40.14
    mng-backupsrv01-bck    A    10.10.30.14
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [4] Konfiguracia reverznej zony "10.10.10.in-addr.arpa"
================================================================================================================


    [4.1] Konfiguracia reverznej DNS zony "10.10.10.in-addr.arpa".
    --------------------------------------------------------------------------------------------------------
    # vi /etc/knot/10.10.10.in-addr.arpa
    --------------------------------------------------------------------------------------------------------
    $TTL    86400
    10.10.10.in-addr.arpa.       IN      SOA     dns1.domena.sk hostmaster.domena.sk. (
                               20161007 ; serial
                               4h       ; slave refresh
                               2h       ; slave retry interval
                               2w       ; slave data expiration
                               1h )     ; maximum caching time when lookups fail
    ;
    
    11.10.10.10.in-addr.arpa.   IN      PTR     oradb01.domena.sk.
    12.10.10.10.in-addr.arpa.   IN      PTR     oradb02.domena.sk.
    
    21.10.10.10.in-addr.arpa.   IN      PTR     oradb01-vip.domena.sk.
    22.10.10.10.in-addr.arpa.   IN      PTR     oradb02-vip.domena.sk.
    
    31.10.10.10.in-addr.arpa.   IN      PTR     oradb-scan.domena.sk.
    32.10.10.10.in-addr.arpa.   IN      PTR     oradb-scan.domena.sk.
    33.10.10.10.in-addr.arpa.   IN      PTR     oradb-scan.domena.sk.
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [5] Konfiguracia reverznej zony "20.10.10.in-addr.arpa"
================================================================================================================


    [5.1] Konfiguracia reverznej DNS zony "20.10.10.in-addr.arpa".
    --------------------------------------------------------------------------------------------------------
    # vi /etc/knot/20.10.10.in-addr.arpa
    --------------------------------------------------------------------------------------------------------
    $TTL    86400
    20.10.10.in-addr.arpa.       IN      SOA     dns1.domena.sk hostmaster.domena.sk. (
                               20161006 ; serial
                               4h       ; slave refresh
                               2h       ; slave retry interval
                               2w       ; slave data expiration
                               1h )     ; maximum caching time when lookups fail
    ;
    
    11.20.10.10.in-addr.arpa.   IN      PTR     oradb01-int.domena.sk.
    12.20.10.10.in-addr.arpa.   IN      PTR     oradb02-int.domena.sk.
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [6] Konfiguracia reverznej zony "30.10.10.in-addr.arpa"
================================================================================================================


    [6.1] Konfiguracia reverznej DNS zony "30.10.10.in-addr.arpa".
    --------------------------------------------------------------------------------------------------------
    # vi /etc/knot/30.10.10.in-addr.arpa
    --------------------------------------------------------------------------------------------------------
    $TTL    86400
    30.10.10.in-addr.arpa.       IN      SOA     dns1.domena.sk hostmaster.domena.sk. (
                               20161006 ; serial
                               4h       ; slave refresh
                               2h       ; slave retry interval
                               2w       ; slave data expiration
                               1h )     ; maximum caching time when lookups fail
    ;
    
    11.30.10.10.in-addr.arpa.   IN      PTR     oradb01-bck.domena.sk.
    12.30.10.10.in-addr.arpa.   IN      PTR     oradb02-bck.domena.sk.
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [7] Konfiguracia reverznej zony "40.10.10.in-addr.arpa"
================================================================================================================


    [7.1] Konfiguracia reverznej DNS zony "40.10.10.in-addr.arpa".
    --------------------------------------------------------------------------------------------------------
    # vi /etc/knot/40.10.10.in-addr.arpa
    --------------------------------------------------------------------------------------------------------
    $TTL    86400
    40.10.10.in-addr.arpa.       IN      SOA     dns1.domena.sk hostmaster.domena.sk. (
                               20161006 ; serial
                               4h       ; slave refresh
                               2h       ; slave retry interval
                               2w       ; slave data expiration
                               1h )     ; maximum caching time when lookups fail
    ;

    40.10.10.in-addr.arpa.      IN      NS      dns1.domena.sk.
    
    11.40.10.10.in-addr.arpa.   IN      PTR     oradb01-mng.domena.sk.
    12.40.10.10.in-addr.arpa.   IN      PTR     oradb02-mng.domena.sk.
    --------------------------------------------------------------------------------------------------------


================================================================================================================
 [8] Restartovanie DNS servera a vykonanie DNS testov
================================================================================================================


    [8.1] Restart DNS servera
    --------------------------------------------------------------------------------------------------------
    # /etc/init.d/knot restart
    --------------------------------------------------------------------------------------------------------
    [ ok ] Restarting knot (via systemctl): knot.service.
    --------------------------------------------------------------------------------------------------------


    [8.2] Prenos zony "domena.sk" (toto je samozrejme mozne iba vdaka tomu, ze sme prenos zony explicitne povolili).
    --------------------------------------------------------------------------------------------------------
    # dig @10.10.40.13 domena.sk axfr
    --------------------------------------------------------------------------------------------------------
    ; <<>> DiG 9.9.5-9+deb8u6-Debian <<>> @10.10.40.13 domena.sk axfr
    ; (1 server found)
    ;; global options: +cmd
    domena.sk.            3600    IN      SOA     dns1.domena.sk. hostmaster.domena.sk. 2016102609 21600 3600 604800 86400
    domena.sk.            3600    IN      NS      dns1.domena.sk.
    dns1.domena.sk.       3600    IN      A       10.10.40.13
    mng-backupsrv01.domena.sk. 3600 IN    A       10.10.40.14
    mng-backupsrv01-bck.domena.sk. 3600 IN A      10.10.30.14
    oradb-scan.domena.sk. 3600 IN      A       10.10.10.31
    oradb-scan.domena.sk. 3600 IN      A       10.10.10.32
    oradb-scan.domena.sk. 3600 IN      A       10.10.10.33
    oradb01.domena.sk. 3600    IN      A       10.10.10.11
    oradb01-bck.domena.sk. 3600 IN     A       10.10.30.11
    oradb01-int.domena.sk. 3600 IN     A       10.10.20.11
    oradb01-iscsi.domena.sk. 3600 IN   A       10.10.50.11
    oradb01-mng.domena.sk. 3600 IN     A       10.10.40.11
    oradb01-vip.domena.sk. 3600 IN     A       10.10.10.21
    oradb02.domena.sk. 3600    IN      A       10.10.10.12
    oradb02-bck.domena.sk. 3600 IN     A       10.10.30.12
    oradb02-int.domena.sk. 3600 IN     A       10.10.20.12
    oradb02-mng.domena.sk. 3600 IN     A       10.10.40.12
    oradb02-vip.domena.sk. 3600 IN     A       10.10.10.22
    rac-clsopdb-1514125476.domena.sk. 3600 IN A   10.10.30.11
    rac-clsopdb-1514125476.domena.sk. 3600 IN A   10.10.30.12
    domena.sk.            3600    IN      SOA     dns1.domena.sk. hostmaster.domena.sk. 2016102609 21600 3600 604800 86400
    ;; Query time: 0 msec
    ;; SERVER: 10.10.40.13#53(10.10.40.13)
    ;; WHEN: Wed Oct 26 14:38:22 CEST 2016
    ;; XFR size: 22 records (messages 1, bytes 704)
    --------------------------------------------------------------------------------------------------------


    [8.3] Prenos reverznej zony "10.10.10.in-addr.arpa" (toto je samozrejme mozne iba vdaka tomu, ze sme prenos zony explicitne povolili).
    --------------------------------------------------------------------------------------------------------
    # dig @10.10.40.13 10.10.10.in-addr.arpa axfr
    --------------------------------------------------------------------------------------------------------
    ; <<>> DiG 9.9.5-9+deb8u6-Debian <<>> @10.10.40.13 10.10.10.in-addr.arpa axfr
    ; (1 server found)
    ;; global options: +cmd
    10.10.10.in-addr.arpa. 86400   IN      SOA     dns1.domena.sk.10.10.10.in-addr.arpa. hostmaster.domena.sk. 20161007 14400 7200 1209600 3600
    11.10.10.10.in-addr.arpa. 86400 IN     PTR     oradb01.domena.sk.
    12.10.10.10.in-addr.arpa. 86400 IN     PTR     oradb02.domena.sk.
    21.10.10.10.in-addr.arpa. 86400 IN     PTR     oradb01-vip.domena.sk.
    22.10.10.10.in-addr.arpa. 86400 IN     PTR     oradb02-vip.domena.sk.
    31.10.10.10.in-addr.arpa. 86400 IN     PTR     oradb-scan.domena.sk.
    32.10.10.10.in-addr.arpa. 86400 IN     PTR     oradb-scan.domena.sk.
    33.10.10.10.in-addr.arpa. 86400 IN     PTR     oradb-scan.domena.sk.
    10.10.10.in-addr.arpa. 86400   IN      SOA     dns1.domena.sk.10.10.10.in-addr.arpa. hostmaster.domena.sk. 20161007 14400 7200 1209600 3600
    ;; Query time: 0 msec
    ;; SERVER: 10.10.40.13#53(10.10.40.13)
    ;; WHEN: Wed Oct 26 14:39:53 CEST 2016
    ;; XFR size: 9 records (messages 1, bytes 491)
    --------------------------------------------------------------------------------------------------------


    [8.4] Prenos reverznej zony "20.10.10.in-addr.arpa" (toto je samozrejme mozne iba vdaka tomu, ze sme prenos zony explicitne povolili).
    --------------------------------------------------------------------------------------------------------
    # dig @10.10.40.13 20.10.10.in-addr.arpa axfr
    --------------------------------------------------------------------------------------------------------
    ; <<>> DiG 9.9.5-9+deb8u6-Debian <<>> @10.10.40.13 20.10.10.in-addr.arpa axfr
    ; (1 server found)
    ;; global options: +cmd
    20.10.10.in-addr.arpa. 86400   IN      SOA     dns1.domena.sk.20.10.10.in-addr.arpa. hostmaster.domena.sk. 20161006 14400 7200 1209600 3600
    11.20.10.10.in-addr.arpa. 86400 IN     PTR     oradb01-int.domena.sk.
    12.20.10.10.in-addr.arpa. 86400 IN     PTR     oradb02-int.domena.sk.
    20.10.10.in-addr.arpa. 86400   IN      SOA     dns1.domena.sk.20.10.10.in-addr.arpa. hostmaster.domena.sk. 20161006 14400 7200 1209600 3600
    ;; Query time: 0 msec
    ;; SERVER: 10.10.40.13#53(10.10.40.13)
    ;; WHEN: Wed Oct 26 14:43:46 CEST 2016
    ;; XFR size: 4 records (messages 1, bytes 287)
    --------------------------------------------------------------------------------------------------------


    [8.5] Prenos reverznej zony "30.10.10.in-addr.arpa" (toto je samozrejme mozne iba vdaka tomu, ze sme prenos zony explicitne povolili).
    --------------------------------------------------------------------------------------------------------
    # dig @10.10.40.13 30.10.10.in-addr.arpa axfr
    --------------------------------------------------------------------------------------------------------
    ; <<>> DiG 9.9.5-9+deb8u6-Debian <<>> @10.10.40.13 30.10.10.in-addr.arpa axfr
    ; (1 server found)
    ;; global options: +cmd
    30.10.10.in-addr.arpa. 86400   IN      SOA     dns1.domena.sk.30.10.10.in-addr.arpa. hostmaster.domena.sk. 20161006 14400 7200 1209600 3600
    11.30.10.10.in-addr.arpa. 86400 IN     PTR     oradb01-bck.domena.sk.
    12.30.10.10.in-addr.arpa. 86400 IN     PTR     oradb02-bck.domena.sk.
    30.10.10.in-addr.arpa. 86400   IN      SOA     dns1.domena.sk.30.10.10.in-addr.arpa. hostmaster.domena.sk. 20161006 14400 7200 1209600 3600
    ;; Query time: 0 msec
    ;; SERVER: 10.10.40.13#53(10.10.40.13)
    ;; WHEN: Wed Oct 26 14:43:56 CEST 2016
    ;; XFR size: 4 records (messages 1, bytes 287)
    --------------------------------------------------------------------------------------------------------


    [8.6] Prenos reverznej zony "40.10.10.in-addr.arpa" (toto je samozrejme mozne iba vdaka tomu, ze sme prenos zony explicitne povolili).
    --------------------------------------------------------------------------------------------------------
    # dig @10.10.40.13 40.10.10.in-addr.arpa axfr
    --------------------------------------------------------------------------------------------------------
    ; <<>> DiG 9.9.5-9+deb8u6-Debian <<>> @10.10.40.13 40.10.10.in-addr.arpa axfr
    ; (1 server found)
    ;; global options: +cmd
    40.10.10.in-addr.arpa.  86400   IN      SOA     dns1.domena.sk.40.10.10.in-addr.arpa. hostmaster.domena.sk. 20161006 14400 7200 1209600 3600
    40.10.10.in-addr.arpa.  86400   IN      NS      dns1.domena.sk.
    11.40.10.10.in-addr.arpa. 86400 IN      PTR     oradb01-mng.domena.sk.
    12.40.10.10.in-addr.arpa. 86400 IN      PTR     oradb02-mng.domena.sk.
    40.10.10.in-addr.arpa.  86400   IN      SOA     dns1.domena.sk.40.10.10.in-addr.arpa. hostmaster.domena.sk. 20161006 14400 7200 1209600 3600
    ;; Query time: 0 msec
    ;; SERVER: 10.10.40.13#53(10.10.40.13)
    ;; WHEN: Wed Oct 26 14:44:07 CEST 2016
    ;; XFR size: 5 records (messages 1, bytes 316)
    --------------------------------------------------------------------------------------------------------

</pre>