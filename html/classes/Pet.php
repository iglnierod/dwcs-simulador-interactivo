<?php

class Pet {
  private $name;
  private $hunger = 50;
  private $energy = 80;
  private $happiness = 60;
  private $hygiene = 70;
  private $alive = true;

  /*
  * @param string $name - Pet's name
  */
  public function __construct($name) {
    $this->name = $name;
  }

  
  /*
  * Feed - Reduce hunger and affect other properties 
  */
  public function feed() {
    if (!$this->alive) return false;

    $this->hunger = max(0, $this->hunger - 30);
    $this->hygiene = min(100, $this->hygiene - 5);
    return "¡{$this->name} ha comido!";
  }

  /* 
  * Sleep - Recover energy
  */
  public function sleep() {
    if (!$this->alive) return false;

    $this->energy = min(100, $this->energy + 40);
    return "{$this->name} está durmiendo...";
  }

  /*
  * Play - Recover happiness
  */
  public function play() {
    if (!$this->alive) return false;

    $this->happiness = min(100, $this->happiness + 10);
    return "{$this->name} ha jugado con la pelota.";
  }

  /*
  * Clean - Clean the pet
  */
  public function clean() {
    if (!$this->alive) return false;

    $this->hygiene = min(100, $this->hygiene + 30);
  }

  /*
  * Update the pet's state 
  */
  public function updateState() {
    $this->hunger = min(100, $this->hunger + 5);
    $this->energy = max(0, $this->energy - 3);
    $this->happiness = max(0, $this->happiness-2);
    $this->hygiene = max(0, $this->hygiene - 4);

    if ($this->hunger >= 100 || $this->hygiene <= 0) {
      $this->alive = false;
    }
  }

  /*
  * Get image depending of the state
  */
  public function getImage() {
    if (!$this->alive) return "dead.gif";

    if ($this->hunger > 70) return "hungry.gif";
    if ($this->energy < 30) return "tired.gif";
    if ($this->happiness < 30) return "sad.gif";
    if ($this->hygiene < 30) return "dirty.gif";

    return "happy.gif";
  }

  /*
  *
  */
  public function generateMessage() {
    if (!$this->alive) return "¡{$this->name} ha muerto por tu negligencia!";
    $messages = [];
    if ($this->hunger > 70) $messages[] = "Tengo mucha hambre";
    if ($this->energy < 30) $messages[] = "Estoy muy cansado";
    if ($this->happiness < 30) $messages[] = "Estoy muy triste";
    if ($this->hygiene < 30) $messages[] = "Estoy sucio";

    return empty($messages) ? "Estoy genial" : implode(", ", $messages);
  }
  
  /*
  * Make a report of the state
  */
  public function getState() {
    return $state = [
      "name" => $this->name,
      "hunger" => $this->hunger,
      "energy" => $this->energy,
      "happiness" => $this->happiness,
      "hygiene" => $this->hygiene,
      "alive" => $this->alive,
      "image" => $this->getImage(),
      "message" => $this->generateMessage()
    ];
  }
}

?>