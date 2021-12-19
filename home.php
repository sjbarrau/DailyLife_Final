<?php

include 'db_conn.php';

session_start();

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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <!--Bootstrap-->
    <link rel="stylesheet" href="./css/bootstrap.min.css" />

</head>

<body>
    <!-- Conectamos con la base de datos para extrare alas tareas -->
     <?php
        $id = $_SESSION['id'];
        $tareas = $conn->query("SELECT * FROM tareas WHERE usuario = $id ORDER BY id DESC");
        
    ?>

    <!--menu de navegacion-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="nav navbar-nav" style="padding-left: 50px">
            <div style="color: white">
                <img src="./img/user.png" alt="Foto usuario" /> 
                <?=$_SESSION['nombre'] ?>
            </div>
            
            <li class="nav-item active" style="margin-top: 6px; margin-left: 50px; ">
                <a class="nav-link" href="calendar.php">Calendario </a>
            </li>
            
            <form action="" method="POST" style="padding-left: 50px">
                <button type="submit" name="cerrar" class="cerrar-sesion">Cerrar Sesion</button>
            </form>
            
        </div>
    </nav>


    <!--menu de navegacion-->
    <div id="page">

        <div class="main-section" id="main">
            <div class="add-section">
                <form action="app/add.php" method="POST" autocomplete="off">
                    <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                        <input type="text" name="titulo" style="border-color: #ff6666" placeholder="Introduzca su nueva tarea">
                        <button type="submit">Añadir Tarea <span>+</span> </button>
                    <?php } else { ?>
                        <input type="text" name="titulo" placeholder="¿Que vas a hacer hoy?">
                        <button type="submit">Añadir Tarea <span>+</span> </button>
                    <?php } ?>
                </form>
            </div>

        
            <div class="show-todo-section">
                <?php if ($tareas->rowCount() <= 0) { ?>
                    <div class="todo-item">
                        <div class="empty">
                            <img src="img/f.png" width="100%">
                            <img src="img/Ellipsis.gif" width="80px">
                        </div>
                    </div>
                <?php } ?>

                <?php while ($tarea = $tareas->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="todo-item">
                        <span id="<?php echo $tarea['id']; ?>" class="remove-to-do">x</span>
                        <?php if ($tarea['checked']) { ?>
                            <input type="checkbox" class="check-box" data-todo-id="<?php echo $tarea['id']; ?>" checked />
                            <h2 class="checked"><?php echo $tarea['titulo'] ?></h2>
                        <?php } else { ?>
                            <input type="checkbox" data-todo-id="<?php echo $tarea['id']; ?>" class="check-box" />
                            <h2><?php echo $tarea['titulo'] ?></h2>
                        <?php } ?>
                        <br>
                        <small>Creado: <?php echo $tarea['fecha'] ?></small>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.remove-to-do').click(function() {
                const id = $(this).attr('id');
                $.post("app/remove.php", {
                        id: id
                    },
                    (data) => {
                        if (data) {
                            $(this).parent().hide(600);
                        }
                    }
                );
            });

            $('.check-box').click(function(e) {
                const id = $(this).attr('data-todo-id');

                $.post('app/check.php', {
                        id: id
                    },
                    (data) => {
                        if (data != 'error') {
                            const h2 = $(this).next();
                            if (data === '1') {
                                h2.removeClass('checked');
                            } else {
                               h2.addClass('checked');
                               
                                /* $(this).parent().hide(600); */

                                /* var $completa = h2.clone();
                                console.log($completa)
                                $('.tareas-completadas').html($completa); */
                            }
                        }
                    }
                );
            });
        });
    </script>


</body>

</html>