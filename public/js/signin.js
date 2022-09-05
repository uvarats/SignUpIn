window.addEventListener('load', function () {
    let form = document.getElementById('signinForm');
    form.addEventListener('submit', submit);
});

function submit(event) {
    event.preventDefault()

    let form = document.getElementById('signinForm');
    let formData = new FormData(form);

    axios.post('/signin/submit', formData)
        .then(function (response) {
            console.log(response.data);
        });
}