<?php

use app\models\Comment;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    by <?=Html::a(Html::encode($model->createdBy->email),['site/contact','subject' => 'To '.Html::encode($model->createdBy->email).', article "'.Html::encode($model->title).'"']); ?>
    on <?=Html::encode(strftime('%d.%m.%Y %H:%m',$model->created_at)); ?>
    
    <br><br>
        <?=HtmlPurifier::process(nl2br($model->content)); ?>
    <br><br>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?php
        if (Yii::$app->user->id == $model->created_by or Yii::$app->user->id == 1) {
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

    <?php
        echo Html::tag('h3','Comments');
        
        Pjax::begin(['id'=>'comment-list']);

        if(count($model->comments)) {
            foreach($model->comments as $comment) {
                echo 'posted by ';
                if(!$comment->created_by)
                    echo Html::tag('strong','anonymous');
                else
                    echo Html::a(Html::encode($comment->createdBy->email),['site/contact','subject' => 'To '.Html::encode($comment->createdBy->email).', comment on "'.Html::encode($model->title).'"']);
                echo ' on ' ;
                echo strftime('%d.%m.%Y %H:%m',$model->created_at);
                echo '<p>'.$comment->content;
                if (Yii::$app->user->id == $model->created_by or Yii::$app->user->id == $comment->created_by or Yii::$app->user->id == 1)
                    echo Html::a('delete',['deletecom','id' => $comment->id],[
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this comment?',
                            'method' => 'post'
                        ]
                    ]);
                 echo '</p>';
            }
        }
        else {
            echo Html::tag('p','there are no comments so far, you can comment below');
        }
        
        Pjax::end();

    ?>

    <?php
        $comment = new Comment();
        $form = ActiveForm::begin([
            'id' => 'comment-create',
            'action' => ['create-comment'],
            ]);
        
        echo $form->field($comment, 'content')->textarea(['rows' => 3])->label(false);
        echo Html::activeHiddenInput($comment,'post_id',['value' => $model->id]);
    ?>

    <div class="form-group">
        <?php
        echo Html::submitButton('Post a comment', ['class' => 'btn btn-success', 'id' => 'comment-submit']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
$('form#comment-create').on('beforeSubmit',function(e) {
    var form = $(this);
    $.post (
        form.attr("action"),
        form.serialize()
    )
    .done(function(result) {
        form.trigger('reset');
        $.pjax.reload({container:'#comment-list'});
    })
    return false;
});
JS;
$this->registerJS($script);

?>
