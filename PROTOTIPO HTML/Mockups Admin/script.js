document.addEventListener('DOMContentLoaded', () => {
    const botonCentro = document.getElementById('boton-centro');

    botonCentro.addEventListener('click', () => {
        if (botonCentro.classList.contains('verde')) {
            botonCentro.classList.remove('verde');
            botonCentro.classList.add('rojo');
            botonCentro.textContent = 'Offline';
        } else {
            botonCentro.classList.remove('rojo');
            botonCentro.classList.add('verde');
            botonCentro.textContent = 'Online';
        }
    });
});


    //Scritp del cajero//
function generarDatos() {
    const fecha = document.getElementById('fecha').value;
    if (fecha) {
        const dato1 = Math.floor(Math.random() * 30000);
        const dato2 = Math.floor(Math.random() * 500000).toFixed(2);
  
        document.getElementById('div1').innerText = `Ganancia De la Fecha Seleccionada (Fecha: ${fecha}): es ${dato1}`;
        document.getElementById('div2').innerText = `Ganancias Mensuales hasta el dia (Fecha: ${fecha}): es ${dato2}`;

    } else {
        alert("Por favor, ingrese una fecha.");
    }
}

    //script generalidades//
    document.addEventListener('DOMContentLoaded', function () {
        var botones = document.querySelectorAll('.boton-consola');
        var detalleFalla = document.getElementById('detalleFalla');
        var tipoFalla = document.getElementById('tipoFalla');
        var otroFalla = document.getElementById('otroFalla');
        
        botones.forEach(function (boton) {
            boton.addEventListener('click', function () {
                if (detalleFalla.style.display === 'none' || detalleFalla.style.display === '') {
                    detalleFalla.style.display = 'block';
                } else {
                    detalleFalla.style.display = 'none';
                }
            });
        });
    
        tipoFalla.addEventListener('change', function () {
            if (tipoFalla.value === 'otros') {
                otroFalla.style.display = 'block';
            } else {
                otroFalla.style.display = 'none';
            }
        });
    });
    

    //scrpit disponibilidad consolas//
    document.addEventListener('DOMContentLoaded', () => {
        const vt = document.getElementById('vt');
    
        vt.addEventListener('click', () => {
            if (vt.classList.contains('verde')) {
                vt.classList.add('rojo');
                vt.classList.remove('verde');
                C1.textContent = 'Disponible';
            } else {
                vt.classList.remove('rojo');
                vt.classList.add('verde');
                C1.textContent = 'Ocupado';
            }
        });
    });