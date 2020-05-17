var botonAbrir = document.getElementById('subirCapa'),
    overlay= document.getElementById('overlay'),
    popup =document.getElementById('popup');
    botonCerrar =document.getElementById('btn-cerrar-popup');
    botonEnviar = document.getElementById('boton-enviar');



botonAbrir.addEventListener('click', function(){
    overlay.classList.add('active');
    popup.classList.add('active');
})

botonCerrar.addEventListener('click', function(){
    overlay.classList.remove('active');
    popup.classList.remove('active');
})


/*
function cargando(){
    document.getElementById('respuesta').innerHTML = 'Subiendo';
} 


botonEnviar.addEventListener('click',function(){
    cargando();
})*/