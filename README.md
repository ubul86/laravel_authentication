# Laravel JWT Authentication API

A simple Laravel 10 application implementing JWT authentication. This project provides endpoints for user registration, login, and user data retrieval.

## Minimum Requirements

- **PHP**: 8.1 or higher
- **Composer**: 2.0 or higher
- **MySQL**: 5.7 or higher
- **Laravel**: 10.x
- **Node.js** (optional, for Vue frontend integration)

## Installation With Docker

First, need a fresh installation of Docker and Docker Compose

### 1. Clone the Project

Clone the repository to your local machine:

```bash
git clone https://github.com/yourusername/your-repository.git
cd your-repository
```
 
### 2. Copy Environment File

Copy the .env.sample file to .env:

```bash
cp .env.sample .env
```

### 3. Set Environment Variables
In the .env file, you need to set the DB connections and some Host value.
Here is an example configuration:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
DB_ROOT_PASSWORD=your_database_root_password

NGINX_PORT=8080
PHPMYADMIN_PORT=45678
```

The DB_HOST needs to be mysql container name.

### 4. Build The Containers

Go to the project root directory, where is the docker-compose.yml file and add the following command:

```bash
docker-compose up -d --build
```

### 5. Install Dependencies:

Install PHP dependencies using Composer:

```bash
docker exec -it {php_container_name} composer install
```

or
```bash
docker exec -it {php_container_name} bash
composer install
```

### 6. Generate JWT Secret

Generate the JWT secret key:

```bash
docker exec -it {php_container_name} php artisan jwt:secret
```

or

```bash
docker exec -it {php_container_name} bash
php artisan jwt:secret
```

### 7. Run Migrations

Run the database migrations:

```bash
docker exec -it {php_container_name} php artisan migrate
```

or

```bash
docker exec -it {php_container_name} bash
php artisan migrate
```

### 8. Seed the Database

Seed the database with initial data:

```bash
docker exec -it {php_container_name} php artisan db:seed
```

or

```bash
docker exec -it {php_container_name} bash
php artisan db:seed
```

## Installation Without Docker

### 1. Clone the Project

Clone the repository to your local machine:

```bash
git clone https://github.com/yourusername/your-repository.git
cd your-repository
```

### 2. Install Dependencies

Install PHP dependencies using Composer:

```bash
composer install
```

### 3. Copy Environment File

Copy the .env.sample file to .env:

```bash
cp .env.sample .env
```

### 4. Generate JWT Secret

Generate the JWT secret key:

```bash
php artisan jwt:secret
```

This command will update the .env file with the JWT_SECRET key.

### 5. Configure the Database

Create a new database for the project and set the database connection in the .env file. Update the following lines in your .env file. There is an example setting:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 6. Run Migrations

Run the database migrations:

```bash
php artisan migrate
```

### 7. Seed the Database

Seed the database with initial data:

```bash
php artisan db:seed
```

### 8. Start the Development Server

Run the Laravel development server:

```bash
php artisan serve
```

The application should now be accessible at http://localhost:8000.

## Endpoints

Here are the available API endpoints:

- POST /register: Register a new user.
  - Request Body:
  ```json
  {
    "name": "John Doe",
    "email": "johndoe@example.com",
    "password": "password",
    "password_confirmation": "password"
  }
  ```
  - Response: Returns the newly created user and JWT token.
   

- POST /login: Authenticate a user and get a JWT token.
  - Request Body:
  ```json
  {
    "email": "johndoe@example.com",
    "password": "password"
  }
  ```
  - Response: Returns a JWT token.
  
  
- GET /user: Get the authenticated user’s details (requires JWT token).
  - Request Header:
  ```json
  Authorization: Bearer {token}
  ```
  - Response: Returns the authenticated user’s details.

- POST /logout: Log out the user and invalidate the JWT token.
  - Request Header:
   ```json
    Authorization: Bearer {token}
  ```
  - Response: Returns a success message if the token was invalidated.


## Testing and Analysis Tools

### PHP CodeSniffer (PHPCS)

PHPCS is used to check coding standards and style violations.

```bash
composer lint
```

### PHPStan

PHPStan is used for static code analysis to find bugs and improve code quality.

Run PHPStan:

```bash
composer analyse
```

Note: You might need to update your phpstan.neon configuration if you encounter issues or deprecations.

## Running Tests

### PHPUnit

Unit tests are written using PHPUnit. To run tests, first configure SQLite in-memory database in phpunit.xml. This setup allows you to run tests without affecting your actual database. The database is created and discarded during each test run, ensuring a clean state.

- Open phpunit.xml and set up the SQLite in-memory database configuration:
```xml
<phpunit bootstrap="vendor/autoload.php" colors="true">
    <php>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
    </php>
</phpunit>
```

- Run the tests:
```bash
php artisan test
```

This will execute all tests in the tests directory and provide a summary of test results.

## Docker Installation

### Linux

- Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04
- For Linux Mint: https://computingforgeeks.com/install-docker-and-docker-compose-on-linux-mint-19/

### Windows

- https://docs.docker.com/desktop/windows/install/

## Docker Compose Installation

### Linux

https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04

### Windows
- Docker automatically installs Docker Compose.



