// Get saved values from localStorage
const savedTextColor = localStorage.getItem('textColor');
const savedBgColor = localStorage.getItem('bgColor');
const savedBgImage = localStorage.getItem('bgImage');

// Apply saved values to the body
document.body.style.color = savedTextColor || 'initial';

// Apply saved text color to all <a> elements
document.querySelectorAll('a').forEach(a => {
    a.style.color = savedTextColor || 'initial';
});

if (savedBgImage) {
    document.body.style.backgroundImage = `url(${savedBgImage})`;
    document.body.style.backgroundSize = 'cover';
    document.body.style.backgroundPosition = 'center';
} else {
    document.body.style.backgroundColor = savedBgColor || 'initial';
}

// Check if lang exists in localStorage and log it
const savedLang = localStorage.getItem('lang');
console.log('Saved lang:', savedLang);