<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'rgb_background_formatter' formatter.
 *
 * @FieldFormatter(
 *  id = "rgb_background_formatter",
 *  label = @Translation("RGB Background Color Formatter"),
 *  field_types = {
 *    "rgb_color"
 *  }
 * )
 */
class RgbBackgroundFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $color = trim($item->value);
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#value' => $color,
        '#attributes' => [
          'style' => 'padding:5px; background-color:' . $color . '; color: #fff; border: 1px solid #ccc;',
        ],
      ];
    }
    return $elements;
  }

}
