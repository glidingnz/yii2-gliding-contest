<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\DefaultType $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="default-type-form">

	<?php $form = ActiveForm::begin([
		'id' => 'DefaultType',
		'layout' => 'horizontal',
		'enableClientValidation' => true,
		'errorSummaryCssClass' => 'error-summary alert alert-danger',
		'fieldConfig' => [
			'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			'horizontalCssClasses' => [
				'label' => 'col-sm-2',
				#'offset' => 'col-sm-offset-4',
				'wrapper' => 'col-sm-8',
				'error' => '',
				'hint' => '',
			],
		],
		]
	);
	?>

	<div class="">
		<?php $this->beginBlock('main'); ?>

		<p>


			<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'disabled'=>!$model->isNewRecord]) ?>

			<!-- attribute description -->
			<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

			<!-- attribute credit -->
			<?=  $form->field($model, 'credit')->dropDownList(
				\app\models\DefaultType::optscredit()
			); ?>

			<!-- attribute price -->
			<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
		</p>
		<?php $this->endBlock(); ?>

		<?=
		Tabs::widget(
			[
				'encodeLabels' => false,
				'items' => [ 
					[
						'label'   => Yii::t('models', 'DefaultType'),
						'content' => $this->blocks['main'],
						'active'  => true,
					],
				]
			]
		);
		?>
		<hr/>

		<?php echo $form->errorSummary($model); ?>

		<?= Html::submitButton(
			'<span class="glyphicon glyphicon-check"></span> ' .
			($model->isNewRecord ? 'Create' : 'Save'),
			[
				'id' => 'save-' . $model->formName(),
				'class' => 'btn btn-success'
			]
		);
		?>

		<?php ActiveForm::end(); ?>

	</div>

</div>

