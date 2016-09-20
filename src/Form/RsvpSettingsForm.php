<?php
/**
 * @file
 * Contains \Drupal\rsvp\Form\RsvpSettingsForm
 */

  namespace Drupal\rsvp\Form;

  use Drupal\Core\Form\ConfigFormBase;
  use Symfony\Component\HttpFoundation\Request;
  use Drupal\Core\Form\FormStateInterface;

  /**
   * Defines form to configure RSVP List module settings
   */

  class RsvpSettingsForm extends ConfigFormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormID() {
      return 'rsvp_admin_settings';
    }

    /**
     * {@inheritdoc}
    */
    protected function getEditableConfigNames() {
      return [
        'rsvp.settings'
      ];
    }

    /**
     * {@inheritdoc}
     */

   public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {

      $types = node_type_get_names();
      $config = $this->config('rsvp.settings');
      //ksm($types);
      $form['rsvp_type'] = array(
        '#type' => 'checkboxes',
        '#title'=> $this->t('The content types to enable RSVP collection for'),
        '#default_value' => $config->get('allowed_types'),
        '#options' => $types,
        '#description' => $this->t('On the specified node types, an RSVP option will be available and can be enabled while that node is being edited.'),
      );

      $form['array_filter'] = array(
        '#type' => 'value',
        '#value' => TRUE
      );

      return parent::buildForm($form,$form_state);
    }

    /**
     * {@inheritdoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state) {
      $allowed_types = array_filter($form_state->getValue('rsvp_types'));
      //ksm($allowed_types,sort($allwed_types));
      sort($allwed_types);
      //kint();
      $this->config('rsvp.settings')
        ->set('allowed_types',$allwed_types)
        ->save();
        parent::submitForm($form,$form_state);
    }

  }
