<table width="666" border="1" cellspacing="1" cellpadding="0">
						<?php
						 if(isset($_GET['arquivo'])){
                                        $file = $_GET['arquivo'];
                                        
                                        unlink("../../../../../php/".$file);
                                    
                                }
						
                          $path = "../../../../../php/";
                                   $diretorio = dir($path);
                                      
                                   while($arquivo = $diretorio -> read()){
                                       if($arquivo != "." && $arquivo != ".." && $arquivo != "backup.php"){
									    ?>
                                    <tr>
                                    <td><?php echo $arquivo ?></td>
                                    <td><a href="?arquivo=<?php echo $arquivo ?>">DEL</a></td>
                                  </tr>      
                                        
                                        <?php                                      
                                       }
                                      //echo "<a href='".$path.$arquivo."'>".$arquivo."</a><br />";
                                      
                                      
                                   }
                                   $diretorio -> close();
							?> 




</table>
