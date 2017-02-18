

## Distributed systems Frameworks


### Micro

- **[Micro (License: Apache-2.0)](https://micro.mu/)**  
[Micro - github](https://github.com/micro/micro)  
Micro is a microservice toolkit. Its purpose is to simplify distributed systems development.
Go Micro abstracts way the details of distributed systems. Here are the main features:
  - Service Discovery - Applications are automatically registered with service discovery so they can find each other.
  - Load Balancing - Smart client side load balancing is used to balance requests between instances of a service.
  - Synchronous Communication - Request-response is provided as a bidirectional streaming transport layer.
  - Asynchronous Communication - Microservices should promote an event driven architecture. Publish and Subscribe semantics are built in.
  - Message Encoding - Micro services can encode requests in a number of encoding formats and seamlessly decode based on the Content-Type header.
  - RPC Client/Server - The client and server leverage the above features and provide a clean simple interface for building microservices.
- **Micro DOC**  
[Micro - a microservices toolkit](https://micro.mu/blog/2016/03/20/micro.html)  
[Micro - Past, Present and Future](https://micro.mu/blog/2016/12/28/micro-past-present-future.html)  


### Go kit

- **[Go kit (License: MIT)](https://gokit.io/)**  
[Go kit - github](https://github.com/go-kit/kit)  
Go kit is a distributed programming toolkit for building microservices in large organizations. We solve common problems in distributed systems, so you can focus on your business logic.




### Memberlist

- **[memberlist - Golang package for gossip based membership and failure detection (License: MPL-2.0)](https://github.com/hashicorp/memberlist)**  
memberlist is a Go library that manages cluster membership and member failure detection using a gossip based protocol. The use cases for such a library are far-reaching: all distributed systems require membership, and memberlist is a re-usable solution to managing cluster membership and node failure detection. memberlist is eventually consistent but converges quickly on average. The speed at which it converges can be heavily tuned via various knobs on the protocol. Node failures are detected and network partitions are partially tolerated by attempting to communicate to potentially dead nodes through multiple routes.



### Kite

- **[Kite - Micro-service framework in Go](https://github.com/koding/kite)**  
[Kite - Micro-service framewor - github](https://godoc.org/github.com/koding/kite)  
Kite is both the name of the framework and the micro-service that is written by using this framework. Basically, Kite is a RPC server as well as a client. It connects to other kites and peers to communicate with each other. They can discover other kites using a service called Kontrol, and communicate with them bidirectionaly. The communication protocol uses a WebSocket (or XHR) as transport in order to allow web applications to connect directly to kites.
Kites can talk with each other by sending dnode messages over a socket session. If the client knows the URL of the server kite it can connect to it directly. If the URL is not known, client can ask for it from Kontrol (Service Discovery).

- **Kite DOC**  
[2015 - Kite A Go Library for Writing Distributed Microservices](https://www.koding.com/blog/2015/01/flying-kites-in-go/)  
[2014 - Kite: Library for writing distributed microservices](https://blog.gopheracademy.com/birthday-bash-2014/kite-microservice-library/)


### Bhive

- **[beehive](https://github.com/kandoo/beehive)**  
Distributed Programming Framework in GoLang
