# Test B : Application

### Deploy

-   Laravel 10 : PHP8.1 NPM 8.18
-   git clone
-   composer install
-   npm install
-   npm run build
-   cp .env.example .env => update db connect
-   php artisan key:gen
-   php artisan migrate
-   php artisan db:seed
-   php artisan serve

<hr>

### Requirement

1. Use migration to create table
2. ORM relationship
3. Setup layout and authentication with laravel breeze
4. Generate data with db seeder
5. List API

## Login

POST /api/login

```json
{
    "email": "email",
    "password": "password"
}
```

> Use Bearer Token from response to make other API

## List, search store with pagination

GET /api/store?id=&user_id=&name=&pageSize=&page=

## Get detail store by id

GET /api/store/:id

## Create store

POST /api/store

```json
{
    "user_id": "2",
    "name": "Store_HCM",
    "address": "D.12 HCM",
    "province": "12"
}
```

## Update store

PUT /api/store/:id

```json
{
    "user_id": "2",
    "name": "Store_HCM",
    "address": "D.10 HCM",
    "province": "10"
}
```

## Delete store

DELETE /api/store/:id

<hr>
## List, search store with pagination

GET /api/product?id=&store_id=&name=&pageSize=&page=

## Get detail product by id

GET /api/product/:id

## Create product

POST /api/product

```json
{
    "store_id": "2",
    "name": "Phone",
    "price": "100000",
    "amount": "2",
    "description": "Phone 2023"
}
```

## Update product

PUT /api/product/:id

```json
{
    "store_id": "2",
    "name": "Phone",
    "price": "100000",
    "amount": "2",
    "description": "Phone 2023"
}
```

## Delete product

DELETE /api/product/:id
