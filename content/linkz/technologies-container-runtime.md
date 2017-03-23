

## Open Container Initiative (OCI) and Specifications

- **[Open Container Initiative](https://www.opencontainers.org/)**  
The Open Container Initiative (OCI) is a lightweight, open governance structure (project), formed under the auspices of the Linux Foundation, for the express purpose of creating open industry standards around container formats and runtime. The OCI was launched on June 22nd 2015. The OCI currently contains two specifications: the Runtime Specification (runtime-spec) and the Image Specification (image-spec). The Runtime Specification outlines how to run a “filesystem bundle” that is unpacked on disk. At a high-level an OCI implementation would download an OCI Image then unpack that image into an OCI Runtime filesystem bundle. At this point the OCI Runtime Bundle would be run by an OCI Runtime.
 - [OCI Runtime Specification](https://github.com/opencontainers/runtime-spec)
 - [OCI Image Specification](https://github.com/opencontainers/image-spec)


## Open Container Initiative (OCI) - Implementations


**Container Based**  


- **[runc (Docker)](https://github.com/opencontainers/runc)**  
runc is a CLI tool for spawning and running containers according to the OCI specification. 


- **[Kurma](http://kurma.io/)**  
[Kurma - github](https://github.com/apcera/kurma)  
[Kurma - Documentation](http://kurma.io/documentation/)  
Kurma is a container runtime built with extensibility and flexibility in mind. It focuses on "everything is a container" and uses this to enable plugins that run within Kurma, leaving Kurma easy and simple to deploy and manage. Configuring networking plugins or customizing how containers are instrumented is easily extensible. Kurma implements the App Container (appc) specification, and leverages libcontainer from the Open Container Initiative (OCI).


- **[rkt - A security-minded, standards-based container engine (License: )](https://coreos.com/rkt)**  
[rkt - github](https://github.com/coreos/rkt)  
[rkt - Documentation](https://coreos.com/rkt/docs/latest/)  
rkt is the next-generation container manager for Linux clusters. Designed for security, simplicity, and composability within modern cluster architectures, rkt discovers, verifies, fetches, and executes application containers with pluggable isolation. rkt can run the same container with varying degrees of protection, from lightweight, OS-level namespace and capabilities isolation to heavier, VM-level hardware virtualization.



**Hypervisor Based**


- **[HyperContainer = Hypervisor + Kernel + Docker Image (License: )](https://hypercontainer.io/)**  
[HyperContainer - github](https://github.com/hyperhq)  
[HyperContainer - How it works](https://hypercontainer.io/how-it-works.html)  
[HyperContainer - Documentation](https://docs.hypercontainer.io/)  
HyperContainer is a Hypervisor-agnostic Docker Runtime that allows you to run Docker images on any hypervisor (KVM, Xen, etc.).

 - [hyperd](https://github.com/hyperhq/hyperd)  
HyperContainer Daemon. This repo contains two parts: the daemon of HyperContainer **hyperd** and the CLI **hyperctl**.

 - [hyperstart](https://github.com/hyperhq/hyperstart)  
The init Task for HyperContainer.

 - [runV](https://github.com/hyperhq/runv)  
runV is a hypervisor-based runtime for OCI. runV is compatible with OCI. However, due to the difference between hypervisors and containers, the following sections of OCI don't apply to runV:  
\- Namespace  
\- Capability  
\- Device  
\- linux and mount fields in OCI specs are ignored    
The current release of runV supports the following hypervisors:  
\- KVM (QEMU 2.0 or later)  
\- Xen (4.5 or later)  
\- VirtualBox (Mac OS X)  

 - [hypernetes = Bare-metal + Hyper + Kubernetes + KeyStone + Cinder + Neutron](https://github.com/hyperhq/hypernetes)  
Hypernetes is a secure, multi-tenant Kubernetes distro.


- **[Frakti (License: Apache-2.0)](https://github.com/kubernetes/frakti)**  
The hypervisor-based container runtime for Kubernetes. Frakti lets Kubernetes run pods and containers directly inside hypervisors via HyperContainer. It is light weighted and portable, but can provide much stronger isolation with independent kernel than linux-namespace-based container runtimes.



- **[cc-oci-runtime](https://github.com/01org/cc-oci-runtime)**  
cc-oci-runtime is an Open Containers Initiative (OCI) "runtime" that launches an Intel VT-x secured Clear Containers 2.0 hypervisor, rather than a standard Linux container. It leverages the highly optimised Clear Linux technology to achieve this goal.







