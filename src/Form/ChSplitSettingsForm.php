<?php

namespace Drupal\ch_split\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form to configure settings for config splits used with Content Hub.
 */
class ChSplitSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ch_split_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ch_split.settings.yml'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ch_split.settings.yml');
    $form['prevent_config_split_export'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Prevent config split export?'),
      '#description' => $this->t('Checking the box will prevent config split config entities from being exported to subscribers.'),
      '#default_value' => $config->get('prevent_config_split_export'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('ch_split.settings.yml')
      ->set('prevent_config_split_export', $form_state->getValue('prevent_config_split_export'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
