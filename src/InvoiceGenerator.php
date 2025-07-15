namespace Drupal\commerce_zugferd_invoice;

use Mpdf\Mpdf;
use Drupal\commerce_order\Entity\Order;

class InvoiceGenerator {
  protected $mustang;

  public function __construct($mustang_service) {
    $this->mustang = $mustang_service;
  }

  public function generateInvoice(Order $order) {
    $pdfRaw = '/tmp/raw_' . $order->id() . '.pdf';
    $pdfFinal = '/tmp/rechnung_' . $order->id() . '.pdf';
    $xml = '/tmp/zugferd_' . $order->id() . '.xml';

    $mpdf = new Mpdf();
    $mpdf->WriteHTML('<h1>Rechnung</h1><p>#' . $order->id() . '</p>');
    $mpdf->Output($pdfRaw, 'F');

    file_put_contents($xml, <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:ferd:CrossIndustryDocument:invoice:1p0">
  <rsm:ExchangedDocument><ram:ID>{$order->id()}</ram:ID></rsm:ExchangedDocument>
</rsm:CrossIndustryInvoice>
XML
    );

    return $this->mustang->generatePdfA3b($pdfRaw, $xml, $pdfFinal);
  }
}
