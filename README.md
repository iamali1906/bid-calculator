## Bit Calculator project setup using Symfony and Vuejs

## Backend Setup

To get the backend up and running, ensure that Symfony is installed on your system. Follow these steps:

1 - Navigate to the backend directory:

``cd backend``

2 - Install the required dependencies:

 ``composer install``

3- Start the Symfony server:

 ``symfony server:start``

The backend API will be accessible at ``http://localhost:8000``

## Running Backend Unit Tests

1- Navigate to the backend directory

``cd backend``

2- Run the PHPUnit tests:

 ``php bin/phpunit``


## Frontend 

To set up and run the frontend:

1- Navigate to the frontend directory:

``cd frontend``

2- Copy the environment configuration template

``cp .env.example .env``

3- Install the necessary dependencies

``npm install``

4- Run the development server

``npm run serve``

The frontend will now be available on http://localhost:8080 by default.


