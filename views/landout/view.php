<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use richardfan\widget\JSRegister;

/**
* @var yii\web\View $this
* @var app\models\Landout $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Landout');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Landouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
?>

<?php
// Register Leaflet Components
$this->registerCssFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.css',
	[
		'integrity' => 'sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==',
		'crossorigin' => '',
]);
$this->registerJsFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.js',
	[
		'integrity' => 'sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==',
		'crossorigin' => '',
]);


// Register Leaflet Full Screen Add In
$this->registerCssFile('https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css');
$this->registerJsFile('https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js');


// Register Leaflet Screen Shot Add In
$this->registerJsFile('https://unpkg.com/leaflet-simple-map-screenshoter');

?>

<div class="giiant-crud landout-view">

	<!-- flash message -->
	<?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
		<span class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
			<?= \Yii::$app->session->getFlash('deleteError') ?>
		</span>
	<?php endif; ?>

	<h1>
		<?= Yii::t('models', 'Landout') ?>
		<small>
			<?= Html::encode($model->rego_short) ?>
		</small>
	</h1>


	<div class="clearfix crud-navigation">

		<!-- menu buttons -->
		<div class='pull-left'>
			<?= Html::a(
				'<span class="glyphicon glyphicon-print"></span> ' . 'Print',
				[ 'report', 'id' => $model->id],
				['class' => 'btn btn-success']) ?>
			<?= Html::a(
				'<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
				[ 'update', 'id' => $model->id],
				['class' => 'btn btn-info']) ?>
		</div>

		<div class="pull-right">
			<?= Html::a('<span class="glyphicon glyphicon-list"></span> '
				. 'Full list', ['index'], ['class'=>'btn btn-default']) ?>
		</div>

	</div>

	<hr/>

	<?php $this->beginBlock('app\models\Landout'); ?>


	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
			'date',
			'rego_short',
			'name',
			'telephone',
			'landed_at',
			'lat',
			'lng',
			'address:ntext',
			'notes:ntext',
			'trailer',
			'plate',
			'crew',
			'crew_phone',
			[
				'attribute'=>'status',
				'value'=>app\models\Landout::getStatusValueLabel($model->status),
			],
			'departed_at',
			'returned_at',
		],
	]); ?>


	<hr/>

	<?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'id' => $model->id],
		[
			'class' => 'btn btn-danger',
			'data-confirm' => '' . 'Are you sure to delete this item?' . '',
			'data-method' => 'post',
	]); ?>
	<?php $this->endBlock(); ?>


	<div class="row">
		<div class="col-md-6">
			<?= Tabs::widget(
				[
					'id' => 'relation-tabs',
					'encodeLabels' => false,
					'items' => [
						[
							'label'   => '<b class=""># '.Html::encode($model->id).'</b>',
							'content' => $this->blocks['app\models\Landout'],
							'active'  => true,
						],
					]
				]
			);
			?>
		</div>
		<div class="col-md-6">
			<?=Html::activeHiddenInput($model, 'lat', ['id'=>'lat'])?>
			<?=Html::activeHiddenInput($model, 'lng', ['id'=>'lon'])?>			
			<?=Html::label('Map')?>
			<div id="map" style="height: 600px;"></div>
		</div>
	</div>

</div>

<?php JSRegister::begin(); ?>

<script>

	var map = L.map('map').setView({lat: $('#lat').val(), lon: $('#lon').val()}, 10);

	var cartoAttribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>';
	var mapLayers = {

		streetmap: 	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
		}),
		terrain: L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}.png', {
			attribution: 'Map tiles by <a href="https://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://www.openstreetmap.org/copyright">ODbL</a>.',
		}),
		opentopomap: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
			maxZoom: 17,
			attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
		}),		
		satellite: L.tileLayer('https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
			attribution: 'Powered by Esri Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
		})
	};

	var layersControl = L.control.layers({
		'Street Map': mapLayers.streetmap,
		'Terrain': mapLayers.terrain,
		'Topology': mapLayers.opentopomap,
		'Satellite': mapLayers.satellite
	});

	mapLayers.terrain.addTo(map);
	layersControl.addTo(map);

	// show the scale bar on the lower left corner
	L.control.scale().addTo(map);

	// Add Full Screen Button to Map
	map.addControl(new L.Control.Fullscreen());

	// Add Print Screen
	L.simpleMapScreenshoter().addTo(map);

	// show a marker on the map
	var marker = L.marker({lat: $('#lat').val(), lon: $('#lon').val()}).addTo(map);


</script>

<?php JSRegister::end(); ?>
