<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MasterTowplane $model
*/

$this->title = Yii::t('models', 'Towplane');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Towplane'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->rego, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud master-towplane-update">

    <h1>
        <?= Yii::t('models', 'Towplane') ?>
        <small>
                        <?= Html::encode($model->rego) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
