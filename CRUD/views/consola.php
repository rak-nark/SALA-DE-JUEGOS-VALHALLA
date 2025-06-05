<?php 
include_once ("../connection/conexion.php");
include_once ("../controller/consolaControlador.php");

//nav 
$activePage = 'consola';
include_once 'header.php';

$obj = new Consola();
$resultados = $obj->listar();
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../configs/css/consola.css">
</head>
<body>
<main class="container-fluid p-4">
  <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeIn">
    <div class="card-header bg-success text-white d-flex flex-column flex-md-row justify-content-between align-items-center py-4 px-4">
      <div class="d-flex align-items-center mb-3 mb-md-0">
        <img src="../configs/image/Imagen2-removebg-preview (1).png" alt="Logo" class="img-fluid" style="max-width: 100px;">
        <h4 class="ms-3 mb-0 fw-semibold">Gestión de Consolas</h4>
      </div>
      <form class="d-flex" method="post">
        <input class="form-control me-2 rounded-pill shadow-sm" type="search" name="busqueda" placeholder="Buscar por tipo" aria-label="Search">
        <button class="btn btn-outline-light rounded-pill" type="submit" name="buscar">Buscar</button>
      </form>
    </div>

    <div class="card-body bg-light rounded-bottom">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center animate__animated animate__fadeInUp">
          <thead class="table-success text-uppercase">
            <tr>
              <th>Código</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if($resultados && mysqli_num_rows($resultados) > 0): ?>
              <?php while($consola = mysqli_fetch_assoc($resultados)): ?>
                <tr>
                  <td><?php echo $consola['id']; ?></td>
                  <td><?php echo htmlspecialchars($consola['tipo']); ?></td>
                  <td>
                    <span class="badge rounded-pill px-3 py-2 fw-semibold 
                      <?php echo $consola['estado'] == 'disponible' ? 'bg-success' : 
                            ($consola['estado'] == 'no_disponible' ? 'bg-danger' : 'bg-warning'); ?>">
                      <?php echo ucfirst(str_replace('_', ' ', $consola['estado'])); ?>
                    </span>
                  </td>
                  <td>
                    <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $consola['id']; ?>">
                      <i class="fas fa-edit"></i> Editar
                    </button>
                  </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="editModal<?php echo $consola['id']; ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content rounded-4">
                      <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Editar Estado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form method="post">
                        <div class="modal-body">
                          <input type="hidden" name="id" value="<?php echo $consola['id']; ?>">
                          <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($consola['tipo']); ?>" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select" required>
                              <option value="disponible" <?= $consola['estado'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                              <option value="no_disponible" <?= $consola['estado'] == 'no_disponible' ? 'selected' : '' ?>>No Disponible</option>
                              <option value="mantenimiento" <?= $consola['estado'] == 'mantenimiento' ? 'selected' : '' ?>>En Mantenimiento</option>
                            </select>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="submit" name="modificar" class="btn btn-success">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center">No se encontraron consolas</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../configs/js/consola.js"></script>
</body>
</html>