<?php
namespace Drupal\hello_module\Controller;

class HelloController {
  public function hello() {
    return [
      '#markup' =>'Hello World! This is a custom module.',
    ];
  }
}

?>

