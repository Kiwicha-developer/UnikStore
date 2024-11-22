function viewUser(){
    let options = document.getElementById('options-user');
    options.style.display = 'block';
}

function hideUser(){
    let options = document.getElementById('options-user');
    options.style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('header-user-nav').addEventListener('mouseover',viewUser);
    document.getElementById('header-user-nav').addEventListener('mouseout',hideUser);

    document.getElementById('options-user').addEventListener('mouseover',viewUser);
    document.getElementById('options-user').addEventListener('mouseout',hideUser);

    disableReestablecer();
        

    document.getElementById('pass-modal-password').addEventListener('input', disableReestablecer);
    document.getElementById('confirmpass-modal-password').addEventListener('input', disableReestablecer);
});



function getIdPass(id,input){
    let inputHidden = document.getElementById(input);
    
    inputHidden.value = id;
}

function cancelarModal(){
    let pass = document.getElementById('pass-modal-password');
    let validatepass = document.getElementById('confirmpass-modal-password');
    let passError =  document.getElementById('passwordError');
    let confirmPasswordError =  document.getElementById('confirmPasswordError');
    
    pass.value = '';
    validatepass.value = '';
    passError.textContent = '';
    confirmPasswordError.textContent = '';
}

function validateModal() {
    let isValid = true;
    
    const pass = document.getElementById('pass-modal-password').value.trim();
    const validatepass = document.getElementById('confirmpass-modal-password').value.trim();
    const passError =  document.getElementById('passwordError');
    const confirmPasswordError =  document.getElementById('confirmPasswordError');
    
    let numberRegex = /[0-9]/;
    let caracterRegex = /(?=.*[\W_])/;
    
    if (pass == '') {
        isValid = false;
        passError.textContent = '';
    } else if (pass.length < 8) {
        isValid = false;
        passError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
    } else if (!numberRegex.test(pass)) {
        isValid = false;
        passError.textContent = 'La contraseña debe contener al menos un numero.';
    } else if (!caracterRegex.test(pass)) {
        isValid = false;
        passError.textContent = 'La contraseña debe contener al menos un carácter especial.';
    } else {
        passError.textContent = ''; // Limpiar mensaje de error si la contraseña es válida
    }
    
    if (validatepass == '') {
        isValid = false;
        confirmPasswordError.textContent = '';
    } else if (validatepass.length < 8) {
        isValid = false;
        confirmPasswordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
    } else if (!numberRegex.test(validatepass)) {
        isValid = false;
        confirmPasswordError.textContent = 'La contraseña debe contener al menos un numero.';
    } else if (!caracterRegex.test(validatepass)) {
        isValid = false;
        confirmPasswordError.textContent = 'La contraseña debe contener al menos un carácter especial.';
    } else if(validatepass != pass){
        confirmPasswordError.textContent = 'La contraseña no coincide';
    }else {
        confirmPasswordError.textContent = '';
    }
    
    return isValid;
}

function disableReestablecer() {
    let btnRes = document.getElementById('btn-reestablecer-modal-password');
    if (validateModal()) {
        btnRes.classList.remove('disabled');
    } else {
        btnRes.classList.add('disabled');
    }
}

tinymce.init({
    selector: '#text-bandeja', // Selector del campo de texto donde inicializamos TinyMCE
    plugins: 'lists link image', // Plugins que quieres habilitar
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | forecolor backcolor', // Barra de herramientas
    menubar: false, // Desactiva el menú
    height: 300, // Altura del editor
    width: '100%',
    content_style: "body { max-height: 100%; overflow-y: auto; }",
    resize: false,
    language: 'es',
    branding: false,
    statusbar: false
});