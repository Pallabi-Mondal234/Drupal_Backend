<?php
namespace Drupal\custom_block\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\RedirectDestinationInterface;
use Drupal\Core\Url;

/**
 * Redirect the user after login  by implementing getSubscriberEvents and onRespond function.
 */
class LoginRedirectSubscriber implements EventSubscriberInterface {
  protected $destination;
  protected $currentUser;

  /**
   * Constructs the LoginRedirectSubscriber object.
   *
   * @param \Drupal\Core\Routing\RedirectDestinationInterface $destination
   *   The redirect destination service.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user service.
   */
  public function __construct(RedirectDestinationInterface $destination, AccountInterface $current_user) {
    $this->destination = $destination;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return[
      KernelEvents::RESPONSE => ['onRespond', -100],
    ];
  }

  /**
   * Redirects authenticated users after login to a custom page.
   *
   * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The response event.
   */
  public function onRespond(ResponseEvent $event) {
    $request = $event->getRequest();

    //Only appears after successful login
    if($request->attributes->get('_route') === 'user.login' && $this->currentUser->isAuthenticated()) {
      $session = $request->getSession();
      if(!$session->get('login_redirected')) {
        $session->set('login_redirected', TRUE);
        $response = new RedirectResponse(Url::fromUri('internal:/custom-welcome-page')->toString());
        $event->setResponse($response);
      }
    }
  }
}
?>
