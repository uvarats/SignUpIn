window.addEventListener('load', function () {
    let form = document.getElementById('signupForm');
    form.addEventListener('submit', submit);
});

async function submit(event) {
    event.preventDefault();
    let form = document.getElementById('signupForm');
    let formData = new FormData(form);
    axios.post('/signup/submit', formData).then(r => {
        console.log(r.data);
    });
}