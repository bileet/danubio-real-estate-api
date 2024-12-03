# DANUBIO Real Estate API with Laravel
An API built with Laravel for managing real estate properties.

## Functionalities
1. Create properties
2. List properties with advanced filtering

## Running the API

### Requirements
- Laravel 11.x
- PHP 8.2+
- MySQL Database

### Steps
1. Clone the repository.  
2. Install dependencies using Composer:  
   ```bash
   composer install
   ```
3. Set up the .env file to use the MySQL database.
4. Run database migrations:
    ```bash
    php artisan migrate
    ```
5. Start the Laravel server:
    ```bash
    php artisan serve
    ```
6. Access the application via the local server URL, probably at http://127.0.0.1:8000.

## API Endpoints

### List Properties
- **Endpoint**: `GET /api/properties`

#### Filter Syntax
- Measurable values (size, bedrooms, price) uses a special filter format: 
`Comparison operators followed by a numeric value.`
    ##### Examples
    - size `=>:100` (Properties larger than 100)
    - price `<=:250000` (Properties priced at or below 250,000)
    - bedrooms `=:3` (Properties with exactly 3 bedrooms)
- The radius while searching by coordinates should be in `Meters`

#### Available Filters
- `type`
- `street`
- `size`
- `size_unit`
- `bedrooms`
- `price`
- `latitude`
- `longitude`
- `radius`

### Create Property
- **Endpoint**: `POST /api/properties`

## Backlog
- User authentication/authorization.
- Roles. e.g. The agency agents can create listings.
- Full CRUD endpoints.
- A 'suggestions' or 'related' list of properties when viewing a single property.
- ...

## Notes
#### I've included a Postman collection for reference: [here](/DANUBIO%20Real%20Estate%20API.postman_collection.json).
