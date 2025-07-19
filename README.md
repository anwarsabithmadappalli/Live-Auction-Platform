# Laravel Project Setup Guide


## Requirements

- PHP >= 8.2  
- Node.js >= 18.x (LTS recommended)  
- NPM >= 9.x  
- Composer  
- MySQL or any compatible database  

## Installation Steps

1. **Clone the Repository**
   ```
   git clone <repository-url>
   cd <project-folder>
   ```
   

2. **Copy Environment File From '.env.example' to '.env'**

3. **Configure Database in .env**  
   Open the .env file and update the following lines with your database credentials:
   env
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   

4. **Install Dependencies**  
   ```
   composer install   
   ```
6. **Generate App Encryption Key**
   ```
   php artisan key:generate
   ```
   
7. **Run Migrations**
   ```
   php artisan migrate
   ```

8. **Seed the Database**
   This will create default users.
   ```
   php artisan db:seed
   ```
9. **Install Frontend Dependencies**
   ```
   npm install
   ```

10. **Start the Development Server**  
   ```
   php artisan serve
   npm run dev
   ```
   The application will be available at: [http://localhost:8000](http://localhost:8000)

11. **Process Queue**
   ```
   php artisan queue:work
   ```
## Default Login Credentials

### Admin
- *Email:* admin@example.com  
- *Password:* password

### Bidder
- *Email:* test@example.com  
- *Password:* password

## Points to Note

- Please ensure that the correct Pusher credentials are set in the .env file before the composer install performs.
