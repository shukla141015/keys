# Keys.lol
This repository contains the website for [Keys.lol](https://keys.lol).

The code that generates the keys is in [a separate repository](https://github.com/SjorsO/keys-generator).

## Laravel version
[Compare to laravel master](https://github.com/laravel/laravel/compare/915667a8d5fa31e7d35b617f64c47ab67a64a171...master)

## Installation
Make sure the [keys generator executable](https://github.com/SjorsO/keys-generator) is available from $PATH.

```bash
cp .env.example .env

# Fill in the .env file

composer install

php artisan key:generate

artisan migrate:fresh
 
npm install && npm run dev
```

## Contributing
Feel free to open a pull request if you want to add new features, or if you want to help improve the code, design, text, seo, or any other part of the website.

If you want want to discuss an idea with me before implementing it, you can contact me by email, twitter, or by opening an issue. 

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
