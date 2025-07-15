<?php

namespace Drupal\commerce_zugferd_invoice\Controller;

use Symfony\Component\HttpFoundation\Response;
use Drupal\commerce_order\Entity\Order;

class InvoiceController {

  public function download($order_id) {
    $order = Order::load($order_id);

    /** @var \Drupal\commerce_zugferd_invoice\InvoiceGenerator $generator */
    $generator = \Drupal::service('commerce_zugferd_invoice.generator');
    $pdfPath = $generator->generateInvoice($order);

    return new Response(file_get_contents($pdfPath), 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'attachment; filename="Rechnung_' . $order_id . '.pdf"',
    ]);
  }
}
