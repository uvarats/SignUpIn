window.addEventListener('load', function () {
    let form = document.getElementById('signupForm');
    form.addEventListener('submit', submit);
});

async function submit(event) {
    event.preventDefault();
    let form = document.getElementById('signupForm');
    let formData = new FormData(form);
    axios.post('/signup/submit', formData).then(r => {
        if (r.data.success) {
          location.replace('/signin');
        }
        if (r.data.errors) {
            let elements = document.getElementsByClassName('text-danger');
            if (elements.length > 0) {
                Object.values(elements).forEach(e => e.innerText = "")
            }

            Object.keys(r.data.errors).forEach(function (key) {
                let element = document.getElementById(key);
                let parent = element.closest('.form-floating');
                let div = parent.getElementsByClassName('text-danger')[0];
                if (div) {
                    div.innerText = r.data.errors[key][0];
                }
            });
        }
    });
}