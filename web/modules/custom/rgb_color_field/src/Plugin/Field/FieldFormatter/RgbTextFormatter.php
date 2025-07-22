<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'rgb_text_color' formatter.
 * 
 * @FieldFormatter(
 *  id = "rgb_text_formatter",
 *  label = @Translation("RGB Text Formatter"),
 *  field_types = {
 *    "rgb_color"
 *  }
 * )
 */
class RgbTextFormatter extends FormatterBase {
  
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $item->value];
    }
    return $elements;
  }
}
?>
