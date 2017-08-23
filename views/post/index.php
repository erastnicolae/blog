<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'layout' => "{items}\n{pager}",
            'itemView' => '_items'
            // 'itemView' => function ($model, $key, $index, $widget) {
            //     return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
            // },

        ])
    ?>
</div>
