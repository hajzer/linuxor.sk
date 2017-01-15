## Emerging Hypervisors Technologies

## HYPERVISORz - Building blocks / Research

- [Bareflank hypervisor - lightweight hypervisor (License: LGPL)](https://github.com/Bareflank/hypervisor)  
The Bareflank Hypervisor is an open source, lightweight hypervisor, lead by Assured Information Security, Inc. that provides the scaffolding needed to rapidly prototype new hypervisors. To ease development, Bareflank is written in C++, and includes support for exceptions and the C++ Standard Template Library (STL) via libc++. With the C++ STL, users can leverage shared pointers, complex data structures (e.g. hash tables, maps, lists, etc…), and several other modern C++ features. Existing open source hypervisors that are written in C are difficult to modify, and spend a considerable amount of time re-writing similar functionality instead of focusing on what matters most: hypervisor technologies. Furthermore, users can leverage inheritance to extend every part of the hypervisor to provide additional functionality above and beyond what is already provided.  
To this end, Bareflank's primary goal is to remain simple, and minimalistic, providing only the scaffolding needed to construct more complete/complicated hypervisors including:  
\- Bare Metal Hypervisors (also known as type 1, like Xen)  
\- Late Launch Hypervisors (also known as type 2, like VirtualBox)  
\- Host-Only Hypervisors (no guests, like MoRE, SimpleVisor and HyperPlatform)  


- [HyperPlatform - Intel VT-x based hypervisor aiming to provide a thin VM-exit filtering platform on Windows (License: MIT)](https://github.com/tandasat/HyperPlatform)  
HyperPlatform is an Intel VT-x based hypervisor (a.k.a. virtual machine monitor) aiming to provide a thin platform for research on Windows. HyperPlatform is capable of monitoring a wide range of events, including but not limited to, access to virtual/physical memory and system registers, occurrences of interrupts and execution of certain instructions.
Researchers are free to selectively enable and/or disable any of those event monitoring and implement their own logic on the top of HyperPlatform. Some potential applications are:  
\- Analyzing kernel mode rootkit  
\- Implementing virtual-machine-based intrusion prevention system (VIPS)  
\- Reverse-engineering the Windows kernel


- [ksm (License: GPL2)](https://asamy.github.io/ksm/)  
[ksm - github](https://github.com/asamy/ksm)  
A really simple and lightweight x64 hypervisor written in C for Windows (Intel processors). Supports VMFUNC, EPTP switching, #VE EPT Violation, VT-x nesting and IDT shadowing. VMFUNC backward compatibility also supported.
All x64 NT kernels starting from the Windows 7 NT kernel. It was mostly tested under Windows 7/8/8.1/10.


- [Simplevisor (License: Ionescu License)](https://ionescu007.github.io/SimpleVisor/)  
[SimpleVisor - github](https://github.com/ionescu007/SimpleVisor)  
SimpleVisor is a simple, portable, Intel VT-x hypervisor with two specific goals: using the least amount of assembly code (10 lines), and having the smallest amount of VMX-related code to support dynamic hyperjacking and unhyperjacking (that is, virtualizing the host state from within the host). It runs on both Windows and UEFI.
SimpleVisor has currently been tested on the following platforms successfully:  
\- Windows 8.1 on a Haswell Processor (Custom Desktop)  
\- Windows 10 Redstone 1 on a Sandy Bridge Processor (Samsung 930 Laptop)  
\- Windows 10 Threshold 2 on a Skylake Processor (Surface Pro 4 Tablet)  
\- Windows 10 Threshold 2 on a Skylape Processor (Dell Inspiron 11-3153 w/ SGX)  
\- VMWare Workstation 11, but without EPT (VMWare does not support 1GB EPTs)  
\- UEFI 2.4 on an Asus Maximus VII Extreme Motherboard (Custom Desktop)  
Too many hypervisor projects out there are either extremely complicated (Xen, KVM, VirtualBox) and/or closed-source (VMware, Hyper-V), as well as heavily focused toward Linux-based development or system. Additionally, most (other than Hyper-V) of them are expressly built for the purpose of enabling the execution of virtual machines, and not the virtualization of a live, running system, in order to perform introspection or other security-related tasks on it.  
SimpleVisor is designed to minimize code size and complexity -- this does come at a cost of robustness. For example, even though many VMX operations performed by SimpleVisor "should" never fail, there are always unknown reasons, such as memory corruption, CPU errata, invalid host OS state, and potential bugs, which can cause certain operations to fail. For truly robust, commercial-grade software, these possibilities must be taken into account, and error handling, exception handling, and checks must be added to support them. Additionally, the vast array of BIOSes out there, and different CPU and chipset iterations, can each have specific incompatibilities or workarounds that must be checked for. SimpleVisor does not do any such error checking, validation, and exception handling. It is not robust software designed for production use, but rather a reference code base.



## HYPERVISORz - Embedded


- [Xvisor (License: GPL)](http://xhypervisor.org/)  
[Xvisor paper - A comparative analysis](http://xhypervisor.org/pdf/Embedded_Hypervisor_Xvisor_A_comparative_analysis.pdf)  
[Xvisor -github](https://github.com/xvisor/xvisor)  
Xvisor is an open-source type-1 hypervisor, which aims at providing a monolithic, light-weight, portable, and flexible virtualization solution.
It provides a high performance and low memory foot print virtualization solution for ARMv5, ARMv6, ARMv7a, ARMv7a-ve, ARMv8a, x86_64, and other CPU architectures. In comparison to other ARM hypervisors, it is the only hypervisor providing support for ARM CPUs which do not have ARM virtualization extensions.
The Xvisor source code is highly portable and can be easily ported to most general-purpose 32-bit or 64-bit architectures as long as they have a paged memory management unit (PMMU) and a port of the GNU C compiler (GCC).
Xvisor primarily supports Full virtualization hence, supports a wide range of unmodified Guest operating systems. Paravirtualization is optional for Xvisor and will be supported in an architecture independent manner (such as VirtIO PCI/MMIO devices) to ensure no-change in Guest OS for using paravirtualization.



## HYPERVISORz - Containers / partitioning / isolation


- [Jailhouse - Linux-based partitioning hypervisor (License: GPLv2)](https://github.com/siemens/jailhouse)  
[jailhouse - coverity](https://scan.coverity.com/projects/4114)  
Jailhouse is a partitioning Hypervisor based on Linux. It is able to run bare-metal applications or (adapted) operating systems besides Linux. For this purpose it configures CPU and device virtualization features of the hardware platform in a way that none of these domains, called "cells" here, can interfere with each other in an unacceptable way.  
Jailhouse is optimized for simplicity rather than feature richness. Unlike full-featured Linux-based hypervisors like KVM or Xen, Jailhouse does not support overcommitment of resources like CPUs, RAM or devices. It performs no scheduling and only virtualizes those resources in software, that are essential for a platform and cannot be partitioned in hardware.  
Once Jailhouse is activated, it runs bare-metal, i.e. it takes full control over the hardware and needs no external support. However, in contrast to other bare-metal hypervisors, it is loaded and configured by a normal Linux system. Its management interface is based on Linux infrastructure. So you boot Linux first, then you enable Jailhouse and finally you split off parts of the system's resources and assign them to additional cells.  
> WARNING: This is work in progress! Don't expect things to be complete in any dimension. Use at your own risk. And keep the reset button in reach.


- [Hypercontainer - Hypervisor-agnostic Docker Runtime (License: Apache 2.0)](https://www.hypercontainer.io)  
[Hypercontainer - How it works](https://www.hypercontainer.io/how-it-works.html)  
[Hypercontainer - github](https://github.com/hyperhq/hyperd)  
[Hypercontainer blog - hypernetes-security-and-multi-tenancy-in-kubernetes](http://blog.kubernetes.io/2016/05/hypernetes-security-and-multi-tenancy-in-kubernetes.html)  
HyperContainer is a hypervisor-agnostic technology that allows you to run Docker images on plain hypervisor.  
\- Fast as Container (A standard server running Ubuntu 14.04 hyperctl run nginx --> Chrome --> load webpage 0.54 second)  
\- Isolated by VM (Independent kernel Minimal attack surface)  
\- Pod in First Class (Run multiple Docker images in one VM Share Namespace Dynamically update Pod)  
\- Immutable Infrastructure (Only kernel + image, Guest OS is gone! 


- [Frakti - The hypervisor-based container runtime for Kubernetes](https://github.com/kubernetes/frakti)  
Frakti lets Kubernetes run pods and containers directly inside hypervisors via HyperContainer. It is light weighted and portable, but can provide much stronger isolation with independent kernel than linux-namespace-based container runtimes.




## HYPERVISORz - Desktop


- [Cappsule (License: GPLv2)](https://cappsule.github.io/)  
[cappsule - github](https://github.com/cappsule)  
[QuarksLab](http://quarkslab.com/)  
Cappsule is a new kind of hypervisor developed by Quarkslab (to our knowledge, there’s no similar public project). Its goal is to virtualize any software on the fly (e.g. web browser, office suite, media player) into lightweight VMs called cappsules. Attacks are confined inside cappsules and therefore don’t have any impact on the host OS. Applications don’t need to be repackaged, and their usage remain the same for the end user: it’s completely transparent. Moreover, the OS doesn’t need to be reinstalled nor modified.
Cappsule makes use of security by isolation and runs transparently sensitive software in different VMs. If one of them is compromised, attackers can’t access data outside of it. Here’s a quick and non-exhaustive list of attacks which are ineffective from a cappsule: keylogging, screen recording, file stealing, network traffic interception, hardware attacks from a compromised application (DMA attacks, BIOS or firmware rootkit), etc. Basically, it protects computers against remote software attacks and makes the assumption that the hardware isn’t backdoored. If this assumption doesn’t fulfil your expectation or if you’re concerned about physical attacks, Qubes OS might be a better choice.


- [nofear (License: GPL)](https://github.com/cappsule/nofear)  
Run any command transparently in a VM (this repo isn't part of Cappsule)
Regarding virtualization, Cappsule introduced the concept of on the fly virtualization with a custom hypervisor; whereas NoFear makes use of KVM included in mainline Linux kernel.



## HYPERVISORz - Anti hypervisor / Security


- [HypervisorsDetection](https://github.com/IgorKorkin/HypervisorsDetection)  
[Igor Korkin - homepage](https://sites.google.com/site/igorkorkin/)  
[Igor Korkin - blog](http://igorkorkin.blogspot.sk/)  
This is the first software system, which can detect a stealthy hypervisor and calculate several nested ones even under countermeasures.
Details are in my paper: Korkin, I. (2015, May 18-21). Two Challenges of Stealthy Hypervisors Detection: Time Cheating and Data Fluctuations. Paper presented at the Proceedings of the 10th Annual Conference on Digital Forensics, Security and Law (CDFSL), 33-57, Daytona Beach, Florida, USA.


