RESTful API built with Laravel framework for the "Foxes / Knowledge" project.

## Starting the application with Docker

1. Run `cp .env.example .env` in the terminal to create environment file.
2. Run `docker-compose up -d --build` to create containers and start the application.
3. Run `docker exec -it foxes-knowledge-api sh` to enter Dockers' PHP console.
4. Now you are ready use the application:
    - Open `localhost:8000` in the browser to access the application.
    - Open `localhost:8080` in the browser to access Swagger API Documentation.

## Building for production with Docker

1. Run `cp .env.example .env` in the terminal to create environment file.
2. Database must be running and configured in `.env` file.
3. Run `docker build -f docker/Dockerfile --target production -t foxes-knowledge-api .` to build the application image.
4. Run `docker run -p 80:80 foxes-knowledge-api` to run the application
5. Open `localhost:8000` in the browser to access the application.
