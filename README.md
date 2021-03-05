# backend-crud-assignment

## Please follow these steps to successfully run the project

### Clone the project

```
git clone https://github.com/yahrdy/backend-crud-assignment.git
```

### Install dependencies

```
composer install
```

### Generate application key

```
php artisan key:generate
```

### Rename `.env.example` file to `.env` and update your environment variables

```
APP_NAME='Your app name'
APP_URL=http://localhost:8000    //Please make sure you enter the correct url that might have different port
DB_DATABASE='Your database name'
DB_USERNAME='Your database username'
DB_PASSWORD='Your database password'
```

### Make symlink for uploading and viewing image publicly

```
php artisan storage:link
```

### Setup passport and generate secret keys and encryption keys

```
php artisan passport:install
```

### Migrate the database and seed

```
php artisan migrate --seed
# You can skip the seeding and just migrate the database by the following command
php artisan migrate
```

### Run the project

```
php artisan serve 
```


