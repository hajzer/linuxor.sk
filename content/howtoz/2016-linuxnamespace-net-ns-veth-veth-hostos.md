## 2016 - Linux NET Namespace - Prepojenie sieťového menného priestoru a hostiteľského systému - pomocou páru veth adaptérov


**FILE:** 2016-linuxnamespace-net-ns-veth-veth-hostos.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1  



<pre>
======================================================================================================================
 [1] NET namespace - Prepojenie sietoveho menneho priestoru a hostitelskeho systemu - pomocou paru veth adapterov
======================================================================================================================


                        +--------------------+                       +--------------------+
                        | hostOS     veth1.1 |=========kabel=========| veth1.2        ns1 |     (PID = 2429)
                        +--------------------+                       +--------------------+
                          hostitelsky system                            namespace "ns1"


    [1.1] - Vytvorime jeden ("ns1") sietovy (NET) menny priestor.
    ----------------------------------------------------------------------------------------------------------------
    # ip netns add ns1
    ----------------------------------------------------------------------------------------------------------------


    [1.2]TERM2 - V sietovom mennom priestore "ns1" spustime (exec) prikaz "bash". PID = 2429
    [1.3]TERM2 - Zistime PID BASH procesu.
    ----------------------------------------------------------------------------------------------------------------
    [1.2]TERM2# ip netns exec ns1 bash
    [1.3]TERM2# echo $$
    ----------------------------------------------------------------------------------------------------------------
    2429
    ----------------------------------------------------------------------------------------------------------------


    [1.4] - Vytvorime par virtualnych Ethernet zariadeni, ktore budu predstavovat sietovy kabel s dvoma RJ45 
            koncovkami, pricom jednu stranu (veth1.2) pripojime do menneho priestoru "ns1" (na zaklade identifikatora
            procesu [55718]) a druhu stranu (veth1.1) pripojime do hostitelskeho systemu.
    ----------------------------------------------------------------------------------------------------------------
    # ip link add veth1.1 type veth peer name veth1.2 netns 2429
    ----------------------------------------------------------------------------------------------------------------


    [1.5] - Overime vytvorenie parov virtualnych zariadeni z kroku [1.4].
    ----------------------------------------------------------------------------------------------------------------
    # ip link show
    ----------------------------------------------------------------------------------------------------------------
    1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN mode DEFAULT qlen 1
        link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    2: ens33: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc pfifo_fast state UP mode DEFAULT qlen 1000
        link/ether 00:0c:29:9b:30:f4 brd ff:ff:ff:ff:ff:ff
    3: veth1.1@if2: <BROADCAST,MULTICAST> mtu 1500 qdisc noop state DOWN mode DEFAULT qlen 1000
        link/ether 22:74:36:08:a3:e0 brd ff:ff:ff:ff:ff:ff link-netnsid 0
    ----------------------------------------------------------------------------------------------------------------


    [1.6] - Zapneme sietovy adapter "veth1.2" v mennom priestore "ns1" a nastavime na nom IP adresu "10.0.0.1".
    [1.7] - Zapneme sietovy adapter "veth1.1" v hostitelskom systeme ako druhu stranu "kabla/koncovky" "veth1.2" a 
            nastavime na nom IP adresu "10.0.0.2". 
    [1.8] - Otestujeme sietovu komunikaciu medzi hostOS a sietovym mennym priestorom "ns1".
    ----------------------------------------------------------------------------------------------------------------
    [1.6]# ip netns exec ns1 ifconfig veth1.2 10.0.0.1/24 up 
    [1.7]# ifconfig veth1.1 10.0.0.2/24 up 
    [1.8]# ping 10.0.0.1
    ----------------------------------------------------------------------------------------------------------------
    64 bytes from 10.0.0.1: icmp_seq=1 ttl=64 time=0.075 ms
    64 bytes from 10.0.0.1: icmp_seq=2 ttl=64 time=0.093 ms
    ...
    ----------------------------------------------------------------------------------------------------------------


    [1.9]  - Zobrazime smerovaciu tabulku pre sietovy menny priestor "ns1".
    [1.10] - Zobrazime zoznam sietovych adapterov/liniek pre sietovy menny priestor "ns1".
    ----------------------------------------------------------------------------------------------------------------
    [1.9] # ip netns exec ns1 route
    ----------------------------------------------------------------------------------------------------------------
    Kernel IP routing table
    Destination     Gateway         Genmask         Flags Metric Ref    Use Iface
    10.0.0.0        0.0.0.0         255.255.255.0   U     0      0        0 veth1.2
    ----------------------------------------------------------------------------------------------------------------
    [1.10]# ip netns exec ns1 ip link
    ----------------------------------------------------------------------------------------------------------------
    1: lo: <LOOPBACK> mtu 65536 qdisc noop state DOWN mode DEFAULT qlen 1
        link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    2: veth1.2@if13: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc noqueue state UP mode DEFAULT qlen 1000
        link/ether 7e:d3:d9:0a:56:b4 brd ff:ff:ff:ff:ff:ff link-netnsid 0
    ----------------------------------------------------------------------------------------------------------------
</pre>