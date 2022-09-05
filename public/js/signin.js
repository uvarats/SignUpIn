window.addEventListener('load', function () {
    let submitBtn = document.getElementById('submitBtn');
    submitBtn.addEventListener('click', submit);
});

function submit(event) {
    event.preventDefault()
    clearErrors();

    let form = document.getElementById('signinForm');
    let formData = new FormData(form);

    axios.post('/signin/submit', formData)
        .then(function (response) {
            if (response.data.success) {
                location.replace("/");
            }
            if (response.data.errors) {
                Object.keys(response.data.errors).forEach(function (key) {
                    error(key, response.data.errors[key][0]);
                })
            }
        });
}