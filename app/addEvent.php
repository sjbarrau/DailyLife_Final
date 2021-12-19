<?php


// Conexion a la base de datos
require '../db_conn.php';

session_start();

if (isset($_POST['titulo']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin']) && isset($_POST['color'])){
	
	$titulo = $_POST['titulo'];
	$fechaInicio = $_POST['fechaInicio'];
	$fechaFin = $_POST['fechaFin'];
	$color = $_POST['color'];
	$id = $_SESSION['id'];

	$sql = "INSERT INTO eventos(titulo, fechaInicio, fechaFin, color, usuario) values ('$titulo', '$fechaInicio', '$fechaFin', '$color', '$id')";
	
	echo $sql;
	
	$query = $conn->prepare( $sql );
	if ($query == false) {
	 print_r($conn->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}

}
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
