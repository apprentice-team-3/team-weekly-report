# Docker起動までの流れ

```bash
docker-compose up -d
docker-compose exec mysql mysql -u root -p mydb
```

## 起動しない場合
Docker UIの方で一旦動いているコンテナを停止してから再度上記コマンドを試す

## Dockerfileまたはymlファイルが更新されたら

```bash
docker-compose up -d --build
```


## ポート番号の確認をお忘れなく
```bash
sudo lsof -i:3306
```
上記コマンドでポート番号が占有していた場合ymlファイルの設定を更新する
- `docker-compose.yml`
- `datasource.php`

上記のポート番号を変更する


起動後にリンクを確認
[http://localhost:8080](http://localhost:8080)
