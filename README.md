## アプリケーション名
Rese

## 作成した目的
飲食店予約アプリ
飲食店を紹介して、予約、レビュー、事前決済をする

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
- 本番環境：http://atte.blog

- ログインは、admin・shopManager・userの3つの役割で行える
- admin(管理者) Email:sunnychiba@samurai.example Password:password
- shopManager(店舗管理者) Email:kitaouji@kinkin.example Password:password
- user(一般ユーザー) Email:k.takakura@poppoya.example Password:password

## 機能一覧
- ログイン機能
- ログアウト機能
- ユーザー登録機能(userアカウントのみ)
- 飲食店一覧閲覧
- 飲食店の詳細情報確認
- 飲食店検索(エリア・ジャンル・キーワード)
- レビューの閲覧
- お気に入り登録・解除
- 飲食店の予約・キャンセル・予約の変更
- ユーザーの予約の確認
- 事前決済
- レビュー投稿
- 飲食店新規登録
- 飲食店情報の変更
- 飲食店側の予約状況確認
- adminロールによるユーザー登録機能(adminアカウント・shopManagerアカウント・userアカウント)
- アカウント全員に対するメールの一斉送信
- 来店確認機能
  

## 使用技術(実行環境)
- PHP8.3.3
- Laravel8.83.8
- MySQL8.3.0

## ER図
![alt text](rese.drawio-1.png)

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:cobaaan/rese.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```

