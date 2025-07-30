<?php

namespace Drupal\award_movies\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Award Winning Movie config entity.
 *
 * @ConfigEntityType(
 *  id = "award_movies",
 *  label = @Translation("Award Winning Movie"),
 *  handlers = {
 *    "list_builder" = "Drupal\award_movies\AwardWinningMovieListBuilder",
 *    "form" = {
 *      "add" = "Drupal\award_movies\Form\AwardWinningMovieForm",
 *      "edit" = "Drupal\award_movies\Form\AwardWinningMovieForm",
 *      "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *    }
 *  },
 * admin_permission = "administer site configuration",
 * config_prefix = "award_movies",
 * entity_keys = {
 *  "id" = "id",
 *  "label" = "label"
 * },
 * config_export = {
 *     "id",
 *     "label",
 *     "year",
 *     "award_name"
 *   },
 * links = {
 *  "add-form" = "/admin/config/media/award-movies/add",
 *  "edit-form" = "/admin/config/media/award-movies/{award_movies}/edit",
 *  "delete-form" = "/admin/config/media/award-movies/{award_movies}/delete",
 *  "collection" = "/admin/config/media/award-movies"
 * }
 * )
 */
class AwardWinningMovie extends ConfigEntityBase {
  /**
   * The machine name of the award-winning movie.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable label of the award-winning movie.
   *
   * @var string
   */
  protected $label;

  /**
   * The year in which the movie won the award.
   *
   * @var int
   */
  protected $year;

  /**
   * The award name that won the movie.
   *
   * @var string
   */
  protected $award_name;

  /**
   * Get the label.
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * Set the label.
   */
  public function setLabel($label) {
    $this->label = $label;
    return $this;
  }

  /**
   * Get the year.
   */
  public function getYear() {
    return $this->year;
  }

  /**
   * Set the year.
   */
  public function setYear($year) {
    $this->year = $year;
    return $this;
  }

  /**
   * Get the award name.
   */
  public function getAwardName() {
    return $this->award_name;
  }

  /**
   * Set the award name.
   */
  public function setAwardName($award_name) {
    $this->award_name = $award_name;
    return $this;
  }

}
