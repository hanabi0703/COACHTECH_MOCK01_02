# 環境構築

## Docker ビルド

```
git clone https://github.com/hanabi0703/COACHTECH_MOCK01_02.git
```

docker-compose.yml ファイルの存在する階層へ移動し以下を実行

```
docker compose up -d --build
```

## Laravel 環境構築

```
docker compose exec php bash
```

```
composer install
```

```
cp .env.example .env
```

※環境変数は適宜変更

```
php artisan key:generate
```

```
php artisan migrate
```

```
php artisan db:seed
```

```
php artisan storage:link
```

## 開発環境

・商品一覧画面:http://localhost/

・ユーザー登録:http://localhost/register

・phpMyAdmin:http://localhost:8080/

## 使用技術(実行環境)

・PHP 7.4.9
・Laravel 8.83.27
・MySQL 8.0.26
・nginx 1.21.1

## ER 図

![MockCase01](https://github.com/user-attachments/assets/d86f4e48-efbd-47b1-97b3-80608ee2d946)
