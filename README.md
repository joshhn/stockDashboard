# CSE330
Tram Vu - 520643 - ngoctramvu

Duy Huynh - 520644 - joshhn

## Checklist

### Rubric (5 points)
- [x] Submit Rubric by April 8th (5 points) -- Approved by TA Rose Liu

### Languages/Frameworks used (20 points)
- [x] Learned/Used TypeScript and Angular frontend framework (10 points)
- [x] Learned/Used PHP Laravel backend (10 points)
- [x] MySQL Database (0 points)

### Functionality (55 points)
#### User Management & Dashboard (30 points)
- [x] Users can sign up for an account. (10 points)
- [x] Users can add/edit/remove stocks in their watchlist. (10 points)
- [x] Users can make multiple watchlists. (5 points)
- [x] The database contains Users and Watchlists with the necessary columns and column types to maintain the above functionality. (5 points)

#### Stock Dashboard (25 points)
- [x] Display real-time stock statistics from TradingView (10 points)
- [x] Visualize real-time stock charts from TradingView (5 points)
- [x] Users can filter stocks (10 points)

### Best Practices (5 points)
- [x] Code is readable and well-formatted (3 points)
- [x] All pages pass the HTML validator (2 points)

### Creative Portion (15 points)
- [x] Add a home page to display current events/news.
- [x] Each event connects to detailed pages about related stocks.
- [x] Users can rename watchlists.
- [x] Users can delete watchlists.
- [x] Utilize Cache in server for news and stocks endpoints.
- [x] Utilize PHP Unit Test in server.


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
