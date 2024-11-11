# 開発手順
```
composer install
```
```
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate ※失敗する場合は何度か試す
```
localhostにアクセスし、laravelのページが表示されている事を確認