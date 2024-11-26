
function validateForm() {
    let isValid = true;

    const user = document.getElementById('user').value.trim();
    const pass = document.getElementById('pass').value.trim();
    const confirmpass = document.getElementById('confirmpass').value.trim();

    const errorPass = document.getElementById('passwordError');
    let numberRegex = /[0-9]/;
    let caracterRegex = /(?=.*[\W_])/;

    if (user == '') {
        isValid = false;
    }

    if (pass == '') {
        isValid = false;
        errorPass.textContent = '';
    } else if (pass.length < 8) {
        isValid = false;
        errorPass.textContent = 'La contraseña debe tener al menos 8 caracteres.';
    } else if (!numberRegex.test(pass)) {
        isValid = false;
        errorPass.textContent = 'La contraseña debe contener al menos un numero.';
    } else if (!caracterRegex.test(pass)) {
        isValid = false;
        errorPass.textContent = 'La contraseña debe contener al menos un carácter especial.';
    } else {
        errorPass.textContent = ''; // Limpiar mensaje de error si la contraseña es válida
    }

    if (confirmpass == '') {
        isValid = false;
        confirmPasswordError.textContent = '';
    } else if (confirmpass.length < 8) {
        isValid = false;
        confirmPasswordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
    } else if (!numberRegex.test(confirmpass)) {
        isValid = false;
        confirmPasswordError.textContent = 'La contraseña debe contener al menos un numero.';
    } else if (!caracterRegex.test(confirmpass)) {
        isValid = false;
        confirmPasswordError.textContent = 'La contraseña debe contener al menos un carácter especial.';
    } else if (confirmpass != pass) {
        confirmPasswordError.textContent = 'La contraseña no coincide';
    } else {
        confirmPasswordError.textContent = '';
    }


    return isValid;
}

function disableButton() {
    let btnRegistrar = document.getElementById('btnRegistrar');
    if (validateForm()) {
        btnRegistrar.classList.remove('disabled');
    } else {
        btnRegistrar.classList.add('disabled');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    disableButton();

    document.getElementById('user').addEventListener('input', disableButton);
    document.getElementById('pass').addEventListener('input', disableButton);
    document.getElementById('confirmpass').addEventListener('input', disableButton);

});