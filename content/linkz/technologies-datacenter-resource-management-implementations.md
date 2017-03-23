

## Datacenter resource management / schedulers - Implementations


- **[YARN - Apache Hadoop YARN (Yet Another Resource Negotiator) is a cluster management technology](http://hadoop.apache.org/)**  
[YARN - github](https://github.com/apache/hadoop/tree/trunk/hadoop-yarn-project/hadoop-yarn)  
[Apache Hadoop Yarn - Homesite](http://hadoop.apache.org/docs/current/hadoop-yarn/hadoop-yarn-site/YARN.html)  
[Apache Hadoop Yarn - Hortonworks](http://hortonworks.com/hadoop/yarn/)  
YARN is now characterized as a large-scale, distributed operating system for big data applications.  <br>    
**YARN - DOC**  
 [2012 - Hortonworks - Introducing Apache Hadoop YARN](http://hortonworks.com/blog/introducing-apache-hadoop-yarn/)    
 [2013 - Hortonworks - Philosophy behind YARN resource management](http://hortonworks.com/blog/philosophy-behind-yarn-resource-management/)  
 [2012 - Hortonworks - Apache Hadoop YARN – Background and an Overview](http://hortonworks.com/blog/apache-hadoop-yarn-background-and-an-overview/)  
 [2012 - Hortonworks - Apache Hadoop YARN – Concepts and applications](http://hortonworks.com/blog/apache-hadoop-yarn-concepts-and-applications/)  
 [2012 - Hortonworks - Apache Hadoop YARN – Resource Manager](http://hortonworks.com/blog/apache-hadoop-yarn-resourcemanager/)  
 [2012 - Hortonworks - Apache Hadoop YARN – Node Manager](http://hortonworks.com/blog/apache-hadoop-yarn-nodemanager/)  


- **[Kubernetes (License: Apache-2.0)](https://kubernetes.io/)**  
[Kubernetes - github](https://github.com/kubernetes/kubernetes)  
[Kubernetes - Documentation](https://kubernetes.io/docs/)  
Kubernetes is an open source system for managing containerized applications across multiple hosts, providing basic mechanisms for deployment, maintenance, and scaling of applications. Kubernetes is hosted by the Cloud Native Computing Foundation (CNCF). Kubernetes builds upon a decade and a half of experience at Google running production workloads at scale using a system called Borg, combined with best-of-breed ideas and practices from the community.


- **[Minikube](https://github.com/kubernetes/minikube)**  
[Running Kubernetes Locally via Minikube](https://kubernetes.io/docs/getting-started-guides/minikube/)  
Minikube is a tool that makes it easy to run Kubernetes locally. Minikube runs a single-node Kubernetes cluster inside a VM on your laptop for users looking to try out Kubernetes or develop with it day-to-day.


- **[MESOS - distributed systems kernel](http://mesos.apache.org/)**  
Mesos is built using the same principles as the Linux kernel, only at a different level of abstraction. The Mesos kernel runs on every machine and provides applications (e.g., Hadoop, Spark, Kafka, Elastic Search) with API’s for resource management and scheduling across entire datacenter and cloud environments.


- **[MiniMesos - Testing infrastructure for Mesos frameworks](https://minimesos.org/)**  
The experimentation and testing tool for Apache Mesos


- **[Bistro (License: BSD) - A fast, flexible toolkit for scheduling and running distributed tasks](https://facebook.github.io/bistro/)**  
[Bistro - github](https://github.com/facebook/bistro)  
A toolkit for making services that schedule and execute tasks. Bistro is an engineer's tool — your clients need to do large amounts of computation, and your goal is to make a system that handles them easily, performantly, and reliably.  <br>  
**Bistro - DOC**  
[Bistro - Getting started](https://facebook.github.io/bistro/docs/getting-started/)  
[Bistro: Scheduling Data-Parallel Jobs Against Live Production Systems](https://facebook.github.io/bistro/static/bistro_ATC_final.pdf)  


- **[Firmanent (LICENSE: Apache 2.0)](http://www.firmament.io/)**  
Firmament is based on a graph-theoretic construct called a flow network, over which it runs a minimum-cost optimization. Unlike heuristic-driven schedulers, Firmament's approach is guaranteed to find the policy-optimal assignment of work to cluster resources. Flexible policy, scalability to large clusters, and high-quality scheduling decisions need not be exclusive: Firmament's principled approach has you covered.
Firmament works stand-alone, or within your cluster manager.


- **[OpenSVC](http://www.opensvc.com/)**





