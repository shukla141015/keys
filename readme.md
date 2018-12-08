# Keys.lol
Cryptocurrency private keys

## Laravel version
[Compare to laravel master](https://github.com/laravel/laravel/compare/bc435e7fdd8308d133a404b1daa811dd30d95fe5...master)

## Installation
Make sure the [keys generator executable](https://github.com/SjorsO/keys-generator) is available from $PATH.

```bash
cp .env.example .env

composer install

php artisan key:generate

artisan migrate:fresh --seed
 
npm install && npm run dev
```
