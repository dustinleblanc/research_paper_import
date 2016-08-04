<?php

namespace Drupal\research_paper_import\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'UserZoteroCollectionsBlock' block.
 *
 * @Block(
 *  id = "user_zotero_collections_block",
 *  admin_label = @Translation("User zotero collections block"),
 * )
 */
class UserZoteroCollectionsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['user_zotero_collections_block']['#markup'] = 'Implement UserZoteroCollectionsBlock.';
    $collections = DustinLeblanc\Zotero\Client::
    return $build;
  }

}
