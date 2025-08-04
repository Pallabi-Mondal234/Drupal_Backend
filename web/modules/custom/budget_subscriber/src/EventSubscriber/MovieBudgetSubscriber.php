<?php

namespace Drupal\budget_subscriber\EventSubscriber;

use Drupal\budget_subscriber\Event\MovieBudgetEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Subscribes to the custom movie budget event and shows budget status.
 */
class MovieBudgetSubscriber implements EventSubscriberInterface {

  /**
   * The config factory service, used to retrieve the configured budget amount.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The messenger service, used to display messages to the end user.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new MovieBudgetSubscriber.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(ConfigFactoryInterface $configFactory, MessengerInterface $messenger) {
    $this->configFactory = $configFactory;
    $this->messenger = $messenger;
  }

  /**
   * Reacts to the movie budget event.
   *
   * @param \Drupal\budget_subscriber\Event\MovieBudgetEvent $event
   *   The dispatched event containing the movie node.
   */
  public function onMovieCheck(MovieBudgetEvent $event): void {
    $node = $event->getNode();

    if ($node->bundle() === 'movie') {
      $config_amount = $this->configFactory->get('movie_budget.settings')->get('budget_amount');
      $movie_amount = $node->get('field_movie_price')->value;

      if ($movie_amount > $config_amount) {
        $status = 'The movie is over budget.';
      }
      elseif ($movie_amount < $config_amount) {
        $status = 'The movie is under budget.';
      }
      else {
        $status = 'The movie is within budget.';
      }

      // Show status as a message.
      $this->messenger->addMessage('Budget Review: ' . $status);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      MovieBudgetEvent::EVENT_NAME => 'onMovieCheck',
    ];
  }

}
