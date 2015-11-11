<?php
require(__DIR__ . "/vendor/autoload.php");

define('_MPDF_TEMP_PATH', "./tmp/");
define('_MPDF_TTFONTDATAPATH', "./tmp/");

$html = file_get_contents(__DIR__ . "/resume.html");
$filepath = __DIR__ . "/output/resume.pdf";

echo "Rendering PDF..." . PHP_EOL;

$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output($filepath, 'F');
//exit;

echo "done." . PHP_EOL;
