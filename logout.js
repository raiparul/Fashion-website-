
document.getElementById('logout-form').addEventListener('submit', function(event) {
    if (!confirm('Are you sure you want to logout?')) {
        event.preventDefault(); // Prevent form submission if the user cancels
    }
});
