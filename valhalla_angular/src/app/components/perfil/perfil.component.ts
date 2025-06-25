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
  nombre: string = '';
  email: string = '';
  telefono: string = '';

  constructor(
    private router: Router,
    private http: HttpClient,
    private authService: AuthService
  ) {}

  guardarCambios() {
    // Lógica para guardar los cambios del perfil
    console.log('Guardando cambios...');
  }

  confirmarEliminarCuenta() {
    const confirmacion = confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');
    if (confirmacion) {
      this.eliminarCuenta();
    }
  }

  eliminarCuenta() {
    const userId = localStorage.getItem('userId'); // Obtener el ID del usuario
    if (userId) {
        this.http.delete(`http://127.0.0.1:8000/api/cliente/${userId}`)
            .subscribe({
                next: () => {
                    alert('Tu cuenta ha sido eliminada correctamente.');
                    this.authService.logout(); // Cerrar sesión
                    this.router.navigate(['/login']); // Redirigir al login
                },
                error: (err) => {
                    alert('Error al eliminar la cuenta. Por favor, intenta nuevamente.');
                    console.error(err);
                }
            });
    } else {
        alert('No se pudo obtener la información del usuario. Por favor, inicia sesión nuevamente.');
        this.router.navigate(['/login']);
    }
}
  logout(): void {
    this.authService.logout(); // Llama al método logout del servicio AuthService
  }
}

