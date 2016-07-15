<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;

$this->params['breadcrumbs'][] = '';
$datas = $dataProvider->getModels();
?>

<?php

//echo yii\grid\GridView::widget([
echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
    'responsive' => TRUE,
    'hover' => true,
    'striped' => false,
    'floatHeader' => true,
    'showPageSummary' => true,
    'toolbar' => [
        '{export}' => false,
        '{toggleData}' => false
    ],
    'panel' => [
        'heading' => 'CKD_GFR ต่ำ แยกตามอำเภอ',
//        'heading' => 'โปรแกรม : ' . $datas[0]['proname'],
//        'before' => 'ระดับความรุนแรง : ' . $datas[0]['levels'],
        'type' => \kartik\grid\GridView::TYPE_PRIMARY,
    //'after' => 'พัฒนาโดย ' . $dev
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'ampurcode',
            'label' => 'AMPURCODE',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a(Html::encode($model['ampurcode']), [
                            'ckd/indivgfrlowbytam/',
                            'ampurcode' => $model['ampurcode'],
                ]);
            },
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'c_ampurname',
                    'label' => 'HOSPNAME',
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

<?php echo Highcharts::widget([
    'options'=>[        
        'title'=>['text'=>'CKD_GFR ต่ำ แยกตามอำเภอ'],
        'xAxis'=>[
            'categories'=>$c_ampurname
        ],
        'yAxis'=>[
            'title'=>['text'=>'จำนวน(คน)']
        ],
        'series'=>[
            [
                'type'=>'column',
                'name'=>'เป้าหมาย',
                'data'=>$cc,
                'dataLabels'=>[
                    'enabled'=>true,
                ]
            ],
            [
                'type'=>'column',
                'name'=>'ผลงาน',
                'data'=>$ct,
                'dataLabels'=>[
                    'enabled'=>true,
                ]
            ],
            
        ]
    ]
]);?>