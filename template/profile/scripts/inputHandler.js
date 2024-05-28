const inputs = document.querySelectorAll('.input:not(dialog .input)');
const selects = document.querySelectorAll('.select');
const imageInput = document.querySelector('.profile-input');
const initialValues = {};

inputs.forEach((input) => {
    initialValues[input.name] = input.value;
    input.addEventListener('input', function() {
        onChange(input);
    });
});

selects.forEach((select) => {
    initialValues[select.name] = select.value;
});

imageInput.addEventListener('change', function() {
    onChange(imageInput);
});

function isModified(element = null) {
    let modified = false;
    if (element) {
        modified = element.value !== initialValues[element.name];
    } else {
        inputs.forEach((input) => {
            if (input.value !== initialValues[input.name]) {
                modified = true;
            }
        });
        selects.forEach((select) => {
            if (select.value !== initialValues[select.name]) {
                modified = true;
            }
        });
        if (imageInput.files.length > 0) {
            modified = true;
        }
    }
    return modified;
}

function onChange(element) {
    if (isModified(element)) {
        element.classList.add('modified');
    } else {
        element.classList.remove('modified');
    }
}