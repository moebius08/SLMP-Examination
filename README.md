### Prerequisites
- Docker and Docker Compose (for method 1)
- PHP 8.4 (for method 2)
- Composer (for method 2)
- PostgreSQL 16 (for method 2)

### Method 1: Using Docker Compose (Recommended)

1. Clone the repository:

2. Create a `.env` file from the example:
```bash
cp .env.example .env
```

3. Build and start the containers:
```bash
docker compose up -d
```

The application will automatically:
- Install dependencies
- Generate application key
- Run database migrations
- Fetch initial data
- Start the server

The application will be available at `http://localhost:8000`

Database credentials (as defined in docker-compose.yml):
- Host: localhost
- Port: 5432
- Database: slmp_exam
- Username: root
- Password: postgresqlpassword

### Method 2: Manual Installation

2. Install PHP dependencies:
```bash
npm install && npm run build
composer install
```

3. Create and configure your `.env` file:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your PostgreSQL database:
   - Create a new database named `slmp_exam`
   - Update the `.env` file with your database credentials:
     ```
     DB_CONNECTION=pgsql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=slmp_exam
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. Run database migrations:
```bash
php artisan migrate
```

6. Import data from jsonplaceholder
```bash
php artisan fetch:jsonplaceholder
```
7. Start the development server:
```bash
php artisan serve
`or`
composer run dev
```

The application will be available at `http://localhost:8000` or `http://127.0.0.1:8000`

### API Documentation

You can find all available endpoints and test the API using the Postman collection provided in the repository:
`SLMP-Examination.postman_collection.json`

Import this collection into Postman to:
- View all available endpoints
- Test the API with pre-configured requests
- See example responses
- Use the included authentication tokens