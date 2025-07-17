<?php
namespace Drupal\custom_block\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * It is used for creating welcome page for user.
 */
class WelcomeController extends ControllerBase {
  
  /**
   *Returns a render array for the welcome page.
   *
   * @return array
   *   A render array containing the welcome message.
   */
  public function welcome() {
    return[
      '#markup'=>'Welcome to the custom page.',
    ];
  }
}
?>
