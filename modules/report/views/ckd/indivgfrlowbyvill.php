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
        'heading' => 'CKD_GFR ต่ำ แยกตามหมู่บ้าน',
        'type' => \kartik\grid\GridView::TYPE_PRIMARY,
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'u_code',
            'label' => 'VILLAGECODE',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a(Html::encode($model['u_code']), [
                            'ckd/indivgfrlowbycid/',
                            'villagecodefull' => $model['u_code'],
                ]);
            },
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
        [
                    'attribute' => 'u_code',
                    'label' => 'u_code',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'u_name',
                    'label' => 'u_name',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ], 
                [
                    'attribute' => 'y_proc',
                    'label' => 'y_proc',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'm_proc',
                    'label' => 'm_proc',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'A',
                    'format' => 'integer',
                    'label' => 'A',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'B',
                    'format' => 'integer',
                    'label' => 'B',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                    [
                    'class' => 'kartik\grid\DataColumn',
                   // 'pageSummary' => true,
                    'attribute' => 'rate',
                    'format' => 'integer',
                    'label' => 'ร้อยละ( B/A)*100',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                    [
                    'attribute' => 'stage1',
                    'label' => 'stage1',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                     [
                    'attribute' => 'stage2',
                    'label' => 'stage2',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                     [
                    'attribute' => 'stage3',
                    'label' => 'stage3',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                     [
                    'attribute' => 'stage4',
                    'label' => 'stage4',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                ],
                     [
                    'attribute' => 'stage5',
                    'label' => 'stage5',
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
