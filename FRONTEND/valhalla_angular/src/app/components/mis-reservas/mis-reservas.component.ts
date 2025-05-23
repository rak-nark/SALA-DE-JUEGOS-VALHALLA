import { Component, OnInit } from '@angular/core';
import { ReservaService } from '../../services/reserva.service';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-mis-reservas',
  templateUrl: './mis-reservas.component.html',
  styleUrls: ['./mis-reservas.component.css']
})
export class MisReservasComponent implements OnInit {
  reservas: any[] = []; // Todas las reservas obtenidas del servicio
  reservasFiltradas: any[] = []; // Reservas que se mostrarán en la tabla
  mostrarHistorialCompleto: boolean = false; // Controla si se muestra el historial completo
  reservaSeleccionada: any = {};
  fechaMinima: string = '';
  fechaMaxima: string = '';
  consolas = [
    { id: 1, nombre: 'Xbox 360 1' },
    { id: 2, nombre: 'Xbox 360 2' },
    { id: 3, nombre: 'Xbox 360 3' },
    { id: 4, nombre: 'Xbox 360 4' },
    { id: 5, nombre: 'Xbox 360 5' },
    { id: 6, nombre: 'Xbox 360 6' },
    { id: 7, nombre: 'Xbox 360 7' },
    { id: 8, nombre: 'Xbox 360 8' },
    { id: 9, nombre: 'Xbox One 1' },
    { id: 10, nombre: 'Xbox One 2' },
    { id: 11, nombre: 'Xbox One 3' },
    { id: 12, nombre: 'Xbox One 4' },
    { id: 13, nombre: 'Xbox One 5' }
  ];
  tiemposDisponibles = [
    { label: '30 minutos', value: 30 },
    { label: '1 hora', value: 60 },
    { label: '1 hora 30 minutos', value: 90 },
    { label: '2 horas', value: 120 },
    { label: '3 horas', value: 180 }
  ];
  constructor(
    private router: Router,
    private reservaService: ReservaService,
    private authService: AuthService
  ) {}
  ngOnInit(): void {
    this.definirFechasValidas();
    this.obtenerMisReservas();
  }
  
  definirFechasValidas(): void {
    const hoy = new Date();
    const fechaMax = new Date();
    fechaMax.setDate(hoy.getDate() + 2); // Máximo hasta 2 días después
  
    this.fechaMinima = hoy.toISOString().split('T')[0]; // Día de hoy
    this.fechaMaxima = fechaMax.toISOString().split('T')[0]; // Hasta dos días después
  }
  obtenerMisReservas(): void {
    this.reservaService.getMisReservas().subscribe(
      (data: any) => {
        // Ordenar las reservas por fecha
        this.reservas = data.sort((a: any, b: any) => {
          const fechaA = new Date(a.fecha).getTime();
          const fechaB = new Date(b.fecha).getTime();
          return fechaA - fechaB;
        });
        // Mostrar solo las reservas pendientes por defecto
        this.filtrarReservasPendientes();
      },
      (error) => {
        console.error('Error al obtener las reservas:', error);
        alert('No se pudieron obtener las reservas. Intente nuevamente.');
      }
    );
  }
   // Filtrar reservas pendientes (fecha igual o posterior a hoy)
   filtrarReservasPendientes(): void {
    const hoy = new Date().toISOString().split('T')[0]; // Fecha de hoy en formato YYYY-MM-DD
    this.reservasFiltradas = this.reservas.filter((reserva) => reserva.fecha >= hoy);
    this.mostrarHistorialCompleto = false; // Actualizar el estado
  }
  // Mostrar el historial completo de reservas
  mostrarHistorial(): void {
    this.reservasFiltradas = this.reservas; // Mostrar todas las reservas
    this.mostrarHistorialCompleto = true; // Actualizar el estado
  }
  // Alternar entre mostrar reservas pendientes y el historial completo
  alternarVista(): void {
    if (this.mostrarHistorialCompleto) {
      this.filtrarReservasPendientes(); // Mostrar solo reservas pendientes
    } else {
      this.mostrarHistorial(); // Mostrar el historial completo
    }
  }

  logout(): void {
    this.authService.logout();
    this.router.navigate(['/login']);
  }
  abrirModal(reserva: any): void {
    this.reservaSeleccionada = { ...reserva };
    // Formatear la hora antes de abrir el modal
    this.reservaSeleccionada.hora = this.formatHora(this.reservaSeleccionada.hora);
    const modal = document.getElementById('modalEditarReserva');
    if (modal) {
      modal.classList.add('show');
      modal.style.display = 'block';
    }
}
// Función para asegurarse de que la hora esté en formato HH:MM
formatHora(hora: string): string {
    if (!hora) return '';  // Si la hora no está definida, devolver vacío.
    const partes = hora.split(':');
    if (partes.length >= 2) {
        const horas = partes[0].padStart(2, '0');  // Asegurar dos dígitos
        const minutos = partes[1].padStart(2, '0');  
        return `${horas}:${minutos}`;
    }
    return hora;
}
  cerrarModal(): void {
    const modal = document.getElementById('modalEditarReserva');
    if (modal) {
      modal.classList.remove('show');
      modal.style.display = 'none';
    }
  }
  editarReserva(): void {
    const fechaInput = document.getElementById('fechaEditar') as HTMLInputElement;
    const horaInput = document.getElementById('horaEditar') as HTMLInputElement;
    const tiempoUsoSelect = document.getElementById('tiempoUsoEditar') as HTMLSelectElement;
    const consolaSelect = document.getElementById('consolaEditar') as HTMLSelectElement;
    if (!fechaInput || !horaInput || !tiempoUsoSelect || !consolaSelect) {
      console.error('No se encontraron algunos elementos del formulario.');
      return;
    }
    const fecha = fechaInput.value;
    let hora = horaInput.value;  // Capturar la hora
    const tiempodeuso = parseInt(tiempoUsoSelect.value, 10);
    const id_consola = parseInt(consolaSelect.value, 10);
    if (!fecha || !hora || isNaN(tiempodeuso) || isNaN(id_consola)) {
      alert('Todos los campos son obligatorios.');
      return;
    }
    const selectedDate = new Date(fecha);
    selectedDate.setHours(0, 0, 0, 0);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const maxDate = new Date(today);
    maxDate.setDate(today.getDate() + 2);
    if (selectedDate < today || selectedDate > maxDate) {
      alert('Solo puedes seleccionar la fecha de hoy, mañana o pasado mañana.');
      return;
    }
    // Formatear la hora antes de enviarla
    hora = this.formatHora(hora);
    const [hour, minute] = hora.split(':').map(Number);
    if (hour < 10 || hour > 20) {
      alert('Seleccione una hora entre las 10:00 AM y las 8:00 PM.');
      return;
    }
    const datosReserva = {
      fecha: fecha,
      hora: hora, // Hora en formato correcto
      tiempodeuso: tiempodeuso.toString(),
      reserva: true,
      id_cliente: this.reservaSeleccionada.id_cliente,
      id_consola: id_consola
    };
    console.log('Datos enviados:', datosReserva);  // Verificar en consola
    this.reservaService.editarReserva(this.reservaSeleccionada.idPrestamo, datosReserva).subscribe(
      (response) => {
        console.log('Reserva editada:', response);
        alert('Reserva editada correctamente.');
        this.obtenerMisReservas();
        this.cerrarModal();
      },
      (error) => {
        console.error('Error al editar la reserva:', error);
        console.log('Detalles del error:', error.error);
        alert(error.error?.message || 'Error al editar la reserva. Intenta nuevamente.');
      }
    );
}
formatHora12(hora: string): string {
  if (!hora) return ''; // Si la hora está vacía, devolver cadena vacía
  const partes = hora.split(':');
  if (partes.length < 2) return hora; // Validar formato
  let horas = parseInt(partes[0], 10);
  const minutos = partes[1].padStart(2, '0'); // Asegurar dos dígitos
  const periodo = horas >= 12 ? 'PM' : 'AM'; // Determinar AM o PM
  if (horas > 12) {
      horas -= 12; // Convertir a formato de 12 horas
  } else if (horas === 0) {
      horas = 12; // Convertir medianoche a 12 AM
  }
  return `${horas}:${minutos} ${periodo}`;
}
  eliminarReserva(idPrestamo: number): void {
    if (!idPrestamo || isNaN(idPrestamo)) {
      console.error('ID de préstamo no válido.');
      return;
    }
    if (confirm('¿Estás seguro de que deseas eliminar esta reserva?')) {
      this.reservaService.eliminarReserva(idPrestamo).subscribe(
        (response) => {
          console.log('Reserva eliminada:', response);
          this.obtenerMisReservas();
        },
        (error) => {
          if (error.status === 404) {
            alert('La reserva no fue encontrada.');
          } else if (error.status === 409) {
            alert(error.error.error); // Muestra mensaje de historial o venta ya registrada
          } else {
            console.error('Error al eliminar la reserva:', error);
          }
        }
      );
    }
  }
  convertirTiempoATexto(tiempo: number): string {
    const tiempoNumerico = Number(tiempo);
    const tiempoEncontrado = this.tiemposDisponibles.find(t => t.value === tiempoNumerico);
    if (tiempoEncontrado) {
      return tiempoEncontrado.label;
    }
    const horas = Math.floor(tiempoNumerico / 60);
    const minutos = tiempoNumerico % 60;
    let texto = '';
    if (horas > 0) {
      texto += `${horas} hora${horas > 1 ? 's' : ''}`;
    }
    if (minutos > 0) {
      if (texto !== '') texto += ' y ';
      texto += `${minutos} minuto${minutos > 1 ? 's' : ''}`;
    }
    return texto || 'Tiempo no definido';
  }
}
