<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\Contest $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="contest-form">

	<?php $form = ActiveForm::begin(
		[
			'id' => 'Contest',
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


			<!-- attribute club_id -->
			<?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
			$form->field($model, 'club_id')->dropDownList(
				\yii\helpers\ArrayHelper::map(app\models\Club::find()->all(), 'id', 'name'),
				[
					'prompt' => 'Select',
					'disabled' => (isset($relAttributes) && isset($relAttributes['club_id']))||!$model->isNewRecord,
				]
			); ?>
			<?=
			$form->field($model, 'gnz_id')->dropDownList(
				Yii::$app->gnz->getContestList(),
				[
					'prompt' => 'Select',
					'disabled' => (isset($relAttributes) && isset($relAttributes['gnz_id']))||!$model->isNewRecord,
				]
			); ?>

			<!-- attribute igcfiles -->
			<?= $form->field($model, 'igcfiles')->textInput(['maxlength' => true]) ?>
		</p>
		<?php $this->endBlock(); ?>

		<?php $this->beginBlock('help'); ?>

		<div class="container">
			<div class="row">
				<div class="col-md-10 col-sm-2 col-12">
					<div class="card h-100">
						<h3 class="card-title">How to Copy the Contest Trace Files to the Scoring Computer</h3>
						<div class="text-center">
							<a href="https://winscp.net/eng/download.php" target="_blank" class="btn btn-primary">Download WinSCP</a>
						</div>
						<div class="text-left">
						<ul>
							<li>Download and Install WinSCP version 5.17.9 or Later</li>
							<li>Run WinSCP</li>
							<li>Log In to a New Site .... Hostname = <?= yii\helpers\Url::base(true)?> ,   Port = 22,   Username = igcfiles , password = igcfiles</li>
							<li>Browse to the "Local" directory on the Scoring Computer where the IGC files are received</li>
							<li>Browse to the "Remote" directory on the Contest Server where the IGC files are uploaded (igcfiles / &ltyour contest&gt>)</li>
							<li>Commands -&gt Static Custom Commands -&gt Keep Local Directory Up to Date</li>
							<li>Any new IGC Trace files will be copied to the scoring computer every 30 seconds</li>
						</ul>
						</div>
						<div class=text-center>
							<a href="https://winscp.net/eng/docs/library_example_keep_local_directory_up_to_date#options" target="_blank" class="btn btn-primary">WinSCP Script Details</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<?php $this->endBlock(); ?>
		<?=
		Tabs::widget(
			[
				'encodeLabels' => false,
				'items' => [
					[
						'label'   => Yii::t('models', 'Contest'),
						'content' => $this->blocks['main'],
						'active'  => true,
					],
					[
						'label'   => 'Help',
						'content' => $this->blocks['help'],
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

