<?php
namespace Drupal\routing_system\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Access\AccessResult;
/**
 * Provide functionality when visit particular path.
 */
class RouteController extends ControllerBase {
  /**
   * Returns a simple welcome page.
   * 
   * @return array
   *   A renderable array containing markup.
   */
  public function welcome() {
    return [
      '#markup'=>$this->t('This is first page of routing.'),
    ];
  }

  /**
   * Checks access based on user role.
   * 
   * @param AccountInterface $account
   *   The currently logged-in user's account object.
   *
   * @return AccessResult
   *   The access result (allowed or denied).
   */
  public function accessCheck(AccountInterface $account) {
    return AccessResult::allowedIf(in_array('administrator',$account->getRoles()));
  }

  /**
   * Displays dynamic content based on URL parameter.
   * 
   * @param string $node
   *   The dynamic value passed in the route path.
   *
   * @return array
   *   A renderable array displaying the passed value.
   */
  public function dynamicPath(string $node) {
    return[
      '#markup'=>$this->t('You passed the value @node',['@node'=>$node]),
    ];
  }
}
?>

