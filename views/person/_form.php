<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\Person $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="person-form">

	<?php $form = ActiveForm::begin([
		'id' => 'Person',
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


			<!-- attribute contest_id -->
			<?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
			$form->field($model, 'contest_id')->dropDownList(
				\yii\helpers\ArrayHelper::map(app\models\Contest::find()->all(), 'id', 'name'),
				[
					'prompt' => 'Select',
					'disabled' => (isset($relAttributes) && isset($relAttributes['contest_id'])),
				]
			); ?>

			<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<!-- attribute role -->
			<?=                         $form->field($model, 'role')->dropDownList(
				\app\models\Person::optsrole()
			); ?>
			<!-- attribute address1 -->
			<?= $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>

			<!-- attribute address2 -->
			<?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>

			<!-- attribute address3 -->
			<?= $form->field($model, 'address3')->textInput(['maxlength' => true]) ?>

			<!-- attribute postcode -->
			<?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>
			<!-- attribute telephone -->
			<?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

		</p>
		<?php $this->endBlock(); ?>

		<?=
		Tabs::widget(
			[
				'encodeLabels' => false,
				'items' => [ 
					[
						'label'   => Yii::t('models', 'Person'),
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

