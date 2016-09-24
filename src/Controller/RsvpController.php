<?php

 /**
  * @file
  * Contains Drupal\rsvp\RsvpController.
  */

namespace Drupal\rsvp\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\EventDispatcher\GenericEvent;
use Drupal\rsvp\RsvpEvent;
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
      //This is how we would create custom generic event.
      //$subject = '';
      //$arguments = array('string' => 'and this is the default value from custom GenericEvent.');
      // $event = new GenericEvent($subject,$arguments);
      //\Drupal::service('event_dispatcher')->dispatch('rsvp.genericEvent',$event);
      //$string = $event->getArgument('string');

      //Custom event
      $string = "Custom string coming from RSVP Event";
      $event = new RsvpEvent($string);
      \Drupal::service('event_dispatcher')->dispatch('rsvp.customEvent',$event);
      $string = $event->getString();

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
       '#markup' => $this->t('Hey @username, here \'s a unique Id for you: @uuid. @tagline @string',
       array('@username' => $username, '@uuid' => $uuid, '@tagline' => $tagline,'@string' => $string))
       );

      return $build;
    }

  }

