### TEORETICKE INFORMACIE O DISTRIBUOVANYCH SYSTEMOCH

- [Distributed systems theory for the distributed systems engineer (****)](http://the-paper-trail.org/blog/distributed-systems-theory-for-the-distributed-systems-engineer/)

- [Distributed systems for fun and profit - KNIHA od Mikito Takada (Rychly prehlad klucovych tem ohladom distribuovanych systemov) (****)](http://book.mixu.net/distsys/index.html)
<br>
“Distributed programming is the art of solving the same problem that you can solve on a single computer using multiple computers.”

- [Kyle Kingsbury (Aphyr - Jepsen seria) - An introduction to distributed systems (****)](https://github.com/aphyr/distsys-class)
<br>
This outline accompanies a 12-16 hour overview class on distributed systems fundamentals. The course aims to introduce software engineers to the practical basics of distributed systems, through lecture and discussion. Participants will gain an intuitive understanding of key distributed systems terms, an overview of the algorithmic landscape, and explore production concerns.

- [Principles of Distributed Computing (lecture collection) (****)](http://disco.ethz.ch/lectures/podc_allstars/)
<br>
Distributed computing is essential in modern computing and communications systems. Examples are on the one hand large-scale networks such as the Internet, and on the other hand multiprocessors such as your new multi-core laptop. The lecture notes on this webpage introduce the principles of distributed computing, emphasizing the fundamental issues underlying the design of distributed systems and networks: communication, coordination, fault-tolerance, locality, parallelism, self-organization, symmetry breaking, synchronization, uncertainty. We explore essential algorithmic ideas and lower bound techniques, basically the "pearls" of distributed computing. Each chapter covers a fresh topic. 

- [2013 - Notes on Distributed Systems for Young Bloods](https://www.somethingsimilar.com/2013/01/14/notes-on-distributed-systems-for-young-bloods/)
<br>
Below is a list of some lessons I’ve learned as a distributed systems engineer that are worth being told to a new engineer. Some are subtle, and some are surprising, but none are controversial. This list is for the new distributed systems engineer to guide their thinking about the field they are taking on. It’s not comprehensive, but it’s a good beginning.


### ZAKLADNE TERMINY A PRIBUZNE OBLASTI


- [ACID (Atomicity, Consistency, Isolation, Durability) vlastnosti](http://www.service-architecture.com/articles/database/acid_properties.html)

- [Strong consistency models (***)](https://aphyr.com/posts/313-strong-consistency-models)
<br>
Network partitions are going to happen. Switches, NICs, host hardware, operating systems, disks, virtualization layers, and language runtimes, not to mention program semantics themselves, all conspire to delay, drop, duplicate, or reorder our messages. In an uncertain world, we want our software to maintain some sense of intuitive correctness.
Well, obviously we want intuitive correctness. Do The Right Thing™! But what exactly is the right thing? How might we describe it? In this essay, we’ll take a tour of some “strong” consistency models, and see how they fit together.

- [2015 - Please stop calling databases CP or AP](https://martin.kleppmann.com/2015/05/11/please-stop-calling-databases-cp-or-ap.html)

- [2004 - Eric Brewer - Towards Robust Towards Robust Distributed Systems](https://www.cs.berkeley.edu/~brewer/cs262b-2004/PODC-keynote.pdf)
<br>
Prva prednaska o CAP teoreme od jeho tvorcu (Eric Brewer).

- [2012 - Eric Brewer - CAP Twelve Years Later: How the "Rules" Have Changed](https://www.infoq.com/articles/cap-twelve-years-later-how-the-rules-have-changed)

- [2015 - Google systems guru explains why containers are the future of computing](https://medium.com/s-c-a-l-e/google-systems-guru-explains-why-containers-are-the-future-of-computing-87922af2cf95#.hwoumfy6x)
<br>
Zaujimave interview s otcom CAP teoremu (Eric Brewer).


### TESTY KOREKTNOSTI DISTRIBUOVANYCH SYSTEMOV

- [Jepsen series on distributed systems correctnes by Aphyr (Kyle Kingsbury) (*****)](https://aphyr.com/tags/Jepsen)
<br>
Aphyr, or Kyle Kingsbury, is a computer safety researcher working as an independent consultant.

- [JEPSEN (Kyle Kingsburry) - Distributed Systems Safety Analysis (*****)](http://jepsen.io/)
<br>
Jepsen is an effort to improve the safety of distributed databases, queues, consensus systems, etc. It encompasses a software library for systems testing, as well as blog posts, and conference talks exploring particular systems’ failure modes. In each post we explore whether the system lives up to its documentation’s claims, file new bugs, and suggest recommendations for operators.

- [2013 - Survey on consistency conditions](http://www.ics.forth.gr/tech-reports/2013/2013.TR439_Survey_on_Consistency_Conditions.pdf)

- [2016 - A Critical Comparison of NOSQL Databases in the Context of Acid and Base](http://repository.stcloudstate.edu/cgi/viewcontent.cgi?article=1006&context=msia_etds)

- [Jepsen - Elasticsearch 1.1.0](https://aphyr.com/posts/317-jepsen-elasticsearch)

- [Jepsen - Elasticsearch 1.5](https://aphyr.com/posts/323-jepsen-elasticsearch-1-5-0)

- [Elasticsearch Resiliency Status - vsetky neduhy Elasticsearch v zmysle jeho odolnosti na rozne vypadky](https://www.elastic.co/guide/en/elasticsearch/resiliency/current/index.html)


### DALSIE ZDROJE INFORMACII 

- [awesome-distributed-systems](https://github.com/theanalyst/awesome-distributed-systems)
<br>
A (hopefully) curated list on awesome material on distributed systems, inspired by other awesome frameworks like awesome-python. Most links will tend to be readings on architecture itself rather than code itself.

- [awesome-distributed-systems](https://github.com/kevinxhuang/awesome-distributed-systems)
<br>
A curated list of awesome distributed systems books, papers, resources and shiny things.


### CHAOS ENGINEERING

- [2000 - How Complex Systems Fail ](http://web.mit.edu/2.75/resources/random/How%20Complex%20Systems%20Fail.pdf)

- [2014 - Chaos Engineering 101](https://medium.com/production-ready/chaos-engineering-101-1103059fae44#.23fy5d6b2)

- [2014 - Chaos Engineering: A Shift in Mindset](https://medium.com/production-ready/chaos-engineering-a-shift-in-mindset-d8fbfc8c5dc2#.8uv04vix5)

- [2016 - How Complex Web Systems Fail — Part 1](https://medium.com/production-ready/how-complex-web-systems-fail-part-1-4aaffc11e0c7#.xyl56jl27)

- [2016 - How Complex Web Systems Fail — Part 2](https://medium.com/production-ready/how-complex-web-systems-fail-part-2-1b1afb4fa7be#.aiq0xwtpp)
