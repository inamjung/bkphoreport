<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = '';
$datas = $dataProvider->getModels();
?>


<a href="#" id="btn_sql">ชุดคำสั่ง</a>
<div id="sql" style="display: none"><?= $sql ?></div>
<br>

<?php

//echo yii\grid\GridView::widget([
echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
    'responsive' => TRUE,
    'hover' => true,
    'striped' => false,
    'floatHeader' => true,
//    'exportConfig'=>[
//            GridView::EXCEL =>[],
//            GridView::PDF=>[],     
//            ],
           'toolbar' => [        
                '{export}'=>false,
                '{toggleData}'=>false
            ],
    'panel' => [
//        'heading' => 'โปรแกรม : ' . $datas[0]['proname'],
//        'before' => 'ระดับความรุนแรง : ' . $datas[0]['levels'],
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        //'after' => 'พัฒนาโดย ' . $dev
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'HOSPCODE',
            'label' => 'HOSPCODE',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'CID',
            'label' => 'CID',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'PID',
            'label' => 'PID',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'pname',
            'label' => 'pname',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'SEX',
            'label' => 'SEX',
            //'value' => $sql->SEX == '1' ? "ชาย" : "หญิง",
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'BIRTH',
            'label' => 'BIRTH',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
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
