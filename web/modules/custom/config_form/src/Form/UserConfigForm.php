<?php
namespace Drupal\config_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Implement config form.
 */
class UserConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['config_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('config_form.settings');

    $form['full_name'] = [
      '#type'=>'textfield',
      '#title'=>$this->t("Full Name"),
      '#default_value'=>$config->get('full_name'),
      '#required'=>TRUE,
    ];
    $form['phone'] = [
      '#type'=>'tel',
      '#title'=>$this->t("Phone Number"),
      '#default_value'=>$config->get('phone'),
      '#required'=>TRUE,
    ];
    $form['email'] = [
      '#type'=>'email',
      '#title'=>$this->t("Email ID"),
      '#default_value'=>$config->get('email'),
      '#required'=>TRUE,
    ];
    $form['gender'] = [
      '#type'=>'radios',
      '#title'=>$this->t("Gender"),
      '#options'=>[
        'male'=>$this->t('Male'),
        'female'=>$this->t('Female'),
        'other'=>$this->t('Other'),
      ],
      '#default_value'=>$config->get('gender'),
      '#required'=>TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $phone = $form_state->getValue('phone');
    $email = $form_state->getValue('email');

    //Phone number must be 10 digits
    if(!preg_match('/^[6-9]\d{9}$/',$phone)) {
      $form_state->setErrorByName('phone', $this->t('Phone number must be a vallid 10 digit Indian Number'));
    }

    // RFC format email validation
  if (!\Drupal::service('email.validator')->isValid($email)) {
    $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    return;
  }

  // Domain checks
  $public_domains = ['gmail.com', 'yahoo.com', 'outlook.com'];
  $email_parts = explode('@', $email);

  if (count($email_parts) === 2) {
    $domain = strtolower($email_parts[1]);

    if (substr($domain, -4) !== '.com') {
      $form_state->setErrorByName('email', $this->t('Only .com domain emails are allowed.'));
    }

    if (!in_array($domain, $public_domains)) {
      $form_state->setErrorByName('email', $this->t('Only public domains like Gmail, Yahoo, or Outlook are allowed.'));
    }
  }
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('config_form.settings')
    ->set('full_name', $form_state->getValue('full_name'))
    ->set('phone',$form_state->getValue('phone'))
    ->set('email',$form_state->getValue('email'))
    ->set('gender',$form_state->getValue('gender'))
    ->save();

    parent::submitForm($form,$form_state);
  }
}

?>

