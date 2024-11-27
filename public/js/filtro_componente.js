function filterSubmit() {
    const form = document.getElementById('form-filtro-componente');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    const baseUrl = form.action;
    const fullUrl = `${baseUrl}?${params}`;

    loadProducts(fullUrl);
}

document.querySelectorAll('.filtro-componente').forEach(function(x){
    x.addEventListener('change',filterSubmit);
});