<?php
namespace Drupal\user_welcome\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\user_welcome\Service\GreetingService;

/**
 * Controller for greeting user which implement create and hello method.
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
      $container->get('user_welcome.greeting_user')
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
