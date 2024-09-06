# Task Management API

This is a Task Management API built with Laravel Lumen. It allows you to create, update, delete, and search for tasks.

## Prerequisites

- PHP >= 7.3
- Composer
- MySQL or any other supported database

## Installation

1. **Clone the repository:**

    ```sh
    git clone git@github.com:MatibeJeremy/task_management.git
    cd task-management-api
    ```

2. **Install dependencies:**

    ```sh
    composer install
    ```

3. **Copy the `.env.example` file to `.env` and configure your environment variables:**

    ```sh
    cp .env.example .env
    ```
   For example, set the database connection details:

    ```sh
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=database_name
    DB_USERNAME=username
    DB_PASSWORD=password

4. **Generate the application key:**

    ```sh
     php -r "echo base64_encode(random_bytes(32));" 
    ```

5. **Run the database migrations:**

    ```sh
    php artisan migrate
    ```
   
## Running the Application

1. **Start the local development server:**

    ```sh
    php -S localhost:8000 -t public
    ```

2. **Access the application:**

   Open your browser and go to `http://localhost:8000`.

## Running Tests After data is added to the table

1. **Run the tests:**

    ```sh
    ./vendor/bin/phpunit
    ```

## API Endpoints

- **GET /tasks**: Get all tasks
- **GET /tasks/search**: Search for tasks
- **GET /tasks/{id}**: Get a task by ID
- **POST /tasks**: Create a new task
- **PUT /tasks/{id}**: Update a task
- **DELETE /tasks/{id}**: Delete a task

