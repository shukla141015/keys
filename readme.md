# Keys.lol
Cryptocurrency private keys

## Laravel version
[Compare to laravel master](https://github.com/laravel/laravel/compare/915667a8d5fa31e7d35b617f64c47ab67a64a171...master)

## Installation
Make sure the [keys generator executable](https://github.com/SjorsO/keys-generator) is available from $PATH.

```bash
cp .env.example .env

composer install

php artisan key:generate

artisan migrate:fresh --seed
 
npm install && npm run dev
```
