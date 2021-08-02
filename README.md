


## build docker image

- ** run docker build docker-config/. -t orcas/php-nginx **
- ** docker-compose up -d  **



## how to run 

- composer install 
- cp .env.example .env with replace database block to the below 

    ```
        DB_CONNECTION=mysql
        DB_HOST=orcas-mysql-db
        DB_PORT=3306
        DB_DATABASE=orcas_task
        DB_USERNAME=root
        DB_PASSWORD=12341234

    ```

- run php artisan key:generate
- run php artisan jwt:secret
- replace redis block to the below 
    ```
        REDIS_HOST=orcas-queue-redis
        REDIS_PASSWORD=null
        REDIS_PORT=6379
    ```

## database migration 

- run ``` docker exec -it orcas-task bash ``` to access task container 
    - cd /var/www/
    - run php artisan migrate 

## note
to access project api by ```localhost:8086```
to access database by  
```
host:127.0.0.1
port : 1790
user : root
password : 12341234
```


