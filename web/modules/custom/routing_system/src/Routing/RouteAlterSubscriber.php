<?php
namespace Drupal\routing_system\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\user\Entity\Role;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

/**
 * Implement alter route function.
 */
class RouteAlterSubscriber extends RouteSubscriberBase {
  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    
    if($route = $collection->get('routing_system.operation')) {
      $route->setPath('/alter-route');
      $route->setRequirement('_role','administrator');
    }
  }

}
?>

