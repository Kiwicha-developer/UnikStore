function loadProducts(url) {
    let loader = document.getElementById('hidden-loader-paginate');
    let containerValue = document.getElementById('hidden-container').value;
    let fullUrl = url + '&container=' + containerValue;

    if(loader){
        loader.style.display = 'block';
    }
    

    fetch(fullUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById(containerValue).innerHTML = data.html;
            loader.style.display = 'none';
        })
        .catch(error => console.error('Error al cargar los productos:', error));
}

function linkEvent(input){
    const url = input.dataset.link;

    loadProducts(url);
}