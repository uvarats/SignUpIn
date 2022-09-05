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