<?php
    class prestamo{
					public $idPrestamo;
					public $fecha;
					public $hora;
					public $tiempodeuso;
					public $reserva;
					public $id_cliente;
					public $id_consola;
                    
					function agregar(){
                                        $conet = new Conexion();
                                        $c = $conet->conectando();
                                        $query = "select * from prestamo where idPrestamo = '$this->idPrestamo'";
                                        $ejecuta = mysqli_query($c, $query);
                                        if(mysqli_fetch_array($ejecuta)){
											echo '<script>	Swal.fire({
												position: "top",
												icon: "info",
												title: "El Registro ya Existe en el Sistema",
												showConfirmButton: false,
												timer: 3000
											});</script>';
                                        }else{
											
                                        $insertar = "insert into prestamo values(
																					'$this->idPrestamo',
																					'$this->fecha',
																					'$this->hora',
																					'$this->tiempodeuso',
																					'$this->reserva',
																					'$this->id_cliente',
																					'$this->id_consola'
                                        )";
                                        
                                        mysqli_query($c,$insertar);
                                        echo '<script>	Swal.fire({
											position: "top",
											icon: "success",
											title: "El Registro Fue Almacenado en el Sistema",
											showConfirmButton: false,
											timer: 3000
										});</script>';
                                            
                                        }
                    }
                    function modificar(){
                                    $c = new Conexion();
								    $cone = $c->conectando();
									$sql = "select * from prestamo where idPrestamo = '$this->idPrestamo'";
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
																	$id = "update prestamo set
																	    idPrestamo = '$this->idPrestamo',
																		fecha = '$this->fecha',
																		hora = '$this->hora',
																		tiempodeuso = '$this->tiempodeuso',
																		reserva = '$this->reserva',
																		id_consola = '$this->id_consola'
                                                                        where idPrestamo = '$this->idPrestamo'";
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
					$c = new Conexion();
					$cone = $c->conectando();
					
					mysqli_autocommit($cone, false); // Iniciar transacción
					
					try {
						// 1. Primero eliminar la venta relacionada
						$deleteVentaSql = "DELETE FROM venta WHERE id_prestamo = '$this->idPrestamo'";
						if (!mysqli_query($cone, $deleteVentaSql)) {
							throw new Exception("Error al eliminar venta relacionada: " . mysqli_error($cone));
						}
						
						// 2. Luego eliminar el préstamo
						$deletePrestamoSql = "DELETE FROM prestamo WHERE idPrestamo = '$this->idPrestamo'";
						if (!mysqli_query($cone, $deletePrestamoSql)) {
							throw new Exception("Error al eliminar préstamo: " . mysqli_error($cone));
						}
						
						// Verificar si realmente se eliminó algo
						if (mysqli_affected_rows($cone) == 0) {
							throw new Exception("No se encontró el préstamo con ID: " . $this->idPrestamo);
						}
						
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