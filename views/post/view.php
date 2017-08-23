<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\captcha\Captcha;
use yii\widgets\ActiveForm;
use app\models\Comment;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    by <?=Html::a(Html::encode($model->createdBy->email),['site/contact','subject' => 'To '.Html::encode($model->createdBy->email).', article "'.Html::encode($model->title).'"']); ?>
    on <?=Html::encode(strftime('%d.%m.%Y %H:%m',$model->created_at)); ?>
    
    <br><br>
        <?=HtmlPurifier::process(nl2br($model->content)); ?>
    <br><br>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?php
        if ($model->created_by == Yii::$app->user->id) {
            echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo '&nbsp';
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post'
                ]
            ]);
        }
        ?>
    </p>

    <?php foreach($model->comments as $comment): ?>
    <br><?= $comment->content; ?><br><br>
    <?php endforeach; ?>

    <?php
        $comment = new Comment();
        $form = ActiveForm::begin([
            'action' => ['comment/create'],
            ]);
        
        echo $form->field($comment, 'content')->textarea(['rows' => 6])->label(false);
        echo Html::activeHiddenInput($comment,'post_id',['value' => $model->id]);
    ?>

    <div class="form-group">
        <?php
        // echo $form->field($comment, 'verifyCode')
        //     ->widget(Captcha::className(), [
        //         'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-3">{input}</div></div>'
        //     ])->label(false);
        echo Html::submitButton('Create', ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
