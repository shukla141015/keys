# Keys.lol
Cryptocurrency private keys

## Laravel version
[compare to laravel master](https://github.com/laravel/laravel/compare/9838f79d2c07c6196afec0363dbabe369e95cc75...master)

## Installation
Make sure the [keys generator executable](https://github.com/SjorsO/keys-generator) is available from $PATH.

```bash
cp .env.examle .env

composer install

php artisan key:generate

artisan migrate:fresh
 
npm install && npm run dev
```
