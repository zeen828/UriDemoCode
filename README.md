# 短網址系統

## 開發使用版本
+ PHP 8.0.7 (cli) (built: Jun  2 2021 00:41:03) ( ZTS Visual C++ 2019 x64 )
+ Laravel 8.40
+ MySQL 8.0.25.0
+ Redis 3.0.504

## 功能
1. 輸入網址產生一個短網址
2. 訪問短網址
3. 短網址分析資訊

## 專案安裝
1. 安裝套件
```bash
composer install
```
2. Laravel設定檔
```bash
# linux
cp .env.example .env
# windows
copy .env.example .env
```
3. Laravel Key
```bash
php artisan key:generate
```
4. 遷移
```bash
php artisan migrate
```
5. 運行
```bash
php artisan serve
# PHP8起一個服務
php -S 127.0.0.1:3000
```
