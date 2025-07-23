<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'hex_color_widget' widget.
 *
 * @FieldWidget(
 *  id = "hex_color_widget",
 *  label = @Translation("Hex code Input"),
 *  field_types = {
 *    "rgb_color"
 *  }
 * )
 */
class HexColorWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state,
  ) {
    $element['value'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Hex Color Code"),
      '#default_value' => $items[$delta]->value ?? '',
      '#size' => 7,
      '#maxlength' => 7,
      '#placeholder' => '#RRGGBB',
    ];
    return $element;
  }

}
