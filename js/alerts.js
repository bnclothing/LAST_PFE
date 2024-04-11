// Get all elements with class "alert"
var alertElements = document.querySelectorAll('.alert');

// Add a setTimeout for each alert to hide it after a 2-second delay
alertElements.forEach(function (alertElement) {
    setTimeout(function () {
        alertElement.classList.add('hidden');
        setTimeout(function () {
            alertElement.style.display = 'none';
        }, 1000);
    }, 2000);
    
});