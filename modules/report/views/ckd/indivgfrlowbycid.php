<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = 'CKD_GFR ต่ำ แยกตามหมู่บ้าน';
$datas = $dataProvider->getModels();
?>

<a href="#" id="btn_sql">ชุดคำสั่ง</a>
<div id="sql" style="display: none"><?= $sql ?></div>
<br>



<?php
if (isset($dataProvider))
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
            'heading' => ' CKD_GFR ต่ำ แยกตามหมู่บ้าน   ',
            'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'NAME',
                'label' => 'NAME',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'LNAME',
                'label' => 'LNAME',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'cid',
                'label' => 'CID',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'gfr58_gfr',
                'label' => 'gfr58_gfr',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'gfr59_gfr',
                'label' => 'gfr59_gfr',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'gfr_decline',
                'label' => 'gfr_decline',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'gfr59_stage',
                'label' => 'gfr59_stage',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'gfr59_substage',
                'label' => 'gfr59_substage',
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
