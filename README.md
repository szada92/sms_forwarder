# sms_forwarder
SMS forwarder plugin for Kalkun

## Usage

tl;dr: mount / copy this folder to Kalkun plugins folder.

### docker usage

Recommended (and currently, on 2024-07-01, the most straightforwardly working) repository: https://github.com/pjunyent/kalkun-dockerfile 

Mount this plugin as:

docker run:
```
- v ~/sms_forwarder/application/plugins/sms_forwarder:/var/www/application/plugins/sms_forwarder
```

docker-compose:
```
  volumes:
    - ~/sms_forwarder/application/plugins/sms_forwarder:/var/www/application/plugins/sms_forwarder
```

### Example docker compose file

Recommended to modify these sample environment values
```
services:
  kalkun:
    container_name: kalkun
    image: junyent/kalkun-gammu:latest
    build:
      context: ./
      dockerfile: kalkun-gammu.dockerfile
    restart: unless-stopped
    network_mode: host
    devices:
      - /dev/ttyUSB0:/dev/ttyUSB0
    volumes:
      - /sys/fs/cgroup:/sys/fs/cgroup
    environment:
      - TZ=Etc/UTC
    depends_on:
      - "kalkun-db"

  kalkun-db:
    container_name: kalkun-db
    image: junyent/kalkun-mariadb:latest
    build:
      context: ./
      dockerfile: kalkun-mariadb.dockerfile
    restart: unless-stopped
    ports:
      - "3306:3306"
    environment:
      MYSQL_RANDOM_ROOT_PASSWORD: kalkun 
      MYSQL_DATABASE: kalkun 
      MYSQL_USER: kalkun 
      MYSQL_PASSWORD: kalkun 
    volumes:
      - ./data/mysql:/var/lib/mysql:Z 
```
