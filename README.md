## Gettting Started

### Installation (MacOS)
#### Client

Install the Angular CLI globally:
```sh
brew install angular-cli
```

Switch to the client folder
```sh
cd client
```

Install dependencies
```sh
npm install
```

Start the local development server
```sh
ng serve
```

TODO


#### Server
Install [Composer](https://getcomposer.org/)
```sh
brew install composer
```

Switch to the server folder
```sh
cd server
```

Install dependencies
```sh
composer install
```

Add .env file from .env.example template
```sh
cp .env.example .env
```

**Modify database credentials in .env**
```
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Generate a new application key
```sh
php artisan key:generate
```

Run database migrations
```sh
php artisan migrate
```

Start the local development server
```sh
php artisan serve
```

Access server at http://localhost:8000

### Development

#### Authorization
[API Token Authentication](https://laravel.com/docs/11.x/sanctum#api-token-authentication)


#### API Requirements

**Required** Send API request with Header -- Accept: application/json

#### Database
The server uses [Polygon.io](https://polygon.io/) to retrieve stocks

Sign up for [Polygon.io](https://polygon.io/) and fill out API key in .env file
```
POLYGON_API_KEY=
```

Run command below to seed the stocks table with available tickers
```sh
php artisan db:seed
```


#### Debugging
To monitor Laravel logs
```sh
tail -f storage/logs/laravel.log
```

#### Testing

**Modify test database credentials in .env**
```
DB_TEST_DATABASE=
DB_TEST_USERNAME=
DB_TEST_PASSWORD=
```

Run All Tests
```sh
php artisan test
```

Run All Tests in Parallel
```sh
php artisan test --parallel
```

Run Single Test
```sh
php artisan test --parallel --filter=UserTest
```
