<?php

 /**
  * @file
  * Contains Drupal\rsvp\RsvpController.
  */

  namespace Drupal\rsvp\Controller;

  use Drupal\Core\Controller\ControllerBase;

  /**
   * Defines what this controller is about;
   */

  class RsvpController extends ControllerBase {
    /**
     * Provides page that we can experiement with.
     * @return array
     *  A render array as expected by drupal_render().
     */

     /**
     * {@inheritdoc}
     */
    public function content() {
      //Get Username;(Drupal service);
      $account = \Drupal::currentUser();
      $username = $account->getUsername();

      //Generate UUID(Drupal service);
      $uuid_generator = \Drupal::service('uuid');
      $uuid = $uuid_generator->generate();

      $rsvpService = \Drupal::service('rsvp.rsvpservice');
      $tagline = $rsvpService->getRsvpService();

      //Send the data out to page.
      $build = array(
       '#type' => 'markup',
       '#markup' => $this->t('Hey !username, here \'s a unique Id for you: !uuid. !tagline',
       array('!username' => $username, '!uuid' => $uuid, '!tagline' => $tagline))
       );

      return $build;
    }

  }

