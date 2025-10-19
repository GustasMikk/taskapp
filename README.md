# How to start the project

1. **Download or copy** the project.

2. **Install composer** if not installed.

3. **Open Command Prompt** and cd into the project.

4. **Run this command** to copy .env file:
```
copy .env.example .env
```

5. **Create database** for the project and update these lines in .env according to you database:
```
DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=taskapp
# DB_USERNAME=root
# DB_PASSWORD= 
```

6. **Run migrations and seeders** to create tables and demo users:
```
php artisan migrate --seed
```
```
user1:
  username: example
  password: example
user2:
  username: example2
  password: example2
```

6. **Run the project** and open it in web browser http://127.0.0.1:8000:
```
php artisan serve
```

7. **Test registering endpoint:**
```
php artisan test
```


"# taskapp" 
