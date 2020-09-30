# CCM

### Prerequisite

1. PHP v7.3+
2. MySQL Server

### Getting started

1. Create database `<DB_NAME>`
2. Move to the project folder and launch a terminal instance from the root.
3. Create a `.env` file by using the provided run, `mv .env.example.<OS> .env`, this will rename the provided `.env.example.<OS>` file to `.env`. (Pick your OS specific .env file)
4. Edit the `.env` file adding your database connections details.
5. Import provided schema to the database, `mysql -u <DB_USER> -h <DB_HOST> -D <DB_NAME> -P 3306 -p < *.sql`.
6. Make your environment variables known to app, `source .env`.
7. Start server,run: `php -S localhost:8000`.
