## 2016 - Linux NET Namespace - Prepojenie dvoch sieťových menných priestorov (ns1, ns2) - pomocou 2 párov veth adaptérov a štandardného Linux prepínača (bridge)


**FILE:** 2016-linuxnamespace-net-ns-veth-veth-hostOS.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1


<pre>
======================================================================================================================
 [1] NET namespace - Prepojenie dvoch sietovych mennych priestorov (ns1, ns2) - pomocou 2 parov veth adapterov a 
                     standardneho Linux prepinaca (bridge)
======================================================================================================================


     +------------------+                 +-------------------------------+                 +------------------+
     | ns1        veth1 |======kabel======| veth1-br   bridge0   veth2-br |======kabel======| veth2        ns2 |
     +------------------+                 +-------------------------------+                 +------------------+
       namespace "ns1"                       hostitelsky system (bridge)                       namespace "ns2"


    Prvy  ethernet kabel (medzi mennym priestorom "ns1" a Linuxovym prepinacom "bridge0"): veth1====veth1-br
    Druhy ethernet kabel (medzi mennym priestorom "ns2" a Linuxovym prepinacom "bridge0"): veth2====veth2-br


    [1.1] - Odstranime (ak existuju) sietove menne priestory "ns1" a "ns2".
    [1.2] - Vytvorime dva ("ns1" a "ns2") sietove (NET) menne priestory.
    ----------------------------------------------------------------------------------------------------------------
    [1.1]# ip netns del ns1 &>/dev/null
    [1.1]# ip netns del ns2 &>/dev/null
    [1.2]# ip netns add ns1
    [1.2]# ip netns add ns2
    ----------------------------------------------------------------------------------------------------------------


    [1.3] - V hostitelskom systeme vytvorime ethernet prepinac/bridge s menom "bridge0".
            Poznamka: Je potrebne nainstalovat balicek "bridge-utils" sluziaci na administraciu Linux prepinaca/bridge.
    [1.4] - Na ethernet prepinaci "bridge0" vypneme Spanning Tree Protokol (STP).
    [1.5] - V hostitelskom systeme zapneme ethernet prepinac "bridge0".
    ----------------------------------------------------------------------------------------------------------------
    [1.3]# brctl addbr bridge0
    [1.4]# brctl stp bridge0 off
    [1.5]# ip link set dev bridge0 up
    ----------------------------------------------------------------------------------------------------------------


    [1.6]TERM1 - V sietovom mennom priestore "ns1" spustime (exec) prikaz "bash".
    [1.7]TERM2 - V sietovom mennom priestore "ns2" spustime (exec) prikaz "bash".
    ----------------------------------------------------------------------------------------------------------------
    [1.6]TERM1# ip netns exec ns1 bash
    [1.7]TERM2# ip netns exec ns2 bash
    ----------------------------------------------------------------------------------------------------------------


    [1.8]  - Vytvorime par virtualnych Ethernet zariadeni, ktore budu predstavovat sietovy kabel s dvoma RJ45 
             koncovkami, pricom nasledne jednu stranu (veth1) umiestnime do menneho priestoru "ns1" a druhu stranu 
             (veth1-br) umiestnime do ethernet prepinaca "bridge0".
    [1.9]  - Virtualny ethernet adapter "veth1" umiestnime do sietoveho menneho priestoru "ns1".
    [1.10] - Virtualny ethernet adapter "veth1-br" pripojime do ethernet prepinaca "bridge0".

    [1.11] - Vytvorime par virtualnych Ethernet zariadeni, ktore budu predstavovat sietovy kabel s dvoma RJ45 
             koncovkami, pricom nasledne jednu stranu (veth2) umiestnime do menneho priestoru "ns2" a druhu stranu 
             (veth2-br) umiestnime do ethernet prepinaca "bridge0".
    [1.12] - Virtualny ethernet adapter "veth2" umiestnime do sietoveho menneho priestoru "ns2".
    [1.13] - Virtualny ethernet adapter "veth2-br" pripojime do ethernet prepinaca "bridge0".
    ----------------------------------------------------------------------------------------------------------------
    [1.8] # ip link add veth1 type veth peer name veth1-br
    [1.9] # ip link set veth1 netns ns1
    [1.10]# brctl addif bridge0 veth1-br

    [1.11]# ip link add veth2 type veth peer name veth2-br
    [1.12]# ip link set veth2 netns ns2
    [1.13]# brctl addif bridge0 veth2-br
    ----------------------------------------------------------------------------------------------------------------


    [1.14] - Zapneme sietovy adapter "veth1" v mennom priestore "ns1" a nastavime na nom IP adresu "10.0.0.1".
    [1.15] - Zapneme sietovy adapter/port "veth1-br" na standardnom Linux prepinaci "bridge0".

    [1.16] - Zapneme sietovy adapter "veth2" v mennom priestore "ns2" a nastavime na nom IP adresu "10.0.0.2".
    [1.17] - Zapneme sietovy adapter/port "veth2-br" na standardnom Linux prepinaci "bridge0".

    [1.18] - Zo sietoveho menneho priestoru "ns1" otestujeme sietovu komunikaciu so sietovym mennym priestorom "ns2".
    [1.19] - Zo sietoveho menneho priestoru "ns2" otestujeme sietovu komunikaciu so sietovym mennym priestorom "ns1".
    ----------------------------------------------------------------------------------------------------------------
    [1.14]# ip netns exec ns1 ifconfig veth1 10.0.0.1/24 up
    [1.15]# ip link set dev veth1-br up

    [1.16]# ip netns exec ns2 ifconfig veth2 10.0.0.2/24 up
    [1.17]# ip link set dev veth2-br up

    [1.18]# ip netns exec ns1 ping 10.0.0.2
    [1.19]# ip netns exec ns2 ping 10.0.0.1
    ----------------------------------------------------------------------------------------------------------------
</pre>