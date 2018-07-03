<?php  

require_once('tcpdf/tcpdf.php');

// Note : Upload the library files and set the path accordingly . They are too many to be uploaded here in this repo . Thanks

class MyPDF extends TCPDF {

    //Page header
    public function Header() {
        
        // Logo
       
        $this->Image('https://img.etimg.com/thumb/msid-60825620,width-300,imgsize-46830,resizemode-4/cardekho-com-ties-up-with-hero-fincorp-for-used-car-financing.jpg', 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // Title
        $this->Cell(0, 15, 'Trial SPDF', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
// create new PDF document
$pdf = new MyPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Parth Poply');
$pdf->SetTitle('Signed PDF Example');
$pdf->SetSubject('Trial SPDF');


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'tcpdf/examples/lang/eng.php')) {
    require_once(dirname(__FILE__).'tcpdf/examples/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

/*
NOTES:
 - To create self-signed signature: openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout tcpdf.crt -out tcpdf.crt
 - To export crt to p12: openssl pkcs12 -export -in tcpdf.crt -out tcpdf.p12
 - To convert pfx certificate to pem: openssl pkcs12 -in tcpdf.pfx -out tcpdf.crt -nodes
*/

// set certificate file
$certificate = 'file://tcpdf/examples/data/cert/tcpdf.crt';

// set additional information
$info = array(
    'Name' => 'TrialSPDF',
    'Location' => 'MyPC',
    'Reason' => 'Testing TCPDF',
    'ContactInfo' => 'http://www.tcpdf.org',
    );

// set document signature
$pdf->setSignature($certificate, $certificate, 'tcpdfdemo', '', 2, $info);

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// printing user input text

$text = $_POST["text_area"];    //Collecting text-box input
$pdf->Ln(4);
$pdf->MultiCell(190,10,$text);
$pdf->Ln(20);
$pdf->Cell(45,10,'Made by Parth Poply.',1,1);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// *** set signature appearance ***

// create content for signature (image and/or text)
$pdf->Image('https://lh5.googleusercontent.com/-REbPTHeDpKQ/VQbQRRtx1dI/AAAAAAAAJq4/jaQVmTwH2IQ/w494-h150-no/123FormBuilder-Style-Signature-Box-No-Borders.png', 150, 60, 150, 40, 'PNG');

// define active area for signature appearance
$pdf->setSignatureAppearance(150, 60, 30, 30);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


//Close and output PDF document
$pdf->Output('example_spdf.pdf', 'D');

?>
