<?php
namespace Drupal\hello_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;

class HelloController extends ControllerBase {

  public function hello() {
    $user = \Drupal::currentUser();
    $name = $user->getDisplayName(); 

    return [
      '#markup' => $this->t('Hello @name!', ['@name' => $name]),
      '#cache' => [
        'contexts' => ['user'],
      ],
    ];
  }
}
?>

