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
		case 'actualizarStatusFotografia':
			echo actualizarStatusFotografia($_POST["foto"]);
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

	function actualizarStatusFotografia($foto){
		$server = 'localhost:3306';
	    $db =   'HarlemCC';
	    $user = 'root';
	    $pwd =  'root';
		$resp = '';
		try{
			$con = mysqli_connect($server,$user,$pwd,$db);
			$query = "UPDATE fotografia set Estatus = 0 where idCamion = 1";
			switch ($foto) {
				case '1':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (1,18,17,16,15,14,13,12,11,10)";
					break;
				case '2':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (2,17,16,15,14,13,12,11,10,9)";
					break;
				case '3':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (3,16,15,14,13,12,11,10,9,8)";
					break;
				case '4':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (4,15,14,13,12,11,10,9,8,7)";
					break;
				case '5':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (5,14,13,12,11,10,9,8,7,6)";
					break;
				case '6':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (6,13,12,11,10,9,8,7,6,5)";
					break;
				case '7':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (7,12,11,10,9,8,7,6,5,4)";
					break;
				case '8':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (8,11,10,9,8,7,6,5,4,3)";
					break;
				case '9':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (9,10,9,8,7,6,5,4,3,2)";
					break;
				case '10':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (10,9,8,7,6,5,4,3,2,1)";
					break;
				case '11':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (11,8,7,6,5,4,3,2,1,18)";
					break;
				case '12':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (12,7,6,5,4,3,2,1,18,17)";
					break;
				case '13':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (13,6,5,4,3,2,1,18,17,16)";
					break;
				case '14':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (14,5,4,3,2,1,18,17,16,15)";
					break;
				case '15':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (15,4,3,2,1,18,17,16,15,14)";
					break;
				case '16':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (16,3,2,1,18,17,16,15,14,13)";
					break;
				case '17':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (17,2,1,18,17,16,15,14,13,12)";
					break;
				case '18':
					$query2 = "UPDATE fotografia set Estatus = 1 where idFotografia in (18,1,18,17,16,15,14,13,12,11)";
					break;
			}
			$sql2 = mysqli_query($con, $query2);

			$query3 = "UPDATE fotografia set Hora = CURRENT_TIMESTAMP where idFotografia = $foto";
			$sql3 = mysqli_query($con, $query3);
			return $resp;
		}catch(Exception $e){
			return $e;	
		}
	}
?>