# YXBwbHkta21vbmc-

**K\*o\*g** 제출 과제를 위한 저장소 입니다.

해당 어플리케이션은 다음과 같은 환경에서 개발 되었습니다.

## Environments

- **Application**
    - Laravel Framework 8.6.x
    - PHP Version 8.0.14
- **Docker Image**
    - php:8.0-fpm
    - mariadb:latest (Distrib 10.6.5-MariaDB)
    - nginx:latest

## Setup Docker

### 1. Build Image

로컬개발환경을 세팅하기 위서 해당 저장소를 복제하고, 아래 명령어를 통해 이미지를 빌드합니다.

```bash
$ docker-compose build
```

### 2. Running Image

빌드된 이미지를 아래의 명령어를 통해서 실행합니다. 백그라운드로 실행시키고자 하는 경우에는 `-d` 옵션을 추가하여 실행 시켜줍니다.

```bash
$ docker-compose up [-d]
```

✔️ 도커 이미지들이 실행되면, `$ docker-compose ps` 명령어를 통해 다음과 같은 화면을 확인할 수 있습니다.

```
NAME                COMMAND                  SERVICE             STATUS              PORTS
kmong-app           "docker-php-entrypoi…"   app                 running             9000/tcp
kmong-mariadb       "docker-entrypoint.s…"   db                  running             0.0.0.0:3307->3306/tcp
kmong-nginx         "/docker-entrypoint.…"   nginx               running             0.0.0.0:8080->8080/tcp
```

✔️ `PORTS` 매핑이 범용 서비스 포트와 다름의 주의하여야 합니다. 개발환경의 충돌을 피하고자 범용 포트와 다르게 설정 되었습니다.

| Service | Local Port | Image Port |
| ------- | ---------- | ---------- |
| MariaDB | 3307 | 3306 |
| Nginx | 8080 | 8080 |
