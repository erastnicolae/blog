<?php
// var_dump($model); die();
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
// use yii\helpers\VarDumper;
// VarDumper::dump(substr($model->content,0,strpos($model->content,PHP_EOL)),100,1); die;
?>

<p>
	<h2><?=Html::a(Html::encode($model->title), ['view', 'id' => $model->id]); ?></h2>
	<i>by</i> <?=Html::a(Html::encode($model->createdBy->email),['site/contact','subject' => 'To '.Html::encode($model->createdBy->email).', article "'.Html::encode($model->title).'"']); ?>
	<i>on</i> <?=Html::encode(strftime('%d.%m.%Y %H:%m',$model->created_at)); ?>
	
	<?php
	if ($model->created_at != $model->updated_at)
		echo ' <i>last update</i> '.Html::encode(strftime('%d.%m.%Y %H:%m',$model->updated_at));
	?>
	<br><br>
	
	<?=HtmlPurifier::process(substr($model->content,0,strpos($model->content,PHP_EOL))); ?>
	... <?=Html::a('read more', ['view', 'id' => $model->id]); ?>
</p>
