### D.J.Bernstein - original kod


- [NaCl - Networking and Cryptography library](https://nacl.cr.yp.to/)
<br>
NaCl (pronounced "salt") is a new easy-to-use high-speed software library for network communication, encryption, decryption, signatures, etc. NaCl's goal is to provide all of the core operations needed to build higher-level cryptographic tools.


- [TweetNaCl - crypto library in 100 tweets](https://tweetnacl.cr.yp.to/)
<br>
[https://tweetnacl.cr.yp.to/software.html](https://tweetnacl.cr.yp.to/software.html)
<br>
TweetNaCl is the world's first auditable high-security cryptographic library. TweetNaCl fits into just 100 tweets while supporting all 25 of the C NaCl functions used by applications. TweetNaCl is a self-contained public-domain C library, so it can easily be integrated into applications.


- [DJB - Index of software](https://cr.yp.to/software.html)


- [libtai](https://cr.yp.to/libtai.html)
<br>
libtai is a library for storing and manipulating dates and times.


### Dalsie C kniznice odvodene z DJB prace


- [Nemo DJB Library (License: Public Domain)](http://www.nemostar.org/libdjb/index.html)
<br>
This library maintains most of the coding style and alogoritmic conventions originally developed by Daniel Bernstien.
Nemo DJB Library (libdjb) consists of:
<br>
\- original routines and data types written by Stephen Welker,
<br>
\- second generation of Daniel Bernstein's core routines that can be found in many of his original software packages.


- [skalibs (License: ISC)](http://skarnet.org/software/skalibs/index.html)
<br>
skalibs is a package centralizing the free software / open source C development files used for building all software at skarnet.org: it contains essentially general-purpose libraries. You will need to install skalibs if you plan to build skarnet.org software. The point is that you won't have to download and compile big libraries, and care about portability issues, everytime you need to build a package: do it only once. skalibs can also be used as a sound basic start for C development. There are a lot of general-purpose libraries out there; but if your main goal is to produce small and secure C code with a focus on system programming, skalibs might be for you.


 - [The stddjb library interface](http://skarnet.org/software/skalibs/libstddjb/)<br>
 libstddjb is the base, and the most important part, of skalibs. It is a set of general-purpose C functions wrapping some system calls, hiding some Unix portability problems, providing some basic low-level buffering functions and string handling, and generally offering a nice API to Unix programming - in many ways nicer and safer than the "standard" Unix APIs like stdio.h.

 - [The datastruct library interface](http://skarnet.org/software/skalibs/libdatastruct/)<br>
 libdatastruct implements generic data structures like chained lists and AVL trees, in a memory-efficient and CPU-efficient way.

 - [The stdcrypto library interface](http://skarnet.org/software/skalibs/libstdcrypto/)<br>
 stdcrypto is a small collection of standard, public-domain cryptographic primitives. Currently, the following operations are provided: rc4, md5, sha1, sha256, sha512

 - [The random library interface](http://skarnet.org/software/skalibs/librandom/)<br>
 librandom is a small library designed to provide an interface to some reasonable-quality pseudorandom number generation. librandom uses arc4random when available, or getrandom - else it defaults to /dev/urandom and a a SURF PRNG.

 - [The unixonacid library interface](http://skarnet.org/software/skalibs/libunixonacid/)<br>
 libunixonacid provides higher-level interfaces to Unix concepts such as the filesystem - for instance, it provides a way to access several files atomically, be it for reading or for writing - or interprocess communication.
 \- transactional filesystem operations <br>
 \- timed synchronous IPC or network operations <br>
 \- safe asynchronous and synchronous message transmission between processes via Unix sockets, including fd-passing <br>
 \- simple callback management for asynchronous message transmission <br>
 \- higher-level client-server interface using messages <br>

 - [The biguint library interface](http://skarnet.org/software/skalibs/libbiguint/)<br>
 biguint is set of simple primitives performing arithmetical operations on (unsigned) integers of arbitrary length. It is nowhere near as powerful or efficient as specialized, assembly language-optimized libraries such as GMP, but it has the advantages of smallness and simplicity.


- [The Sodium crypto library - libsodium (License: ISC)](https://github.com/jedisct1/libsodium)
<br>
[libsodium - doc](https://download.libsodium.org/doc/)
<br>
Sodium is a new, easy-to-use software library for encryption, decryption, signatures, password hashing and more. It is a portable, cross-compilable, installable, packageable fork of NaCl, with a compatible API, and an extended API to improve usability even further.
Its goal is to provide all of the core operations needed to build higher-level cryptographic tools.


- [libowfat (License: GPL)](https://www.fefe.de/libowfat/)
<br>
[libowfat - api](https://github.com/gebi/libowfat )
<br>
[MAN-ualove stranky ku kniznici "libowfat"](https://manned.org/browse/search?q=libowfat)
<br>
Short answer: reimplement libdjb under GPL.
