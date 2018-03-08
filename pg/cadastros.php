<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<ol id="toca">
    <li><a href="#page-1"><span ><i class="icon-user"></i> Clientes</span></a></li>
    <li><a href="#page-2"><span class="iconfont grupo">Grupo de clientes</span></a></li>
</ol>
<div class="content2" id="page-1">
	<?php include "cadclientes.php";?>
</div>
<div class="content2" id="page-2">
<?php include "grupo.php";?>

</div>

<script src="js/activatables.js" type="text/javascript"></script>
<script type="text/javascript">
activatables('page', ['page-1', 'page-2']);
</script>
