

## Unikernel technologies - Build tools


**[unik - The Unikernel & MicroVM Compilation and Deployment Platform (License: Apache-2.0)](https://github.com/solo-io/unik)**  
unik - Company: [DELL/EMC](https://www.emc.com/about/news/press/2016/20160524-01.htm)  
UniK (pronounced you-neek) is a tool for compiling application sources into unikernels (lightweight bootable disk images) rather than binaries.
UniK runs and manages instances of compiled images across a variety of cloud providers as well as locally on Virtualbox.
UniK utilizes a simple docker-like command line interface, making building unikernels as easy as building containers. Supported providers:
  - AWS Firecracker  
  - Virtualbox  
  - AWS  
  - vSphere  
  - QEMU  
  - UKVM  
  - Xen  
  - OpenStack  
  - Photon Controller  


**[Unikraft - Automated Building of Specialized OSes and Unikernels (License: BSD-3-Clause)](http://cnp.neclab.eu/projects/unikraft/)**  
Unikraft - Company: [NEC Laboratories Europe](https://uk.nec.com/en_GB/emea/about/neclab_eu) / [NEC Laboratories Europe - Systems and Machine Learning](http://cnp.neclab.eu/)  
[Unikraft - GitHub](https://github.com/sysml)   
[Unikraft - WIKI](https://wiki.xenproject.org/wiki/Category:Unikraft)  
In recent years, several papers and projects dedicated to unikernels have shown the immense potential for performance gains that these have. By leveraging specialization and the use of minimalistic OSes, unikernels are able to yield impressive numbers, including fast instantiation times (tens of milliseconds or less), tiny memory footprints (a few MBs or even KBs), high network throughput (10-40 Gb/s), and high consolidation (e.g., being able to run thousands of instances on a single commodity server), not to mention a reduced attack surface and the potential for easier certification. Unikernel projects worthy of mention include MirageOS, ClickOS, Erlang on Xen, OSv, HALVM, and Minicache, Rump, among others. The fundamental drawback of unikernels is that they require that applications be manually ported to the underlying minimalistic OS (e.g. having to port nginx, snort, mysql or memcached to MiniOS or OSv); this requires both expert work and often considerable amount of time. In essence, we need to pick between either high performance with unikernels, or no porting effort but decreased performance and decreased efficiency with standard OS/VM images. The goal of this proposal is to change this status quo by providing a highly configurable unikernel code base; we call this base Unikraft.


## Unikernel technologies - Implementations


**[UNIKERNEL.ORG](http://unikernel.org/)**  
[http://unikernel.org/resources/](http://unikernel.org/resources/)  
[http://unikernel.org/blog/](http://unikernel.org/blog/)  
A community site for Unikernels


**[HermitCore - A lightweight unikernel for a scalable and predictable runtime behavior (License: BSD-3-Clause)](https://hermitcore.org/)**  
HermitCore - Company: [RWTH Aachen University](http://www.os.rwth-aachen.de/)  
[HermitCore - GitHub](https://github.com/hermitcore/)    
HermitCore is a novel unikernel operating system targeting a scalable and predictable runtime behavior for HPC and cloud environments. The current version supports C/C++, Fortran, Go, Pthreads, OpenMP and iRCCE as message passing library. HermitCore can be used as classical unikernel within a virtual machine. In addition, it extends the multi-kernel approach (like FusedOS, McKernel and mOS) and combines it with unikernel features. HermitCore is designed for KVM/Linux but also for x86_64 bare-metal environments and provides a better programmability and scalability for hierarchical systems, which based on multiple cluster-on-a-chip processors.


**[OSv - the operating system designed for the cloud (License: BSD-3-Clause)](http://osv.io/)**  
OSv - Company: [Cloudius Systems](http://www.cloudius-systems.com/) / [ScyllaDB](https://www.scylladb.com/) / [Avi Kivity](https://twitter.com/avikivity)  
[OSV - GitHub](https://github.com/cloudius-systems/osv)  
[OSV - WIKI](https://github.com/cloudius-systems/osv/wiki)  
[DOC - OSv - Hypervisors Are Dead, Long Live the Hypervisor - Part1](http://osv.io/blog/blog/2014/06/19/containers-hypervisors-part-1/)  
[DOC - OSv - Hypervisors Are Dead, Long Live the Hypervisor - Part2](http://osv.io/blog/blog/2014/06/19/containers-hypervisors-part-2/)  
[DOC - OSv - Hypervisors Are Dead, Long Live the Hypervisor - Part3](http://osv.io/blog/blog/2014/06/19/containers-hypervisors-part-3/)  
OSv is a new open-source operating system for virtual-machines. OSv was designed from the ground up to execute a single application on top of a hypervisor, resulting in superior performance and effortless management when compared to traditional operating systems which were designed for a vast range of physical machines. OSv has new APIs for new applications, but also runs unmodified Linux applications (most of Linux's ABI is supported) and in particular can run an unmodified JVM, and applications built on top of one.


**[RumpKernels (License: BSD-2-Clause)](http://rumpkernel.org/)**  
[RumpKernels - BOOK - The Design and Implementation of the Anykernel and Rump Kernels](http://www.fixup.fi/misc/rumpkernel-book/)  
[RumpKernels - GitHub](https://github.com/rumpkernel)  
[RumpKernels - WIKI](https://github.com/rumpkernel/wiki)  
Rump kernels enable you to build the software stack you need without forcing you to reinvent the wheels. The key observation is that a software stack needs driver-like components which are conventionally tightly-knit into operating systems — even if you do not desire the limitations and infrastructure overhead of a given OS, you do need drivers.


**[MirageOS - A programming framework for building type-safe, modular systems (License: LGPLv2 / ISC)](https://mirage.io/)**  
MirageOS - Company: [Unikernel Systems](http://unikernel.com/) / [Docker](https://www.docker.com/) / [Anil Madhavapeddy](http://anil.recoil.org/)  
[MirageOS - GitHub](https://github.com/mirage)   
[MirageOS - DOC](https://mirage.io/docs/)  
MirageOS is a library operating system that constructs unikernels for secure, high-performance network applications across a variety of cloud computing and mobile platforms. Code can be developed on a normal OS such as Linux or MacOS X, and then compiled into a fully-standalone, specialised unikernel that runs under a Xen or KVM hypervisor. This lets your services run more efficiently, securely and with finer control than with a full conventional software stack. MirageOS uses the OCaml language, with libraries that provide networking, storage and concurrency support that work under Unix during development, but become operating system drivers when being compiled for production deployment. The framework is fully event-driven, with no support for preemptive threading.


**[IncludeOS (License: Apache-2.0)](https://www.includeos.org/)**  
IncludeOS - Company: [IncludeOS](http://www.includeos.com/)  
[IncludeOS - GitHub](https://github.com/includeos)  
[IncludeOS - Blog](http://www.includeos.org/blog/)  
IncludeOS allows you to run your application in the cloud without an operating system. IncludeOS adds operating system functionality to your application allowing you to create performant, secure and resource efficient virtual machines. IncludeOS applications boot in tens of milliseconds and require only a few megabytes of disk and memory.


**[ClickOS - Fast and Lightweight Network Function Virtualization (License: MIT / W3C)](http://cnp.neclab.eu/projects/clickos/)**  
ClickOS - Company: [NEC Laboratories Europe](https://uk.nec.com/en_GB/emea/about/neclab_eu) / [NEC Laboratories Europe - Systems and Machine Learning](http://cnp.neclab.eu/)    
[ClickOS - GitHub](https://github.com/sysml)   
[ClickOS - DOC](http://cnp.neclab.eu/projects/clickos/papers/)    
Over the years middleboxes have become a fundamental part of today’s networks. Despite their usefulness, they come with a number of problems, many of which arise from the fact that they are hardware-based: they are costly, difficult to manage, and their functionality is hard or impossible to change, to name a few. To address these issues, there is a recent trend towards network function virtualization (NFV), in essence proposing to turn these middleboxes into software-based, virtualized entities. Towards this goal we introduce ClickOS, a high-performance, virtualized software middlebox platform. ClickOS virtual machines are small (5MB), boot quickly (about 30 milliseconds), add little delay (45 microseconds) and over one hundred of them can be concurrently run while saturating a 10Gb pipe on a commodity server. We further implement a wide range of middleboxes including a firewall, a carrier-grade NAT and a load balancer and show that ClickOS can handle packets in the millions per second.


## Unikernel technologies - Problems

- [2016 - Unikernels Will Create More Security Problems Than They Solve](http://thenewstack.io/unikernels-will-create-security-problems-solve/)
- [2016 - Debunking Unikernel Criticisms](http://thenewstack.io/utilizing-unikernels-within-internet-things/)
- [2016 - Unikernels Can’t be Debugged, Joyent’s Chief of Technology Argues](http://thenewstack.io/good-luck-debugging-unikernels-joyents-chief-technology-says/)

