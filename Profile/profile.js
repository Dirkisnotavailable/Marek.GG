// Zmen krajinu bez refreshu

document.getElementById('changeemail').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('emailForm').style.display = 'block';
});

document.getElementById('changecountry').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('.countryform').style.display = 'block';
});

document.getElementById('email-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    fetch('/Testik/Profile/changeemail.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.text();
    })
    .then(data => {
        alert('Email changed successfully!');
        document.querySelector('.info').innerHTML = 'Email: ' + document.getElementById('new-email').value;
        document.getElementById('emailForm').style.display = 'none';
    })
    .catch(error => {
        alert(error.message);
        console.error('Error:', error);
    });
});

document.getElementById('country-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    fetch('/Testik/Profile/changecountry.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.text();
    })
    .then(data => {
        alert('Country changed successfully!');
        document.querySelector('.info2').innerHTML = 'Country: ' + document.getElementById('new-country').value;
        document.querySelector('.countryform').style.display = 'none';
    })
    .catch(error => {
        alert(error.message);
        console.error('Error:', error);
    });
});

document.addEventListener('click', function(event) {
    var emailForm = document.getElementById('emailForm');
    var countryForm = document.querySelector('.countryform');
    if (!emailForm.contains(event.target) && event.target.id !== 'changeemail') {
        emailForm.style.display = 'none';
    }
    if (!countryForm.contains(event.target) && event.target.id !== 'changecountry') {
        countryForm.style.display = 'none';
    }
});
