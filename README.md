# Laravel calculator

## Project Setup

### Requirements

- PHP 8.x
- Composer

### Tech Used: 

- Laravel
- VueJs
- Passport

## WEB Preview

Calculator
![Calculator](https://github.com/G-eat/calculator/blob/master/public/images/calculator.png)

Calculator history
![Calculator history](https://github.com/G-eat/calculator/blob/master/public/images/calculator_history.png)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/G-eat/calculator.git

2. Cd to project:
    ```bash
    cd calculator

3. Install PHP dependencies using Composer:
    ```bash
    composer install

4. Set up your environment variables:
    Create a copy of the .env.example file and name it .env
    ```bash
    cp .env.example .env

    Configure your database connection in the .env file:
    
5. Generate an application key:
    ```bash
    php artisan key:generate

6. Run migrations
    ```bash
    php artisan migrate

7. Passport command(for api)
    ```bash
    php artisan passport:install

8. Start the Laravel development server:
    ```bash
    php artisan serve

Access the application in your browser at http://127.0.0.1:8000.

### UML Diagrams
Access the UML diagrams at http://127.0.0.1:8000/uml.

### Api Postman Collection
Click to go to: [postman collection](https://github.com/G-eat/calculator/blob/master/public/calculator.postman_collection.json)