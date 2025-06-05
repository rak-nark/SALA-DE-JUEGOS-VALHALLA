<?php 
include_once("../connection/conexion.php");
include_once("../controller/gananciasControlador.php");

//nav 
$activePage = 'ganancias';
include_once 'header.php';

$c = new conexion();
$cone = $c->conectando();

// Variables para las fechas (inicializadas por defecto como vacías)
$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
$ganancia_personalizada = 0;

// Validar que las fechas sean realmente fechas válidas (YYYY-MM-DD)
function es_fecha_valida($fecha) {
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha);
}

$fecha_inicio_valida = es_fecha_valida($fecha_inicio) ? $fecha_inicio : '';
$fecha_fin_valida = es_fecha_valida($fecha_fin) ? $fecha_fin : '';

// Calcular ganancias si se enviaron fechas válidas
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    !empty($fecha_inicio_valida) &&
    !empty($fecha_fin_valida)
) {
    $sql = "SELECT SUM(monto) AS total FROM venta WHERE fecha BETWEEN ? AND ?";
    $stmt = mysqli_prepare($cone, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $fecha_inicio_valida, $fecha_fin_valida);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_assoc($resultado);
    $ganancia_personalizada = $fila['total'] ?? 0;
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Ganancias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXhW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../configs/css/consola.css">
</head>
<body>
<div class="d-flex">
  <!-- Content -->
  <main class="container-fluid p-4 animate__animated animate__fadeIn">
    <div class="card shadow-lg rounded-4">
      <div class="card-header bg-success text-white d-flex flex-column flex-md-row justify-content-between align-items-center rounded-top-4">
        <div class="d-flex align-items-center mb-3 mb-md-0">
          <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" class="img-fluid" style="max-width: 100px;">
          <h4 class="ms-3 mb-0">Consulta de Ganancias</h4>
        </div>
        <form class="d-flex" method="post">
          <input class="form-control me-2" type="search" name="nombreCliente" id="idCliente" placeholder="Buscar por cliente" aria-label="Search">
          <button class="btn btn-outline-light" type="submit" name="buscar" id="buscar"><i class="fas fa-search me-2"></i>Buscar</button>
        </form>
      </div>

      <div class="card-body">
        <form method="POST" class="row g-3 align-items-end mb-4 animate__animated animate__fadeInUp">
          <div class="col-md-4">
            <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo htmlspecialchars($fecha_inicio_valida, ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="col-md-4">
            <label for="fecha_fin" class="form-label">Fecha Fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo htmlspecialchars($fecha_fin_valida, ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-success w-100"><i class="fas fa-chart-line me-2"></i>Consultar</button>
          </div>
        </form>

        <div class="table-responsive animate__animated animate__fadeIn">
          <table class="table table-striped table-hover rounded-3 overflow-hidden">
            <thead class="table-success">
              <tr>
                <th>Período</th>
                <th>Ingresos Estimados</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($fecha_inicio_valida) && !empty($fecha_fin_valida)): ?>
                <tr>
                  <td>
                    Desde <?php echo htmlspecialchars($fecha_inicio_valida, ENT_QUOTES, 'UTF-8'); ?> 
                    hasta <?php echo htmlspecialchars($fecha_fin_valida, ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td><span class="fw-bold text-success">$<?php echo number_format($ganancia_personalizada, 2); ?></span></td>
                </tr>
              <?php else: ?>
                <tr>
                  <td colspan="2" class="text-center">Seleccione un rango de fechas para ver las ganancias.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="mt-4">
          <a href="home.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Volver</a>
        </div>
      </div>
    </div>
  </main>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../configs/js/consola.js"></script>
</body>
</html>