<!DOCTYPE html>
<html>
<head>
	<title>HCC_Poject</title>

	<!--Librerias Base-->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/Style.css">

	<!--API HERE -->



	<meta charset="utf-8">
</head>
<body>
	<header>
		<nav class="menuSuperior">
			<h1>Here comes the bus!</h1>
		</nav>
	</header>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="bannerPrincipal">
				<h1 class="textoBannerPrincipal">Este es el banner principal</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div id="contenedorSelectorRuta">
					<label class="label" for="cmbRuta">Selecciona la ruta</label>
					<select class="form-control" name="cmbRuta" id="cmbRuta">
						<option>Ruta 80</option>				
						<option>Ruta 57</option>
					</select>
				</div>
				<div id="contenedorSelectorCamion">
					<label class="label" for="cmbCamion">Selecciona Camión</label>
					<select class="form-control" name="cmbCamion" id="cmbCamion">
						<option>LE-1005</option>
						<option>LE-1006</option>
					</select>
				</div>
				<br/>
				<button class="btn btn-info" onclick="test()">Mostrar Fotografias</button>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				 <div style="width: 640px; height: 480px" id="mapContainer"></div>

			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	function test(){
		alert('test');
	}
</script>
</html>