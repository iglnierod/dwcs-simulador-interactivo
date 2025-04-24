<?php
session_start();
require_once 'classes/Pet.php';

function showForm() {
  echo '
  <!DOCTYPE html>
  <html>
  <head>
  <title>Pet virtual</title>
  <link rel="stylesheet" href="assets/css/estilos.css">
  <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="p-4 bg-gray-800 text-white text-lg">
  <div class="contenedor">
  <h1 class="text-2xl mb-4">Pon un nombre a tu mascota virtual</h1>
  <form method="post">
  <input class="text-black p-1 rounded-md" type="text" name="name" placeholder="Nombre" required>
  <button class="bg-blue-500 rounded-md px-4 py-1 ml-2 hover:bg-blue-600" type="submit">Crear</button>
  </form>
  </div>
  </body>
  </html>
  ';
}

function showGame($pet) {
  $state = $pet->getState();
  echo '
  <!DOCTYPE html>
  <html>
  <head>
  <title>Pet - '.$state['name'].'</title>
  <link rel="stylesheet" href="assets/css/estilos.css">
  <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="text-lg bg-gray-800 text-white p-2">
  <div class="contenedor">
  <h1 class="text-3xl my-4">'.$state['name'].'</h1>

  <div class="estado">
  <img class="rounded-md my-4" src="assets/img/'.$state['image'].'" alt="Pet" height="150px">
  <h3 class="text-xl underline my-1">'.$state['message'].'</h3>
  </div>

  <div class="indicadores">
  <div class="indicador"><span>Hambre:</span> '.$state['hunger'].'/100</div>
  <div class="indicador"><span>Energía:</span> '.$state['energy'].'/100</div>
  <div class="indicador"><span>Felicidad:</span> '.$state['happiness'].'/100</div>
  <div class="indicador"><span>Higiene:</span> '.$state['hygiene'].'/100</div>
  </div>

  <div class="acciones mt-4">
  <a href="?accion=feed" class="bg-blue-500 rounded-md px-2 py-1">Alimentar</a>
  <a href="?accion=sleep" class="bg-blue-500 rounded-md px-2 py-1">Dormir</a>
  <a href="?accion=play" class="bg-blue-500 rounded-md px-2 py-1">Jugar</a>
  <a href="?accion=clean" class="bg-blue-500 rounded-md px-2 py-1">Bañar</a>
  <a href="?accion=delete" class="bg-red-500 rounded-md px-2 py-1" onclick="return confirm(\'¿Estás seguro que quieres eliminar la mascota?\')">Eliminar</a>
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
      $_SESSION['pet'] = serialize($pet);
      break;
    case 'sleep':
      $pet->sleep();
      $_SESSION['pet'] = serialize($pet);
      break;
    case 'play':
      $pet->play();
      $_SESSION['pet'] = serialize($pet);
      break;
    case 'clean':
      $pet->clean();
      $_SESSION['pet'] = serialize($pet);
      break;
    case 'delete':
      unset($_SESSION['pet']); // eliminar mascota
      break;
  }

  header("Location: index.php");
  exit;
}

// Mostrar juego o formulario
if (isset($_SESSION['pet'])) {
  $pet = unserialize($_SESSION['pet']);
  $pet->updateState();
  $_SESSION['pet'] = serialize($pet);
  showGame($pet);
} else {
  showForm();
}
?>
