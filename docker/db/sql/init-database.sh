#wait for the MySQL Server to come up
#sleep 90s

#run the setup script to create the DB and the schema in the DB
mysql -u docker -pdocker docker < "/docker-entrypoint-initdb.d/001-create-table.sql"
mysql -u docker -pdocker docker < "/docker-entrypoint-initdb.d/002-insert-data-sample.sql"
