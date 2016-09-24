<?php
/**
 * @file
 * Contains \Drupal\rsvp\RsvpSubscriber
 */

namespace Drupal\rsvp;

use Drupal\Core\Url;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation;

/**
 * Subscribes to the kernal request event to comltetely obliterate the default content.
 *
 * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
 * the event to process.
 */

class RsvpSubscriber implements EventSubscriberInterface {
  /**
   * Overrides the content and serves a 404 status code.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *  The response event, which we will take over like a boss.
   */

  public function checkForCustomRedirect(GetResponseEvent $event) {
    $route_name = \Drupal::request()->attributes->get(RouteObjectInterface::ROUTE_NAME);
    if($route_name === 'rsvp.testPage') {
      drupal_set_message('Redirect worked!. You are all set.');
      $event->setResponse(new RedirectResponse(\Drupal::url('<front>')));
    }
  }

  //Type hint;
  public function onCustomResponse(FilterResponseEvent $event) {
    $route_name = \Drupal::request()->attributes->get(RouteObjectInterface::ROUTE_NAME);
    //ksm(\Drupal::request()->getClientIP());
    //e.g. rsvp.testPage
    if($route_name === 'rsvp.testPage') {
        $response = $event->getResponse();
        $response->setContent('Test RSVP event');
        //$response->setStatusCode('404');
    }
  }
  /**
   * This will override custom genericEvent value coming from RSVPController.
   */
  public function checkForCustomGenericEvent(GenericEvent $event) {
    $event->setArgument('string','This is now coming from RsvpSubscriber.php');
  }
  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = array();
    //$events[KernelEvents::RESPONSE][] = array('onCustomResponse',100);
    //$events[KernelEvents::REQUEST][] = array('checkForCustomRedirect');
    $events['rsvp.genericEvent'][] = array('checkForCustomGenericEvent');
    return $events;
  }
}
