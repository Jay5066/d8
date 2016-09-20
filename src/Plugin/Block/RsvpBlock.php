<?php
/**
 * @file
 * contains \Drupal\rsvp\Plugin\Block\RsvpBlock
 */

namespace Drupal\rsvp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides an 'RSVP' List Block
 * @Block(
 *   id = "rsvp_block",
 *   admin_label = @Translation("RSVP Block")
 * )
 */

class RsvpBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  //Place form inside our block;
  public function build() {
    //return array('#markup' => $this->t('My RSVP List Block'));
    return \Drupal::formBuilder()->getForm('Drupal\rsvp\Form\RsvpForm');
  }

  //Control block acccess;
  public function blockAccess(AccountInterface $account) {
    /**
     * @var \Drupal\node\Entity\Node\ $node;
     */
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node->nid->value;
    if(is_numeric($nid)) {
      return AccessResult::allowedIfHasPermission($account, 'view rsvp');
    }
    return AccessResult::forbidden();
  }

}
