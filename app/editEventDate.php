<?php

// Conexion a la base de datos
require '../db_conn.php';

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	
	$id = $_POST['Event'][0];
	$fechaInicio = $_POST['Event'][1];
	$fechaFin = $_POST['Event'][2];

	$sql = "UPDATE eventos SET  fechaInicio = '$fechaInicio', fechaFin = '$fechaFin' WHERE id = $id ";

	
	$query = $conn->prepare( $sql );
	if ($query == false) {
	 print_r($conn->errorInfo());
	 die ('Error');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Error');
	}else{
		die ('OK');
	}

}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
