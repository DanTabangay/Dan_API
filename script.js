document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contact-form');
    const emailInput = document.getElementById('email'); // Corrected id
    const loadingOverlay = document.getElementById('loading-overlay');

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        if (emailInput.value.trim() === '') {
            alert('Please enter an email address.');
            return; // Stop form submission
        }

        // Show the loading overlay
        loadingOverlay.style.display = 'flex';

        // Collect form data
        const formData = new FormData(this);

        // Send form data to PHP script using Fetch API
        fetch('email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Hide the loading overlay
            loadingOverlay.style.display = 'none';

            // Check if the status is success
            if (data.status === 'success') {
                // If success, display an alert and redirect to contact.html
                alert(data.message);
                window.location.href = 'contact.html';
            } else {
                // If error, display an alert with the error message
                alert(data.message);
            }
        })
        .catch(error => {
            // Hide the loading overlay
            loadingOverlay.style.display = 'none';

            // If there's an error with the fetch request, display an alert
            alert('An error occurred while processing your request.');
            console.error('Error:', error);
        });
    });
});
