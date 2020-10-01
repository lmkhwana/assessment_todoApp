# Todolist App Frontend

## Project setup
```
git clone https://gitlab.com/lmkhwana/todo_app_frontend.git && cd todo_app_frontend
```

## Point to the backend server
### Create a .env file and enter the backend base url in this format
```
VUE_APP_BACKEND_URL=YOUR_BACKEND_URL
```

### Build the project
```
docker build -t todolistapp .
```

### Run the project
```
docker run -it -p 8080:80 --rm  todolistapp
```

