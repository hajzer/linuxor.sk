## 2016 - Linux NET Namespace - Prepojenie dvoch sieťových menných priestorov (ns1, ns2) - pomocou 2 portov na distribuovanom prepínači OVS (openvswitch)


**FILE:** 2016-linuxnamespace-net-ns-ovs2p-ns.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1


<pre>
======================================================================================================================
 [1] NET namespace - Prepojenie dvoch sietovych mennych priestorov (ns1, ns2) - pomocou 2 portov na distribuovanom
                     prepinaci OVS (openvswitch)
======================================================================================================================


     +------------------+                  +-------------------------------+                  +------------------+
     | ns1        veth1 |=====ovs-port=====|              ovs0             |=====ovs-port=====| veth2        ns2 |
     +------------------+                  +-------------------------------+                  +------------------+
       namespace "ns1"                      hostitelsky system (openvswitch)                    namespace "ns2"


    Prvy  OVS port - na OVS prepinaci sa vytvori interny OVS port "veth1", ktory sa priradi mennemu priestoru "ns1".
    Druhy OVS port - na OVS prepinaci sa vytvori interny OVS port "veth2", ktory sa priradi mennemu priestoru "ns2".


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


    [1.6] - Na distribuovanom prepinace "ovs0" vytvorime interny port "veth1-ovs".
    [1.7] - Virtualny ethernet adapter "veth1-ovs" umiestnime do sietoveho menneho priestoru "ns1".

    [1.8] - Na distribuovanom prepinace "ovs0" vytvorime interny port "veth2-ovs".
    [1.9] - Virtualny ethernet adapter "veth2-ovs" umiestnime do sietoveho menneho priestoru "ns2".
    ----------------------------------------------------------------------------------------------------------------
    [1.6]# ovs-vsctl add-port ovs0 veth1-ovs -- set Interface veth1-ovs type=internal
    [1.7]# ip link set veth1-ovs netns ns1

    [1.8]# ovs-vsctl add-port ovs0 veth2-ovs -- set Interface veth2-ovs type=internal
    [1.9]# ip link set veth2-ovs netns ns2
    ----------------------------------------------------------------------------------------------------------------


    [1.10] - Zapneme sietovy adapter "veth1-ovs" v mennom priestore "ns1" a nastavime na nom IP adresu "10.0.0.1".
    [1.11] - Zapneme sietovy adapter "veth2-ovs" v mennom priestore "ns2" a nastavime na nom IP adresu "10.0.0.2".

    [1.12] - Zo sietoveho menneho priestoru "ns1" otestujeme sietovu komunikaciu so sietovym mennym priestorom "ns2".
    [1.13] - Zo sietoveho menneho priestoru "ns2" otestujeme sietovu komunikaciu so sietovym mennym priestorom "ns1".
    ----------------------------------------------------------------------------------------------------------------
    [1.10]# ip netns exec ns1 ifconfig veth1-ovs 10.0.0.1/24 up
    [1.11]# ip netns exec ns2 ifconfig veth2-ovs 10.0.0.2/24 up

    [1.12]# ip netns exec ns1 ping 10.0.0.2
    [1.13]# ip netns exec ns2 ping 10.0.0.1
    ----------------------------------------------------------------------------------------------------------------


    [1.14] - Na distribuovanom prepinaci "ovs0" zobrazime informacie o konfiguracii portov.
    ----------------------------------------------------------------------------------------------------------------
    [1.14]# ovs-vsctl show
    ----------------------------------------------------------------------------------------------------------------
    31dff9cb-870d-4093-915d-28dc71f8ac6e
        Bridge "ovs0"
            Port "ovs0"
                Interface "ovs0"
                    type: internal
            Port "veth1-ovs"
                Interface "veth1-ovs"
                    type: internal
            Port "veth2-ovs"
                Interface "veth2-ovs"
                    type: internal
        ovs_version: "2.6.1"
    ----------------------------------------------------------------------------------------------------------------
</pre>