import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router, ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  form: FormGroup;
  constructor(
    private http: HttpClient,
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
    this.http.post<{ token: string, cliente: { idCliente: number } }>('http://127.0.0.1:8000/api/login', datos)
      .subscribe({
        next: (respuesta) => {
          console.log('Login exitoso:', respuesta);
          localStorage.setItem('token', respuesta.token);
          localStorage.setItem('userId', respuesta.cliente.idCliente.toString()); // 🔹 Guardar el userId
          // Obtener la URL de redirección desde los queryParams
          const returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/home';
          this.router.navigateByUrl(returnUrl); // 🔹 Redirigir a la URL guardada o a la página de home
        },
        error: (error) => {
          console.error('Error en el inicio de sesión:', error);
          alert(error.error.message || 'Correo o contraseña incorrectos.');
        },
      });
  }
}
