<?php
// Conexion a la base de datos
require '../db_conn.php';

if (isset($_POST['borrar']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	$sql = "DELETE FROM eventos WHERE id = $id";
	$query = $conn->prepare( $sql );
	if ($query == false) {
	 print_r($conn->errorInfo());
	 die ('Erreur prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
	
}else if (isset($_POST['titulo']) && isset($_POST['color']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$titulo = $_POST['titulo'];
	$color = $_POST['color'];
	
	$sql = "UPDATE eventos SET titulo = '$titulo', color = '$color' WHERE id = $id ";

	
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
