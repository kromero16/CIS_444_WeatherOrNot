Weather Forecast Web Application
Overview

This project is a web-based weather forecasting application with user authentication, enabling users to log in, update their account details, and view weather forecasts for different cities. The application is built following the Model-View-Controller (MVC) architecture, ensuring a clean separation of concerns between data handling, business logic, and user interface.

Features

    User registration and authentication.
    Ability to update account details (username and password).
    Weather forecast display for user-selected cities.
    Responsive design for various device sizes.

Getting Started
Prerequisites

    PHP 7.4 or higher.
    MySQL Database.
    Web server (e.g., Apache, Nginx).
    Composer (for dependency management).

Installation

    git clone https://github.com/kromero16/CIS_444_WeatherOrNot.git
    cd weather-forecast-app


Database Setup

To set up the database for this application, follow these steps:

  Log in to your MySQL server.
  
  Create a new database named WeatherOrNot_DB:

    CREATE DATABASE WeatherOrNot_DB;
    USE WeatherOrNot_DB;


Create the Users Table:

Execute the following SQL script to create a Users table:

    CREATE TABLE Users (
        UserID INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


This table will store user account information, including usernames and passwords.

Update Application Configuration:

    Ensure that the Configs/DB_Config.php file in the application is updated with the correct database credentials.

Configure Your Web Server:

    Point your web server to the public directory of the project.
    Ensure mod_rewrite is enabled for Apache to support clean URLs.

Install Dependencies:

    composer install
    
Adding Your RapidAPI Key

This application uses external APIs via RapidAPI to fetch weather data. To run the application successfully, you'll need to add your RapidAPI key to the script.js file.

Steps to Add Your RapidAPI Key:

Obtain a RapidAPI Key:
        If you don't already have a RapidAPI key, you can obtain one by signing up at RapidAPI.
        Once you have an account, generate a new API key.

Add the API Key to the Application:
        Open the script.js file located in the Scripts directory.
        Locate the API endpoint calls.
        Replace the placeholder in the API call headers with your actual RapidAPI key. For example:

    xhr.setRequestHeader('X-RapidAPI-Key', 'YOUR_RAPIDAPI_KEY_HERE');

Security Note:

Do Not Commit Your API Key: 

    Avoid committing your API key to public repositories for security reasons.
Future Updates:

        We plan to transition to Node.js in the future to enhance security by keeping the API key server-side and using environment variables to manage sensitive information.
        
        This change will prevent the exposure of the API key in the client-side code.


Usage

    Access the application through your web browser by navigating to the domain or IP address configured in your web server.
    Register as a new user or log in with existing credentials.
    Use the application to view weather forecasts and manage your account.

Architecture

This application follows the MVC pattern:

    Model: Handles data logic and database interactions.
    View: Presents data to the user in a user-friendly format.
    Controller: Acts as an intermediary between the Model and View, handling user inputs and application logic.

Contributing

Contributions to this project are welcome. Please follow these steps:

    Fork the repository.
    Create a new branch: git checkout -b feature-branch-name.
    Make your changes and commit them: git commit -am 'Add some feature'.
    Push to the original branch: git push origin feature-branch-name.
    Create a pull request.

License

This project is licensed under the MIT License.
Contact

    Kevin Romero-Zaldana - kromeroit@gmail.com
    Project Link: https://github.com/kromero16/CIS_444_WeatherOrNot
