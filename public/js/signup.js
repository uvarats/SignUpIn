window.addEventListener('load', function () {
    let submitBtn = document.getElementById('submitBtn');
    submitBtn.addEventListener('click', submit);
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