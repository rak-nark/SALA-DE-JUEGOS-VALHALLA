import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { AuthService } from '../../services/auth.service'; 

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  form: FormGroup;
  constructor(
    private authService: AuthService,
    private router: Router,
    private route: ActivatedRoute // 🔹 Para obtener la URL de redirección
  ) {
    this.form = new FormGroup({
      correoCliente: new FormControl('', [Validators.required, Validators.email]),
      contrasenaCliente: new FormControl('', [Validators.required, Validators.minLength(8)])
    });
  }
login() {
    if (this.form.invalid) {
      alert('Por favor, complete todos los campos correctamente.');
      return;
    }
    const datos = this.form.value;
    this.authService.login(datos).subscribe({
      next: (respuesta) => {
        // El AuthService ya guarda el token y el userId
        const returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/home';
        this.router.navigateByUrl(returnUrl);
      },
      error: (error) => {
        console.error('Error en el inicio de sesión:', error);
        alert(error.error.message || 'Correo o contraseña incorrectos.');
      },
    });
  }
}
