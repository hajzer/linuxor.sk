## 2016 - Linux NET Namespace - Prepojenie dvoch sieťových menných priestorov (ns1, ns2) - pomocou 2 párov veth adaptérov a distribuovaného prepínača OVS (openvswitch)


**FILE:** 2016-linuxnamespace-net-ns-veth-ovs-veth-ns.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1


<pre>
======================================================================================================================
 [1] NET namespace - Prepojenie dvoch sietovych mennych priestorov (ns1, ns2) - pomocou 2 parov veth adapterov a 
                     distribuovaneho prepinaca OVS (openvswitch)
======================================================================================================================


     +------------------+                 +-------------------------------+                 +------------------+
     | ns1        veth1 |======kabel======| veth1-ovs   ovs0    veth2-ovs |======kabel======| veth2        ns2 |
     +------------------+                 +-------------------------------+                 +------------------+
       namespace "ns1"                     hostitelsky system (openvswitch)                    namespace "ns2"


    Prvy  ethernet kabel (medzi mennym priestorom "ns1" a OVS prepinacom "ovs0"): veth1====veth1-ovs
    Druhy ethernet kabel (medzi mennym priestorom "ns2" a OVS prepinacom "ovs0"): veth2====veth2-ovs


    Na tieto testovacie scenare je pouzity RedHat Linux 7.3, ktory sice obsahuje modul jadra pre Openvswitch, ale
    uz neobsahuje uzivatelske nastroje pre administraciu openvswitch (ovs-vsctl). Tieto uzivatelske nastroje su
    obsiahnute v inych Redhat produktoch ako je napriklad Red Hat Openstack Platform a podobne. V tejto chvili nam
    neostava nic ine ako nainstalovat si Openvswitch zo zdrojovych suborov, vid. [1.0.X].


    [1.0.1] Pre uspesnu instalaciu distribuovaneho prepinaca Openvswitch je potrebne mat nastroje na kompilaciu a 
            kniznice, ktore Openvswitch vyuziva.
    ----------------------------------------------------------------------------------------------------------------
    # yum install gcc make python-devel openssl-devel kernel-devel graphviz kernel-debug-devel autoconf automake \
      rpm-build redhat-rpm-config libtool checkpolicy selinux-policy-devel python-six
    ----------------------------------------------------------------------------------------------------------------


    [1.0.2] - Vytvorime adresar pre build RPM balicka zo zdrojovych suborov a stiahneme aktualny zdrojovy balicek 
              pre Openvswitch.
    ----------------------------------------------------------------------------------------------------------------
    # mkdir -p /root/rpmbuild/SOURCES
    # cd /root/rpmbuild/SOURCES
    # wget http://openvswitch.org/releases/openvswitch-2.6.1.tar.gz
    ----------------------------------------------------------------------------------------------------------------


    [1.0.3] - Balicek so zdrojovymi subormi rozbalime a spustime kompilaciu a vytvorenie RPM balicka
              V adresari "/root/rpmbuild/RPMS/x86_64/" vzniknu RPM balicky pre Openvswitch
    ----------------------------------------------------------------------------------------------------------------
    # cd /root/rpmbuild/SOURCES/
    # tar -xvf ./openvswitch-2.6.1.tar.gz
    # sed 's/openvswitch-kmod, //g' openvswitch-2.6.1/rhel/openvswitch.spec > openvswitch-2.6.1/rhel/openvswitch_no_kmod.spec
    # rpmbuild -bb --nocheck openvswitch-2.6.1/rhel/openvswitch_no_kmod.spec
    ----------------------------------------------------------------------------------------------------------------


    [1.0.4] - Nainstalujeme RPM balicek s Openvswitch
    ----------------------------------------------------------------------------------------------------------------
    # cd /root/rpmbuild/RPMS/x86_64/
    # yum localinstall ./openvswitch-2.6.1-1.x86_64.rpm
    ----------------------------------------------------------------------------------------------------------------


    [1.1] - Odstranime (ak existuju) sietove menne priestory "ns1" a "ns2".
    [1.2] - Vytvorime dva ("ns1" a "ns2") sietove (NET) menne priestory.
    ----------------------------------------------------------------------------------------------------------------
    [1.1]# ip netns del ns1 &>/dev/null
    [1.1]# ip netns del ns2 &>/dev/null
    [1.2]# ip netns add ns1
    [1.2]# ip netns add ns2
    ----------------------------------------------------------------------------------------------------------------


    [1.3] - V hostitelskom systeme spustime Openvswitch a 
    [1.3] - vytvorime distribuovany (openvswitch) ethernet prepinac/bridge s menom "ovs0".
    ----------------------------------------------------------------------------------------------------------------
    [1.3]# /etc/init.d/openvswitch start
    [1.3]# ovs-vsctl add-br ovs0
    ----------------------------------------------------------------------------------------------------------------


    [1.4]TERM1 - V sietovom mennom priestore "ns1" spustime (exec) prikaz "bash".
    [1.5]TERM2 - V sietovom mennom priestore "ns2" spustime (exec) prikaz "bash".
    ----------------------------------------------------------------------------------------------------------------
    [1.4]TERM1# ip netns exec ns1 bash
    [1.5]TERM2# ip netns exec ns2 bash
    ----------------------------------------------------------------------------------------------------------------


    [1.6]  - Vytvorime par virtualnych Ethernet zariadeni, ktore budu predstavovat sietovy kabel s dvoma RJ45 
             koncovkami, pricom nasledne jednu stranu (veth1) umiestnime do menneho priestoru "ns1" a druhu stranu 
             (veth1-ovs) umiestnime do distribuovaneho ethernet prepinaca "ovs0".
    [1.7]  - Virtualny ethernet adapter "veth1" umiestnime do sietoveho menneho priestoru "ns1".
    [1.8]  - Virtualny ethernet adapter "veth1-ovs" pripojime do distribuovaneho ethernet prepinaca "ovs0".

    [1.9]  - Vytvorime par virtualnych Ethernet zariadeni, ktore budu predstavovat sietovy kabel s dvoma RJ45 
             koncovkami, pricom nasledne jednu stranu (veth2) umiestnime do menneho priestoru "ns2" a druhu stranu 
             (veth2-ovs) umiestnime do distribuovaneho ethernet prepinaca "ovs0".
    [1.10] - Virtualny ethernet adapter "veth2" umiestnime do sietoveho menneho priestoru "ns2".
    [1.11] - Virtualny ethernet adapter "veth2-ovs" pripojime do distribuovaneho ethernet prepinaca "ovs0".
    ----------------------------------------------------------------------------------------------------------------
    [1.6] # ip link add veth1 type veth peer name veth1-ovs
    [1.7] # ip link set veth1 netns ns1
    [1.8] # ovs-vsctl add-port ovs0 veth1-ovs

    [1.9] # ip link add veth2 type veth peer name veth2-ovs
    [1.10]# ip link set veth2 netns ns2
    [1.11]# ovs-vsctl add-port ovs0 veth2-ovs
    ----------------------------------------------------------------------------------------------------------------


    [1.12] - Zapneme sietovy adapter "veth1" v mennom priestore "ns1" a nastavime na nom IP adresu "10.0.0.1".
    [1.13] - Zapneme sietovy adapter/port "veth1-ovs" na distribuovanom prepinaci "ovs0".

    [1.14] - Zapneme sietovy adapter "veth2" v mennom priestore "ns2" a nastavime na nom IP adresu "10.0.0.2".
    [1.15] - Zapneme sietovy adapter/port "veth2-ovs" na distribuovanom prepinaci "ovs0".

    [1.16] - Zo sietoveho menneho priestoru "ns1" otestujeme sietovu komunikaciu so sietovym mennym priestorom "ns2".
    [1.17] - Zo sietoveho menneho priestoru "ns2" otestujeme sietovu komunikaciu so sietovym mennym priestorom "ns1".
    ----------------------------------------------------------------------------------------------------------------
    [1.12]# ip netns exec ns1 ifconfig veth1 10.0.0.1/24 up
    [1.13]# ip link set dev veth1-ovs up

    [1.14]# ip netns exec ns2 ifconfig veth2 10.0.0.2/24 up
    [1.15]# ip link set dev veth2-ovs up

    [1.16]# ip netns exec ns1 ping 10.0.0.2
    [1.17]# ip netns exec ns2 ping 10.0.0.1
    ----------------------------------------------------------------------------------------------------------------
</pre>