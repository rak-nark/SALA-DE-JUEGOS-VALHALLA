<?php
    class venta{
					public $id;
					public $fecha;
					public $monto;
                    public $idPrestamo;
                    
					function agregar(){
						$conet = new Conexion();
						$c = $conet->conectando();
						// Usar consulta preparada para evitar inyección y no reflejar datos de usuario
						$query = "SELECT * FROM venta WHERE id = ?";
						$stmt = mysqli_prepare($c, $query);
						mysqli_stmt_bind_param($stmt, "s", $this->id);
						mysqli_stmt_execute($stmt);
						$ejecuta = mysqli_stmt_get_result($stmt);

						if(mysqli_fetch_array($ejecuta)){
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
									title: "Error al almacenar el registro",
									showConfirmButton: false,
									timer: 3000
								});</script>';
							}
							mysqli_stmt_close($stmt_insert);
						}
						mysqli_stmt_close($stmt);
					}
                    function modificar(){
                                    $c = new Conexion();
								    $cone = $c->conectando();
									$sql = "select * from venta where id = '$this->id'";
									$r = mysqli_query($cone,$sql);
									if(mysqli_fetch_array($r))
																{
																	echo '<script>	Swal.fire({
																		icon: "info",
																		title: "El Registro a Modificar ya Existe en el Sistema",
																		showConfirmButton: false,
																		timer: 3000
																	});</script>';
																}
																else
																	{
																	$id = "update venta set
																	    id = '$this->id',
																		fecha = '$this->fecha',
																		monto = '$this->monto',
                                                                        id_prestamo = '$this->id_prestamo',
                                                                        where id = '$this->id'";
																	mysqli_query($cone,$id);
																	echo $id;
																	echo '<script>	Swal.fire({
																		position: "top",
																		icon: "success",
																		title: "El Registro Fue Actualizado en el Sistema",
																		showConfirmButton: false,
																		timer: 3000
																	});</script>';				
																}
				}
                    
                    function eliminar(){
									try{   
									$c = new Conexion();
									$cone = $c->conectando();
									$sql= "delete from venta where id='$this->id'";
									mysqli_query($cone,$sql);
								    echo $sql;
									echo '<script>	Swal.fire({
										position: "top",
										icon: "success",
										title: "El Registro Fue Eliminado del Sistema",
										showConfirmButton: false,
										timer: 3000
									});</script>';
									}catch(Exception $e){
										echo'<script> Swal.fire({
											position: "top",
											icon: "warning",
											title: "El Registro no se Puede Eliminar Porqué Tiene venta Relacionados",
											showConfirmButton: false,
											timer: 3000
										});</script>';
									}
								}

								function obtenerVentasDiarias($fecha) {
									$sql = "SELECT * FROM ventas WHERE DATE(fecha) = ?";
									$stmt = $this->db->prepare($sql);
									$stmt->execute([$fecha]);
									return $stmt->fetchAll(PDO::FETCH_ASSOC);
								}

								function obtenerVentasMensuales($mes, $anio) {
									$sql = "SELECT * FROM ventas WHERE MONTH(fecha) = ? AND YEAR(fecha) = ?";
									$stmt = $this->db->prepare($sql);
									$stmt->execute([$mes, $anio]);
									return $stmt->fetchAll(PDO::FETCH_ASSOC);
								}

								function obtenerVentasSemestrales($semestre, $anio) {
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
