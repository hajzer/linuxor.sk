


## Time-Series Monitoring Systems - Informácie

- [2016 - Top10 Time Series Databases (****)](https://blog.dataloop.io/top10-open-source-time-series-databases)  
Porovnanie 10 Time-Series databaz (DalmatinerDB, InfluxDB, Prometheus, Riak TS, OpenTSDB, KairosDB, Elasticsearch, Druid, Blueflood, Graphite (Whisper)).

- [Open Source Time Series DB Comparison (****)](https://docs.google.com/spreadsheets/d/1sMQe9oOKhMhIVw9WmuCEWdPtAoccJ4a-IuZv4fXDHxM/pubhtml)



## Time-Series Monitoring Systems - Technológie


## Prometheus

**[Prometheus (License: Apache-2.0)](https://prometheus.io/)**    
[Prometheus - github](https://github.com/prometheus/prometheus)  
[Prometheus - Exporters](https://prometheus.io/docs/instrumenting/exporters/)  
[Prometheus - Clients](https://prometheus.io/docs/instrumenting/clientlibs/)  
Prometheus, a Cloud Native Computing Foundation project, is a systems and service monitoring system. It collects metrics from configured targets at given intervals, evaluates rule expressions, displays the results, and can trigger alerts if some condition is observed to be true.

Prometheus' main distinguishing features as compared to other monitoring systems are:  
- a multi-dimensional data model (timeseries defined by metric name and set of key/value dimensions)  
- a flexible query language to leverage this dimensionality  
- no dependency on distributed storage; single server nodes are autonomous  
- timeseries collection happens via a pull model over HTTP  
- pushing timeseries is supported via an intermediary gateway  
- targets are discovered via service discovery or static configuration  
- multiple modes of graphing and dashboarding support  
- support for hierarchical and horizontal federation      

**Prometheus - DOC**  
[Prometheus - Documentation](https://prometheus.io/docs/)  
[Prometheus - COMPARISON TO ALTERNATIVES](https://prometheus.io/docs/introduction/comparison/)  
[Prometheus - Presentations, Tutorials](https://prometheus.io/docs/introduction/media/)


## OpenTSDB Time-Series Monitoring Stack

**[OpenTSDB - The Scalable Time Series Database (License: GPL-3.0)](http://opentsdb.net/)**  
[OpenTSDB - github](https://github.com/OpenTSDB/opentsdb)  
[OpenTSDB - resources](http://opentsdb.net/docs/build/html/resources.html)  
Store and serve massive amounts of time series data without losing granularity.
OpenTSDB consists of a Time Series Daemon (TSD) as well as set of command line utilities. Interaction with OpenTSDB is primarily achieved by running one or more of the TSDs. Each TSD is independent. There is no master, no shared state so you can run as many TSDs as required to handle any load you throw at it. Each TSD uses the open source database HBase to store and retrieve time-series data. The HBase schema is highly optimized for fast aggregations of similar time series to minimize storage space. Users of the TSD never need to access HBase directly. You can communicate with the TSD via a simple telnet-style protocol, an HTTP API or a simple built-in GUI. All communications happen on the same port (the TSD figures out the protocol of the client by looking at the first few bytes it receives).

**[TCollector (License: GPL-3.0)](http://opentsdb.net/docs/build/html/user_guide/utilities/tcollector.html)**  
tcollector is a client-side process that gathers data from local collectors and pushes the data to OpenTSDB. You run it on all your hosts, and it does the work of sending each host's data to the TSD. OpenTSDB is designed to make it easy to collect and write data to it. It has a simple protocol, simple enough for even a shell script to start sending data. However, to do so reliably and consistently is a bit harder. What do you do when your TSD server is down? How do you make sure your collectors stay running? This is where tcollector comes in.

**[SCollector](http://bosun.org/scollector/)**  
[scollector - Documentation](https://godoc.org/bosun.org/cmd/scollector)  
scollector is a replacement for OpenTSDB's TCollector and can be used to send metrics to a Bosun server.
Benefits of scollector over TCollector:  
- scollector uses the HTTP based API, not the older Telnet based API  
- scollector is written in Go and is more resource efficient  
- scollector integrates with Bosun's metadata (Units, Gauge/Counter, Description) and allows external collectors to also use metadata  


## Bosun

**[Bosun (License: MIT)](http://bosun.org/)**  
[Bosun - github](https://github.com/bosun-monitor/bosun)  
is an open-source, MIT licensed, monitoring and alerting system by Stack Exchange. It has an expressive domain specific language for evaluating alerts and creating detailed notifications. It also lets you test your alerts against history for a faster development experience.

**Bosun - DOC**  
[2016 - STACK OVERFLOW'S BOSUN ARCHITECTURE](http://kbrandt.com/post/bosun_arch/)  
Poznamka: Kyle Brandt je autorom systemu Bosun a momentalne pracuje pre Stack Overflow.  

[Kyle Brandt - TALKS](http://kbrandt.com/page/talks/)
[2015 - Installing Bosun for production](https://medvedev.io/blog/posts/2015-06-21-bosun-install-1.html)



## InfluxData Time-Series Monitoring Stack

**[InfluxData - Telegram - TIME-SERIES DATA COLLECTION (License: MIT)](https://www.influxdata.com/time-series-platform/telegraf/)**  
[Telegram - github](https://github.com/influxdata/telegraf)  
[Telegram - Input plugins](https://docs.influxdata.com/telegraf/v1.2/inputs/)  
[Telegram - Output plugins](https://docs.influxdata.com/telegraf/v1.2/outputs/)  
Telegraf is a light-weight, non-license collector for gathering metrics from some of the most popular systems, apps, and services like Docker, RDBS, NoSQL, SNMP and more. The extensible architecture means you can build your own integrations putting no limits on the kind of metrics you want to collect.

**[InfluxData - InfluxDB - TIME-SERIES DATA STORAGE (License: MIT)](https://www.influxdata.com/time-series-platform/influxdb/)**  
[InfluxDB - github](https://github.com/influxdata/influxdb)    
InfluxDB is an open source database written in Go specifically to handle time series data with high availability and high performance requirements. InfluxDB installs in minutes without external dependencies, yet is flexible and scalable enough for complex deployments.

**[InfluxData - Chronograf - TIME-SERIES DATA VISUALIZATION (License: AGPL-3.0)](https://www.influxdata.com/time-series-platform/chronograf/)**  
[Chronograf - github](https://github.com/influxdata/chronograf)  
Chronograf is a simple to install graphing and visualization application that you deploy behind your firewall to perform ad hoc exploration of your InfluxDB data, It includes support for templates and a library of intelligent, pre-configured dashboards for common data sets.

**[InfluxData - Kapacitor - IME SERIES DATA PROCESSING, MONITORING, & ALERTING (License: MIT)](https://www.influxdata.com/time-series-platform/kapacitor/)**  
[Kapacitor - github](https://github.com/influxdata/kapacitor)    
Kapacitor is InfluxDB's native data processing engine. It can process both stream and batch data from InfluxDB. Kapacitor lets you plug in your own custom logic or user defined functions to process alerts with dynamic thresholds, match metrics for patterns or compute statistical anomalies.

**Influx - DOC**  
[2016 - influxdb-comparisons](https://github.com/dalmatinerdb/influxdb-comparisons)  
This repo contains code for benchmarking InfluxDB against other databases and time series solutions.


[2016 - Benchmarking InfluxDB vs MongoDB for Time-Series Data, Metrics and Management](https://www.influxdata.com/technical-papers/benchmarking-influxdb-vs-mongodb-for-time-series-data-metrics-and-management/)  
[https://www.influxdata.com/wp-content/uploads/2016/05/InfluxDB-vs-MongoDB-Sept82016.pdf](https://www.influxdata.com/wp-content/uploads/2016/05/InfluxDB-vs-MongoDB-Sept82016.pdf)

[2016 - Benchmarking InfluxDB vs Cassandra for Time-Series Data, Metrics and Management](https://www.influxdata.com/technical-papers/benchmarking-influxdb-vs-cassandra-for-time-series-data-metrics-and-management/)  
[https://www.influxdata.com/wp-content/uploads/2016/05/InfluxDB-vs-Cassandra-Sept82016.pdf](https://www.influxdata.com/wp-content/uploads/2016/05/InfluxDB-vs-Cassandra-Sept82016.pdf)

[2016 - Benchmarking InfluxDB vs Elasticsearch for Time-Series](https://www.influxdata.com/technical-papers/benchmarking-influxdb-vs-elasticsearch-for-time-series-2/)  
[https://www.influxdata.com/wp-content/uploads/2016/05/InfluxDB-vs-Elastic-Sept82016.pdf](https://www.influxdata.com/wp-content/uploads/2016/05/InfluxDB-vs-Elastic-Sept82016.pdf)

[2016 - Benchmarking InfluxDB vs OpenTSDB for Time-Series Data, Metrics and Management](https://www.influxdata.com/technical-papers/benchmarking-influxdb-vs-opentsdb-for-time-series-data-metrics-and-management/)  
[https://www.influxdata.com/wp-content/uploads/2016/11/InfluxDBvs.OpenTSDB_11172016.pdf](https://www.influxdata.com/wp-content/uploads/2016/11/InfluxDBvs.OpenTSDB_11172016.pdf)


## Argus

**[Argus - Time series monitoring and alerting platform (License: BSD-3-Clause)](https://github.com/salesforce/Argus)**  
Argus is a time-series monitoring and alerting platform. It consists of discrete services to configure alerts, ingest and transform metrics & events, send 
notifications, create namespaces, and to both establish and enforce policies and quotas for usage. Its architecture allows any and all of these services to be retargeted to new technology as it becomes available, with little to no impact on the users.
> Poznamka: Jadro je postavene nad OpenTSDB a Apache HBase.

**Argus - DOC**  
[Argus WIKI](https://github.com/salesforce/Argus/wiki)  
[2016 - Argus: Time-Series Monitoring and Alerting](https://medium.com/salesforce-open-source/argus-time-series-monitoring-and-alerting-d2941f67864#.68r4hss9n)


## DalmatinerDB

**[DalmatinerDB - A fast, distributed metric store (License: MIT)](https://dalmatiner.io/)**   
DalmatinerDB is a metric database written in pure Erlang. It takes advantage of some special properties of metrics to make some tradeoffs. The goal is to make a store for metric data (time, value of a metric) that is fast, has a low overhead, and is easy to query and manage. DalmatinerDB is a no fluff purpose built metric database. Not a layer put on top of a general purpose database or datastore.

This allows features that otherwise wouldn't be possible:  
- a highly optimized network protocol  
- sequential reads/writes for metrics  
- and a client-server model that takes as much load from the actual store as possible

**DalmatinerDB - DOC**  
[DalmatinerDB - Documentation](https://dalmatiner.readme.io/docs)




