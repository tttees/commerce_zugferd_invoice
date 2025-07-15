namespace Drupal\commerce_zugferd_invoice\Plugin\CommerceOrderAction;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Plugin\CommerceOrderAction\OrderActionBase;

/**
 * @CommerceOrderAction(
 *   id = "send_zugferd_invoice",
 *   label = @Translation("Send ZUGFeRD invoice"),
 *   category = @Translation("ZUGFeRD")
 * )
 */
class SendZugferdInvoiceAction extends OrderActionBase {
  public function execute(OrderInterface $order) {
    $generator = \Drupal::service('commerce_zugferd_invoice.generator');
    $pdfPath = $generator->generateInvoice($order);
    $email = $order->getEmail();

    \Drupal::service('plugin.manager.mail')->mail('default', 'zugferd_invoice', $email, 'de', [
      'subject' => 'Ihre Rechnung',
      'body' => 'Im Anhang finden Sie Ihre ZUGFeRD-konforme Rechnung.',
      'attachments' => [$pdfPath],
    ]);
  }
}
