namespace Drupal\commerce_zugferd_invoice\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingsForm extends ConfigFormBase {
  protected function getEditableConfigNames() {
    return ['commerce_zugferd_invoice.settings'];
  }

  public function getFormId() {
    return 'commerce_zugferd_invoice_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('commerce_zugferd_invoice.settings');

    $form['storage_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Speicherpfad'),
      '#default_value' => $config->get('storage_path'),
    ];
    $form['mustang_jar_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Pfad zur Mustangproject JAR'),
      '#default_value' => $config->get('mustang_jar_path'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('commerce_zugferd_invoice.settings')
      ->set('storage_path', $form_state->getValue('storage_path'))
      ->set('mustang_jar_path', $form_state->getValue('mustang_jar_path'))
      ->save();
  }
}
