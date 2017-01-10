### SOFT - TAZKE VAHY (ROBUSTNEJSIE RIESENIA)


- [Firejail](https://firejail.wordpress.com/)
<br>
[https://github.com/netblue30/firejail](https://github.com/netblue30/firejail)
<br>
Firejail is a SUID program that reduces the risk of security breaches by restricting the running environment of untrusted applications using Linux namespaces and seccomp-bpf. It allows a process and all its descendants to have their own private view of the globally shared kernel resources, such as the network stack, process table, mount table. Firejail can work in a SELinux or AppArmor environment, and it is integrated with Linux Control Groups.
<br>

> Vzhladom na dost velku komplexnost tohto nastroja je otazne kolko bezpecnostnych problemov moze pouzitie tohto nastroja priniest aj ked je zoznam deklarovanych  bezpecnostnych moznosti celkom zaujimavy.

> V poslednom case bolo v nastroji firejail objavenych dost vela bezpecnostnych problemov: <br>
>
 - [2017 - seclist - Firejail security](http://seclists.org/oss-sec/2017/q1/20)
 - [firejail - release notes](https://firejail.wordpress.com/download-2/release-notes/)
  - security: --bandwidth root shell found by Martin Carpenter (CVE-2017-5207)
  - security: disabled --allow-debuggers when running on kernel versions prior to 4.8; a kernel bug in ptrace system call allows a full bypass of seccomp filter; problem reported by Lizzie Dixon (CVE-2017-5206)
  - security: root exploit found by Sebastian Krahmer (CVE-2017-5180)
  - security: root exploit found by Sebastian Krahmer (CVE-2017-5180)
  - security: overwrite /etc/resolv.conf found by Martin Carpenter (CVE-2016-10118)
  - security: invalid environment exploit found by Martin Carpenter (CVE-2016-10122)
  - CVE-2016-9016 submitted by Aleksey Manevich
  - security: overwrite /etc/resolv.conf found by Martin Carpenter (CVE-2016-10118)
  - CVE-2016-7545 submitted by Aleksey Manevich
  - ...


- [Minijail (ChromiumOS/Google)](https://android.googlesource.com/platform/external/minijail/+/master)
<br>
[Chromium OS Sandboxing](https://www.chromium.org/chromium-os/developer-guide/chromium-os-sandboxing)
<br>
[2016 - LWN - Minijail](https://lwn.net/Articles/700557/)
<br>
Minijail is a tool and library that Google uses in multiple systems for sandboxing. In fact, he said, Google uses it everywhere: on Android, Chrome OS, on its servers, and beyond.


- [NsJail](http://google.github.io/nsjail/)
<br>
[github - NsJail](https://github.com/google/nsjail)
<br>
A light-weight process isolation tool, making use of Linux namespaces and seccomp-bpf. This is NOT an official Google product.


### SOFT - LAHKE VAHY


- [Jailkit](http://olivier.sessink.nl/jailkit/)
<br>
Jailkit is a set of utilities to limit user accounts to specific files using chroot() and or specific commands. Setting up a chroot shell, a shell limited to some specific command, or a daemon inside a chroot jail is a lot easier and can be automated using these utilities. Jailkit is known to be used in network security appliances from several leading IT security firms, internet servers from several large enterprise organizations, internet servers from internet service providers, as well as many smaller companies and private users that need to secure cvs, sftp, shell or daemon processes.


- [bubblewrap (ProjectAtomic/RedHat)](https://github.com/projectatomic/bubblewrap)
<br>
Unprivileged sandboxing tool. The goal of bubblewrap is to run an application in a sandbox, where it has restricted access to parts of the operating system or user data such as the home directory.


- [Mbox](https://pdos.csail.mit.edu/archive/mbox/)
<br>
[2013 - Practical and effective sandboxing for non-root users](https://taesoo.gtisc.gatech.edu/pubs/2013/kim:mbox.pdf)


### SOFT - DALSIE PROJEKTY


- [openjail](https://github.com/waneck/openjail)
<br>
Openjail is a secure application sandbox built with modern Linux sandboxing features, built on top of playpen.


- [SimpleLinuxSandbox](https://github.com/mzohreva/SimpleLinuxSandbox)
<br>
A simple sandbox using Linux namespaces. Executes COMMAND in a virtual environment with very limited access to system resources. The command is executed with non-root privileges. The uid and gid can be directly specified with -u and -g options, otherwise the user running the sandbox is used. If the sandbox is run as root (e.g. with sudo), then the non-root user must be specified through -u and -g options.


- [Limon](https://github.com/cysinfo/Limon)
<br>
[2015 - Automating Linux Malware Analysis Using Limon Sandbox](https://www.blackhat.com/docs/eu-15/materials/eu-15-KA-Automating-Linux-Malware-Analysis-Using-Limon-Sandbox-wp.pdf)
<br>
Limon is a sandbox developed as a research project written in python, which automatically collects, analyzes, and reports on the run time indicators of Linux malware. It allows one to inspect the Linux malware before execution, during execution, and after execution (post-mortem analysis) by performing static, dynamic and memory analysis using open source tools. Limon analyzes the malware in a controlled environment, monitors its activities and its child processes to determine the nature and purpose of the malware. It determines the malware's process activity, interaction with the file system, network, it also performs memory analysis and stores the analyzed artifacts for later analysis.


- [Sandbox (Gentoo)](https://gitweb.gentoo.org/proj/sandbox.git/about/)
<br>
Sandbox is a library (and helper utility) to run programs in a "sandboxed" environment.  This is used as a QA measure to try and prevent applications from modifying files they should not


### DOC

- [Denying Syscalls with Seccomp](https://eigenstate.org/notes/seccomp)

