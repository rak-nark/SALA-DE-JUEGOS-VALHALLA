<?php
    class consola{
					public $id;
					public $tipo;
					public $disponibilidad;
                    
					function agregar(){
                                        $conet = new Conexion();
                                        $c = $conet->conectando();
                                        $query = "select * from consola where id = '$this->id'";
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
                                        $insertar = "insert into consola values(
																					'$this->id',
																					'$this->tipo',
																					'$this->disponibilidad'
																					
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
									$sql = "select * from consola where id = '$this->id'";
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
																	$id = "update consola set
																	    id = '$this->id',
																		tipo = '$this->tipo',
																		disponibilidad = '$this->disponibilidad'
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
									$sql= "delete from consola where id='$this->id'";
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
											title: "El Registro no se Puede Eliminar Porqué Tiene consola Relacionados",
											showConfirmButton: false,
											timer: 3000
										});</script>';
									}
								}
    }
                    
?>