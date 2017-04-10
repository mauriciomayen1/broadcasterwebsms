#!/bin/sh


sleep 40

mysql -u comex -h 172.16.27.16  -pcomex123 proyectemail <<QUERY_INPUT

load data local infile '/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms/motherbase.csv' into table motherbase
fields terminated by ','
lines terminated by '\n'
IGNORE 1 LINES
(msisdn,operador);
QUERY_INPUT
