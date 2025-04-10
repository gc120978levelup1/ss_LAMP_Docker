# [DOCKER](https://docs.docker.com/get-started/get-docker/) LAMP STACK for Laravel Development
a simple DOCKER Full Stack LAMP server for Laravel Development  

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) + [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur).

## Pre-requisite (WSL2)
* Docker + WSL2 + Git + Composer + Laravel + Nodejs (+ Vue)
* Make sure DOCKER is running when executing the command lines below
* Make A New Laravel project and wait until its totally done
* Copy and Paste All this fileS (DOCKER Full Stack LAMP server) to the newly created Laravel project
* Open .env file and change the DB_DATABASE value as per liking
* Open ss file and change the value of database_name as per above DB_DATABASE value

## Set All the Docker Services Names to point to 127.0.0.1 Hostname (use WSL2 terminal)
All this Host Names can be found in docker-compose.yml file

```sh
sudo nano /mnt/c/windows/system32/drivers/etc/hosts
# add the following items at the bottom of the list ans save
127.0.0.1 database.jaed.com
127.0.0.1 www.jaed.com
127.0.0.1 phpmyadmin.jaed.com
```

### (use Git Bash Terminal) Download this ss_LAMP_DOCKER folder INSIDE YOUR PROJEECT and wait until done downloading (use Git Bash Terminal)

```sh
git clone --recursive https://github.com/gc120978levelup1/ss_LAMP_Docker.git
```

### Go inside this ss_LAMP_DOCKER folder (Git Bash Terminal)

```sh
cd ss_LAMP_DOCKER
```

### Merge to main file (Git Bash Terminal)

```sh
./ss merge
```

### Come out of ss_LAMP_DOCKER folder (Git Bash Terminal)

```sh
cd ..
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
./ss dev
```

### Shut Down Container in  (Git Bash Terminal)

```sh
./ss down
```

### Shut Down Container in  (Git Bash Terminal)

    =====================================================================
      Usage: ./ss check     - Check the status of the containers
             ./ss merge     - Merge this ss_DOCKER_LAMP to main project
             ./ss up        - Start the Garry's Mod server
             ./ss down      - Stop the Garry's Mod server
             ./ss migrate   - Execute database migration
             ./ss dev       - Launch the development server
             ./ss bkup      - Backup the database
             ./ss visit-db  - Visit the database container
             ./ss visit-www - Visit the web server container
             ./ss help      - Show this help message
             ./ss -h        - Show this help message