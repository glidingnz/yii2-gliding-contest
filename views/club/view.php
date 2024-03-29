<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Club $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Club');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Clubs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud club-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Club') ?>
        <small>
            <?= Html::encode($model->name) ?>
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
                ['create', 'id' => $model->id, 'Club'=>$copyParams],
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

    <?php $this->beginBlock('\app\models\Club'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
        'address1',
        'address2',
        'address3',
        'postcode',
        'telephone',
        'email:email', 
        'bankname', 
        'bankno', 
        'gstno', 
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


    
<?php $this->beginBlock('Contests'); ?>
<div style='position: relative'>
<div style='position:absolute; right: 0px; top: 0px;'>
  <?= Html::a(
        '<span class="glyphicon glyphicon-list"></span> ' . 'List All' . ' Contests',
        ['contest/index'],
        ['class'=>'btn text-muted btn-xs']
    ) ?>
  <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New' . ' Contest',
            ['contest/create', 'Contest' => ['club_id' => $model->id]],
            ['class'=>'btn btn-success btn-xs']
        ); ?>
</div>
</div>
<?php Pjax::begin(['id'=>'pjax-Contests', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-Contests ul.pagination a, th a']) ?>
<?=
 '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}<div class="text-center">{pager}</div>{items}<div class="text-center">{pager}</div>',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getContests(),
        'pagination' => [
            'pageSize' => 20,
            'pageParam'=>'page-contests',
        ]
    ]),
    'pager'        => [
        'class'          => yii\widgets\LinkPager::class,
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
    'columns' => [
         'id',
        'gnz_id',
        'name',
        'start',
        'end',
[
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{view} {update}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'contest' . '/' . $action;
        $params['Contest'] = ['club_id' => $model->primaryKey()[0]];
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'contest'
],
]
])
 . '</div>'
?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


    <?= Tabs::widget(
    [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.Html::encode($model->id).'</b>',
    'content' => $this->blocks['\app\models\Club'],
    'active'  => true,
],
[
    'content' => $this->blocks['Contests'],
    'label'   => '<small>Contests <span class="badge badge-default">'. $model->getContests()->count() . '</span></small>',
    'active'  => false,
],
 ]
                 ]
);
    ?>
</div>
