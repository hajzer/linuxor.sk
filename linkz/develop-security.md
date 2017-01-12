### SOFT

- [Coccinelle](http://coccinelle.lip6.fr/)
<br>
Coccinelle is a program matching and transformation engine which provides the language SmPL (Semantic Patch Language) for specifying desired matches and transformations in C code. Coccinelle was initially targeted towards performing collateral evolutions in Linux. Such evolutions comprise the changes that are needed in client code in response to evolutions in library APIs, and may include modifications such as renaming a function, adding a function argument whose value is somehow context-dependent, and reorganizing a data structure. Beyond collateral evolutions, Coccinelle is successfully used (by us and others) for finding and fixing bugs in systems code.


- [Coccinellery (Coccinelle gallery)](http://coccinellery.org/)
<br>
This is a gallery of semantic patches for use with Coccinelle. They are extracted automatically from a collection of semantic patches that have been used to create patches for the Linux Kernel and other software. The descriptions are derived from the commit messages contained in those patches.


- [Jaderné noviny - 1. 9. 2016: Pohled do hlavy vývojářky Coccinelle](http://www.abclinuxu.cz/clanky/jaderne-noviny-1.-9.-2016-pohled-do-hlavy-vyvojarky-coccinelle)


### DOC - MEMORY ALLOCATION

- [2016 - How to Allocate Dynamic Memory Safely](http://www.barrgroup.com/Embedded-Systems/How-To/Malloc-Free-Dynamic-Memory-Allocation)

- [Guarded heap allocations](http://stackoverflow.com/a/33568256)

- [Secmalloc - a secure memory library](http://www.jabberwocky.com/software/secmalloc/)
<br>
Most modern systems have some notion of swap, where the contents of memory can be written to disk, freeing up the memory for other purposes. This allows the system a lot of flexibility in managing its memory. Infrequently used data is a prime candidate for swapping to disk, thus freeing up the real memory for more useful purposes. This can be a problem when using cryptography as there is a danger of keys or other sensitive data ending up in swap where (eventually) it may fall into the wrong hands. Secmalloc provides a secure version of the common 'malloc' interface for managing memory. All memory allocated by secmalloc is locked, so that it cannot be swapped out.

