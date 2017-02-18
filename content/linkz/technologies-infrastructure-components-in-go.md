


## Container infrastructure components in GO lang



## HTTP LoadBalancer/Reverse Proxy

- **[traefik (License: MIT)](https://traefik.io/)**  
[traefik - github](https://github.com/containous/traefik)  
[traefik - documentation](https://docs.traefik.io/)   
Traefik is a modern HTTP reverse proxy and load balancer made to deploy microservices with ease. It supports several backends (Docker, Swarm, Kubernetes, Marathon, Mesos, Consul, Etcd, Zookeeper, BoltDB, Rest API, file…) to manage its configuration automatically and dynamically.
 - It’s fast
 - No dependency hell, single binary made with go
 - Rest API
 - Multiple backends supported: Docker, Swarm, Kubernetes, Marathon, Mesos, Consul, Etcd, and more to come
 - Watchers for backends, can listen for changes in backends to apply a new configuration automatically
 - Hot-reloading of configuration. No need to restart the process
 - Graceful shutdown http connections
 - Circuit breakers on backends
 - Round Robin, rebalancer load-balancers
 - Rest Metrics
 - Tiny official docker image included
 - SSL backends support
 - SSL frontend support (with SNI)
 - Clean AngularJS Web UI
 - Websocket support
 - HTTP/2 support
 - Retry request if network error
 - Let’s Encrypt support (Automatic HTTPS with renewal)
 - High Availability with cluster mode



## Object storage

- **[Minio (License: Apache-2.0)](https://minio.io/)**  
[Minio - github](https://github.com/minio/minio)  
Minio is a lightweight object storage server released under Apache License v2.0. It is compatible with Amazon S3 cloud storage service. It is best suited for storing unstructured data such as photos, videos, log files, backups and container / VM images. Size of an object can range from a few KBs to a maximum of 5TB. Minio has advanced features like erasure code, bitrot protection and lambda functions. Application developers often deploy Minio in a dockerized container and orchestrate it with Kubernetes. Minio server is light enough to be bundled with the application stack, similar to Node JS, Redis and MySQL.


 - **Minio - DOC**  
[Minio - documentation](http://docs.minio.io/)  
[Minio - erasure code](http://docs.minio.io/docs/minio-erasure-code-quickstart-guide)  
[Minio - distributed storage](http://docs.minio.io/docs/distributed-minio-quickstart-guide)
 - [2016 - Build AWS S3 compatible cloud storage on GCP with Minio and Kubernetes](https://medium.com/google-cloud/build-aws-s3-compatible-cloud-storage-on-gcp-with-minio-and-kubernetes-2adc0a367f98#.uafq8ip9z)
 - [AWS S3 open source alternative written in Go (minio.io)](https://news.ycombinator.com/item?id=12392081) - 
Celkom zaujimava diskusia na ycombinator



## Key-value store

- **[etcd (License: Apache-2.0)](https://coreos.com/etcd)**  
[etcd - github](https://github.com/coreos/etcd)  
[etcd - documentation](https://coreos.com/etcd/docs/latest/)  
etcd is a distributed, consistent key-value store for shared configuration and service discovery, with a focus on being:
 - Simple: well-defined, user-facing API (gRPC)
 - Secure: automatic TLS with optional client cert authentication
 - Fast: benchmarked 10,000 writes/sec
 - Reliable: properly distributed using Raft  
etcd gracefully handles leader elections during network partitions and will tolerate machine failure, including the leader. Your applications can read and write data into etcd. A simple use-case is to store database connection details or feature flags in etcd as key value pairs. These values can be watched, allowing your app to reconfigure itself when they change. Advanced uses take advantage of the consistency guarantees to implement database leader elections or do distributed locking across a cluster of workers.



## Datacenter-Aware Scheduler

- **[Nomad (License: MPL-2.0)](https://www.nomadproject.io/)**  
[Nomad - github](https://github.com/hashicorp/nomad)  
Nomad is a cluster manager, designed for both long lived services and short lived batch processing workloads. Developers use a declarative job specification to submit work, and Nomad ensures constraints are satisfied and resource utilization is optimized by efficient task packing. Nomad supports all major operating systems and virtualized, containerized, or standalone applications.



- **[Cloud Integrated Advanced Orchestrator](https://clearlinux.org/ciao)**  
[Cloud Integrated Advanced Orchestrator - github](https://github.com/01org/ciao)  
Ciao is the "Cloud Integrated Advanced Orchestrator". Its goal is to provide an easy to deploy, secure, scalable cloud orchestration system which handles virtual machines, containers, and bare metal apps agnostically as generic workloads. Implemented in the Go language, it separates logic into "controller", "scheduler" and "launcher" components which communicate over the "Simple and Secure Node Transfer Protocol (SSNTP)".


## Performance monitoring

- **[cAdvisor](https://github.com/google/cadvisor)**  
Analyzes resource usage and performance characteristics of running containers.
cAdvisor (Container Advisor) provides container users an understanding of the resource usage and performance characteristics of their running containers. It is a running daemon that collects, aggregates, processes, and exports information about running containers. Specifically, for each container it keeps resource isolation parameters, historical resource usage, histograms of complete historical resource usage and network statistics. This data is exported by container and machine-wide.
cAdvisor has native support for Docker containers and should support just about any other container type out of the box. We strive for support across the board so feel free to open an issue if that is not the case. cAdvisor's container abstraction is based on lmctfy's so containers are inherently nested hierarchically.


## Management 

- **[Gravitational Teleport - Modern SSH server for teams managing distributed infrastructure (License: Apache-2.0)](http://gravitational.com/teleport/)**  
[Gravitational Teleport - github](https://github.com/gravitational/teleport)  
[Gravitational Teleport - Architecture](http://gravitational.com/teleport/docs/architecture/)  
[Gravitational Teleport - Quickstart](http://gravitational.com/teleport/docs/quickstart/)  
[Gravitational Teleport - Admin guide](http://gravitational.com/teleport/docs/admin-guide/)  
Gravitational Teleport (“Teleport”) is a modern SSH server for remotely accessing clusters of Linux servers via SSH or HTTPS. It is intended to be used instead of sshd.
Teleport enables teams to easily adopt the best SSH practices like:
 - Integrated SSH credentials with your organization Google Apps identities or other OAuth identitiy providers.
 - No need to distribute keys: Teleport uses certificate-based access with automatic expiration time.
 - Enforcement of 2nd factor authentication.
 - Cluster introspection: every Teleport node becomes a part of a cluster and is visible on the Web UI.
 - Record and replay SSH sessions for knowledge sharing and auditing purposes.
 - Collaboratively troubleshoot issues through session sharing.
 - Connect to clusters located behind firewalls without direct Internet access via SSH bastions.
 - Teleport is built on top of the high-quality Golang SSH implementation and it is compatible with OpenSSH.









## Others GO projects

- [Awesome Go](https://awesome-go.com/) - A curated list of awesome Go frameworks, libraries and software.

