# Pingcrm With Pest Laravel.

![](https://pestphp.com/assets/img/small-logo.gif)


Pest is the new kid on the block when it comes to PHP testing frameworks. It has gained popularity quickly thanks to its modern approach, gorgeous output and focus on developer experience.


## Installation

Clone the repo locally:

```sh
git clone https://github.com/AymanElbery/pingcrm-with-pest-laravel.git
cd pingcrm-with-pest-laravel
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm install
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Install Pest:

```sh
composer require pestphp/pest-plugin-laravel --dev
php artisan pest:install
```

Install Faker plugin:

```sh
composer require pestphp/pest-plugin-faker --dev
```

You're ready to Test! 
Just Run:
```sh
php artisan test
```
