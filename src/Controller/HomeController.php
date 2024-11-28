<?php 
namespace App\Controller;
 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PdfGeneratorService;
use FontLib\Table\Type\name;
use Src\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    #[Route('/',name:'app_home')]
    public function index() :Response{
        return $this->render("test.html.twig",[
            "controller_name"=> "HomeController"
        ]);}

    #[Route('/generate-pdf',name:'app_generate_pdf')]
        public function generate(PdfGeneratorService $pdfGeneratorService) :Response{

            $html=$this->renderView('pdf.html.twig');
        $content=$pdfGeneratorService->generate($html);
        return new Response($content,200,['Content-Type'=>'application/pdf',]);
        }

        #[Route(path: '/stream-pdf',name:'app_stream_pdf')]
        public function streamPdf(PdfGeneratorService $pdfGeneratorService) :Response{
       
            $html=$this->renderView('pdf.html.twig');
        // Utiliser la méthode pour générer et streamer le PDF
        $response = $pdfGeneratorService->getStreamResponse($html, 'hello.pdf');
      
        // Ajouter un en-tête pour forcer le téléchargement
        $response->headers->set('Content-Disposition', 'attachment; filename="hello.pdf"');

        
       
        return $response;
        }
}