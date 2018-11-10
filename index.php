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
	</header>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12" id="bannerPrincipal">
				<img src="img/HCTBBANER.svg" alt="Here comes the bus!" style="max-height: 100px">
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
				 <div id="mapContainer"></div>

			</div>
		</div>
	</div>
	<div class="overlayModal modalFotografias"></div>
	<div class="modalFotografias" id="contenedorModalFotografias"></div>
	<div id="pruebitas"></div>
</body>
<!--FUNCIONES-->
<script type="text/javascript">
	$(document).ready(function(){
		iniciarHiloMapa();
		cargarRutas();
		cargarCamiones(1);
		hiloCamion();

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
			var camion = $("#cmbCamion").val();
			if(camion == 0){
				alert('Selecciona un camión');
			}else{
				$(".modalFotografias").fadeIn();
				obtenerFotografias(camion);
			}
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
	function cargarUbicacionCamiones(map, ruta){
		$.ajax({url: "src/funciones.php",
			type: "POST",
			data: {"funcion": "cargarUbicacionCamiones", "ruta": ruta},
			success: function(result){			
        	var respuesta = result;
			var dato = respuesta.split('|');
			for(var x = 0; x < dato.length-1; x++){
				//alert(dato[x]);
				var latitud = dato[x].split(';')[1];
				var longitud = dato[x].split(';')[2];
				cargarMarca(map, latitud, longitud);
			}
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
				cadena += '<img src="file/'+dato[x]+'" class="fotoCamion">';
			}
			$('#contenedorModalFotografias').empty();
			$('#contenedorModalFotografias').append(cadena);
    	}});		
	}
	function actualizarPosicionCamion(camion, latitud, longitud){
		$.ajax({url: "src/funciones.php",
			type: "POST",
			data: {"funcion": "actualizarPosicionCamion", "camion": camion, "latitud": latitud, "longitud": longitud},
			success: function(result){			
    	}});		
	}

	var listaDir = [{latitud:21.06188,longitud:-101.57984},
					{latitud:21.06074,longitud:-101.58086},
					{latitud:21.05992,longitud:-101.58151},
					{latitud:21.0595,longitud:-101.58208},
					{latitud:21.06001,longitud:-101.58267},
					{latitud:21.06062,longitud:-101.58351},
					{latitud:21.06163,longitud:-101.58476},
					{latitud:21.06261,longitud:-101.58599},
					{latitud:21.06324,longitud:-101.58681},
					{latitud:21.06381,longitud:-101.58745},
					{latitud:21.0641,longitud:-101.58727},
					{latitud:21.06384,longitud:-101.58664},
					{latitud:21.06351,longitud:-101.58571},
					{latitud:21.06313,longitud:-101.58411},
					{latitud:21.06269,longitud:-101.58254},
					{latitud:21.0625,longitud:-101.58169},
					{latitud:21.06224,longitud:-101.58076},
					{latitud:21.06194,longitud:-101.57984}];

	var flag = 0;					
	function hiloCamion(){
		actualizarPosicionCamion(1,listaDir[flag]["latitud"], listaDir[flag]["longitud"]);
		flag = flag + 1;
		if(flag < listaDir.length){
			setTimeout("hiloCamion()",2500);
		}else{
			flag = 0;
			setTimeout("hiloCamion()",2500);
		}
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
$("#mapContainer").empty();
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
var ruta = $("#cmbRuta").val();
if(ruta != 0){
	cargarUbicacionCamiones(map, ruta);
}/*
var test = [{lat: 21.07390, long:-101.585796},{lat: 21.06390, long:-101.585796},{lat: 21.05390, long:-101.585796}];
	for(var x = 0; x<3; x++){
		cargarMarca(map, test[x]["lat"], test[x]["long"]);
	}*/
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

function iniciarHiloMapa(){
	cargarMapa();
	setTimeout("iniciarHiloMapa()",5000);
}

</script>
</html>