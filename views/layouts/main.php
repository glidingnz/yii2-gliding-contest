<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this->registerCsrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>
	<body>
		<?php $this->beginBody() ?>

		<div class="wrap">
			<?php
			NavBar::begin([
				'brandLabel' => Yii::$app->name,
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
					'class' => 'navbar-inverse navbar-fixed-top',
				],
			]);


			if (\Yii::$app->user->isGuest){
				$contest_id = 0;
			}
			else{
				$contest_id = \yii::$app->user->identity->profile->contest_id;
			}

			$contest = app\models\Contest::findOne(['id'=>$contest_id]);
			$contest = $contest->name ?? 'No Contest Selected';


			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-left navbar-active'],
				'items' => [
					Yii::$app->user->isGuest ? ( ['label'=>'No Contest Selected']) : (['label'=> $contest, 'url' => ['/user/settings']]), 
				],
			]);
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'Contest Management', 'visible'=>!Yii::$app->user->isGuest,
						'items'=> [
							['label' => 'Launches', 'url' => ['/launch/manage']],
							['label' => 'Status', 'url' => ['/status/manage']],
							['label' => 'Tracking', 'url' => ['/track']],
							['label' => 'Landouts', 'url' => ['/landout']],
							['label' => 'Aero Retrieves', 'url' => ['/retrieve/manage']],
							['label' => 'Accounts', 'url' => ['/transaction/manage']],
							['label' => 'Prices', 'url' => ['/transaction-type']],
							['label' => 'Pilots', 'url' => ['/pilot']],
							['label' => 'Towplanes', 'url' => ['/towplane']],
						],
					],
					['label' => 'Contest Admin', 'visible'=>Yii::$app->user->can('Administrator') or Yii::$app->user->can('Director') ,
						'items'=> [
							['label' => 'Clubs', 'url' => ['/club']],
							['label' => 'Contests', 'url' => ['/contest']],
							['label' => 'Default Prices', 'url' => ['/default-type']],
						],
					],
					['label' => 'User Admin', 'visible'=>Yii::$app->user->can('Administrator'),
						'items' => [
							['label'=>'Users', 'url' => ['/user/admin']],
							['label'=>'Roles', 'url' => ['/user/role/index']],
							['label'=>'Permissions', 'url' => ['/user/permission/index']],
							['label'=>'Rules', 'url' => ['/user/rules/index']],								
						],
					],
					Yii::$app->user->isGuest ? (
						['label' => 'Login', 'url' => ['/user/login']]
					) : (
						'<li>'
						. Html::beginForm(['/user/logout'], 'post')
						. Html::submitButton(
							'Logout (' . Yii::$app->user->identity->username . ')',
							['class' => 'btn btn-link logout']
						)
						. Html::endForm()
						. '</li>'
					)
				],
			]);
			NavBar::end();
			?>

			<div class="container">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				<?= Alert::widget() ?>
				<?= $content ?>
			</div>
		</div>

		<footer class="footer">
			<div class="container">
				<p class="pull-left">&copy; Lyon MacIntyre Ltd <?= date('Y') ?></p>

				<p class="pull-right"><?= Yii::powered() ?></p>
			</div>
		</footer>

	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>
