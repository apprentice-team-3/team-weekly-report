# Docker起動までの流れ

```bash
docker-compose up -d
docker-compose exec mysql mysql -u root -p mydb
```

## 起動しない場合
Docker UIの方で一旦動いているコンテナを停止してから再度上記コマンドを試す

起動後にリンクを確認
[http://localhost:8080](http://localhost:8080)
