document.addEventListener('DOMContentLoaded', function() {
    // Mostrar notificaciones de mantenimientos próximos
    mostrarNotificaciones();
    
    // Manejar el evento de completar mantenimiento
    document.querySelectorAll('.btn-completar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            confirmarCompletar(this);
        });
    });
    
    // Configurar los modales de edición
    configurarModalesEdicion();
    
    // Manejar el envío de formularios via AJAX
    configurarFormsAJAX();
    
    // Configurar la búsqueda
    document.getElementById('buscador').addEventListener('input', buscarMantenimientos);
});

/**
 * Muestra notificaciones de mantenimientos próximos
 */
function mostrarNotificaciones() {
    fetch('../controller/mantenimientoControlador.php?action=obtenerProximos')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const notificaciones = document.getElementById('notificaciones-mantenimiento');
                notificaciones.innerHTML = '';
                
                data.forEach(mantenimiento => {
                    const notif = document.createElement('div');
                    notif.className = `alert alert-${getAlertClass(mantenimiento.clase_estado)}`;
                    notif.innerHTML = `
                        <strong>${mantenimiento.nombre_consola}</strong> - 
                        Mantenimiento ${mantenimiento.tipo} programado para 
                        ${formatFecha(mantenimiento.fecha)}.
                        <button class="btn btn-sm btn-completar" 
                                data-id="${mantenimiento.id}">
                            Marcar como completado
                        </button>
                    `;
                    notificaciones.appendChild(notif);
                });
            }
        });
}

/**
 * Confirma antes de marcar un mantenimiento como completado
 */
function confirmarCompletar(btn) {
    const id = btn.getAttribute('data-id');
    
    Swal.fire({
        title: '¿Confirmar acción?',
        text: "¿Estás seguro de marcar este mantenimiento como completado?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, completar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            completarMantenimiento(id);
        }
    });
}

/**
 * Envía la solicitud para completar el mantenimiento
 */
function completarMantenimiento(id) {
    const formData = new FormData();
    formData.append('completar', true);
    formData.append('id', id);
    
    fetch('../controller/mantenimientoControlador.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 1500
            });
            // Actualizar la tabla después de 1.5 segundos
            setTimeout(() => location.reload(), 1500);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    });
}

/**
 * Configura los modales de edición
 */
function configurarModalesEdicion() {
    // Cuando se muestra un modal de edición, cargar los datos
    document.querySelectorAll('.edit-modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            
            fetch(`../controller/mantenimientoControlador.php?action=obtener&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    const modal = this;
                    modal.querySelector('input[name="id"]').value = data.id;
                    modal.querySelector('select[name="tipo"]').value = data.tipo;
                    modal.querySelector('input[name="descripcion"]').value = data.descripcion;
                    modal.querySelector('input[name="id_consola"]').value = data.id_consola;
                    modal.querySelector('input[name="fecha"]').value = data.fecha;
                });
        });
    });
}

/**
 * Configura el envío de formularios via AJAX
 */
function configurarFormsAJAX() {
    document.querySelectorAll('.ajax-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const action = this.getAttribute('action') || '../controller/mantenimientoControlador.php';
            const method = this.getAttribute('method') || 'POST';
            
            fetch(action, {
                method: method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Cerrar modales si están abiertos
                    bootstrap.Modal.getInstance(document.querySelector('.modal.show'))?.hide();
                    // Actualizar la tabla después de 1.5 segundos
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error inesperado'
                });
            });
        });
    });
}

/**
 * Realiza búsqueda de mantenimientos
 */
function buscarMantenimientos() {
    const termino = this.value.trim();
    const url = `../controller/mantenimientoControlador.php?action=buscar&termino=${encodeURIComponent(termino)}`;
    
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('tabla-mantenimientos').innerHTML = html;
            // Reconfigurar eventos en los nuevos botones
            document.querySelectorAll('.btn-completar').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    confirmarCompletar(this);
                });
            });
        });
}

/**
 * Determina la clase de alerta según el estado
 */
function getAlertClass(claseEstado) {
    const classes = {
        'completado': 'success',
        'programado': 'primary',
        'proximo': 'warning',
        'urgente': 'danger',
        'vencido': 'secondary'
    };
    return classes[claseEstado] || 'info';
}

/**
 * Formatea una fecha para mostrarla
 */
function formatFecha(fechaStr) {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fecha = new Date(fechaStr);
    return fecha.toLocaleDateString('es-ES', options);
}
