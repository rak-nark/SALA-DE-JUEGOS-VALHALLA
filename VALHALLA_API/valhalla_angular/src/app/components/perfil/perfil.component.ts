import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { AuthService } from '../../services/auth.service';
@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.component.html',
  styleUrls: ['./perfil.component.css']
})
export class PerfilComponent {
  cliente: any = {
    nombreCliente: '',
    apellidoCliente: '',
    correoCliente: '',
    contrasenaCliente: ''
  };
  constructor(
    private router: Router,
    private http: HttpClient,
    private authService: AuthService
  ) {}
  guardarCambios(): void {
    const userId = localStorage.getItem('userId');
    if (userId) {
      // Crear un objeto con solo los campos modificados
      const datosActualizados: any = {};
      if (this.cliente.nombreCliente) {
        datosActualizados.nombreCliente = this.cliente.nombreCliente;
      }
      if (this.cliente.apellidoCliente) {
        datosActualizados.apellidoCliente = this.cliente.apellidoCliente;
      }
      if (this.cliente.correoCliente) {
        datosActualizados.correoCliente = this.cliente.correoCliente;
      }
      if (this.cliente.contrasenaCliente) {
        datosActualizados.contrasenaCliente = this.cliente.contrasenaCliente;
      }
  
      // Enviar la solicitud PUT
      this.http.put(`http://127.0.0.1:8000/api/cliente/${userId}`, datosActualizados).subscribe(
        (data) => {
          alert('Datos actualizados correctamente');
          console.log('Cambios realizados correctamente:', data);
          this.router.navigate(['/login'])// Mensaje en consola
        },
        (error) => {
          if (error.error && error.error.errors) {
            let mensajeError = 'Errores de validación:\n';
            for (const key in error.error.errors) {
              mensajeError += `- ${error.error.errors[key].join(', ')}\n`;
            }
            alert(mensajeError);
          } else {
            alert('Error al actualizar los datos. Por favor, intenta nuevamente.');
          }
          console.error('Error al actualizar los datos:', error); // Mensaje de error en consola
        }
      );
    } else {
      alert('No se pudo obtener la información del usuario. Por favor, inicia sesión nuevamente.');
      this.router.navigate(['/login']);
    }
  }
  confirmarEliminarCuenta(): void {
    if (confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')) {
      this.eliminarCuenta();
    }
  }
  eliminarCuenta(): void {
    const userId = localStorage.getItem('userId');
    if (userId) {
      this.http.delete(`http://127.0.0.1:8000/api/cliente/${userId}`).subscribe(
        () => {
          alert('Tu cuenta ha sido eliminada correctamente.');
          this.authService.logout(); // Cerrar sesión
          this.router.navigate(['/login']); // Redirigir al login
        },
        (error) => {
          alert('Error al eliminar la cuenta. Por favor, intenta nuevamente.');
          console.error(error);
        }
      );
    } else {
      alert('No se pudo obtener la información del usuario. Por favor, inicia sesión nuevamente.');
      this.router.navigate(['/login']);
    }
  }
  logout(): void {
    this.authService.logout(); // Llama al método logout del servicio AuthService
  }
}