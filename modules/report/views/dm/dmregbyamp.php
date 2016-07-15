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
        'heading' => '',
        'type' => \kartik\grid\GridView::TYPE_INFO,  
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        
        [
            'attribute' => 'c_ampurcodefull',
            'label' => 'AMPURCODE',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a(Html::encode($model['c_ampurcodefull']), [
                            'dm/indivdmregbytam/',
                            'ampurcode' => $model['c_ampurcodefull'],
                ]);
            },
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
        [
                    'attribute' => 'c_ampurcodefull',
                    'label' => 'AMPCODE',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'c_ampurname',
                    'label' => 'AMPNAME',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'pageSummary' => true,
                    'attribute' => 'regandunreg', 
                    'format' => 'integer',
                    'label' => 'จำนวนทั้งหมด(คน)',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                    [
                    'class' => 'kartik\grid\DataColumn',
                    'pageSummary' => true,
                    'attribute' => 'reg', 
                    'format' => 'integer',
                    'label' => 'มีในทะเบียน(คน)',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
        [
                    'class' => 'kartik\grid\DataColumn',
                    'pageSummary' => true,
                    'attribute' => 'unreg', 
                    'format' => 'integer',
                    'label' => 'ไม่มีในทะเบียน(คน)',
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
