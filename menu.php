<br/>
<ul>
   <li><a href='inicio.php?pg=inicio' class="iconfont inicio">Home</a></li>
   <?php if($_SESSION['id_usuario_session'] == 1) { ?>
   <li><a href='#' class="iconfont config">Configuracões</a>
     <ul>
         <li class='active'><a href='inicio.php?pg=configuracoes'>Meus Dados</a></li>
         <li class='active'><a href='inicio.php?pg=numero'>Nosso Número</a></li>
         <li class='active'><a href='inicio.php?pg=banco'>Configurar Bancos</a></li>
         <li class='active'><a href='inicio.php?pg=confboleto'>Configurar Boletos</a></li>
         <li class='active'><a href='inicio.php?pg=confmail'>Configurar Email</a></li>
      </ul>
   </li>
   <li class='last'><a href='#' class="iconfont clientes">Clientes</a>
       <ul>
         <li class='active'><a href='inicio.php?pg=grupo'><?php echo $config['grupo'] ?></a></li>
       	 <li class='active'><a href='inicio.php?pg=cadclientes'><?php echo $config['cadclientes'] ?></a></li>
         <li class='active'><a href='inicio.php?pg=listaclientes'><?php echo $config['listaclientes'] ?></a></li>
      </ul>
   </li>
  <?php } ?>
   <li class='last'><a href='#' class="iconfont fatura">Boletos</a>
	   <ul>
         <?php if($_SESSION['id_usuario_session'] == 1) { ?>
         <li class='active'><a href='inicio.php?pg=lancafatura'><?php echo $config['lfatura'] ?></a></li>
         <li class='active'><a href='inicio.php?pg=recarne'>Faturas em Grupo</a></li>
         <?php } ?>
         <li class='active'><a href='inicio.php?pg=fatpendente'><?php echo $config['pendentes'] ?></a></li>
         <li class='active'><a href='inicio.php?pg=fatvencida'><?php echo $config['vencidos'] ?></a></li>
         <li class='active'><a href='inicio.php?pg=fatbaixada'><?php echo $config['quitados'] ?></a></li>
      </ul>
   </li>
   <li class='active'><a href='inicio.php?pg=fluxo' class="iconfont fluxo">Fluxo de Caixa</a></li>
   <li class='last'><a href='php/sair.php' class="iconfont sair">Sair</a></li>
   </li>
</ul>
