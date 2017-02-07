

## Technológie úložísk objektov (Object Storage) - Informácie


- [2016 - Why object storage is eating the world](https://opensource.com/life/16/7/object-storage)



## Technológie úložísk objektov (Object Storage) - Technológie


## ceph

**[ceph (License: LGPL-2.1)](https://ceph.com/)**  
[ceph - github](https://github.com/ceph)  
[ceph - blog](https://ceph.com/community/blog/)
Ceph is a unified, distributed storage system designed for excellent performance, reliability and scalability.

**Object storage**  
Ceph provides seamless access to objects using native language bindings or radosgw (RGW), a REST Interface that's compatible with applications written for S3 and Swift. Organizations prefer object-based storage when deploying large scale storage systems, because it stores data more efficiently. Object-based storage systems separate the object namespace from the underlying storage hardware—this simplifies data migration.  
\* partial or complete reads and writes  
\* snapshots  
\* atomic transactions with features like append, truncate and clone range  
\* object level key-value mappings  

**Block storage**  
Ceph's RADOS Block Device (RBD) provides access to block device images that are striped and replicated across the entire storage cluster. Ceph’s object storage system isn’t limited to native binding or RESTful APIs. You can mount Ceph as a thinly provisioned block device! When you write data to Ceph using a block device, Ceph automatically stripes and replicates the data across the cluster.    
\* Thinly provisioned  
\* Resizable images  
\* Image import/export  
\* Ability to mount with Linux or QEMU KVM clients!  

**File system**  
Ceph provides a POSIX-compliant network file system (CephFS) that aims for high performance, large data storage, and maximum compatibility with legacy applications. Ceph provides a traditional file system interface with POSIX semantics. Object storage systems are a significant innovation, but they complement rather than replace traditional file systems.    
\* Stronger data safety for mission-critical applications  
\* Virtually unlimited storage to file systems  
\* Applications that use file systems can use Ceph FS natively  
\* Ceph automatically balances the file system to deliver maximum performance.  


**ceph - DOC**  
[ceph - Documentation](http://docs.ceph.com/docs/master/)  
[ceph - Use cases / Reference Architectures](https://ceph.com/use-cases/)  
[ceph - WIKI](http://tracker.ceph.com/projects/ceph/wiki/)

**ceph - SW**  
[ceph PGs per Pool Calculator](https://ceph.com/pgcalc/)  



## Minio
**[Minio (License: Apache-2.0)](https://minio.io/)**  
[Minio - github](https://github.com/minio/minio)  
Minio is a lightweight object storage server released under Apache License v2.0. It is compatible with Amazon S3 cloud storage service. It is best suited for storing unstructured data such as photos, videos, log files, backups and container / VM images. Size of an object can range from a few KBs to a maximum of 5TB. Minio has advanced features like erasure code, bitrot protection and lambda functions. Application developers often deploy Minio in a dockerized container and orchestrate it with Kubernetes. Minio server is light enough to be bundled with the application stack, similar to Node JS, Redis and MySQL.


**Minio - DOC**  
[Minio - Documentation](http://docs.minio.io/)  
[Minio - Erasure code](http://docs.minio.io/docs/minio-erasure-code-quickstart-guide)  
[Minio - Distributed storage](http://docs.minio.io/docs/distributed-minio-quickstart-guide)  

[2016 - Build AWS S3 compatible cloud storage on GCP with Minio and Kubernetes](https://medium.com/google-cloud/build-aws-s3-compatible-cloud-storage-on-gcp-with-minio-and-kubernetes-2adc0a367f98#.uafq8ip9z)  
[AWS S3 open source alternative written in Go (minio.io)](https://news.ycombinator.com/item?id=12392081) - 
Celkom zaujimava diskusia na ycombinator



## LeoFS
**[LeoFS (License: Apache-2.0)](http://leo-project.net/leofs/)**  
[LeoFS - github](https://github.com/leo-project/leofs)      
LeoFS is a highly available, distributed, eventually consistent object/blob store. If you are searching a storage system that is able to store huge amount and various kind of files such as photo, movie, log data and so on, LeoFS is suitable for that. LeoFS provides High Reliability thanks to its great design on top of the Erlang/OTP capabilities. Erlang/OTP is known for being used in production systems for years with a solid nine nines (99.9999999%) availability, and LeoFS is no exception. A LeoFS system will stay up regardless of software errors or hardware failures happening inside the cluster.

LeoFS is supporting the following features:  

- **Multi Protocol**
  - S3-API Support  
     * LeoFS is an Amazon S3 compatible storage system.  
     * Switch to LeoFS to decrease your cost from more expensive public-cloud solutions.  
  + REST-API Support  
     * To easily access LeoFS with REST-API
  + NFS Support
     * NFS support was provided from LeoFS v1.1, the current status of which is beta.
- **Large Object Support**
  + LeoFS covers handling large size objects.
- **Multi Data Center Replication**
  + LeoFS is a highly scalable, fault-tolerant distributed file system without SPOF.
  + LeoFS's cluster can be viewed as a huge capacity storage. It consists of a set of loosely connected nodes.
  + We can build a global scale storage system with easy operations


**LeoFS - DOC**  
[2014 - The next step of LeoFS and Introducing NewDB Project](http://www.slideshare.net/rakutentech/d4-rakuten-tech2014leofsnewdb?ref=http://leo-project.net/leofs/)  
[2014 - Scaling and High Performance Storage System: LeoFS](http://www.slideshare.net/rakutentech/scaling-and-high-performance-storage-system-leofs)  
[2012 - Introduce LeoFS](http://www.slideshare.net/yousukehara/introduction-to-leofs)  



## IPFS
**[IPFS (License: MIT) - Status: IPFS is a work in progress!](https://ipfs.io/)**  
[IPFS - github](https://github.com/ipfs/ipfs)  
IPFS (the InterPlanetary File System) is a new hypermedia distribution protocol, addressed by content and identities. IPFS enables the creation of completely distributed applications. It aims to make the web faster, safer, and more open. IPFS is a distributed file system that seeks to connect all computing devices with the same system of files. In some ways, this is similar to the original aims of the Web, but IPFS is actually more similar to a single bittorrent swarm exchanging git objects. You can read more about its origins in the paper IPFS - Content Addressed, Versioned, P2P File System.


**IPFS - DOC**  
[IPFS - Content Addressed, Versioned, P2P File System (DRAFT 3)](https://github.com/ipfs/papers/raw/master/ipfs-cap2pfs/ipfs-p2p-file-system.pdf)  
[IPFS - Papers](https://github.com/ipfs/papers/tree/master/ipfs-ttpw)



