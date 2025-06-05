<?php
class prestamo {
					public $idPrestamo;
					public $fecha;
					public $hora;
					public $tiempodeuso;
					public $reserva;
					public $id_cliente;
					public $id_consola;

					public function agregar() {
						$conet = new Conexion();
						$c = $conet->conectando();
						// Consulta preparada para evitar inyección SQL
						$query = "SELECT * FROM prestamo WHERE idPrestamo = ?";
						$stmt = mysqli_prepare($c, $query);
						mysqli_stmt_bind_param($stmt, "s", $this->idPrestamo);
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
							// Consulta preparada para el insert
							$insertar = "INSERT INTO prestamo (idPrestamo, fecha, hora, tiempodeuso, reserva, id_cliente, id_consola) VALUES (?, ?, ?, ?, ?, ?, ?)";
							$stmt_insert = mysqli_prepare($c, $insertar);
							mysqli_stmt_bind_param(
								$stmt_insert,
								"sssssss",
								$this->idPrestamo,
								$this->fecha,
								$this->hora,
								$this->tiempodeuso,
								$this->reserva,
								$this->id_cliente,
								$this->id_consola
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
									title: "Error al almacenar el registro",
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
						// Consulta preparada para evitar inyección SQL (select)
						$query = "SELECT * FROM prestamo WHERE idPrestamo = ?";
						$stmt = mysqli_prepare($cone, $query);
						mysqli_stmt_bind_param($stmt, "s", $this->idPrestamo);
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
							// Consulta preparada para el update
							$update = "UPDATE prestamo SET 
								idPrestamo = ?, 
								fecha = ?, 
								hora = ?, 
								tiempodeuso = ?, 
								reserva = ?, 
								id_consola = ?
								WHERE idPrestamo = ?";
							$stmt_update = mysqli_prepare($cone, $update);
							mysqli_stmt_bind_param(
								$stmt_update,
								"sssssis",
								$this->idPrestamo,
								$this->fecha,
								$this->hora,
								$this->tiempodeuso,
								$this->reserva,
								$this->id_consola,
								$this->idPrestamo
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
					$c = new Conexion();
					$cone = $c->conectando();

					mysqli_autocommit($cone, false); // Iniciar transacción

					try {
						// 1. Primero eliminar la venta relacionada (consulta preparada)
						$deleteVentaSql = "DELETE FROM venta WHERE id_prestamo = ?";
						$stmtVenta = mysqli_prepare($cone, $deleteVentaSql);
						mysqli_stmt_bind_param($stmtVenta, "s", $this->idPrestamo);
						if (!mysqli_stmt_execute($stmtVenta)) {
							throw new Exception("Error al eliminar venta relacionada: " . mysqli_error($cone));
						}
						mysqli_stmt_close($stmtVenta);

						// 2. Luego eliminar el préstamo (consulta preparada)
						$deletePrestamoSql = "DELETE FROM prestamo WHERE idPrestamo = ?";
						$stmtPrestamo = mysqli_prepare($cone, $deletePrestamoSql);
						mysqli_stmt_bind_param($stmtPrestamo, "s", $this->idPrestamo);
						if (!mysqli_stmt_execute($stmtPrestamo)) {
							throw new Exception("Error al eliminar préstamo: " . mysqli_error($cone));
						}

						// Verificar si realmente se eliminó algo
						if (mysqli_stmt_affected_rows($stmtPrestamo) == 0) {
							throw new Exception("No se encontró el préstamo con ID: " . $this->idPrestamo);
						}
						mysqli_stmt_close($stmtPrestamo);

						mysqli_commit($cone); // Confirmar transacción

						echo '<script>Swal.fire({
							position: "top",
							icon: "success",
							title: "Préstamo y venta relacionada eliminados correctamente",
							showConfirmButton: false,
							timer: 3000
						});</script>';

					} catch(Exception $e) {
						mysqli_rollback($cone); // Revertir en caso de error
						echo '<script>Swal.fire({
							position: "top",
							icon: "error",
							title: "Error: ' . addslashes($e->getMessage()) . '",
							showConfirmButton: false,
							timer: 3000
						});</script>';
					} finally {
						mysqli_autocommit($cone, true); // Restaurar autocommit
					}
				}
			}
				?>