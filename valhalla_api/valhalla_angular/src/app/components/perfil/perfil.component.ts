import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { AuthService } from '../../services/auth.service';
import { FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.component.html',
  styleUrls: ['./perfil.component.css']
})
export class PerfilComponent implements OnInit {
  form: FormGroup;

  constructor(
    private fb: FormBuilder,
    private router: Router,
    private http: HttpClient,
    private authService: AuthService
  ) {
    this.form = this.fb.group({
      nombreCliente: [''],
      apellidoCliente: [''],
      correoCliente: [''],
      contrasenaCliente: ['']
    });
  }

  ngOnInit() {
    const userId = localStorage.getItem('userId');
    if (userId) {
      this.http.get(`http://127.0.0.1:8000/api/cliente/${userId}`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      }).subscribe({
        next: (data: any) => {
          this.form.patchValue(data);
        },
        error: (err) => {
          console.error('Error al cargar el perfil:', err);
          alert('Error al cargar el perfil. Inténtalo nuevamente.');
        }
      });
    } else {
      alert('No se pudo obtener la información del usuario. Inicia sesión nuevamente.');
      this.router.navigate(['/login']);
    }
  }

  modificar() {
    if (this.form.valid) {
      const confirmacion = confirm('¿Estás seguro de que deseas guardar los cambios?');
      if (confirmacion) {
        const userId = localStorage.getItem('userId');
        if (userId) {
          const datos = this.form.value;
          this.http.put(`http://127.0.0.1:8000/api/cliente/${userId}`, datos, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          }).subscribe({
            next: (respuesta) => {
              console.log('Datos modificados con éxito:', respuesta);
              alert('Perfil actualizado correctamente.');
            },
            error: (err) => {
              console.error('Error al modificar los datos:', err);
              alert('Error al actualizar el perfil.');
            },
          });
        } else {
          alert('No se pudo obtener la información del usuario. Inicia sesión nuevamente.');
          this.router.navigate(['/login']);
        }
      }
    } else {
      console.error('El formulario no es válido.');
    }
  }

  confirmarEliminarCuenta() {
    const confirmacion = confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer y se perderán todos tus datos.');
    if (confirmacion) {
      this.eliminarCuenta();
    }
  }

  eliminarCuenta() {
    const userId = localStorage.getItem('userId');
    if (userId) {
      this.http.delete(`http://127.0.0.1:8000/api/cliente/${userId}`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      }).subscribe({
        next: () => {
          alert('Tu cuenta ha sido eliminada correctamente.');
          this.authService.logout();
          this.router.navigate(['/login']);
        },
        error: (err) => {
          alert('Error al eliminar la cuenta. Inténtalo nuevamente.');
          console.error(err);
        }
      });
    } else {
      alert('No se pudo obtener la información del usuario. Inicia sesión nuevamente.');
      this.router.navigate(['/login']);
    }
  }

  logout(): void {
    this.authService.logout();
  }
}