<?php
namespace Drupal\contact_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Contact Form' block.
 *
 * @Block(
 *   id = "contact_form_block",
 *   admin_label = @Translation("Contact Form Block")
 * )
 */
class ContactFormBlock extends BlockBase {
  public function build() {
    return [
      '#title' => $this->t('Contact Us'),
      'form' => \Drupal::formBuilder()->getForm('Drupal\contact_form\Form\ContactForm'),
    ];
  }
}
