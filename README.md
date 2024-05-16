# Banking System

## Setup

1. Clone the repository:

    ```sh
    git clone https://github.com/awalhadi/banking-system
    cd banking-system
    ```

2. Install composer dependencies:

    ```sh
    composer install
    ```

3. Setup environment variables:

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. Configure `.env` file with database information.

5. Run migrations:

    ```sh
    php artisan migrate
    ```

6. Serve the application:

    ```sh
    php artisan serve
    ```

7. Install npm packages (you can use yarn or npm):
    ```sh
    yarn install
    ```
    or
    ```sh
    npm run install
    ```
8. Then run dev
    ```sh
    yarn dev
    ```
    or
    ```sh
    npm run dev
    ```
