import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { LoginComponent } from './components/login/login.component';
import { PerfilComponent } from './components/perfil/perfil.component';
import { ReservaComponent } from './components/reserva/reserva.component';
import { SignupComponent } from './components/signup/signup.component';
import { authGuard } from './guards/auth.guard'; // 🔹 Importa el AuthGuard
import { MisReservasComponent } from './components/mis-reservas/mis-reservas.component';


const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' }, // Redirige al login por defecto
  { path: 'login', component: LoginComponent },
  { path: 'home', component: HomeComponent },
  { path: 'perfil', component: PerfilComponent, canActivate: [authGuard] }, // 🔹 Protege la ruta
  { path: 'reserva', component: ReservaComponent, canActivate: [authGuard] }, // 🔹 Protege la ruta
  { path: 'signup', component: SignupComponent },
  { path: 'mis-reservas', component: MisReservasComponent, canActivate: [authGuard] } 
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
  
})
export class AppRoutingModule { }


