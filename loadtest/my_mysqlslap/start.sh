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
mysqlslap --no-defaults --user=root --password=thisisnotsecure --host=mysql --concurrency=5 --iterations=10 --create-schema=employees --query="SELECT * FROM dept_emp;" --verbose
