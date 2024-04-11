var dropdown = document.getElementById("myDropdown");
var profileImg = document.getElementById("profile-img");

function showMenu() {
    dropdown.classList.toggle("show");

    if (dropdown.classList.contains("show")) {
        // Hover effect when the dropdown is open
        applyHoverStyles();
    } else {
        // Reset styles when the dropdown is hidden
        resetStyles();
    }
}

function applyHoverStyles() {
    profileImg.style.width = '50px';
    profileImg.style.height = '50px';
    profileImg.style.border = '2px solid rgba(79, 192, 210, 1)';
}

function resetStyles() {
    profileImg.style.width = '40px';
    profileImg.style.height = '40px';
    profileImg.style.border = '1px solid white';
}

profileImg.onmouseover = function () {
    // Apply hover styles only if the dropdown is closed
    if (!dropdown.classList.contains("show")) {
        applyHoverStyles();
    }
};

profileImg.onmouseout = function () {
    // Reset styles only if the dropdown is closed
    if (!dropdown.classList.contains("show")) {
        resetStyles();
    }
};

window.onclick = function (event) {
    if (!event.target.matches('#profile-img')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show') && !event.target.closest('.dropdown-content')) {
                openDropdown.classList.remove('show');
                resetStyles();
            }
        }
    }
};

