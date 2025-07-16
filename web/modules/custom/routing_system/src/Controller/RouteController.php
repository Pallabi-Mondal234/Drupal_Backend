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
  public function welcome() {
    return [
      '#markup'=>$this->t('This is first page of routing.'),
    ];
  }

  /**
   * Check access dynamically.
   */
  public function accessCheck(AccountInterface $account) {
    return AccessResult::allowedIf(in_array('administrator',$account->getRoles()));
  }

  /**
   * Dynamic Path change.
   */
  public function dynamicPath($node) {
    return[
      '#markup'=>$this->t('You passed the value @node',['@node'=>$node]),
    ];
  }
}
?>

