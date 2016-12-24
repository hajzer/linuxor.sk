### DOC - TRANSAKCIE, TRANSAKCNY LOG, ...

- [2016 - The Guts n' Glory of Database Internals (****)](https://ayende.com/blog/posts/series/174337/the-guts-n-glory-of-database-internals)
<br>
Cela seria clankov na temu implementovania databaz (konkretne LMDB engine od SYMAS)

 - [2016 - The transaction journal & recovery](https://ayende.com/blog/175075/voron-internals-the-transaction-journal-recovery)

 - [2016 - Merging transactions](https://ayende.com/blog/174945/the-guts-n-glory-of-database-internals-merging-transactions)

 - [2016 - Early lock release](https://ayende.com/blog/174946/the-guts-n-glory-of-database-internals-early-lock-release)

 - [2016 - What goes inside the transaction journal](https://ayende.com/blog/174916/the-guts-n-glory-of-database-internals-what-goes-inside-the-transaction-journal?key=9f2e9fc51b95457eaa6029d82dba9aba)

 - [2016 - Log shipping and point in time recovery](https://ayende.com/blog/174917/the-guts-n-glory-of-database-internals-log-shipping-and-point-in-time-recovery)

 - [2016 - Fast transaction log - Linux](https://ayende.com/blog/174753/fast-transaction-log-linux)

 - [2016 - Fast transaction log - Windows](https://ayende.com/blog/174785/fast-transaction-log-windows)

 - [2016 - Understanding durability with hard disks](https://ayende.com/blog/174563/the-guts-n-glory-of-database-internals-understanding-durability-with-hard-disks)

- [2013 - The Log: What every software engineer should know about real-time data's unifying abstraction (****)](https://engineering.linkedin.com/distributed-systems/log-what-every-software-engineer-should-know-about-real-time-datas-unifying)


### DOC - ATOMICITA

- [Atomic Commit In SQLite](https://www.sqlite.org/atomiccommit.html)
<br>
Velmi pekne informacie o tom ako su implementovane atomicke operacie v SQLite.


### DOC - ATOMICITA / ATOMICKE OPERACIE V OS LINUX

- [2010 - Things UNIX can do atomically](http://rcrowley.org/2010/01/06/things-unix-can-do-atomically.html)

- [2015 - Failure-Atomic Updates of Application Data in a Linux File System](https://www.usenix.org/conference/fast15/technical-sessions/presentation/verma)
<br>
[https://www.usenix.org/system/files/conference/fast15/fast15-paper-verma.pdf](https://www.usenix.org/system/files/conference/fast15/fast15-paper-verma.pdf)


### SOFT

- [Narayana](http://narayana.io/)
<br>
With over 20 years of expertise in the area of transaction processing, Narayana is the premier open source transaction manager. It has been used extensively within industry and to drive standards including the OMG and Web Services.


- [Apache Tephra](http://tephra.incubator.apache.org/)
<br>
Apache Tephra provides globally consistent transactions on top of distributed data stores such as Apache HBase. While HBase provides strong consistency with row- or region-level ACID operations, it sacrifices cross-region and cross-table consistency in favor of scalability. This trade-off requires application developers to handle the complexity of ensuring consistency when their modifications span region boundaries. By providing support for global transactions that span regions, tables, or multiple RPCs, Tephra simplifies application development on top of HBase, without a significant impact on performance or scalability for many workloads.
Tephra is used by the Apache Phoenix as well to add cross-row and cross-table transaction support with full ACID semantics.

