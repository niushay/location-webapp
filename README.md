# Navigation App API

# Table of Contents

- [Table of Contents](#table-of-contents)
- [Overview](#overview)
- [Features](#features)
- [Tools Used](#tools-used)
- [Requirements](#requirements)
- [Getting Started](#getting-started)
- [Testing](#testing)
- [Usage](#usage)
- [OpenAI Documentation](#openai-documentation)
- [License](#license)

## Overview

This project is a Location Management System designed for saving, editing, listing, routing, and viewing location details.

## Features

- **Save Locations**: Easily save new locations with details such as name, latitude, longitude, and additional information.

- **Edit Locations**: Update and modify existing location information as needed.

- **List Locations**: View a list of all saved locations with their details for quick reference.

- **View Location Details**: Retrieve and display detailed information for a specific location.

- **Route Locations**: Utilize the routing functionality to find the optimal path between multiple locations.

## Tools Used
This project is built using the following tools:

- **Laravel 10.10**

- **PHP 8.1**

- **Pest**

- **Swagger**

- **Sail**

- **Rate Limit**

## Requirements

Before you begin, ensure that you have the following prerequisites installed on your system:

- [Docker](https://www.docker.com/get-started)

## Getting Started

To set up and run the Location Management System, follow these steps:

1. Install dependencies with Docker:

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

2. Copy the environment file:

    ```bash
    cp .env.example .env
    ```

3. Create an alias for Laravel Sail:

    ```bash
    alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
    ```

4. Start the application with Laravel Sail:

    ```bash
    sail up
    ```

5. Run database migrations:

    ```bash
    sail php artisan migrate
    ```

## Testing

To run tests using PEST, execute the following command:

```bash
sail artisan test
 ```

## Usage
1. Access the application by navigating to http://localhost in your web browser.

2. Use the provided interface to save, edit, list, view details, and route locations.

## OpenAI Documentation
For additional documentation, including API details, refer to the following link:

http://localhost/api/documentation

Make sure the application is running before accessing the documentation.

## License
This project is licensed under the MIT License.
