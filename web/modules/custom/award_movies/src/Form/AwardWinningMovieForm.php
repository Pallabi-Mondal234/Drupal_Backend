<?php

namespace Drupal\award_movies\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Create the from for awarded movie.
 */
class AwardWinningMovieForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\award_movies\Entity\AwardWinningMovie $entity */
    $entity = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Movie Name'),
      '#default_value' => $entity->label(),
      '#required' => TRUE,
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity->id(),
      '#machine_name' => ['exists' => '\Drupal\award_movies\Entity\AwardWinningMovie::load'],
      '#disabled' => !$entity->isNew(),
    ];
    $form['year'] = [
      '#type' => 'number',
      '#title' => $this->t('Year'),
      '#default_value' => $entity->getYear(),
      '#required' => TRUE,
    ];
    $form['award_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Award Name'),
      '#default_value' => $entity->getAwardName(),
      '#required' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\award_movies\Entity\AwardWinningMovie $entity */
    $entity = $this->entity;
    $entity->setLabel($form_state->getValue('label'));
    $entity->setYear($form_state->getValue('year'));
    $entity->setYear($form_state->getValue('award_name'));
    $entity->save();

    parent::submitForm($form, $form_state);
  }

}
