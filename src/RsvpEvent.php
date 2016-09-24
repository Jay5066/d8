<?php

namespace Drupal\rsvp;

use Symfony\Component\EventDispatcher\Event;

/**
 * Gets information on all the possible configuration collections.
 */
class RsvpEvent extends Event {
  /**
   * A simple custom string
   *
   * @var string
   */
  protected $string;

  /**
   * Adds custom string as a prop to the event class
   * @param string
   *  A simple string
   */
  public function __construct($string){
   $this->string = $string;
  }

  /**
   * Gets the string.
   *  @return string
   *   The string that we're passing.
   */

  public function getString() {
    return $this->string;
  }

  /**
   *Sets the String
   *
   * @param $value
   *  The Strig that we're passig
   *
   */

  public function setString($value) {
  $this->string = $value;
  }

}
