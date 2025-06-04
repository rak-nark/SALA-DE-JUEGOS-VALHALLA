<?php

// Definir tarifas por tipo de consola
$tarifas = [
    '360' => [
        30 => 1500,
        60 => 2500,
        90 => 3000,
        120 => 5000,
        180 => 7500
    ],
    'one' => [
        30 => 1500,
        60 => 3000,
        90 => 3500,
        120 => 5500,
        180 => 8500
    ]
];

// Función para calcular ganancias en un rango de fechas
function calcular_ganancias($conexion, $fecha_inicio, $fecha_fin) {
    global $tarifas;
    
    // Usar consulta preparada para evitar inyección SQL
    $query = "
        SELECT p.tiempodeuso, c.tipo 
        FROM prestamo p
        JOIN consola c ON p.id_consola = c.id
        WHERE p.fecha BETWEEN ? AND ?
          AND p.reserva = 1 
    ";
    
    $stmt = mysqli_prepare($conexion, $query);
    if ($stmt === false) {
        // Manejar error
        return 0;
    }
    mysqli_stmt_bind_param($stmt, 'ss', $fecha_inicio, $fecha_fin);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $total = 0;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $tiempo = $fila['tiempodeuso'];
        $tipo_consola = $fila['tipo'];
        
        // Verificar si el tipo de consola y el tiempo de uso tienen una tarifa definida
        if (isset($tarifas[$tipo_consola][$tiempo])) {
            $total += $tarifas[$tipo_consola][$tiempo];
        }
    }
    mysqli_stmt_close($stmt);
    return $total;
}

// Obtener fechas del formulario
$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : date('Y-m-d');
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : date('Y-m-d');

$ganancia_personalizada = calcular_ganancias($conexion, $fecha_inicio, $fecha_fin);
?>