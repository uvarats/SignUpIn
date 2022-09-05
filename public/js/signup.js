window.addEventListener('load', function () {
    let form = document.getElementById('signupForm');
    form.addEventListener('submit', submit);
});

async function submit(event) {
    event.preventDefault();
    clearErrors();

    let form = document.getElementById('signupForm');
    let formData = new FormData(form);
    if(formData.get('password') !== formData.get('passwordConfirmation')) {
        error('password', "Passwords doesn't match!");
        return;
    }

    axios.post('/signup/submit', formData).then(r => {
        if (r.data.success) {
          location.replace('/signin');
        }
        if (r.data.errors) {
            Object.keys(r.data.errors).forEach(function (key) {
                error(key, r.data.errors[key][0]);
            });
        }
    });
}

function error(field, message) {
    let element = document.getElementById(field);
    let div = element.querySelectorAll('.errors')[0];
    if (div) {
        div.innerText = message;
    }
}

function clearErrors() {
    let elements = document.querySelectorAll('.errors');
    if (elements.length > 0) {
        Object.values(elements).forEach(e => e.innerText = "")
    }
}