<?php
    class venta{
					public $id;
					public $fecha;
					public $monto;
                    public $idPrestamo;
                    

								public function agregar() {
									$conet = new Conexion();
									$c = $conet->conectando();

									// Consulta preparada para evitar inyección SQL
									$query = "SELECT * FROM venta WHERE id = ?";
									$stmt = mysqli_prepare($c, $query);
									mysqli_stmt_bind_param($stmt, "s", $this->id);
									mysqli_stmt_execute($stmt);
									$ejecuta = mysqli_stmt_get_result($stmt);

									if (mysqli_fetch_array($ejecuta)) {
										echo '<script>Swal.fire({
											position: "top",
											icon: "info",
											title: "El Registro ya Existe en el Sistema",
											showConfirmButton: false,
											timer: 3000
										});</script>';
									} else {
										$insertar = "INSERT INTO venta (id, fecha, monto, id_prestamo) VALUES (?, ?, ?, ?)";
										$stmt_insert = mysqli_prepare($c, $insertar);
										mysqli_stmt_bind_param(
											$stmt_insert,
											"ssss",
											$this->id,
											$this->fecha,
											$this->monto,
											$this->id_prestamo
										);
										if (mysqli_stmt_execute($stmt_insert)) {
											echo '<script>Swal.fire({
												position: "top",
												icon: "success",
												title: "El Registro Fue Almacenado en el Sistema",
												showConfirmButton: false,
												timer: 3000
											});</script>';
										} else {
											echo '<script>Swal.fire({
												position: "top",
												icon: "error",
												title: "Error al guardar el registro",
												showConfirmButton: false,
												timer: 3000
											});</script>';
										}
										mysqli_stmt_close($stmt_insert);
									}
									mysqli_stmt_close($stmt);
								}

								public function modificar() {
									$c = new Conexion();
									$cone = $c->conectando();

									// Consulta preparada para evitar inyección SQL
									$sql = "SELECT * FROM venta WHERE id = ?";
									$stmt = mysqli_prepare($cone, $sql);
									mysqli_stmt_bind_param($stmt, "s", $this->id);
									mysqli_stmt_execute($stmt);
									$r = mysqli_stmt_get_result($stmt);

									if (mysqli_fetch_array($r)) {
										echo '<script>Swal.fire({
											icon: "info",
											title: "El Registro a Modificar ya Existe en el Sistema",
											showConfirmButton: false,
											timer: 3000
										});</script>';
									} else {
										// Consulta preparada para update
										$update = "UPDATE venta SET id = ?, fecha = ?, monto = ?, id_prestamo = ? WHERE id = ?";
										$stmt_update = mysqli_prepare($cone, $update);
										mysqli_stmt_bind_param(
											$stmt_update,
											"sssss",
											$this->id,
											$this->fecha,
											$this->monto,
											$this->id_prestamo,
											$this->id
										);
										if (mysqli_stmt_execute($stmt_update)) {
											echo '<script>Swal.fire({
												position: "top",
												icon: "success",
												title: "El Registro Fue Actualizado en el Sistema",
												showConfirmButton: false,
												timer: 3000
											});</script>';
										} else {
											echo '<script>Swal.fire({
												position: "top",
												icon: "error",
												title: "Error al actualizar el registro",
												showConfirmButton: false,
												timer: 3000
											});</script>';
										}
										mysqli_stmt_close($stmt_update);
									}
									mysqli_stmt_close($stmt);
								}

								public function eliminar(){
								try {   
									$c = new Conexion();
									$cone = $c->conectando();
									// Consulta preparada para evitar inyección SQL
									$sql = "DELETE FROM venta WHERE id = ?";
									$stmt = mysqli_prepare($cone, $sql);
									mysqli_stmt_bind_param($stmt, "s", $this->id);
									if (mysqli_stmt_execute($stmt)) {
										echo '<script>Swal.fire({
											position: "top",
											icon: "success",
											title: "El Registro Fue Eliminado del Sistema",
											showConfirmButton: false,
											timer: 3000
										});</script>';
									} else {
										echo '<script>Swal.fire({
											position: "top",
											icon: "error",
											title: "Error al eliminar el registro",
											showConfirmButton: false,
											timer: 3000
										});</script>';
									}
									mysqli_stmt_close($stmt);
								} catch(Exception $e){
									echo '<script> Swal.fire({
										position: "top",
										icon: "warning",
										title: "El Registro no se Puede Eliminar Porqué Tiene venta Relacionados",
										showConfirmButton: false,
										timer: 3000
									});</script>';
								}
							}


								public function obtenerVentasDiarias($fecha) {
									$sql = "SELECT * FROM ventas WHERE DATE(fecha) = ?";
									$stmt = $this->db->prepare($sql);
									$stmt->execute([$fecha]);
									return $stmt->fetchAll(PDO::FETCH_ASSOC);
								}

								public function obtenerVentasMensuales($mes, $anio) {
									$sql = "SELECT * FROM ventas WHERE MONTH(fecha) = ? AND YEAR(fecha) = ?";
									$stmt = $this->db->prepare($sql);
									$stmt->execute([$mes, $anio]);
									return $stmt->fetchAll(PDO::FETCH_ASSOC);
								}

								public function obtenerVentasSemestrales($semestre, $anio) {
									$rango = ($semestre == 1) ? [1, 6] : [7, 12];
									$sql = "SELECT * FROM ventas WHERE MONTH(fecha) BETWEEN ? AND ? AND YEAR(fecha) = ?";
									$stmt = $this->db->prepare($sql);
									$stmt->execute([$rango[0], $rango[1], $anio]);
									return $stmt->fetchAll(PDO::FETCH_ASSOC);
								}

								public function obtenerVentasAnuales($anio) {
									$sql = "SELECT * FROM ventas WHERE YEAR(fecha) = ?";
									$stmt = $this->db->prepare($sql);
									$stmt->execute([$anio]);
									return $stmt->fetchAll(PDO::FETCH_ASSOC);
								}
    }
                    
?>
