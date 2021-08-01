


## build docker image

- ** run docker build docker-config/. -t orcas/php-nginx **
- ** docker-compose up -d  **



## how to run 

- composer install 
- cp .env.example .env
- add DB_HOST "orcas-mysql-db"
- add DB_USERNAME "root"
- add DB_PASSWORD "12341234"
- add DB_DATABASE "orcas-task-db" then migrate db
- add REDIS_HOST "queue-redis" 
- change QUEUE_CONNECTION "redis" 
- you can access project api by use "localhost:8086"

## database connection 

- connect to database remotlly by use port 1590 - username root - password 12341234
- create database "orcas-task-db"