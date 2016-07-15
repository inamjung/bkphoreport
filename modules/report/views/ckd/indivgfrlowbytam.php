<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = 'CKD_GFR ต่ำ แยกตามตำบล';
$datas = $dataProvider->getModels();
?>

<a href="#" id="btn_sql">ชุดคำสั่ง</a>
<div id="sql" style="display: none"><?= $sql ?></div>
<br>


<?php
if (isset($dataProvider))
//$dev = \yii\helpers\Html::a('คุณไอน้ำ เรืองโพน', 'https://fb.com/inam06', ['target' => '_blank']);
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
        'responsive' => TRUE,
        'hover' => true,
        'striped' => false,
        'floatHeader' => true,
        'toolbar' => [
            '{export}' => false,
            '{toggleData}' => false
        ],
        'panel' => [
            'heading' => ' CKD_GFR ต่ำ แยกตามตำบล   ',
            'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
            'attribute' => 'tamboncode',
            'label' => 'TAMBONCODE',
            'format' => 'raw',
            'value' => function($model)use($ampurcode) {
                return Html::a(Html::encode($model['tamboncode']), [
                            'ckd/indivgfrlowbyvill/',
                            'tamboncode' => $model['tamboncode'],
                            //'ampurcode'=>$ampurcode
                ]);
            },
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
//            [
//                'attribute' => 'ampurcode',
//                'label' => 'AMPURCODE',
//                'headerOptions' => ['class' => 'text-center'],
//                'contentOptions' => ['class' => 'text-left'],
//            ],
//            [
//                'attribute' => 'c_ampurname',
//                'label' => 'AMPURNAME',
//                'headerOptions' => ['class' => 'text-center'],
//                'contentOptions' => ['class' => 'text-left'],
//            ],
            
            [
                'attribute' => 'c_tambonname',
                'label' => 'TAMBONNAME',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                    'class' => 'kartik\grid\DataColumn',
                    'pageSummary' => true,
                    'attribute' => 'cc', 
                    'format' => 'integer',
                    'label' => 'เป้า(คน)',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                    [
                    'class' => 'kartik\grid\DataColumn',
                    'pageSummary' => true,
                    'attribute' => 'ct', 
                    'format' => 'integer',
                    'label' => 'ผลงาน(คน)',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
        ]
    ]);
?>

<?php
$script = <<< JS
$(function(){
    $("label[title='Show all data']").hide();
});
        
$('#btn_sql').on('click', function(e) {
    
   $('#sql').toggle();
});
JS;
$this->registerJs($script);
?>
