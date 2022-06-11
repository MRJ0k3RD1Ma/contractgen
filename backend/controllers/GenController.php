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
    }

    public function generate($data){

        try {

            $html2pdf = new Html2Pdf('P', 'A4', 'ru',true,'UTF-8',[0,0,0,0]);
            $html2pdf->pdf->setDisplayMode('fullpage');
            $html2pdf->writeHTML(
                $this->render('contract')
            );
            error_reporting(0);
            $html2pdf->createIndex('',32,12,false,1,'helvetica');

            $html2pdf->output('contact.pdf','D');
            exit;

        }catch (Html2PdfException $e){
            $formatter = new ExceptionFormatter($e);
            return $formatter->getMessage();
        }

    }
}