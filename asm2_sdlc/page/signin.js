document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('signin-form');
    const submitButton = document.getElementById('signin-button');
    const inputs = form.querySelectorAll('input');

    // Add event listener to submit button
    submitButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission
        
        // Validate inputs (Example: Check if email and password fields are not empty)
        let valid = true;
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                valid = false;
                input.classList.add('error'); // Add error class to invalid inputs
            } else {
                input.classList.remove('error'); // Remove error class from valid inputs
            }
        });

        if (valid) {
            // If inputs are valid, submit the form (you can add AJAX submission here)
            form.submit();
        }
    });
});
