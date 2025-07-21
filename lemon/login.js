/**
 * File: login.js
 * Author: Pan Zitao
 * Date: 2025-07-21
 * Description: Handles client-side login form submission, password encryption, and AJAX request.
 */

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');

    loginForm.addEventListener('submit', function(event) {
        // prevents page refresh
        event.preventDefault();

        // Get user input
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Encrypt the password with a simple Caesar cipher (shift right by 3)
        // This is a very basic encryption, for demonstration purposes only.
        // 'password' -> 'sdvvzrug'
        const shift = 3;
        let encryptedPassword = "";
        for (let i = 0; i < password.length; i++) {
            let charCode = password.charCodeAt(i);
            // Only encrypt letters
            if (charCode >= 97 && charCode <= 122) { // a-z
                charCode = ((charCode - 97 + shift) % 26) + 97;
            } else if (charCode >= 65 && charCode <= 90) { // A-Z
                charCode = ((charCode - 65 + shift) % 26) + 65;
            }
            encryptedPassword += String.fromCharCode(charCode);
        }

        // Use the fetch API to send data to the server
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username,
                password: encryptedPassword // Send the encrypted password
            })
        })
        .then(response => response.json())
        .then(data => {
            // Handle the server's response
            if (data.success) {

                // Login successful, redirect to the main page
                window.location.href = 'index.php';

            } else {

                // Login failed, display the error message
                errorMessage.textContent = data.message || 'Invalid username or password.';
            
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'An error occurred. Please try again.';
        });
    });
});