# Keys.lol
Cryptocurrency private keys

## Installation
GMP (GNU Multiple Precision Arithmetic Library) is required for bitcoin math:
```bash
sudo apt-get install php7.1-gmp
 
sudo phpenmod gmp
```

Rename `.env.example` to `.env` and fill in the arrows
```bash
composer update

php artisan key:generate
 
php artisan migrate
 
npm install (--no-bin-links)
 
npm run dev
```
