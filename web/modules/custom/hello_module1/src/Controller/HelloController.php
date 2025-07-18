<?php
namespace Drupal\hello_module1\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\hello_module1\Service\GreetingService;

/**
 * Controller for greeting user.
 */
class HelloController extends ControllerBase {

  /**
   * The user greeting service.
   * 
   * @var GreetingService 
   */
  protected GreetingService $greet;

  /**
   * Constructor.
   * 
   * @param GreetingService $greet
   *    The custom greeting service.
   */
  public function __construct(GreetingService $greet) {
    $this->greet = $greet;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('hello_module1.greeting_user')
    );
  }

  /**
   * Greet login user.
   * 
   * @return string
   *    The greet message.
   */
  public function hello() {
    return [
      '#markup' => $this->t($this->greet->getGreeting()),
      '#cache' => [
        'contexts' => ['user'],
      ],
    ];
  }
}
?>
