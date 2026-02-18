# お問い合わせフォーム

---

## 環境構築

### Dockerビルド

1. git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
2. docker-compose up -d --build

### Laravel環境構築

1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

## 開発環境

- お問い合わせ画面:http://localhost/
- ユーザー登録:http://localhost/register
- phpMyAdmin:http://localhost:8080/

## 使用技術

- PHP
- Laravel
- jquery
- MySQL
- nginx

## ER図

![](images/test1.jpg)
