<?php

namespace backend\controllers;

use rudissaar\fpdf\FPDF;
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
        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('times', 'B', 15);
        $pdf->Cell(40, 10, 'Hello World');
        $pdf->Output('D', Yii::$app->basePath.'/web/tmp/contract.pdf');
    }
}