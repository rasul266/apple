<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Apple;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Generate Apple', ['generate'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',

            [

                'attribute' => 'color',
                'contentOptions' => function($model) {
                    return [
                        'style' =>'color:'.$model->color ];
                    }
            ],

                [

                'attribute' => 'size',
                'value' => function($model) {
                    return $model->size/Apple::DEFAULT_SIZE;
                    }
            ],

            'created_at:datetime',
            'fall_date:datetime',

            [
                'filter' => Apple::getStatusList(),
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Apple $model */
                    return $model->getStatusName();
              }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{fall} {eat} {delete} ',
                'buttons' => [

                    'fall' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url,
                                ['title' => 'Упасть', 'class' => 'btn btn-default btn-sm']);
                    },
                    'eat' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-apple"></span>', $url,
                                ['title' => 'Съесть', 'class' => 'btn btn-default btn-sm']);
                    },

                    'delete' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                ['title' => 'Удалить', 'class' => 'btn btn-default btn-sm']);
                    }
                ],
            ],
        ],
    ]);
  ?>


</div>
