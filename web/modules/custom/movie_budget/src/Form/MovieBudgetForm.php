<?php

namespace Drupal\movie_budget\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure movie_budget settings for this site.
 */
class MovieBudgetForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'movie_budget_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['movie_budget.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['budget_amount'] = [
      '#type' => 'number',
      '#title' => $this->t('Enter The Movie Budget'),
      '#default_value' => $this->config('movie_budget.settings')->get('budget_amount'),
      '#field_suffix' => $this->t('Cr INR'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('movie_budget.settings')
      ->set('budget_amount', $form_state->getValue('budget_amount'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
