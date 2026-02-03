## アプリケーション名

FashionablyLate

## 環境構築
1⃣　Dockerビルド  
  
① アプリケーションを作成するために、開発環境を GitHub からクローンします。
  
コマンドライン上
```
git clone git@github.com:HIDE52/hide-kadai1.git
mv hide-kadai1 FashionablyLate
```
  
② 開発環境を構築します。  
  
```
コマンドライン上

cd FashionablyLate
docker-compose up -d --build
code .
```
  
③「Docker Desktop 」の確認を行い、FashionablyLateコンテナが作成されているか確認を行います。  
  
2⃣　Laravel のパッケージのインストール  
  
①


```
コマンドライン上

docker-compose exec php bash
```
  
② composerコマンドを使って必要なパッケージをインストールします

```
PHPコンテナ上

composer install
```
  
③
```
ここに手順を記載
テスト
```




## 使用技術(実行環境)

ここにバージョンを記載

## URL

ここにURLを記載

## ER図

![ER図](ER.drawio.png)
