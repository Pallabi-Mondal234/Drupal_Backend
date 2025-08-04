<?php

namespace Drupal\budget_subscriber\EventSubscriber;

use Drupal\budget_subscriber\Event\MovieBudgetEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Subscribes to the custom movie budget event and shows budget status.
 */
class MovieBudgetSubscriber implements EventSubscriberInterface {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new MovieBudgetSubscriber.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * Reacts to the movie budget event.
   */
  public function onMovieCheck(MovieBudgetEvent $event): void {
    $node = $event->getNode();

    if ($node->bundle() === 'movie') {
      $config_amount = \Drupal::config('movie_budget.settings')->get('budget_amount');
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
