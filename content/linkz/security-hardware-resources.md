

## TEE (Trusted Execution Environment) - INTRO

- [2014 - Introduction to Trusted Execution Environments (TEE) – IY5606](http://sec.cs.ucl.ac.uk/users/smurdoch/talks/rhul14tee.pdf)


## Intel SGX - Intro

- [2016 - Intel SGX Explained - Cryptology ePrint Archive - IACR (*****)](https://eprint.iacr.org/2016/086.pdf)  
Victor Costan and Srinivas Devadas of MIT criticize the way SGX obtains cryptographic keys over the internet.
Intel’s Software Guard Extensions (SGX) is a set of extensions to the Intel architecture that aims to provide
integrity and confidentiality guarantees to securitysensitive computation performed on a computer where
all the privileged software (kernel, hypervisor, etc) is potentially malicious.
- [2016 - Intel® Software Guard Extensions Tutorial Series (***)](https://software.intel.com/en-us/articles/introducing-the-intel-software-guard-extensions-tutorial-series)  
Today we are launching a multi-part tutorial series aimed at software developers who want to learn how to integrate Intel® Software Guard Extensions (Intel® SGX) into their applications. The intent of the series is to cover every aspect of the software development cycle when building an Intel SGX application, beginning at application design and running through development, testing, packaging, and deployment. While isolated code samples and individual articles are valuable, this in-depth look at enabling Intel SGX in a single application provides developers with a hands-on and holistic view of the technology as it is woven into a real-world application.
- **2013/2014 - Intel® SGX for Dummies (Intel® SGX Design Objectives)**  
Security Analysis of the Computer Architecture *OR* What a software researcher can teach you about *YOUR* computer
[https://software.intel.com/en-us/blogs/2013/09/26/protecting-application-secrets-with-intel-sgx](https://software.intel.com/en-us/blogs/2013/09/26/protecting-application-secrets-with-intel-sgx)  
[https://software.intel.com/en-us/blogs/2014/06/02/intel-sgx-for-dummies-part-2](https://software.intel.com/en-us/blogs/2014/06/02/intel-sgx-for-dummies-part-2)  
[https://software.intel.com/en-us/blogs/2014/09/01/intel-sgx-for-dummies-part-3](https://software.intel.com/en-us/blogs/2014/09/01/intel-sgx-for-dummies-part-3)  


## Hardware Security - Papers

- [2017 - sandsifter - the x86 processor fuzzer](https://github.com/xoreaxeaxeax/sandsifter)  
The sandsifter audits x86 processors for hidden instructions and hardware bugs, by systematically generating machine code to search through a processor's instruction set, and monitoring execution for anomalies. Sandsifter has uncovered secret processor instructions from every major vendor; ubiquitous software bugs in disassemblers, assemblers, and emulators; flaws in enterprise hypervisors; and both benign and security-critical hardware bugs in x86 chips.
With the multitude of x86 processors in existence, the goal of the tool is to enable users to check their own systems for hidden instructions and bugs.
  - [WhitePaper](https://github.com/xoreaxeaxeax/sandsifter/blob/master/references/domas_breaking_the_x86_isa_wp.pdf)
  - [Presentation](https://github.com/xoreaxeaxeax/sandsifter/blob/master/references/domas_breaking_the_x86_isa.pdf)
- [2017/02 - ASLR^CACHE OR ANC: A MMU SIDECHANNEL BREAKING ASLR FROM JAVASCRIPT](https://www.vusec.net/projects/anc/)  
In this project, we show that the limitations of ASLR is fundamental to how modern processors manage memory and build an attack that can fully derandomize ASLR from JavaScript without relying on any software feature. "We hence recommend ASLR to no longer be trusted as a first line of defense against memory error attacks and for future defenses not to rely on it as a pivotal building block."
- [2016 - A Survey of Microarchitectural Timing Attacks and Countermeasures on Contemporary Hardware](https://eprint.iacr.org/2016/613.pdf)
- [2016 - DRAMA: Exploiting DRAM Buffers for Fun and Profit](https://www.blackhat.com/docs/eu-16/materials/eu-16-Schwarz-How-Your-DRAM-Becomes-A-Security-Problem-wp.pdf)
- [2015 - The Spy in the Sandbox – Practical Cache Attacks in Javascript](https://iss.oy.ne.ro/SpyInTheSandbox.pdf)
- [2015 - Cross Processor Cache Attacks](https://eprint.iacr.org/2015/1155.pdf)
- [2015 - Intel x86 considered harmful](http://blog.invisiblethings.org/papers/2015/x86_harmful.pdf)  
- **2013 - Thoughts on Intel's upcoming Software Guard Extensions (Part 1,2)**  
[http://theinvisiblethings.blogspot.sk/2013/08/thoughts-on-intels-upcoming-software.html](http://theinvisiblethings.blogspot.sk/2013/08/thoughts-on-intels-upcoming-software.html)  
[http://theinvisiblethings.blogspot.sk/2013/09/thoughts-on-intels-upcoming-software.html](http://theinvisiblethings.blogspot.sk/2013/09/thoughts-on-intels-upcoming-software.html)  
- [2005 - D.J.Bernstein - Cache-timing attacks on AES](http://cr.yp.to/antiforgery/cachetiming-20050414.pdf)


## Hardware Security - Presentations

- [2015 - Attacking Hypervisors via Firmware and Hardware](http://www.intelsecurity.com/advanced-threat-research/content/AttackingHypervisorsViaFirmware_bhusa15_dc23.pdf)
- [2015 - The Memory Sinkhole : An architectural privilege escalation vulnerability](https://www.blackhat.com/docs/us-15/materials/us-15-Domas-The-Memory-Sinkhole-Unleashing-An-x86-Design-Flaw-Allowing-Universal-Privilege-Escalation.pdf)
- [University of Maryland - hardware security](https://github.com/KarenWest/hardwareSecurity)   
Hardware security course from Coursera and University of Maryland.


## Memory Attacks

- [2016 - Memory Deduplication - presentations](https://fahrplan.events.ccc.de/congress/2016/Fahrplan/system/event_attachments/attachments/000/003/152/original/33c3_memdedup_curse_slides_final.pdf)
- [2016 - DEDUP EST MACHINA](https://www.vusec.net/projects/dedup-est-machina/)  
Dedup Est Machina (published at S&P ’16) is a new cool attack showing how a JavaScript-enabled attacker can abuse memory deduplication and Rowhammer to own a Microsoft Edge browser on Windows 10 with all the defenses up. The end-to-end attack relies on no software vulnerabilities.
- [2016 - FLIP FENG SHUI](http://www.vusec.net/projects/flip-feng-shui/)  
Flip Feng Shui (FFS) is a new exploitation vector that allows an attacker virtual machine (VM) to flip a bit in a memory page of a victim VM that runs on the same host as the attacker VM. FFS relies on a hardware vulnerability for flipping a bit and a physical memory massaging primitive to land a victim page on vulnerable physical memory location.
- [2015 - Cross-VM Address-Space Layout INtrospection (CAIN)](https://xorlab.com/blog/2015/07/30/cain/)  
We found an attack vector against memory deduplication in Virtual Machine Monitors (VMM) where attackers can effectively leak randomized base addresses of libraries and executables in processes of neighboring Virtual Machines (VM). The attack takes advantage of the well known memory deduplication side-channel.
- [2015 - CAIN: Silently Breaking ASLR in the Cloud](https://www.usenix.org/node/191961)  
[http://www.antoniobarresi.com/security/cloud/2015/07/30/cain/](http://www.antoniobarresi.com/security/cloud/2015/07/30/cain/)
- [PrivateCore - Physical Memory Attacks](https://privatecore.com/resources-overview/physical-memory-attacks/index.html)
- [PrivateCore - Side Channel Attacks](https://privatecore.com/resources-overview/side-channel-attacks/index.html)



## Time channels

- [2014 - The Last Mile An Empirical Study of Timing Channels on seL4 - Link1](http://www.cse.unsw.edu.au/~davec/papers/Cock_GMH_14.pdf)
- [2014 - The Last Mile An Empirical Study of Timing Channels on seL4 - Link2](http://research.davidcock.fastmail.fm/slides/lastmile.pdf)


## CPU security features

- [Intel CPU security features (****)](https://github.com/huku-/research/wiki/Intel-CPU-security-features)


## HW Security - People

- **Dr. Steven J. Murdoch - prednasky a vyskumne prace**  
[Talks](http://sec.cs.ucl.ac.uk/users/smurdoch/talks/)  
[Papers](http://sec.cs.ucl.ac.uk/users/smurdoch/papers/)

