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

<?php if($appleList):?>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Цвет</th>
            <th scope="col">Сколько съели (%)</th>
            <th scope="col">Дата появления</th>
            <th scope="col">Дата падения</th>
            <th scope="col">Состояние</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($appleList as $apple):?>
        <tr>
            <td style="color:<?=$apple->color?>"><?=$apple->color?></td>
            <td><?=$apple->size/Apple::MAX_SIZE?></td>
            <td><?=$apple->date?></td>
            <td><?=$apple->fallDate?></td>
            <td><?=$apple->statusName?></td>
            <td>

                <a class='btn btn-default btn-sm' title="Упасть" href="<?=\yii\helpers\Url::to(['/apple/fall','id'=>$apple->id])?>">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>

                <?= Html::beginForm('eat','pos')?>
                <?=Html::input('number','percent','',['style'=>'width:50px','placeholder'=>'%'])?>
                <?=Html::hiddenInput('id',"$apple->id")?>
                <?=Html::submitInput('Съесть')?>
               <?=Html::endForm()?>

                <a class='btn btn-default btn-sm' title="Удалить" href="<?=\yii\helpers\Url::to(['/apple/delete','id'=>$apple->id])?>">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>

            </td>
        </tr>

        <?php endforeach;?>

        </tbody>
    </table>
<?php else:?>
      <h4 class="text-center">Яблок пока нет</h4>
    <?php endif;?>
</div>
