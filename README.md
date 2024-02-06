# backend-developer-test

## Requirements

- PHP 8.1
- Mysql Database
- Sqlite
- Composer
- Git

## Installation

#### Clone the git repository on your computer

```
git clone https://github.com/OfficialOzioma/coding-test.git
```

#### After cloning Enter the folder by running the code on your terminal

```
cd coding-test
```

#### You need to install it's dependencies

```
composer install
```

### Setup

- When you are done with installation, copy the `.env.example` file to `.env`

  ```
  cp .env.example .env
  ```

- Generate the application key

  ```
  php artisan key:generate
  ```

- Add your database credentials to the necessary `env` fields

- Migrate the application
  
    ```
    php artisan migrate
    ```

- Seed the database for testing
  
  ```
   php artisan db:seed
  ```

- You can then test the achievements endpoint
  
  ```
  http://localhost:8000/users/1/achievements
  ```

### Testing

#### This testing using SQLite as database make sure you have it setup on you PC

check the .env.testing file to update the credentials to match your configuration

- To test run the Laravel artisan Test command below

    ```
    php artisan test
    ```
