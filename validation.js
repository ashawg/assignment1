
document.addEventListener('submit', function(event) {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    
    if (username.length < 3 || password.length < 8) {
        alert('Username must be at least 3 characters and password must be at least 8 characters.');
        event.preventDefault();
    }
});
