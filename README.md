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
---

## 🔐 Authentication Guide

This API uses **token-based authentication**. Follow the steps below to authenticate:

### 1. 📝 Register a New User

**Endpoint:** `POST /api/register`
**Body (JSON):**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "your_password",
  "password_confirmation": "your_password"
}
```

This will create a new user in the system.

---

### 2. 🔑 Login to Get Token

**Endpoint:** `POST /api/login`
**Body (JSON):**

```json
{
  "login": "john@example.com",
  "password": "your_password"
}
```

**Response:**

```json
{
  "access_token": "your_token_here",
  "user": {}
}
```

Copy the `access_token` value — you'll use this to authenticate further requests.

---

### 3. ✅ Authenticate Requests

In **Postman**, do the following:

* Go to the **Authorization** tab of any request.
* Set **Type** to `Bearer Token`.
* Paste your token into the **Token** field.

Alternatively, you can manually set the header:

```http
Authorization: Bearer your_token_here
```

---

Once authenticated, you can now access protected endpoints using the token. The Postman collection (`SLMP-Examination.postman_collection.json`) already includes this setup — just replace the token with yours under the Authorization tab.

Make sure to check the rest of the Postman collection for example payloads and responses.
