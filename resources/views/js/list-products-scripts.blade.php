let clickPrices = false;
        function changePriceList(){
            let prices = document.querySelectorAll('.price-list-product');
            if(clickPrices){
                prices.forEach(function(x){
                    let preciesito = x.dataset.value;
                    x.textContent = '$' + preciesito;
                });
                clickPrices = false;
            }else{
                prices.forEach(function(x){
                    let preciesito = x.dataset.value;
                    x.textContent = 'S/.' + (preciesito * {{$tc}}).toFixed(2);
                });
                clickPrices = true;
            }
            
        }
    
        function mostrarImg(id) {
            var imgDiv = document.getElementById('img-' + id);
            imgDiv.style.display = 'block';
        }
    
        function ocultarImg(id) {
            var imgDiv = document.getElementById('img-' + id);
            imgDiv.style.display = 'none';
        }
        
        function copiarTexto(id) {
            let texto = document.getElementById('descripcion-' + id);

            texto.select();
            texto.setSelectionRange(0, 99999); // Para dispositivos móviles

            document.execCommand('copy');

            mostrarAlerta();
        }
        
        function mostrarAlerta() {
            var alertElement = document.getElementById('myAlert');
            alertElement.style.display = 'block';
            setTimeout(function() {
              alertElement.classList.remove('show');
              alertElement.classList.add('fade');
              setTimeout(function() {
                alertElement.style.display = 'none';
                alertElement.classList.remove('fade');
                alertElement.classList.add('show');
              }, 150); // Tiempo para la animación de desvanecimiento
            }, 3000);
          }
          
          function viewProductsList(state){
              let allLiProducts = document.querySelectorAll('.li-item-product-all');
              let liProducts = document.querySelectorAll('.li-item-product-' + state);
              allLiProducts.forEach(function(x){
                          x.style.display = 'none';
                      });
              
              if(state == 'TODOS'){
                  allLiProducts.forEach(function(x){
                      x.style.display = 'block';
                  });
              }
                  
                  liProducts.forEach(function(x){
                      x.style.display = 'block';
                  });
                  
              }
          