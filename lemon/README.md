# Lemonade Guide - A Dynamic, Multi-Language Website

This project is a fully functional, database-driven website created as a guide for making lemonade. It demonstrates a range of web development skills including secure user authentication, session management, dynamic content loading from a database, and multi-language support.

---

## Core Features

*   **User Authentication (Login & Registration)**: Secure user login and registration system. Passwords are encrypted on the client-side before being sent to the server.
*   **AJAX-Powered Interactions**: Both user authentication and language switching are handled via AJAX (`fetch` API), providing a smoother user experience without full page reloads for form submissions.
*   **Session Management**: Users are automatically logged out after 15 minutes of inactivity to enhance security.
*   **Multi-language Support**: The content dynamically switches between English, Chinese (中文), and German (Deutsch). All text is fetched from a database.

## Technology Stack

*   **Frontend**: HTML5, CSS3, JavaScript (ES6)
*   **Backend**: PHP
*   **Database**: MySQL
*   **Development Environment**: XAMPP (or any similar stack with Apache, MySQL, and PHP)

## Security Measures

The primary security measure is the protection of user credentials.

1.  **Client-Side Encryption (Vigenère Cipher)**: To avoid sending plain-text passwords over the network, this project implements a Vigenère cipher.
    *   **Key**: The secret key used for encryption is `"lemon"`.
    *   **Coverage**: The cipher handles uppercase letters, lowercase letters, and numbers.

2.  **Server-Side Verification Process**:
    *   **Login**: The server receives an encrypted password. It fetches the user's plain-text password from the database, applies the *exact same* Vigenère encryption, and compares the two encrypted strings. The login is successful only if they match.
    *   **Registration**: The server receives an encrypted password. It first checks if the username is available. If so, it **decrypts** the password back to plain text before storing it in the database. This is necessary to maintain compatibility with the login system.

3.  **SQL Injection Prevention**: All database queries that involve user input use prepared statements (`mysqli::prepare`) to prevent SQL injection attacks.

## Setup and Installation

1.  **Set up Database**:
    *   Start your MySQL server.
    *   Create a new database named `lemon`.
    *   Create the `users` table:
        ```sql
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );
        ```
    *   Insert a sample user (the password is inplaintext in the DB):
        ```sql
        INSERT INTO users (username, password) VALUES ('testuser', 'password123');
        ```
    *   Create the `translations` table for the multi-language feature:
        ```sql
        CREATE TABLE translations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            page_key VARCHAR(50) NOT NULL,
            text_key VARCHAR(100) NOT NULL,
            en TEXT,
            zh TEXT,
            de TEXT,
            UNIQUE KEY unique_text_key (text_key)
        );
        ```
    *   Populate the `translations` table with the necessary text data for each page.

2.  **Configure Connection**:
    *   Open the `lemon/login.php` and `lemon/translations.php` files.
    *   Update the database connection details at the top of the files to match your environment (servername, username, password, port if not default).
        ```php
        $servername = "localhost:3307"; // Your server name and port
        $db_username = "root";          // Your DB username
        $db_password = "123456";        // Your DB password
        $dbname = "lemon";
        ```

3.  **Run the Project**:
    *   Place the `lemon` folder into your web server's root directory (e.g., `htdocs` in XAMPP).
    *   Open your web browser and navigate to `http://localhost/lemon/login.html`.

## File Structure

*   `login.html` / `register.html`: User authentication pages.
*   `login.js` / `register.js`: Client-side logic for authentication.
*   `login.php` / `register.php`: Server-side logic for authentication.
*   `language_switcher.js`: Handles the AJAX request for changing the language.
*   `switch_language.php`: The backend endpoint for the AJAX language switch.
*   `logout.php`: Destroys the session to log the user out.
*   `index.php`, `Ingredient.php`, `Instructions.php`, `Tips.php`, `Variations.php`, `Thanks.php`: The main content pages.
*   `translations.php`: A helper script to fetch text from the database.
*   `index.css`, `login.css`, etc.: Stylesheets for the project.
*   `lemonpics/`: Directory containing all image assets.
*   `README.md`: This file.
