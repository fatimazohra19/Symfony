<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfGeneratorService {
    private Dompdf $pdf;

    public function __construct(Dompdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function getStreamResponse(string $html, string $filename): StreamedResponse
{
    try {
        // Générer le PDF avec le contenu HTML
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4');
        $this->pdf->render();
        $pdfContent = $this->pdf->output();
    } catch (\Exception $e) {
        // Log l'erreur ou lance une exception personnalisée
        throw new \Exception("Erreur lors de la génération du PDF: " . $e->getMessage());
    }

    // Créer une réponse streamée
    $response = new StreamedResponse(function () use ($pdfContent) {
        echo $pdfContent;
    });

    // Définir les headers pour le téléchargement du PDF
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'inline; filename="' . $filename . '"');

    return $response;
}

    public function generate(string $html): string
    {
        // Générer le PDF et le renvoyer sous forme de chaîne
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4');
        $this->pdf->render();

        return $this->pdf->output();
    }
}
