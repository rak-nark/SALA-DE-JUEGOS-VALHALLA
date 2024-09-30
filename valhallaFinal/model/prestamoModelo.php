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
                                        echo $insertar;
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
																		reserva = '$this->reserva'
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
									try{   
									$c = new Conexion();
									$cone = $c->conectando();
									$sql= "delete from prestamo where idPrestamo='$this->idPrestamo'";
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
											title: "El Registro no se Puede Eliminar Porqué Tiene prestamo Relacionados",
											showConfirmButton: false,
											timer: 3000
										});</script>';
									}
								}
    }
                    
?>