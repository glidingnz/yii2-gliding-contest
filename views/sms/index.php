<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SmsForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Send SMS';
$this->params['breadcrumbs'][] = $this->title;

/**
 * create action column template depending acces rights
 */
$actionColumnTemplates = [];

if (\Yii::$app->user->can('app_contest_view', ['route' => true])) {
    $actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('app_contest_update', ['route' => true])) {
    $actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('app_contest_delete', ['route' => true])) {
    $actionColumnTemplates[] = '{delete}';
}
if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">' . $actionColumnTemplateString . '</div>';

?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-4">
            <h1><?= 'Send' ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'sms-form']); ?>

            <?= $form->field($model, 'to')->dropDownList(
                array_merge(
                    [0 => 'Everyone'],
                    \Yii\helpers\ArrayHelper::map(app\models\Person::find()->all(), 'telephone', 'name')
                ),
                ['autofocus' => true]
            ) ?>

            <?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'contact-button', 'data' => [
                    'confirm' => 'Are you sure want to Send this message?'
                ]]) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-8">
            <div class="table-responsive">
                <h1><?= 'Received' ?></h1>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'class' => yii\widgets\LinkPager::class,
                        'firstPageLabel' => 'First',
                        'lastPageLabel' => 'Last',
                    ],
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                    'headerRowOptions' => ['class' => 'x'],
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
                            'urlCreator' => function ($action, $model, $key, $index) {
                                // using the column name as key, not mapping to 'id' like the standard generator
                                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                                return Url::toRoute($params);
                            },
                            'contentOptions' => ['nowrap' => 'nowrap']
                        ],
                        // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                        'from',
                        'sent',
                        'received',
                        'message',
                    ]
                ]); ?>
            </div>
        </div>

    </div>

</div>