<?php
namespace Drupal\contact_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ContactForm extends FormBase {
  private $submissionMessage;

  public function getFormId() {
    return 'contact_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attributes']['class'][] = 'custom-form';

    if (!empty($this->submissionMessage)) {
      $form['submission_message'] = [
        '#markup' => '<div class="form-success-message">' . $this->submissionMessage . '</div>',
        '#weight' => -100, // ensures it shows above everything
      ];
    }

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#required' => TRUE,
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Attempted validation function commented out due to issues with the form state.
   *
   * public function validateForm(array &$form, FormStateInterface $form_state) {
   * $first_name = $form_state->getValue('first_name');
   * $last_name = $form_state->getValue('last_name');
   * $email = $form_state->getValue('email');
   * $message = $form_state->getValue('message');
   *
   * if (empty(trim($first_name)) || empty(trim($last_name))) {
   * $form_state->setErrorByName('first_name', $this->t('Both first and last name are required.'));
   * }
   *
   * if (!\Drupal::service('email.validator')->isValid($email)) {
   * $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
   * }
   *
   * if (strlen(trim($message)) < 50) {
   * $form_state->setErrorByName('message', $this->t('Your message must be at least 50 characters.'));
   * }
   * }
 */

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->submissionMessage = $this->t('Thank you for your submission, @name.', [
      '@name' => $form_state->getValue('first_name'),
    ]);

    \Drupal::logger('contact_form')->notice('@first_name @last_name sent the following message and can be reached at @email: @message.', [
      '@first_name' => $form_state->getValue('first_name'),
      '@last_name' => $form_state->getValue('last_name'),
      '@email' => $form_state->getValue('email'),
      '@message' => $form_state->getValue('message'),
    ]);

    $form_state->setRebuild(TRUE);
  }
}
