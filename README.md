# Microservices Sample Project

This is a sample project demonstrating a microservices architecture using different technologies for each service.

## Architecture

*   **Frontend**: HTML/JS (served via Nginx)
*   **API Gateway**: Node.js (Express)
*   **User Service**: Node.js + MongoDB
*   **Product Service**: Python (Flask) + PostgreSQL
*   **Order Service**: PHP (Slim) + MySQL

## Prerequisites

*   Docker
*   Docker Compose

## How to Run

1.  Clone the repository.
2.  Run the following command in the root directory:

    ```bash
    docker-compose up --build
    ```

3.  Open your browser and navigate to `http://localhost:3000`.

## Features to Test

1.  **Register/Login**: Use the User Service section to create an account and get a JWT token.
2.  **Manage Products**: Use the Product Service section to list and add new products.
3.  **Place Order**: Use the Order Service section to simulate buying a product (requires Login).

## Port Mapping

*   **Frontend**: 3000
*   **API Gateway**: 8080
*   **User Service**: 3001
*   **Product Service**: 5000
*   **Order Service**: 8000
