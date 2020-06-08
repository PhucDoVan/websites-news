# 契約関連統合管理システム（SACLMS）
 
## 開発環境の起動手順
### 1. サーバー環境を起動
~~~bash
$ ./up_server.sh
~~~

### 2. 管理画面へアクセス
- [http://127.0.0.1/](http://127.0.0.1/)

### 3. サーバー環境の停止
~~~bash
$ ./down.sh
~~~

## デプロイ
### ステージング
`./deploy-staging.sh`  
(developブランチ / eyemovicメンバーのみ)

...もしくは...

`php deployer.phar -f server/deploy.php deploy staging`
