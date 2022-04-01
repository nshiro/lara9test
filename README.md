# 当レポジトリについて
当レポジトリでは、「[Laravel テスト実践入門！ ～ Laravel 9 で始めるTDDテスト入門講座 ～](https://www.udemy.com/course/laravel9-test/)」で使用するコードを置いています。

# 設置方法
基本的には講座を視聴し、その各回で見たコードを実際に手を動かして書いて動作を確認いただきたいのですが、とは言え、完成版もあった方が良いとは思いますので、以下手順を記載させていただきます。

## ダウンロード
以下のコマンドでクローンします。
（最後の lara9test の箇所は適宜変更して下さい。作成されるフォルダ名になります）
```bash
git clone https://github.com/nshiro/lara9test lara9test
```

又は、レポジトリサイトの右上「Code」を押した後に出てくる「Download ZIP」でダウンロードします。

## 設定等
システムのトップディレクトリに入り、composer install を行います。

```php
composer install
```
新規でDBを作成し、.env.example を .env にコピーをした上で、.env に作成したDBの設定をします。

以下のコマンドで、.env の APP_KEY を設定します。
```bash
php artisan key:generate
```

以下のコマンドでダミーデータを登録します。
```bash
php artisan migrate:fresh --seed
```

以上です。

WEBサーバは、各自の環境に応じた形で設定して下さい。
