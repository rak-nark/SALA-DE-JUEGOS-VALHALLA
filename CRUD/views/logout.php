<?php
session_start();
// Destruir todas las variables de sesión
session_unset();
// Destruir la sesión completamente
session_destroy();
// Mensaje para confirmar el cierre de sesión (puedes personalizar o redirigir de inmediato)
echo "<script>
        alert('Se cerró la sesión correctamente.');
        window.location.href = 'index.php';
      </script>";
?>
