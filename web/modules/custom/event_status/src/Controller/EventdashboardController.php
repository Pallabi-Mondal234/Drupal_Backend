<?php

namespace Drupal\event_status\Controller;

use Drupal\Core\Database\Connection;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A controller which implements dashboard function and perform operation.
 */
class EventdashboardController extends ControllerBase {

  /**
   * Connect with database.
   *
   * @var Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * A constructor for database connection.
   *
   * @param Drupal\Core\Database\Connection $database
   *   Connect with the database.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    $container->get('database')
    );
  }

  /**
   * Show the count of events according to the year.
   */
  public function dashboard() {
    $header_yearly = ['Event Year', 'Number of Events'];
    $rows_yearly = [];

    // Yearly events.
    $query = $this->database->select('node_field_data', 'n');
    $query->join('node__field_date', 'fd', 'fd.entity_id = n.nid');
    $query->addExpression('EXTRACT(YEAR FROM fd.field_date_value)', 'event_year');
    $query->addExpression('COUNT(n.nid)', 'event_count');
    $query->condition('n.type', 'events');
    $query->groupBy('event_year');
    $result = $query->execute()->fetchAllKeyed();
    foreach ($result as $year => $count) {
      $rows_yearly[] = ["Events in $year", $count];
    }

    $header_quarterly = ['Quarterly Events', 'Number of Events'];
    $rows_quarterly = [];

    // Quaterly Events.
    $query = $this->database->select('node_field_data', 'n');
    $query->join('node__field_date', 'fd', 'fd.entity_id=n.nid');
    $query->addExpression('EXTRACT(YEAR FROM fd.field_date_value)', 'event_year');
    $query->addExpression('CEIL(EXTRACT(MONTH FROM fd.field_date_value) / 3)', 'event_quarter');
    $query->addExpression('COUNT(n.nid)', 'quarter_count');
    $query->condition('n.type', 'events');
    $query->groupBy('event_year');
    $query->groupBy('event_quarter');
    $result = $query->execute()->fetchAll();
    foreach ($result as $records) {
      $year = $records->event_year;
      $quarter = $records->event_quarter;
      $count = $records->quarter_count;
      $rows_quarterly[] = ["Events in Q$quarter, $year", $count];
    }

    $header_types = ['Event Type', 'Number of Events'];
    $rows_types = [];

    // Events of each type.
    $query = $this->database->select('node_field_data', 'n');
    $query->join('node__field_type', 'fd', 'fd.entity_id=n.nid');
    $query->addExpression('fd.field_type_value ', 'event_type');
    $query->addExpression('COUNT(n.nid)', 'event_type_count');
    $query->condition('n.type', 'events');
    $query->groupBy('event_type');
    $result = $query->execute()->fetchAllKeyed();
    foreach ($result as $event => $count) {
      $rows_types[] = [$event, $count];
    }

    $header = ['content type', 'number of nodes'];
    $row = [];
    $pract = $this->database->select('node_field_data', 'n');
    $pract->addExpression('n.type', 'content_type');
    $pract->addExpression('COUNT(n.type)', 'total_node');
    $pract->condition('n.status', 1);
    $pract->groupBy('content_type');
    $pract->range(0, 10);
    $result = $pract->execute()->fetchAllKeyed();
    foreach ($result as $content_type => $total_node) {
      $row[] = [$content_type, $total_node];
    }
    return [
      'yearly_table' => [
        '#type' => 'table',
        '#header' => $header_yearly,
        '#rows' => $rows_yearly,
        '#caption' => $this->t("Yearly Events"),
        '#attributes' => ['class' => ['events-table']],
      ],
      'quarterly_table' => [
        '#type' => 'table',
        '#header' => $header_quarterly,
        '#rows' => $rows_quarterly,
        '#caption' => $this->t('Quarterly Events'),
        '#attributes' => ['class' => ['events-table']],
      ],
      'type_table' => [
        '#type' => 'table',
        '#header' => $header_types,
        '#rows' => $rows_types,
        '#caption' => $this->t('Event Types'),
        '#attributes' => ['class' => ['events-table']],
      ],
      'result_table' => [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $row,
        '#caption' => $this->t('Result Types'),
        '#attributes' => ['class' => ['events-table']],
      ],
      '#attached' => [
        'library' => [
          'event_status/event_status.styles',
        ],
      ],
      '#cache' => [
        'tags' => ['node_list:events'],
      ],
    ];
  }

}
