namespace Drupal\commerce_zugferd_invoice\Service;

class MustangZugferdService {
  protected $jarPath;

  public function __construct($jarPath = '/opt/mustang/mustangproject.jar') {
    $this->jarPath = $jarPath;
  }

  public function generatePdfA3b($pdfPath, $xmlPath, $outputPath) {
    $cmd = sprintf('java -jar %s -pdf %s -xml %s -out %s',
      escapeshellarg($this->jarPath), escapeshellarg($pdfPath),
      escapeshellarg($xmlPath), escapeshellarg($outputPath));
    shell_exec($cmd);

    if (!file_exists($outputPath)) {
      throw new \Exception('PDF/A-3b konnte nicht erstellt werden.');
    }

    return $outputPath;
  }
}
