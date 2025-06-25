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
  reservas: any[] = [];
  reservaSeleccionada: any = null; // Para almacenar la reserva seleccionada para editar

  constructor(
    private router: Router,
    private reservaService: ReservaService,
    private authService: AuthService
  ) {}

  tiemposDisponibles = [
    { label: '30 minutos', value: 30 },
    { label: '1 hora', value: 60 },
    { label: '1 hora 30 minutos', value: 90 },
    { label: '2 horas', value: 120 },
    { label: '3 horas', value: 180 }
  ];

  ngOnInit(): void {
    this.obtenerMisReservas();
  }

  obtenerMisReservas(): void {
    this.reservaService.getMisReservas().subscribe(
      (data: any) => {
        this.reservas = data;
      },
      (error) => {
        console.error('Error al obtener las reservas:', error);
      }
    );
  }

  logout(): void {
    this.authService.logout();
    this.router.navigate(['/login']);
  }

  // Método para abrir el modal y cargar los datos de la reserva seleccionada
  abrirModal(reserva: any): void {
    this.reservaSeleccionada = reserva;
    const modal = document.getElementById('modalEditarReserva');
    if (modal) {
      modal.classList.add('show');
      modal.style.display = 'block';
    }
  }

  // Método para cerrar el modal
  cerrarModal(): void {
    const modal = document.getElementById('modalEditarReserva');
    if (modal) {
      modal.classList.remove('show');
      modal.style.display = 'none';
    }
  }

  // Método para editar la reserva
  editarReserva(): void {
    const datosReserva = {
      fecha: (document.getElementById('fechaEditar') as HTMLInputElement).value,
      hora: (document.getElementById('horaEditar') as HTMLInputElement).value,
      tiempodeuso: (document.getElementById('tiempoUsoEditar') as HTMLSelectElement).value,
      reserva: true,
      id_cliente: this.reservaSeleccionada.id_cliente,
      id_consola: (document.getElementById('consolaEditar') as HTMLSelectElement).value
    };

    this.reservaService.editarReserva(this.reservaSeleccionada.idPrestamo, datosReserva).subscribe(
      (response) => {
        console.log('Reserva editada:', response);
        this.obtenerMisReservas(); // Actualizar la lista de reservas
        this.cerrarModal(); // Cerrar el modal después de editar
      },
      (error) => {
        console.error('Error al editar la reserva:', error);
      }
    );
  }

  eliminarReserva(idPrestamo: number): void {
    if (confirm('¿Estás seguro de que deseas eliminar esta reserva?')) {
      this.reservaService.eliminarReserva(idPrestamo).subscribe(
        (response) => {
          console.log('Reserva eliminada:', response);
          this.obtenerMisReservas(); // Actualizar la lista de reservas
        },
        (error) => {
          console.error('Error al eliminar la reserva:', error);
        }
      );
    }
  }

  // Método para convertir el valor numérico a texto
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