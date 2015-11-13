<?php
require(__DIR__ . "/vendor/autoload.php");

define('_MPDF_TEMP_PATH', "./tmp/");
define('_MPDF_TTFONTDATAPATH', "./tmp/");

$outputDir    = __DIR__ . "/output/";
$filepathPDF  = $outputDir . "resume.pdf";
$filepathHTML = $outputDir . "resume.html";

// make output and temporary directories
if (!is_dir(_MPDF_TEMP_PATH)) {
    mkdir(_MPDF_TEMP_PATH);
}
if (!is_dir($outputDir)) {
    mkdir($outputDir);
}

// build resume
ob_start();
require(__DIR__ . "/src/resume.php");
$html = ob_get_clean();

echo "Rendering PDF..." . PHP_EOL;

file_put_contents($filepathHTML, $html);

// render PDF
$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output($filepathPDF, 'F');

echo "done." . PHP_EOL;
