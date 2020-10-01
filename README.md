# assessment_todoApp

## Getting the Project
```
git clone https://github.com/lmkhwana/assessment_todoApp.git && cd assessment_todoApp
```

### Backend setup
```
- cd backend
- docker-compose up -d
- docker-compose exec app php artisan key:generate
- docker-compose exec app php artisan config:cache
```

### Database setup
Access the database and grant the 'luthando' user access
```
- cd backend
- docker-compose exec db bash
- mysql -u root -p  // run this command inside the container
- 56658378  // enter the password, this is strictly for this demo purpose.
            // on a real world app I wouldn't include passwords in plain text.
            // Once logged in execute the following commands:
            
- GRANT ALL ON todos.* TO 'luthando'@'%' IDENTIFIED BY '56658378';
- FLUSH PRIVILEGES;
- EXIT;

// It will take you back to the container, execute the following command to exit.
- exit

```

### Migrate data
```
- docker-compose exec app php artisan migrate
```

# Todo
```show frontend setup```
