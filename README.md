## Installation

Please follow these steps to install the projects:

- Clone the project.
- Navigate to the project directory.
- Run the following commands:
    - `cp .env.example .env`
    - `docker-compose build`
    - `docker-compose exce app composer install`
    - `docker-compose exce app php artisan key:generate`.
    - `docker-compose exce app php artisan migrate --seed`.

## Testing

Please Run the following commands to run the test cases:
- `docker-compose exce app php artisan test`.