<?php
 /**
  * @file
  * Contains \Drupal\rsvp\Form\RsvpForm
  */
  namespace Drupal\rsvp\Form;

  use Drupal\Core\Database\Database;
  use Drupal\Core\Form\FormBase;
  use Drupal\Core\Form\FormStateInterface;

  /**
   * Provides and RSVP Email form
   */

  class RsvpForm extends FormBase {

    /**
     * (@inheritdoc)
     */
    public function getFormId() {
      return 'rsvp_email_form';
    }

    /**
     * (@inheritdoc)
     */

    public function buildForm(array $form, FormStateInterface $form_state) {
      $node = \Drupal::routeMatch()->getParameter('node');
      $user = \Drupal::routeMatch()->getParameter('user');
      $nid = $node->nid->value;
      $form['email'] = array(
        '#title' => t('Email Address'),
        '#type' => 'textfield',
        '#size' => 25,
        '#description'=> t('We will send updates to your email.'),
        '#required'=>true,
      );

      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('RSVP'),
      );

      $form['nid'] = array(
        '#type' => 'hidden',
        '#value' => $nid,
      );

      return $form;
    }

    /**
     * (@inheritdoc)
     */

    public function validateForm(array &$form, FormStateInterface $form_state) {
      $value = $form_state->getValue('email');
      if($value == !\Drupal::service('email.validator')->isValid($value)) {
        $form_state->setErrorByName(
          'email',
          t("This email %mail is not valid.",array('%mail' => $value))
        );
      }

    }

    /**
     * (@inheritdoc)
     */

    public function submitForm(array &$form, FormStateInterface $form_state) {

      $uid = \Drupal::currentUser()->id();
      $user = \Drupal\user\Entity\User::load($uid);
      //ksm($user);

      db_insert('rsvp')
      ->fields(array(
          'mail' => $form_state->getValue('email'),
          'nid'  => $form_state->getValue('nid'),
          'uid'  => $uid,
          'created' => REQUEST_TIME,
        )
      )->execute();

      drupal_set_message(
        t('Thanks you for thre RSVP you are now in the list for the event.')
      );
    }
  }
