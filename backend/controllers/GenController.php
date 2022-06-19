<?php

namespace backend\controllers;

use rudissaar\fpdf\FPDF;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;
use Yii;


class GenController extends Controller {

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] =[
            'class'=>Cors::className()
        ];

        $behaviors['formats'] = [
            'class'=>'yii\filters\ContentNegotiator',
            'formats'=>[
                'application/json'=>Response::FORMAT_JSON
            ]
        ];
        return $behaviors;
    }


    public function actionIndex(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            return $this->generate($post);
        }else{
            return -1;
        }
        return null;
    }

    public function generate($data){

        $this->layout = 'empty';
        try {

            $html2pdf = new Html2Pdf('P', 'A4', 'ru',true,'cp1252',[30,12.5,15,20]);
//            $html2pdf->setDefaultFont('dejavusanscondensed');
            $html2pdf->setDefaultFont('Cambria');
//            $html2pdf->pdf->setDisplayMode('fullpage');
            $html2pdf->writeHTML(
                $this->render('contract')
            );
            error_reporting(0);
            $html2pdf->createIndex('',32,12);

            $html2pdf->output('contact.pdf');
            exit;

        }catch (Html2PdfException  $e){
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }

    }
}