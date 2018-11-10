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
	<meta name="viewport" content="initial-scale=1.0, width=device-width" />
	<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1533195059" />
	<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
	<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
	<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
	<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>


	<meta charset="utf-8">
</head>
<body>
	<header>
		<nav class="menuSuperior">
			<img src="img/HCTBBANER.svg" alt="why">
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
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" id="contenedorOpciones">
				<div id="contenedorSelectorRuta">
					<label class="label" for="cmbRuta">Selecciona la ruta</label>
					<select class="form-control" name="cmbRuta" id="cmbRuta">
						<option value="0">Selecciona Una Opción</option>
					</select>
				</div>
				<div id="contenedorSelectorCamion">
					<label class="label" for="cmbCamion">Selecciona Camión</label>
					<select class="form-control" name="cmbCamion" id="cmbCamion">
						
					</select>
					<br/>
					<button class="btn btn-primary" id="btnMostrarFotografias">Mostrar Fotografias</button>
				</div>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				 <div style="width: 640px; height: 480px" id="mapContainer"></div>

			</div>
		</div>
	</div>
	<div class="overlayModal modalFotografias"></div>
	<div class="modalFotografias" id="contenedorModalFotografias"></div>
</body>
<!--FUNCIONES-->
<script type="text/javascript">
	$(document).ready(function(){
		cargarMapa();
		cargarRutas();
		cargarCamiones(1);

		$("#cmbRuta").on("change", function(){
			var ruta = $(this).val();
			if(ruta == 0){
				$("#cmbCamion").empty();
				$("#contenedorSelectorCamion").fadeOut();
			}else{
				$("#cmbCamion").empty();
				cargarCamiones(ruta);
				$("#contenedorSelectorCamion").fadeIn();
			}
		});

		$(".overlayModal").on("click", function(){
			$(".modalFotografias").fadeOut();
		});

		$("#btnMostrarFotografias").on("click", function(){
			$(".modalFotografias").fadeIn();
		});
	});

	function cargarRutas(){
		$.ajax({url: "src/funciones.php",
			type: "POST",
			data: {"funcion": "obtenerRutas"},
			success: function(result){			
        	var respuesta = result;
			var dato = respuesta.split('|');
			var cadena = "";
			for(var x = 0; x < dato.length-1; x++){
				cadena += '<option value="'+dato[x].split(';')[0]+'">'+dato[x].split(';')[1]+'</option>';
			}
			$('#cmbRuta').append(cadena);
    	}});		
	}
	function cargarCamiones(ruta){
		$.ajax({url: "src/funciones.php",
			type: "POST",
			data: {"funcion": "obtenerCamiones", "ruta": ruta},
			success: function(result){			
        	var respuesta = result;
			var dato = respuesta.split('|');
			var cadena = '<option value="0">Selecciona Una Opción</option>';
			for(var x = 0; x < dato.length-1; x++){
				cadena += '<option value="'+dato[x].split(';')[0]+'">'+dato[x].split(';')[1]+'</option>';
			}
			$('#cmbCamion').append(cadena);
    	}});		
	}
	function obtenerFotografias(camion){
		$.ajax({url: "src/funciones.php",
			type: "POST",
			data: {"funcion": "obtenerFotografias", "camion": camion},
			success: function(result){			
        	var respuesta = result;
			var dato = respuesta.split('|');
			var cadena = '';
			for(var x = 0; x < dato.length-1; x++){
				cadena += '<option value="'+dato[x].split(';')[0]+'">'+dato[x].split(';')[1]+'</option>';
			}
			$('#contenedorModalFotografias').empty();
			$('#cmbCamion').append(cadena);
    	}});		
	}
</script>
<!--FUNCIONES MAPAS-->
<script  type="text/javascript" charset="UTF-8" >

function cargarMapa(){
var platform = new H.service.Platform({
  app_id: 'Hg1o8cYDxjZ6oqkVRUNQ',
  app_code: 'fW9v5D8_f3g2rlUxmQfYXg',
  useHTTPS: true
});
var pixelRatio = window.devicePixelRatio || 1;
var defaultLayers = platform.createDefaultLayers({
  tileSize: pixelRatio === 1 ? 256 : 512,
  ppi: pixelRatio === 1 ? undefined : 320
});

//Step 2: initialize a map  - not specificing a location will give a whole world view.
var map = new H.Map(document.getElementById('mapContainer'),
  defaultLayers.normal.map, {pixelRatio: pixelRatio});

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
var ui = H.ui.UI.createDefault(map, defaultLayers);

// Now use the map as required...
moverUTL(map);
var test = [{lat: 21.07390, long:-101.585796},{lat: 21.06390, long:-101.585796},{lat: 21.05390, long:-101.585796}];
	for(var x = 0; x<3; x++){
		cargarMarca(map, test[x]["lat"], test[x]["long"]);
	}
}

function cargarMarca(map, latitud, longitud){	
		var position = {lat:latitud, lng:longitud};
		marker = new H.map.Marker(position);
		map.addObject(marker);
}

function moverUTL(map){
	  map.setCenter({lat:21.06386, lng:-101.585796});
	  map.setZoom(14);
	}
</script>
</html>