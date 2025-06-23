# Brand Listing API Project

## Project URLs

-   **API Base URL:** `http://localhost:8080/api` (adjust based on your environment)

-   **Swagger/OpenAPI Documentation:** \[Coming Soon\] - After deployment, you can host this OpenAPI YAML file and use tools like Swagger UI to generate interactive documentation.

-   **Postman Collection:** \[Coming Soon\] - You can import the raw OpenAPI YAML into Postman to generate a collection.

## Overview

The Brand Listing API project is a robust backend application designed to provide a RESTful API for managing brand information. It is built using Docker, Docker Compose, and PHP with the Laravel framework, leveraging Laravel Passport for API authentication. This project offers comprehensive CRUD (Create, Read, Update, Delete) operations for brands, allows user authentication via API tokens, and handles country-specific data via request headers, enabling seamless management and interaction with brand content.

## Key Features

-   **API Authentication:** Secure user authentication using Laravel Passport, providing Bearer tokens for accessing protected routes.

-   **Brand CRUD Operations:** Full functionality to create, retrieve, update, and delete brand records.

-   **Country Code Header Integration:** Brand creation and updates utilize an `X-Country-Code` header to associate brands with specific countries, managed by custom middleware.

-   **Dockerized Environment:** Utilizes Docker and Docker Compose for consistent, isolated, and easily reproducible development and production environments.

-   **MySQL Database:** Persistent storage for brand, user, and OAuth client data.

-   **Nginx Web Server:** High-performance web server acting as a reverse proxy for the Laravel application.

-   **PHP Laravel Framework:** Provides a robust, elegant, and feature-rich backend framework for rapid development.

## Tools and Technologies

-   **Docker:** Containerization platform for consistent application execution across environments.

-   **Docker Compose:** Tool for defining and running multi-container Docker applications, simplifying service configuration and interdependencies.

-   **Laravel:** PHP web application framework with expressive, elegant syntax, offering robust features for routing, ORM (Eloquent), authentication, and more.

-   **Laravel Passport:** OAuth2 server and API authentication for Laravel, making it easy to issue API tokens.

-   **Nginx:** High-performance web server and reverse proxy, serving as the entry point for HTTP requests to the Laravel application.

-   **MySQL:** Relational database management system for structured data storage.

-   **Bash:** Scripting language used in the `Makefile` for automating common development and deployment tasks.

## Setup Instructions

### Prerequisites

-   **Docker:** Ensure Docker Desktop (or Docker Engine) is installed and running on your system.

    -   [Docker Installation Guide](https://docs.docker.com/get-docker/)

-   **Docker Compose:** Ensure Docker Compose is installed. It typically comes with Docker Desktop.

    -   [Docker Compose Installation Guide](https://docs.docker.com/compose/install/)

### Clone the Repository

First, clone the project repository to your local machine:

git clone
cd # e.g., cd brand-listing-app

### Configuration

#### Environment Variables

1.  **Application Environment (`.env`):**
    Copy the `.env.example` file to `.env` in the project root.

    ```
    cp .env.example .env

    ```

    Update the environment variables in `.env` as needed. Pay special attention to:

    -   `APP_URL`: Set this to your application's accessible URL (e.g., `http://localhost:8080`).

    -   `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: These should match your MySQL service configuration in `docker-compose.yml` or `variables.env`.

    -   `PASSPORT_PASSWORD_CLIENT_ID` and `PASSPORT_PASSWORD_CLIENT_SECRET`: If you're using `.env` for these (as discussed in advanced seeding), ensure they are set after running `passport:client --password` once.

2.  **Docker Compose Variables (`variables.env`):**
    Create a `variables.env` file in your project root and define environment variables used by Docker Compose (e.g., database user/password for Docker's MySQL service).

### Build and Start Containers

To build Docker images and start the application containers in detached mode (background):

make start-app

This command will:

-   Build the Docker images specified in `docker-compose.yml` (including installing Composer dependencies inside the `php-fpm` container).

-   Start the `app` (php-fpm), `nginx`, and `mysql` containers.

### Run Migrations and Seeders

After starting the containers, you need to set up your database schema and seed initial data, including Passport clients:

make migrate

This command will:

-   Execute `php artisan migrate` to set up the database schema (creating all tables, including `oauth_clients`).

-   Execute `php artisan db:seed` to populate initial data, which _must_ include your `PassportClientSeeder` to create the necessary OAuth clients.

-   **Important:** If this is your first time or you want a fresh database, use `php artisan migrate:fresh --seed` instead of `migrate`. You might add a `make fresh` target for this.

### Generate Application Key

Ensure your Laravel application has an encryption key:

docker-compose exec app php artisan key:generate

### Passport Installation (One-time, often covered by CI/CD or initial dev setup)

If `php artisan migrate:fresh --seed` doesn't install Passport, ensure it's run manually once to generate encryption keys:

docker-compose exec app php artisan passport:install

### Access the Application

The API will be accessible on `http://localhost:8080/api` (or another port if configured differently in `docker-compose.yml`).

-   **Login:** `POST http://localhost:8080/api/login`

-   **Brands:** `GET/POST/PUT/DELETE http://localhost:8080/api/brands`

### Stopping and Restarting

-   To stop all running containers, use:

    ```
    make stop

    ```

-   To restart the containers after making code changes:

    ```
    make restart

    ```

### Running Tests

To run the application's automated tests:

make test

This command will:

-   Clear the configuration cache.

-   Run database migrations for the testing environment (often an in-memory SQLite database or a dedicated test database).

-   Execute PHPUnit tests.

### Viewing Logs

To follow the logs for the `app` (PHP-FPM/Laravel) container:

make logs

### Container Access

-   To access the `app` container as the root user:

    ```
    make root

    ```

-   To access the `nginx` container as the root user:

    ```
    make root-nginx

    ```

### Makefile Commands Summary

Your `Makefile` provides convenient shortcuts for common operations:

-   `help`, `help-default`: Displays the help menu with available commands.

-   `up`: Starts Docker containers in detached mode (`docker-compose up -d --build`).

-   `stop`: Stops all Docker containers (`docker-compose stop`).

-   `status`: Shows the status of Docker containers (`docker-compose ps`).

-   `restart`: Stops, rebuilds, and restarts the containers (`docker-compose down && docker-compose up -d --build`).

-   `migrate`: Runs database migrations (`docker-compose exec app php artisan migrate --force && docker-compose exec app php artisan db:seed`).

-   `root`: Logs into the `app` container as the root user (`docker-compose exec app bash`).

-   `root-nginx`: Logs into the `nginx` container as the root user (`docker-compose exec nginx bash`).

-   `test`: Runs tests using Docker Compose (`php artisan config:clear && php artisan migrate --env=testing --force && php artisan test --env=testing`).

-   `logs`: Follows logs for the `app` container (`docker-compose logs -f app`).

-   `build`: Builds or rebuilds Docker images.

-   `deploy-acceptance`, `deploy-staging`, `deploy-production`: Deployment targets (implementation details not provided here).

-   `pull`: Pulls the latest MySQL Docker image.

-   `reset`: Stops, cleans, rebuilds, and restarts the containers.

-   `ping-app`, `ping-nginx`: Network connectivity tests between containers.

-   `clean`: Stops containers and removes them.

-   `cleanall`: Prunes all unused Docker data.

-   `%`: A catch-all target that does nothing.
