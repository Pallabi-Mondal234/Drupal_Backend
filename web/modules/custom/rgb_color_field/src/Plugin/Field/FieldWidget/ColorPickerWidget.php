<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'color_picker_widget' widget.
 * 
 * @FieldWidget(
 *  id = "color_picker_widget",
 *  label = @Translation("HTML5 Color Picker"),
 *  field_types = {
 *    "rgb_color"
 *  }
 * )
 */
class ColorPickerWidget extends WidgetBase {
  
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, 
  array &$form, FormStateInterface $form_state) {
    $element['value'] = [
      '#type' => 'color',
      '#title' => $this->t('Color Picker'),
      '#default_value' => $items[$delta]->value ?? '#000000',
    ];
    return $element;
  }
}
?>
