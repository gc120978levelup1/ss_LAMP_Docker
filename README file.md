# [DOCKER](https://docs.docker.com/get-started/get-docker/) LAMP STACK for Laravel Development
a simple DOCKER Full Stack LAMP server for Laravel Development  

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) + [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur).

## Pre-requisite (WSL2)
* Docker + WSL2 + Git + Composer + Laravel + Nodejs (+ Vue)
* Make A New Laravel project and wait until its totally done
* Copy and Paste All this fileS (DOCKER Full Stack LAMP server) to the newly created Laravel project
* Open .env file and change the DB_DATABASE value as per liking
* Open ss file and change the value of database_name as per above DB_DATABASE value

## Set All the Docker Services Names to point to 127.0.0.1 Hostname (WSL2)
All this Host Names can be found in docker-compose.yml file

```sh
sudo nano /mnt/c/windows/system32/drivers/etc/hosts
# add the following items at the bottom of the list ans save
127.0.0.1 database.jaed.com
127.0.0.1 www.jaed.com
127.0.0.1 phpmyadmin.jaed.com
```

### Check Containers Status in (Git Bash Terminal)

```sh
./ss check
```

## Launch Containers in  (Git Bash Terminal) (node + composer)

```sh
./ss up
```

### Launch Initial Data Migration in  (Git Bash Terminal)

```sh
./ss migration
```

### Now Your Project (Production) is ONLINE!!!!
using your browser, visit the www address as per specified in the service (docker-compose.yml file)
ex. www.jaed.com

### Run The Development Mode to Edit Things  (Git Bash Terminal)

```sh
,/ss dev
```

### Shut Down Container in  (Git Bash Terminal)

```sh
./ss down
```


### Shut Down Container in  (Git Bash Terminal)

    =============================================================
      Usage: $0 check     - Check the status of the containers
             $0 up        - Start the Garry's Mod server
             $0 down      - Stop the Garry's Mod server
             $0 migrate   - Execute database migration
             $0 dev       - Launch the development server
             $0 bkup      - Backup the database
             $0 visit-db  - Visit the database container
             $0 visit-www - Visit the web server container
             $0 help      - Show this help message
             $0 -h        - Show this help message