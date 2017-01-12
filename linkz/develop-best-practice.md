### ZAKLADNE PRINCIPY


- [The Twelve-Factor App](http://12factor.net/)
<br>
In the modern era, software is commonly delivered as a service: called web apps, or software-as-a-service. The twelve-factor app is a methodology for building software-as-a-service apps that:
 - Use declarative formats for setup automation, to minimize time and cost for new developers joining the project;
 - Have a clean contract with the underlying operating system, offering maximum portability between execution environments;
 - Are suitable for deployment on modern cloud platforms, obviating the need for servers and systems administration;
 - Minimize divergence between development and production, enabling continuous deployment for maximum agility;
 - And can scale up without significant changes to tooling, architecture, or development practices.
<br><br>
The twelve-factor methodology can be applied to apps written in any programming language, and which use any combination of backing services (database, queue, memory cache, etc).
<br><br>


- [The C10K problem](http://www.kegel.com/c10k.html)
<br>
It's time for web servers to handle ten thousand clients simultaneously, don't you think? After all, the web is a big place now.
And computers are big, too. You can buy a 1000MHz machine with 2 gigabytes of RAM and an 1000Mbit/sec Ethernet card for $1200 or so. Let's see - at 20000 clients, that's 50KHz, 100Kbytes, and 50Kbits/sec per client. It shouldn't take any more horsepower than that to take four kilobytes from the disk and send them to the network once a second for each of twenty thousand clients. (That works out to $0.08 per client, by the way. Those $100/client licensing fees some operating systems charge are starting to look a little heavy!) So hardware is no longer the bottleneck.
