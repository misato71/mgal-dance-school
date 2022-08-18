# ダンススクールの予約アプリ

## 1. このアプリの概要
これは、友人がダンススクールの運営をしていて、予約作業の効率化のために開発したダンススクールの予約アプリです。
このアプリは、ダンススクールの管理者、ダンスレッスンを予約する生徒が使うことを想定しています。
このアプリの目的は、ダンスレッスンの登録や予約の管理、レッスン予約、生徒情報の管理もできます。
アプリの使い方としては、管理者がこのアプリにログインし、まずはレッスン、講師、スタジオを登録し、次にスケジュールを登録していきます。
ダンスレッスンを予約する生徒は自身の登録した情報にログインし、行きたい日のレッスン（スケジュール）を予約するという流れになっています。
このアプリは、スマートフォンやタブレット端末のレスポンシブデザインにも対応しており、外出先や、在宅でもレッスンの予約が手軽にできます。
以下、具体的な技術要素をまとめていますので、ご覧いただければ幸いです。

## 2. 技術要素

- 開発環境 AWS Cloud9 / Ubuntu Server 18.04 LTS
- HTML5 / CSS3
- Bootstrap 4.2.1
- PHP 7.3.33
- MySQL 5.7.39
- Laravel Framework 6.20.44
- 画像の保存 AWS / S3
- バージョン管理 Git 2.17.1 / GitHub
- デプロイ Heroku
- 実際にherokuにデプロイしたもの: https://mgal-dance-school.herokuapp.com/
- デプロイ AWS / EC2
- 実際にEC2にデプロイしたもの: http://18.176.18.1/

##### ※以下のダミー管理者を使ってログインしてご利用ください。
- 名前: test
- メールアドレス: test@test.com
- パスワード: test

##### ※以下のダミーユーザーを使ってログインしてご利用ください。
- 名前: aru
- メールアドレス: aru@aru.com
- パスワード: aruarudesu

## 2. 機能一覧
#### (1) 管理者
- ログイン・ログアウト機能

##### (1) スケジュール関連
- スケジュール一覧表示機能
- スケジュール詳細表示機能
- スケジュールの日付検索機能
- スケジュールの今月、翌月絞り込み機能
- スケジュール登録・編集・削除機能

##### (2) 予約関連
- 予約管理表示機能
- 予約詳細表示機能
- 予約新規追加機能
- 予約キャンセル機能
- 予約の日付検索機能

##### (3) レッスン関連
- レッスン一覧表示機能
- レッスンの詳細表示機能
- レッスンの登録・編集機能

##### (4) 講師関連
- 講師一覧表示機能
- 講師の詳細表示機能
- 講師の登録・編集機能

##### (5) スタジオ関連
- スタジオ一覧表示機能
- スタジオの詳細表示機能
- スタジオの登録・編集機能

##### (6) お客様関連
- お客様管理一覧表示機能
- お客様情報詳細表示機能
- お客様の名前検索機能

#### (2) ユーザ

##### (1) スケジュール関連
- スケジュール一覧表示機能
- スケジュール詳細表示機能
- スケジュールの日付検索機能
- スケジュールの今月、翌月絞り込み機能

##### (2) 予約関連
- お客様の予約管理表示機能
- 予約詳細表示機能
- 予約新規追加機能
- 予約キャンセル機能

##### (3) お客様関連
- お客様情報の登録・編集機能
- パスワード変更機能
- ログイン・ログアウト機能

## 3. このアプリの資料

##### ⓵最初の画面
![最初の画面](/public/uploads/sample1.png)

##### ⓶ログイン後のトップ画面
![ログイン後のトップ画面(スケジュール一覧) ](/public/uploads/sample2.png)

##### ➂このアプリのデータベース図
![このアプリのデータベース図](/public/uploads/sample3.png)

##### ➂このアプリの（管理者）サイトマップ
![このアプリの（管理者）サイトマップ](/public/uploads/sample4.png)

##### ➂このアプリの（ユーザ）サイトマップ
![このアプリの（ユーザ）サイトマップ](/public/uploads/sample5.png)

## 4. このWebアプリケーションを開発した経緯
テックアカデミーでのレッスンの集大成として、このオリジナルアプリを開発しました。
友人がダンススクールの運営をしていて、「お客様の予約の管理をLineで一人一人対応している為大変！」というお話を聞いたのがきっかけで、レッスンの予約をアプリでできたら便利だろうなと思い開発しました。
ダンススクールの予約サイトとして、業務の効率化を高める目的として、このアプリ開発に取り組みました。

## 5. お問い合わせ
駆け出しエンジニアの立場で、まだまだ不勉強なためバグが潜んでいるかもしれません。
現在、ユーザの退会、キャンセル機能は前日までに設定するなどの作成に挑戦しおります。
改善点などがありましたら、以下のメールアドレスにご連絡いただけると幸いです。

##### ◆メールアドレス:
misato71h@gmail.com

## 著者
2022/08/18 Harada Misato