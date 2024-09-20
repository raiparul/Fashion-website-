// signup.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(event) {
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const usertype = document.getElementById('usertype').value;
        
        // Simple client-side validation
        if (username === '' || email === '' || password === '' || !usertype) {
            alert('All fields are required.');
            event.preventDefault(); // Prevent form submission
            return;
        }
        
        // Validate email format
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            event.preventDefault(); // Prevent form submission
            return;
        }
        
        // Validate password strength (example: at least 8 characters)
        if (password.length < 8) {
            alert('Password must be at least 8 characters long.');
            event.preventDefault(); // Prevent form submission
            return;
        }
    });
});
