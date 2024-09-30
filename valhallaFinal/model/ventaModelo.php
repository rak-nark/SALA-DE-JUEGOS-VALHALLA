<?php
    class venta{
					public $id;
					public $fecha;
					public $monto;
                    public $idPrestamo;
                    
					function agregar(){
                                        $conet = new Conexion();
                                        $c = $conet->conectando();
                                        $query = "select * from venta where id = '$this->id'";
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
                                        $insertar = "insert into venta values(
																					'$this->id',
																					'$this->fecha',
																					'$this->monto',
                                                                                    '$this->id_prestamo'
																					
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
    }
                    
?>
