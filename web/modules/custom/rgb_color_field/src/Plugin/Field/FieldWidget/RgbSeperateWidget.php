<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'rgb_seperate_widget' widget
 * 
 * @FieldWidget(
 *  id = "rgb_seperate_widget",
 *  label = @Translation("RGB Seperate Input"),
 *  field_types = {
 *    "rgb_color"
 *  }
 * )
 */
class RgbSeperateWidget extends WidgetBase {
  
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, 
  array &$form, FormStateInterface $form_state) {
    $value = $items[$delta]->value ?? '#000000';
    [$r, $g, $b] = sscanf(ltrim($value, '#'), "%02x%02x%02x");

    $element['r'] = [
      '#type' => 'number',
      '#title' => $this->t('R'),
      '#default_value' => $r,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['g'] = [
      '#type' => 'number',
      '#title' => $this->t('G'),
      '#default_value' => $g,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['b'] = [
      '#type' => 'number',
      '#title' => $this->t('B'),
      '#default_value' => $b,
      '#min' => 0,
      '#max' => 255,
    ];
    return $element;
  }

  /**
   * @inheritdoc
   */
  public function massageFormValues(array $values, array $form, 
  FormStateInterface $form_state) {
    foreach ($values as &$value) {
      $r = $value['r'] ?? 0;
      $g = $value['g'] ?? 0;
      $b = $value['b'] ?? 0;
      $value['value'] = sprintf("#%02x%02x%02x", $r, $g, $b);
    }
    return $values;
  }
}
?>
