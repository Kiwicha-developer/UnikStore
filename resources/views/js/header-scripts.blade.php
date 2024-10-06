function viewUser(){
    let options = document.getElementById('options-user');
    options.style.display = 'block';
}

function hideUser(){
    let options = document.getElementById('options-user');
    options.style.display = 'none';
}

document.getElementById('header-user-nav').addEventListener('mouseover',viewUser);
document.getElementById('header-user-nav').addEventListener('mouseout',hideUser);

document.getElementById('options-user').addEventListener('mouseover',viewUser);
document.getElementById('options-user').addEventListener('mouseout',hideUser);

