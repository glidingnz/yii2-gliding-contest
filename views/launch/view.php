<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Launch $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Launch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Launches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud launch-view">

	<!-- flash message -->
	<?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
		<span class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			<?= \Yii::$app->session->getFlash('deleteError') ?>
		</span>
	<?php endif; ?>

	<h1>
		<?= Yii::t('models', 'Launch') ?>
		<small>
			<?= Html::encode($model->id) ?>
		</small>
	</h1>


	<div class="clearfix crud-navigation">

		<!-- menu buttons -->
		<div class='pull-left'>
			<?= Html::a(
				'<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
				[ 'update', 'id' => $model->id],
				['class' => 'btn btn-info']
			) ?>

			<?= Html::a(
				'<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
				['create', 'id' => $model->id, 'Launch'=>$copyParams],
				['class' => 'btn btn-success']
			) ?>

			<?= Html::a(
				'<span class="glyphicon glyphicon-plus"></span> ' . 'New',
				['create'],
				['class' => 'btn btn-success']
			) ?>
		</div>

		<div class="pull-right">
			<?= Html::a('<span class="glyphicon glyphicon-list"></span> '
				. 'Full list', ['index'], ['class'=>'btn btn-default']) ?>
		</div>

	</div>

	<hr/>

	<?php $this->beginBlock('\app\models\Launch'); ?>


	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
			[
				'format' => 'html',
				'attribute' => 'towplane_id',
				'value' => ($model->towplane ?
					Html::a('<i class="glyphicon glyphicon-list"></i>', ['towplane/index']).' '.
					Html::a('<i class="glyphicon glyphicon-circle-arrow-right"></i> '.$model->towplane->name, ['towplane/view', 'id' => $model->towplane->id,]).' '.
					Html::a('<i class="glyphicon glyphicon-paperclip"></i>', ['create', 'Launch'=>['towplane_id' => $model->towplane_id]])
					:
					'<span class="label label-warning">?</span>'),
			],
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
			[
				'format' => 'html',
				'attribute' => 'pilot_id',
				'value' => ($model->pilot ?
					Html::a('<i class="glyphicon glyphicon-list"></i>', ['pilot/index']).' '.
					Html::a('<i class="glyphicon glyphicon-circle-arrow-right"></i> '.$model->pilot->name, ['pilot/view', 'id' => $model->pilot->id,]).' '.
					Html::a('<i class="glyphicon glyphicon-paperclip"></i>', ['create', 'Launch'=>['pilot_id' => $model->pilot_id]])
					:
					'<span class="label label-warning">?</span>'),
			],
			'date',
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
			[
				'format' => 'html',
				'attribute' => 'transaction_id',
				'value' => ($model->transaction ?
					Html::a('<i class="glyphicon glyphicon-list"></i>', ['transaction/index']).' '.
					Html::a('<i class="glyphicon glyphicon-circle-arrow-right"></i> '.$model->transaction->id, ['transaction/view', 'id' => $model->transaction->id,]).' '.
					Html::a('<i class="glyphicon glyphicon-paperclip"></i>', ['create', 'Launch'=>['transaction_id' => $model->transaction_id]])
					:
					'<span class="label label-warning">?</span>'),
			],
		],
	]); ?>


	<hr/>

	<?= Html::a(
		'<span class="glyphicon glyphicon-trash"></span> ' . 'Delete',
		['delete', 'id' => $model->id],
		[
			'class' => 'btn btn-danger',
			'data-confirm' => '' . 'Are you sure to delete this item?' . '',
			'data-method' => 'post',
		]
	); ?>
	<?php $this->endBlock(); ?>



	<?= Tabs::widget(
		[
			'id' => 'relation-tabs',
			'encodeLabels' => false,
			'items' => [
				[
					'label'   => '<b class=""># '.Html::encode($model->id).'</b>',
					'content' => $this->blocks['\app\models\Launch'],
					'active'  => true,
				],
			]
		]
	);
	?>
</div>
