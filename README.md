# Laravel calculator

## Project Setup

### Requirements

- PHP 8.x
- Composer
- Docker (optional, for containerized development)

### Installation

1. Clone the repository:
   ```bash
   git clone <repository_url>

2. Install PHP dependencies using Composer:
    ```bash
    composer install

3. Set up your environment variables:
    Create a copy of the .env.example file and name it .env.
    Configure your database connection in the .env file:

4. Generate an application key:
    ```bash
    php artisan key:generate

5. Run migrations
    ```bash
    php artisan migrate

6. Passport command(for api)
    ```bash
    php artisan passport:install

7. Start the Laravel development server:
    ```bash
    php artisan serve

Access the application in your browser at http://127.0.0.1:8000.

### Docker Setup

1. Build and start the Docker containers:
    ```bash
    docker-compose up -d --build

Access the application in your browser at http://127.0.0.1:8000.

### UML Diagrams
Access the UML diagrams at http://127.0.0.1:8000/uml.

### Api Postman Collection
    folder "public" - filename "calculator.postman_collection.json"