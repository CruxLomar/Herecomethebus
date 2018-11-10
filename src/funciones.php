<?php
	
	

	switch ($_POST["funcion"]) {
		case 'obtenerRutas':
			echo obtenerRutas();
			break;
		default:
		echo 'funcion no encontrada';
		break;

		case 'obtenerCamiones':
			echo obtenerCamiones($_POST["ruta"]);
		case 'obtenerFotografias':
			echo obtenerFotografias($_POST["camion"]);
			break;
		case 'actualizarPosicionCamion':
			echo actualizarPosicionCamion($_POST["camion"], $_POST["latitud"], $_POST["longitud"]);
			break;
		case 'cargarUbicacionCamiones':
			echo cargarUbicacionCamiones($_POST["ruta"]);
			break;
		break;
	}

	function obtenerRutas(){
		$server = 'localhost:3306';
	    $db =   'HarlemCC';
	    $user = 'root';
	    $pwd =  'root';
		$resp = '';
		try{
			$con = mysqli_connect($server,$user,$pwd,$db);
			$query = "SELECT * FROM Ruta";	
			$sql = mysqli_query($con, $query);
			$x = 0;
			while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
				$resp .= $row["idRuta"] . ";" . $row["NombreRuta"] . "|";
			}
			return $resp;
		}catch(Exception $e){
			return $e;	
		}
	}

	function obtenerCamiones($ruta){
		$server = 'localhost:3306';
	    $db =   'HarlemCC';
	    $user = 'root';
	    $pwd =  'root';
		$resp = '';
		try{
			$con = mysqli_connect($server,$user,$pwd,$db);
			$query = "SELECT idCamion, Matricula FROM camion where idRuta = $ruta and Estatus = 1";
			$sql = mysqli_query($con, $query);
			$x = 0;
			while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
				$resp .= $row["idCamion"] . ";" . $row["Matricula"] . "|";
			}
			return $resp;
		}catch(Exception $e){
			return $e;	
		}
	}

	function obtenerFotografias($camion){
		$server = 'localhost:3306';
	    $db =   'HarlemCC';
	    $user = 'root';
	    $pwd =  'root';
		$resp = '';
		try{
			$con = mysqli_connect($server,$user,$pwd,$db);
			$query = "SELECT Nombre from fotografia where idcamion = $camion  and Estatus = 1 order by hora desc";
			$sql = mysqli_query($con, $query);
			$x = 0;
			while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
				$resp .= $row["Nombre"] . "|";
			}
			return $resp;
		}catch(Exception $e){
			return $e;	
		}
	}

	function actualizarPosicionCamion($camion, $latitud, $longitud){
		$server = 'localhost:3306';
	    $db =   'HarlemCC';
	    $user = 'root';
	    $pwd =  'root';
		$resp = '';
		try{
			$con = mysqli_connect($server,$user,$pwd,$db);
			$query = "UPDATE camion set lat = $latitud, longi=$longitud where idcamion = $camion";
			$sql = mysqli_query($con, $query);
			return $resp;
		}catch(Exception $e){
			return $e;	
		}
	}

	function cargarUbicacionCamiones($ruta){
		$server = 'localhost:3306';
	    $db =   'HarlemCC';
	    $user = 'root';
	    $pwd =  'root';
		$resp = '';
		try{
			$con = mysqli_connect($server,$user,$pwd,$db);
			$query = "SELECT idCamion, lat, longi FROM camion where idRuta = $ruta and Estatus = 1 and lat <> 0";
			$sql = mysqli_query($con, $query);
			$x = 0;
			while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
				$resp .= $row["idCamion"] . ";" . $row["lat"] . ";" .$row["longi"] ."|";
			}
			return $resp;
		}catch(Exception $e){
			return $e;	
		}
	}
?>