import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'] // ✅ Corrección aquí
})
export class HomeComponent {

  constructor(private router: Router, private authService: AuthService) {}

  logout() {      
    this.authService.logout();
    this.router.navigate(['/login']); // ✅ Redirigir al login después del logout
  }


 // Lista de imágenes
 images = [
  { src: '../../../assets/img/1.png', alt: 'Halo' },
  { src: '../../../assets/img/2.png', alt: 'Forza' },
  { src: '../../../assets/img/3.png', alt: 'Gears of War' },
  { src: '../../../assets/img/8.png', alt: 'Sea of Thieves' },
  { src: '../../../assets/img/5.png', alt: 'Ori' },
  { src: '../../../assets/img/6.png', alt: 'Cuphead' },
  { src: '../../../assets/img/7.png', alt: 'Fable' },
  { src: '../../../assets/img/9.png', alt: 'State of Decay' }
];

currentIndex = 0; 
private galleryWidth: number = 0; 

ngOnInit(): void {
  this.startAutoScroll();
}

// Función para mover las imagenes
startAutoScroll(): void {
  setInterval(() => {
      this.currentIndex = (this.currentIndex + 1) % this.images.length;
      this.scrollGallery();
  }, 3000); // Desplazamiento cada 3 segundos
}

// Función para desplazar la galería
scrollGallery(): void {
  const gallery = document.querySelector('.gallery') as HTMLElement;
  if (gallery) {
      const imageWidth = 600; // Ancho de cada imagen
      const gap = 8; // Espacio entre imágenes
      const offset = -this.currentIndex * (imageWidth + gap);

      // Si llegamos al final de la galería, reiniciamos sin animación
      if (this.currentIndex === this.images.length) {
          gallery.style.transition = 'none';
          gallery.style.transform = `translateX(0)`;
          this.currentIndex = 0;
          setTimeout(() => {
              gallery.style.transition = 'transform 0.5s ease-in-out';
              this.scrollGallery();
          }, 0);
      } else {
          gallery.style.transform = `translateX(${offset}px)`;
      }
  }
}
}

