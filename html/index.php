<?php
session_start();
require_once 'classes/Pet.php';

// Función para mostrar el formulario inicial
function showForm() {
  echo '
  <!DOCTYPE html>
  <html>
  <head>
  <title>Pet virtual</title>
  <link rel="stylesheet" href="assets/css/estilos.css">
  </head>
  <body>
  <div class="contenedor">
  <h1>Pon un nombre a tu mascota virtual</h1>
  <form method="post">
  <input type="text" name="name" placeholder="Nombre" required>
  <button type="submit">Crear</button>
  </form>
  </div>
  </body>
  </html>
  ';
}

// Función para mostrar el juego
function showGame($pet) {
  $state = $pet->getState();
  echo '
  <!DOCTYPE html>
  <html>
  <head>
  <title>Pet - '.$state['name'].'</title>
  <link rel="stylesheet" href="assets/css/estilos.css">
  </head>
  <body>
  <div class="contenedor">
  <h1>'.$state['name'].'</h1>

  <div class="estado">
  <img src="assets/img/'.$state['image'].'" alt="Pet" height="150px">
  <p>'.$state['message'].'</p>
  </div>

  <div class="indicadores">
  <div class="indicador"><span>Hambre:</span> '.$state['hunger'].'/100</div>
  <div class="indicador"><span>Energía:</span> '.$state['energy'].'/100</div>
  <div class="indicador"><span>Felicidad:</span> '.$state['happiness'].'/100</div>
  <div class="indicador"><span>Higiene:</span> '.$state['hygiene'].'/100</div>
  </div>

  <div class="acciones">
  <a href="?accion=feed" class="boton">Alimentar</a>
  <a href="?accion=sleep" class="boton">Dormir</a>
  <a href="?accion=play" class="boton">Jugar</a>
  <a href="?accion=clean" class="boton">Bañar</a>
  </div>
  </div>
  </body>
  </html>
  ';
}

// Crear mascota nueva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
  $petName = trim($_POST["name"]);
  $newPet = new Pet($petName);
  $_SESSION['pet'] = serialize($newPet);
  header("Location: index.php");
  exit;
}

// Procesar acciones
if (isset($_GET['accion']) && isset($_SESSION['pet'])) {
  $pet = unserialize($_SESSION['pet']);

  switch ($_GET['accion']) {
    case 'feed':
      $pet->feed();
      break;
    case 'sleep':
      $pet->sleep();
      break;
    case 'play':
      $pet->play();
      break;
    case 'clean':
      $pet->clean();
      break;
  }

  $_SESSION['pet'] = serialize($pet);
  header("Location: index.php");
  exit;
}

// Mostrar la interfaz si hay mascota
if (isset($_SESSION['pet'])) {
  $pet = unserialize($_SESSION['pet']);

  // Aquí se actualiza el estado solo al recargar
  $pet->updateState();
  $_SESSION['pet'] = serialize($pet);

  showGame($pet);
} else {
  showForm();
}
?>
