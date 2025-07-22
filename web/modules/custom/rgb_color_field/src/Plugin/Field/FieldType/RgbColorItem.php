<?php

namespace Drupal\rgb_color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'rgb_color' field type.
 * 
 * @FieldType(
 *  id = "rgb_color",
 *  label = @Translation("RGB Color"),
 *  description = @Translation("A field storing RGB color in hex format."),
 *  default_widget = "hex_color_widget",
 *  default_formatter = "rgb_text_formatter"
 * )
 */
class RgbColorItem extends FieldItemBase {
  
  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
    ->setLabel(t("Hex Color Value"))->setRequired(TRUE);
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 7,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return empty($this->get('value')->getValue());
  }
}
?>
