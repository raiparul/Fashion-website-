

document.addEventListener('DOMContentLoaded', function() {
    const logoutButton = document.querySelector('.btn-danger');

    
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            const confirmed = confirm('Are you sure you want to logout?');
            if (!confirmed) {
                event.preventDefault(); 
            }
        });
    }

   
});
