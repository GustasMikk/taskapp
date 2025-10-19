# How to start the project

1. **Download or copy** the project.

2. **Open Command Prompt** and cd into the project:
```
cd to/project/
```

3. **Install composer** inside the project:
```
composer install
```

4. **Copy .env file**:
```
copy .env.example .env
```

5. **Generate key**:
```
php artisan key:generate
```

6. **Create database** and update these lines in .env according to your database:
```
DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=taskapp
# DB_USERNAME=root
# DB_PASSWORD= 
``` 

7. **Run migrations and seeders** to create tables and example users:
```
php artisan migrate --seed
//if encountering any errors try to change database name inside project's config/database.php under database you are using and try again
```


6. **Run the project** and open it in web browser http://127.0.0.1:8000:
```
php artisan serve
```

7. **Login with demo users** or register your own user:
```
user1:
  username: example
  password: example
user2:
  username: example2
  password: example2
```

8. **Test registering endpoint:**
```
php artisan test
```