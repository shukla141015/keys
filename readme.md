# Vlug boilerplate
Opinionated, basic Laravel boilerplate.

## Installation
Rename `.env.example` to `.env` and fill in the arrows
```bash
composer update

php artisan key:generate
 
php artisan migrate
 
npm install (--no-bin-links)
 
npm run dev
```

### Server permissions
todo




### Broadcasting events
```bash
composer require pusher/pusher-php-server
 
npm install laravel-echo
 
npm install pusher-js
```

Add the following to the page head in  `base-template.blade.php`:
```php
<script>
    <?php
    echo 'window.Laravel = ' . json_encode([                
            'pusherKey'       => env('PUSHER_APP_KEY'),
            'pusherCluster'   => env('PUSHER_APP_CLUSTER'),
            'pusherEncrypted' => env('APP_HTTPS'),
        ]);
    ?>
</script>
```
