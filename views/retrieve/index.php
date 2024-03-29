<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\date\DatePicker;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\Retrieve $searchModel
*/

$this->title = Yii::t('models', 'Retrieves');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
	$actionColumnTemplate = implode(' ', $actionColumnTemplates);
	$actionColumnTemplateString = $actionColumnTemplate;
} else {
	Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
	$actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud retrieve-index">

	<?php
	//             echo $this->render('_search', ['model' =>$searchModel]);
	?>


	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	<h1>
		<?= Yii::t('models', 'Retrieves') ?>
		<small>
			List
		</small>
	</h1>
	<div class="clearfix crud-navigation">
		<?php if(\Yii::$app->user->can('app_retrieve_create', ['route' => true])){ ?>
			<div class="pull-left">
				<?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Record Aero Retrieve', ['manage'], ['class' => 'btn btn-success']) ?>
			</div>
		<?php } ?>
		<?php if(\Yii::$app->user->can('app_retrieve_create', ['route' => true])){ ?>
			<div class="pull-right">


				<?= 
				\yii\bootstrap\ButtonDropdown::widget(
					[
						'id' => 'giiant-relations',
						'encodeLabel' => false,
						'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . 'Relations',
						'dropdown' => [
							'options' => [
								'class' => 'dropdown-menu-right'
							],
							'encodeLabels' => false,
							'items' => [
								[
									'url' => ['pilot/index'],
									'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Pilot'),
								],
								[
									'url' => ['towplane/index'],
									'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Towplane'),
								],

							]
						],
						'options' => [
							'class' => 'btn-default'
						]
					]
				);
				?>
			</div>
		<?php } ?>
	</div>

	<hr />

	<div class="table-responsive">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'pager' => [
				'class' => yii\widgets\LinkPager::class,
				'firstPageLabel' => 'First',
				'lastPageLabel' => 'Last',
			],
			'filterModel' => $searchModel,
			'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
			'headerRowOptions' => ['class'=>'x'],
			'columns' => [
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => $actionColumnTemplateString,
					'buttons' => [
						'view' => function ($url, $model, $key) {
							$options = [
								'title' => Yii::t('cruds', 'View'),
								'aria-label' => Yii::t('cruds', 'View'),
								'data-pjax' => '0',
							];
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
						}
					],
					'urlCreator' => function($action, $model, $key, $index) {
						// using the column name as key, not mapping to 'id' like the standard generator
						$params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
						$params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
						return Url::toRoute($params);
					},
					'contentOptions' => ['nowrap'=>'nowrap']
				],
				[
					'attribute'=>'date',
					'value' =>'date',
					'filter'=>DatePicker::widget([
						'model' => $searchModel,
						'attribute'=>'date',
						'pluginOptions' => [
							'autoclose' => true,
							'todayHighlight' => true,
							'todayBtn' => true,
							'format' => 'yyyy-mm-dd'
						]
					])       
				],
				// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
				[
					'class' => yii\grid\DataColumn::class,
					'attribute' => 'towplane_id',
					'value' => function ($model) {
						if ($rel = $model->towplane) {
							return Html::a($rel->name, ['towplane/view', 'id' => $rel->id,], ['data-pjax' => 0]);
						} else {
							return '';
						}
					},
					'format' => 'raw',
				],
				// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
				[
					'class' => yii\grid\DataColumn::class,
					'attribute' => 'pilot_id',
					'value' => function ($model) {
						if ($rel = $model->pilot) {
							return Html::a($rel->person->name, ['pilot/view', 'id' => $rel->id,], ['data-pjax' => 0]);
						} else {
							return '';
						}
					},
					'format' => 'raw',
				],
			]
		]); ?>
	</div>

</div>


<?php \yii\widgets\Pjax::end() ?>


