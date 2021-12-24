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
    - redis:latest (6.2.6)
      - Session Storage

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
kmong-redis         "docker-entrypoint.s…"   redis               running             0.0.0.0:6382->6379/tcp
```

✔️ `PORTS` 매핑이 범용 서비스 포트와 다름의 주의하여야 합니다. 개발환경의 충돌을 피하고자 범용 포트와 다르게 설정 되었습니다.

| Service | Local Port | Image Port |
| ------- | ---------- | ---------- |
| MariaDB | 3307 | 3306 |
| Nginx | 8080 | 8080 |
| Redis | 6382 | 6379 |

## Setup Laravel

### 1. Install Dependencies with Composer

라라벨 실행환경에 필요한 의존성 라이브러리들을 설치하기 위해 `kmong-app` 이미지에 접속합니다.

```bash
$ docker exec -it kmong-app bash
```

`kmong-app` 안에서 다음 경로로 이동 후 **composer**를 통해 의존성을 해결(설치)합니다.

```bash
$ cd /var/www/ && composer install
```

‼️ 일반적인 개발 환경에서 `.env` 파일은 민감한 내용을 포함하고 있어 커밋 내역에 같이 포함되지 않으나, 해당 프로젝트에서는 원활한 테스트 진행을 위해 포함 되었습니다.

### 2. Migrations

로컬 DB에 테이블을 마이그레이션 하기 위해 다음 명령어를 실행합니다. (경로: `/var/www/`)

```bash
$ php artisan migrate
```

또 한, 기본적인 테스트를 위한 더미 데이터를 생성하기 위해 다음의 명령어를 실행합니다.

```bash
$ php artisan db:seed --class=ProductSeeder
```

### 3. Check it out

**로컬 머신**에서 `http://localhost:8080` 페이지에 접속하여 라라벨 프레임워크의 기본 화면이 정상적으로 출력되는지 확인합니다.

정상적으로 페이지 출력이 확인되면, **API 명세** 확인 후 API를 호출 테스트 진행 또는 아래의 공유된 **Postman** 링크를 클릭하여 쉽게 테스트를 진행해 볼 수 있습니다.

https://www.getpostman.com/collections/de66705eef32bc7c8892

## API Spec

모든 API의 용청 및 응답 데이터의 타입은 `application/json` 이며 기본적인 응답 스펙 또한 동일합니다. 항상 `status` 키 값으로 응답의 성공 유무를 판단할 수 있습니다.

### 회원가입

회원 멤버 계정을 생성합니다.

**Request and Bodies**

🔎 `POST /api/member`

```json
{
    "email": [string],
    "password": [string],
    "display_name": [string]
}
```

**Response**

```json
{
    "status": [bool],
    "message": [string]
}
```

### 로그인 및 로그아웃

`stateless`로 상태관리는 하는 라라벨 프레임워크의 `api` 특성상 로그인 및 로그아웃 처리는 `stateful` 상태 관리가 되어야 하며, 일반적인 API 호출 URI와는 다르게 `api` prefix가 붙지 않습니다.

기본적은 응답 포맷은 동일합니다.

**Request and Bodies**

🔎 `POST /member/login`

🔎 `POST /member/logout`

로그아웃 호출의 경우 Body 값을 포함하지 않습니다.

```json
{
    "email": [string],
    "password": [string]
}
```

**Response**

```json
{
    "status": [bool],
    "message": [string]
}
```

### 상품정보 조회하기

상품번호의 해당하는 상품 정보를 가져옵니다.

**Request**

🔎 `GET /api/shop/item/{id:integer}`

**Response**

```json
{
    "status": [bool],
    "items": {
        "id": [integer],
        "goodsname": [string],
        "price": [integer],
        "display": [integer],
        "created_at": [string],
        "updated_at": [string|nullable],
        "deleted_at": [string|nullable]
    }
}
```

| key | description |
| --- | ----------- |
| items.display | `1` \| `0` \(`1` = displayed\) |

### 상품 주문

상품 주문 API 또한 `stateful` 상태를 유지해야 합니다.

**Request and Bodies**

🔎 `POST /shop/order`

```json
{
    "product_id": [integer]
}
```

| key | description |
| --- | ----------- |
| product_id | 주문하려는 상품 번호 |

**Response**

```json
{
    "status": [bool],
    "messages": [string]
}
```

### 상품 주문 내역

현재 세션에 조회할 수 있는 주문 내역을 가져옵니다.

**Request**

🔎 `GET /shop/orders`

**Response**

```json
{
    "status": true,
    "items": [
        ProductOrderSpec,
        ...
    ]
}
```

**ProductOrderSpec**

```json
{
    "id": [integer],
    "member_id": [integer],
    "goods_id": [integer],
    "status": 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7,
    "created_at": [string],
    "updated_at": [string|nullable],
    "deleted_at": [string|nullable],
    "status_translated": [string],
    "product_info": {
        "id": [integer],
        "goodsname": [string],
        "price": [integer],
        "display": [integer],
        "created_at": [string],
        "updated_at": [string|nullable],
        "deleted_at": [string|nullable]
    }
}
```

`ProductOrderSpec`의 `status` 값이 갖는 의미는 아래 코드를 참고하시기 바랍니다.

```php
/**
 * 주문 상태 정보
 *
 * 주문요청: 0
 * 입금대기: 1
 * 입금확인: 2
 * 판매자 확인: 3
 * 배송준비중 (작업중): 4
 * 배송완료: 5
 * 환불요청: 6
 * 환불거절: 7
 */
const STATUS_ORDER_REQUEST = 0;
const STATUS_INCOME_READY = 1;
const STATUS_INCOME_COMPLETE = 2;
const STATUS_SELLER_CHECKED = 3;
const STATUS_SELLER_PACKAGING = 4;
const STATUS_SELLER_DELIVERIED = 5;
const STATUS_CLIENT_REFUND_REQUEST = 6;
const STATUS_SELLER_REJECT_REFUND = 7;
```

**Example**
```json
{
    "status": true,
    "items": [
        {
            "id": 1,
            "member_id": 1,
            "goods_id": 1,
            "status": 0,
            "created_at": "2021-12-23T06:39:21.000000Z",
            "updated_at": "2021-12-23T06:39:21.000000Z",
            "deleted_at": null,
            "status_translated": "주문 요청",
            "product_info": {
                "id": 1,
                "goodsname": "테스트상품",
                "price": 10000,
                "display": 1,
                "created_at": "2021-12-23T15:19:23.000000Z",
                "updated_at": "2021-12-23T15:19:25.000000Z",
                "deleted_at": null
            }
        },
        {
            "id": 2,
            "member_id": 1,
            "goods_id": 1,
            "status": 0,
            "created_at": "2021-12-23T06:39:32.000000Z",
            "updated_at": "2021-12-23T06:39:32.000000Z",
            "deleted_at": null,
            "status_translated": "주문 요청",
            "product_info": {
                "id": 1,
                "goodsname": "테스트상품",
                "price": 10000,
                "display": 1,
                "created_at": "2021-12-23T15:19:23.000000Z",
                "updated_at": "2021-12-23T15:19:25.000000Z",
                "deleted_at": null
            }
        }
    ]
}
```

