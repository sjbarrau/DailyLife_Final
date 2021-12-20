<?php
include 'db_conn.php';

session_start();

$id = $_SESSION['id'];
$sql = "SELECT id, titulo, fechaInicio, fechaFin, color FROM eventos WHERE usuario = '$id'";

$req = $conn->prepare($sql);
$req->execute();

$events = $req->fetchAll();


//Control de acceso:
if (empty($_SESSION['id'])) {
    header('Location: login.php');
}


if(isset($_POST['cerrar'])) {
    session_destroy();
    header("Location:login.php");
}

?>

<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="css/style.css">
    <!--Bootstrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

	<link href='css/fullcalendar.css' rel='stylesheet' />


  </head>
  <body>

    <!--menu de navegacion-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="nav navbar-nav" style="padding-left: 50px">
            <div style="color: white">
                <img src="./img/user.png" alt="Foto usuario" /> 
                <?=$_SESSION['nombre'] ?>
            </div>
            
            <li class="nav-item active" style="margin-top: 6px; margin-left: 50px; ">
                <a class="nav-link" href="home.php">Tareas </a>
            </li>
            
            <form action="" method="POST" style="padding-left: 50px">
                <button type="submit" name="cerrar" class="cerrar-sesion">Cerrar Sesion</button>
            </form>
            
        </div>
    </nav>


	<div class="container calendar-main">

		<div class="row">
				<div class="col-lg-12 text-center">
					<h4 style="margin-top:30px">Seleccione un día para añadir un nuevo evento.</h4>
					<p>Click y arrastrar para cambiar eventos de fecha.
						<br>
						Haga doble click sobre un evento para editarlo
					</p>

					<div id="calendar" class="col-centered">
					</div>
				</div>
				
		</div>


		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<form class="form-horizontal" method="POST" action="app/addEvent.php">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Agregar Evento</h4>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label for="titulo" class="col-sm-2 control-label">Titulo</label>
						<div class="col-sm-10">
						<input type="text" name="titulo" class="form-control" id="titulo" placeholder="Titulo">
						</div>
					</div>
					<div class="form-group">
						<label for="color" class="col-sm-2 control-label">Color</label>
						<div class="col-sm-10">
						<select name="color" class="form-control" id="color">
										<option value="">Seleccionar</option>
							<option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
							<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
							<option style="color:#008000;" value="#008000">&#9724; Verde</option>						  
							<option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
							<option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
							<option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
							
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="fechaInicio" class="col-sm-2 control-label">Fecha Inicial</label>
						<div class="col-sm-10">
						<input type="text" name="fechaInicio" class="form-control" id="fechaInicio" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="fechaFin" class="col-sm-2 control-label">Fecha Final</label>
						<div class="col-sm-10">
						<input type="text" name="fechaFin" class="form-control" id="fechaFin" readonly>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
				</form>
				</div>
			</div>
			</div>




			<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<form class="form-horizontal" method="POST" action="app/editEventTitle.php">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modificar Evento</h4>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label for="titulo" class="col-sm-2 control-label">Titulo</label>
						<div class="col-sm-10">
						<input type="text" name="titulo" class="form-control" id="titulo" placeholder="Titulo">
						</div>
					</div>
					<div class="form-group">
						<label for="color" class="col-sm-2 control-label">Color</label>
						<div class="col-sm-10">
						<select name="color" class="form-control" id="color">
							<option value="">Seleccionar</option>
							<option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
							<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
							<option style="color:#008000;" value="#008000">&#9724; Verde</option>						  
							<option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
							<option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
							<option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
							
							</select>
						</div>
					</div>
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label class="text-danger"><input type="checkbox"  name="borrar"> Eliminar Evento</label>
							</div>
							</div>
						</div>
					
					<input type="hidden" name="id" class="form-control" id="id">
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
				</form>
				</div>
			</div>
			</div>

		</div>




	</div>



	<script src="js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- FullCalendar -->
	<script src='js/moment.js'></script>
	<script src='js/fullcalendar/fullcalendar.min.js'></script>
	<script src='js/fullcalendar/fullcalendar.js'></script>
	<script src='js/fullcalendar/locale/es.js'></script>

	<script>


	$(document).ready(function() {

	   var date = new Date();
       var yyyy = date.getFullYear().toString();
       var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
       var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
		
		$('#calendar').fullCalendar({
			header: {
				language: 'es',
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay',

			},
			defaultDate: yyyy+"-"+mm+"-"+dd,
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,

			select: function(fechaInicio, fechaFin) {

				$('#ModalAdd #fechaInicio').val(moment(fechaInicio).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #fechaFin').val(moment(fechaFin).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #titulo').val(event.titulo);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php foreach($events as $event): 
			
				$start = explode(" ", $event['fechaInicio']);
				$end = explode(" ", $event['fechaFin']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['fechaInicio'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['fechaFin'];
				}
			?>
				{
					id: '<?php echo $event['id']; ?>',
					title: '<?php echo $event['titulo']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
				},
			<?php endforeach; ?>
			]
		});
		
		function edit(event){
			fechaInicio = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.fechaFin){
				fechaFin = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				fechaFin = fechaInicio;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = fechaInicio;
			Event[2] = fechaFin;
			
			$.ajax({
			 url: 'app/editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						
					}else{
						alert('Ha ocurrido un error al mover el evento.'); 
					}
				}
			});
		}
		
	});

</script>

  </body>
</html>