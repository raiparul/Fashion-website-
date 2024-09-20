// admin_dashboard.js

document.addEventListener('DOMContentLoaded', function() {
    // Dynamic greeting based on the time of day
    const greetingElement = document.querySelector('h1');
    const now = new Date();
    const hour = now.getHours();
    let greeting;

    if (hour < 12) {
        greeting = 'Good Morning, ';
    } else if (hour < 18) {
        greeting = 'Good Afternoon, ';
    } else {
        greeting = 'Good Evening, ';
    }

    const username = greetingElement.textContent.replace('Welcome, ', '');
    greetingElement.textContent = `${greeting}${username}`;

    // Confirm before navigating to different sections
    const listGroupItems = document.querySelectorAll('.list-group-item');

    listGroupItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            const confirmation = confirm("Are you sure you want to navigate to this section?");
            if (!confirmation) {
                event.preventDefault(); // Prevent navigation if not confirmed
            }
        });
    });

    // Confirm before logging out
    const logoutButton = document.querySelector('.btn-danger');

    logoutButton.addEventListener('click', function(event) {
        const confirmation = confirm("Are you sure you want to logout?");
        if (!confirmation) {
            event.preventDefault(); // Prevent logout if not confirmed
        }
    });
});
