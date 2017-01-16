

## 2016 - Linux NET Namespace - Prepojenie dvoch sieťových menných priestorov (ns1, ns2) - pomocou páru veth adaptérov


**FILE:** 2016-linuxnamespace-net-ns-veth-veth-ns.md  
**DATE:** 11/2016  
**UPDATED:**  
**AUTHOR:** Ladislav Hajzer -> lala (at) linuxor (dot) sk  
**VERSION:** 1  


## 1 Schéma


<pre>
                        +--------------------+                       +--------------------+
    (PID = 12112)       | ns1          veth1 |=========kabel=========| veth2          ns2 |     (PID = 12130)
                        +--------------------+                       +--------------------+
                           namespace &quot;ns1&quot;                               namespace &quot;ns2&quot;
</pre>


## 2 Vytvorenie sieťových menných priestorov 

Vytvoríme dva (&quot;ns1&quot; a &quot;ns2&quot;) sieťové (NET) menné priestory.

<pre>
# ip netns add ns1
# ip netns add ns2
</pre>


## 3 Spustenie procesov v menných priestoroch


- [1]TERM1 - V sieťovom mennom priestore **&quot;ns1&quot;** spustíme (exec) príkaz **&quot;bash&quot;**. PID = 12112
- [2]TERM1 - Zistíme PID BASH procesu.
- [3]TERM2 - V sieťovom mennom priestore **&quot;ns2&quot;** spustíme (exec) príkaz **&quot;bash&quot;**. PID = 12130
- [4]TERM2 - Zistíme PID BASH procesu.


<pre>
[1]TERM1# ip netns exec ns1 bash
[2]TERM1# echo $$
----------------------------------------------------------------------------------------------------------------
12112
----------------------------------------------------------------------------------------------------------------
[3]TERM2# ip netns exec ns2 bash
[4]TERM2# echo $$
----------------------------------------------------------------------------------------------------------------
12130
</pre>


## 4 Vytvorenie páru virtuálnych Ethernet zariadení


- [1] - Vytvorime par virtualnych Ethernet zariadeni, ktore budu predstavovat sietovy kabel s dvoma RJ45 
koncovkami, pricom nasledne jednu stranu (veth1) umiestnime do menneho priestoru &quot;ns1&quot; a druhu stranu 
(veth2) umiestnime do menneho priestoru &quot;ns2&quot;.
- [2] - Virtualny ethernet adapter &quot;veth1&quot; umiestnime do sietoveho menneho &quot;ns1&quot;.
- [3] - Virtualny ethernet adapter &quot;veth1&quot; umiestnime do sietoveho menneho &quot;ns2&quot;.


<pre>
[1]# ip link add veth1 type veth peer name veth2
[2]# ip link set veth1 netns ns1
[3]# ip link set veth2 netns ns2
</pre>


## 5 Zapnutie virtuálnych Ethernet zariadení v menných priestoroch a otestovanie komunikácie


- [1]  - Zapneme sieťový adaptér **&quot;veth1&quot;** v mennom priestore **&quot;ns1&quot;** a nastavíme na ňom IP adresu **&quot;10.0.0.1&quot;**.
- [2] - Zapneme sieťový adaptér **&quot;veth2&quot;** v mennom priestore **&quot;ns2&quot;** a nastavíme na ňom IP adresu **&quot;10.0.0.2&quot;**.
- [3] - Zo sieťového menného priestoru **&quot;ns1&quot;** otestujeme sieťovú komunikáciu so sieťovým menným priestorom **&quot;ns2&quot;**.
- [4] - Zo sieťového menného priestoru **&quot;ns2&quot;** otestujeme sieťovú komunikáciu so sieťovým menným priestorom **&quot;ns1&quot;**.

<pre>
[1] # ip netns exec ns1 ifconfig veth1 10.0.0.1/24 up 
[2]# ip netns exec ns2 ifconfig veth2 10.0.0.2/24 up 
[3]# ip netns exec ns1 ping 10.0.0.2
----------------------------------------------------------------------------------------------------------------
64 bytes from 10.0.0.2: icmp_seq=1 ttl=64 time=0.022 ms
64 bytes from 10.0.0.2: icmp_seq=2 ttl=64 time=0.036 ms
...
----------------------------------------------------------------------------------------------------------------
[4]# ip netns exec ns2 ping 10.0.0.1
----------------------------------------------------------------------------------------------------------------
64 bytes from 10.0.0.1: icmp_seq=1 ttl=64 time=0.026 ms
64 bytes from 10.0.0.1: icmp_seq=2 ttl=64 time=0.069 ms
...
</pre>