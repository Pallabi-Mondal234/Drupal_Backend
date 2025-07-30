<?php

namespace Drupal\award_movies;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * It's a list builder class.
 */
class AwardWinningMovieListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Movie Name');
    $header['year'] = $this->t('Year');
    $header['award_name'] = $this->t('Award');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\award_movies\Entity\AwardWinningMovie $entity */
    $row['label'] = $entity->label();
    $row['year'] = $entity->getYear();
    $row['award_name'] = $entity->getAwardName();
    return $row + parent::buildRow($entity);
  }

}
