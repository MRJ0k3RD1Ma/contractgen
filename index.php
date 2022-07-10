<?php
// Require composer autoload
    require_once __DIR__ . '/vendor/autoload.php';

    use GuzzleHttp\Client;
    use Mpdf\Mpdf;

    function debug($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        die();
    }

    $client = new Client();
    $id = $_GET['id'];
    $lang = $_GET['lang'];
    $resServer = $client->request("GET", "https://app.zerox.uz/api/v1/generatepdf/$id", [
        'query' => [],
    ]);
    if ($resServer->getStatusCode() == 200) {
        $body = json_decode($resServer->getBody(), true);
    } else {
        die();
    }

    $res = $client->request('GET', 'http://pdf.lc/templates/source.php', [
        'query' => ['id'=>$id,'body' => $body, 'lang' => $lang],
    ]);

    $body = $res->getBody();
//echo $body;
//exit;
$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
//        'cssFile' => __DIR__.'/templates/fonts/custom.css',
        /*'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/templates/fonts/',
        ]),
        'fontdata' => $fontData + [
                'cambria' => [
                    'R' => 'Cambria.ttf',
                    'I' => 'Cambria-Italic.ttf',
                    'B' => 'Cambria-Bold.ttf',
                    'BI' => 'Cambria-BoldItalic.ttf',
                ]
            ],
        'default_font' => 'cambria'*/
//        'default_font_size' => 9,
        'default_font' => 'times'
    ]);

$mpdf->setFooter('{PAGENO}');

$stylesheet = file_get_contents(__DIR__.'/templates/fonts/custom.css');

$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($body);

//    $mpdf->WriteHTML($body);
    $mpdf->Output();
