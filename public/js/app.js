document.getElementById('form-update-bandeja').addEventListener('submit', function(event) {
    event.preventDefault();

    let form = document.getElementById('form-update-bandeja');
    let formData = new FormData(form);


    let loader = document.getElementById('modalBandeja-total-body');
    loader.style.display = 'flex';

    fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            loader.style.display = 'none';
        })
        .catch(error => {
            loader.style.display = 'none';
            console.log('Error: ' + error);
        });
});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

function hiddeInputDate(id){
    let inputDate = document.getElementById(id);
    inputDate.click();

}
