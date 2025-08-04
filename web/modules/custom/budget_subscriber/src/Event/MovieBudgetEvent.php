<?php

namespace Drupal\budget_subscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Drupal\node\NodeInterface;

/**
 * Defines the custom event that carries node and build info.
 */
class MovieBudgetEvent extends Event {

  public const EVENT_NAME = 'budget_subscriber.movie_budget';

  /**
   * Store the node object being viewed.
   *
   * @var string
   */
  protected NodeInterface $node;

  /**
   * Constructor to initialize the event object.
   *
   * @param object $node
   *   The node object being viewed.
   */
  public function __construct(NodeInterface $node) {
    $this->node = $node;
  }

  /**
   * Returns the node object.
   *
   * @return \Drupal\node\NodeInterface
   *   The node being viewed.
   */
  public function getNode() {
    return $this->node;
  }

}
