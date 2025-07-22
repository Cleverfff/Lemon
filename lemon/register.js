/**
 * File: register.js
 * Author: Pan Zitao
 * Date: 2025-07-22
 * Description: Handles client-side registration, including password validation, encryption, and submission.
 */

document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('register-form');
    const errorMessage = document.getElementById('error-message');

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // --- Client-side validation ---
        if (!username || !password || !confirmPassword) {
            errorMessage.textContent = 'All fields are required.';
            return;
        }

        if (password !== confirmPassword) {
            errorMessage.textContent = 'Passwords do not match.';
            return;
        }

        // Encrypt the password with the Vigenère cipher using the key "lemon".
        const key = "lemon";
        let encryptedPassword = "";
        for (let i = 0; i < password.length; i++) {
            let pCharCode = password.charCodeAt(i);
            const kChar = key[i % key.length].toLowerCase();
            const shift = kChar.charCodeAt(0) - 'a'.charCodeAt(0);

            let cCharCode;
            if (pCharCode >= 97 && pCharCode <= 122) { // a-z
                cCharCode = ((pCharCode - 97 + shift) % 26) + 97;
            } else if (pCharCode >= 65 && pCharCode <= 90) { // A-Z
                cCharCode = ((pCharCode - 65 + shift) % 26) + 65;
            } else if (pCharCode >= 48 && pCharCode <= 57) { // 0-9
                cCharCode = ((pCharCode - 48 + shift) % 10) + 48;
            } else {
                cCharCode = pCharCode;
            }
            encryptedPassword += String.fromCharCode(cCharCode);
        }

        // Use the fetch API to send data to the server
        fetch('register.php', {
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
            if (data.success) {
                // Redirect to login page after successful registration
                alert('Registration successful! You can now log in.');
                window.location.href = 'login.html';
            } else {
                // Display error message from the server
                errorMessage.textContent = data.message || 'Registration failed. Please try again.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'An error occurred. Please try again.';
        });
    });
});