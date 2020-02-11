#!/bin/bash

# Get the employees db
wget https://launchpad.net/test-db/employees-db-1/1.0.6/+download/employees_db-full-1.0.6.tar.bz2
bzip2 -dfv employees_db-full-1.0.6.tar.bz2
tar -xf employees_db-full-1.0.6.tar

# push the employees db to the mysql pod
ls -l
cd employees_db
mysql -h mysql -uroot -pthisisnotsecure -t < employees.sql

# Start loadtesting
mysqlslap --user=root --password --host=mysql  --auto-generate-sql --verbose
sleep 3600

