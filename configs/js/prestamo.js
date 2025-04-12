// 1. Toggle del menú lateral
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');

menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
});

// 2. Función para ordenar la tabla
function ordenarTabla(n) {
    const table = document.querySelector(".table");
    let filas = Array.from(table.getElementsByTagName("TBODY")[0].getElementsByTagName("TR"));
    let dir = "asc"; // Dirección de ordenación (ascendente o descendente)

    // Ordenar las filas en función del contenido de la columna seleccionada
    filas.sort((a, b) => {
        let x = a.getElementsByTagName("TD")[n].innerText.toLowerCase();
        let y = b.getElementsByTagName("TD")[n].innerText.toLowerCase();

        // Si los valores son números, convertirlos antes de comparar
        if (!isNaN(x) && !isNaN(y)) {
            x = parseFloat(x);
            y = parseFloat(y);
        }

        // Comparar según la dirección de ordenación
        if (dir === "asc") {
            return x > y ? 1 : -1;
        } else {
            return x < y ? 1 : -1;
        }
    });

    // Alternar entre ascendente y descendente
    dir = dir === "asc" ? "desc" : "asc";

    // Eliminar las filas actuales y reinsertarlas ordenadas
    const tbody = table.getElementsByTagName("TBODY")[0];
    tbody.innerHTML = ""; // Limpiar el contenido actual
    filas.forEach(fila => tbody.appendChild(fila)); // Insertar filas ordenadas
}

// 3. Autocompletar fecha y hora actual
function autocompletarFechaHora() {
    const fechaActual = new Date();

    // Formatear la fecha en el formato YYYY-MM-DD (requerido por input type="date")
    const año = fechaActual.getFullYear();
    const mes = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11
    const dia = String(fechaActual.getDate()).padStart(2, '0');
    const fechaFormateada = `${año}-${mes}-${dia}`;

    // Formatear la hora en el formato HH:MM (requerido por input type="time")
    const horas = String(fechaActual.getHours()).padStart(2, '0');
    const minutos = String(fechaActual.getMinutes()).padStart(2, '0');
    const horaFormateada = `${horas}:${minutos}`;

    // Asignar la fecha y hora actual a los campos del formulario
    document.getElementById('fecha').value = fechaFormateada;
    document.getElementById('hora').value = horaFormateada;
}

// Ejecutar la función para autocompletar fecha y hora al cargar la página
autocompletarFechaHora();

