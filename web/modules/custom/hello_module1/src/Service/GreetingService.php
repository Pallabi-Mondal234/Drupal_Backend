<?php
namespace Drupal\hello_module1\Service;

use Drupal\Core\Session\AccountInterface;
/**
 * Implement the service of greeting.
 */
class GreetingService {
  /**
   * The current user.
   * 
   * @var AccountInterface
   */
  protected AccountInterface $currentUser;

  /**
   * Constructor.
   * 
   * @param AccountInterface $current_user.
   *    The current user of the service.
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Get the greeting message for the user.
   * 
   * @return string
   *    The greeting message.
   */
  public function getGreeting():string {
    $name = $this->currentUser->getDisplayName();
    return "Welcome {$name}";
  }
}
?>
