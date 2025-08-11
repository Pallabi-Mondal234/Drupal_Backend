<?php

namespace Drupal\tax_form\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implement a form which accepts a taxonomy term.
 */
class TaxonomyForm extends FormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a TaxonomyForm object.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tax_form_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['term_reference'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Enter your taxonomy term'),
      '#target_type' => 'taxonomy_term',
      '#required' => TRUE,
      '#maxlength' => 20,
      '#selection_settings' => [
        'target_bundles' => ['employee_name'],
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $term_id = $form_state->getValue('term_reference');

    if (!empty($term_id)) {
      $message = '';

      // Fetch tid, uuid, and term name.
      $query = $this->database->select('taxonomy_term_data', 'td');
      $query->join('taxonomy_term_field_data', 'fd', 'td.tid = fd.tid');
      $query->fields('td', ['tid', 'uuid']);
      $query->fields('fd', ['name']);
      $query->condition('fd.tid', $term_id);
      $results = $query->execute()->fetchAll();

      foreach ($results as $r) {
        $message .= "Term Id: {$r->tid} <br> UUID: {$r->uuid} <br> Term Name: {$r->name}<br>";
      }

      // Fetch node id and url where the term is used.
      $query2 = $this->database->select('taxonomy_index', 'ti');
      $query2->join('node_field_data', 'nfd', 'ti.nid=nfd.nid');
      $query2->fields('nfd', ['nid', 'title']);
      $query2->condition('ti.tid', $term_id);
      $results2 = $query2->execute()->fetchAllKeyed();

      foreach ($results2 as $nid => $title) {
        /** @var \Drupal\node\NodeInterface $node */
        $node = $this->entityTypeManager->getStorage('node')->load($nid);
        if ($node) {
          $url = $node->toUrl()->toString();
          $message .= "Node Title: $title <br> Node URL: $url <br>";
        }
      }

      $this->messenger()->addMessage(Markup::create($message));
    }
  }

}
