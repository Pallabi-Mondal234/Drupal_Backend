<?php
namespace Drupal\hello_module1\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Implement hello function for greeting.
 */
class HelloController extends ControllerBase {
  /**
   * Greet login user.
   */
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

