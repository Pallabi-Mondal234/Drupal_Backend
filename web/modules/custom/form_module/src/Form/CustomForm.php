<?php
namespace Drupal\form_module\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Build Generic form.
 */
class CustomForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => 'Enter your name',
      '#required' => TRUE,
      '#maxlength' => 20,
    );
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => 'Enter your last name',
      '#required' => TRUE,
      '#maxlength' => 20,
    );
    $form['textarea'] = array(
      '#type' => 'textarea',
      '#title' => 'Write your comment here',
      '#default_value' => '',
      '#attributes' => [
        'placeholder' => 'Write your comment here',
        'rows' => 5,
      ],
    );
    $form['email'] = array(
      '#title' => ('Email Address'),
      '#type' => 'email',
      '#size' => 25,
      '#required' => TRUE,
      '#description' => 'my test form',
    );
    $form['age'] = array(
      '#title' => ('Age'),
      '#type' => 'number',
      '#size' => 25,
      '#min' => 1,
      '#max' => 120,
    );
    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t("Gender"),
      '#options' => [
        'male' => 'Male',
        'female' => 'Female',
        'other' => 'Other',
      ],
      '#ajax' => [
        'callback' => '::updateOtherField',
        'event' => 'change',
        'wrapper' => 'other-gender-wrapper',
      ],
    ];
    // Wrapper div to replace on AJAX
    $form['other_gender_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'other-gender-wrapper'],
    ];
     // Conditionally add "other" text field
    if ($form_state->getValue('gender') === 'other') {
      $form['other_gender_wrapper']['other_gender'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Please specify gender'),
      ];
    }
    $form['password'] = [
      '#type' => 'password',
      '#title' => t('Password'),
      '#required' => TRUE,
      '#maxlength' => 6,
    ];
    $form['default'] = array(
      '#title' => 'Deafult Field',
      '#type' => 'textfield',
      '#default_value' => 'This is a default field'
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => ('submit'),
    );
    $form['#submit'][] = 'form_module_custom_form_id_submit';
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function updateOtherField(array &$form, FormStateInterface $form_state) {
    return $form['other_gender_wrapper'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage(('Form testing completd'));
    $data = $form_state->getValues();
    \Drupal::database()->insert('form_submission')
      ->fields([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'age' => $data['age'],
      ])
      ->execute();

    \Drupal::messenger()->addMessage('Data has been stored.');
  }
}
?>

