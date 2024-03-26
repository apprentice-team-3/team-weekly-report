飯後

`Dockerfile`ファイルと`docker.compose.yml`
を変更しましたー
どうやらM1だと通常のMySQLイメージは読み込まないようで
Oracleの出してるIMAGEを使うみたいです

`docker.compose.yml`今あるディレクトリの
- `conf.d`ディレクトリ
- `init.d`ディレクトリ

を追加してくださいー
`init.d`ディレクトリ直下のSQLがイメージ作成後に実行されるっぽい
