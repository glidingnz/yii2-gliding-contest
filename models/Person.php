<?php

namespace app\models;

use Yii;
use \app\models\base\Person as BasePerson;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "persons".
*/
class Person extends BasePerson
{

	public function behaviors()
	{
		return ArrayHelper::merge(
			parent::behaviors(),
			[
				# custom behaviors
			]
		);
	}

	public function rules()
	{
		return ArrayHelper::merge(
			parent::rules(),
			[
				# custom validation rules
			]
		);
	}

	public static function find()
	{
		if (\Yii::$app->request->isConsoleRequest)
			return parent::find();

		if (\Yii::$app->user->isGuest){
			$contest = 0;	
		}
		else{
			$contest = \yii::$app->user->identity->profile->contest_id;
		}

		return parent::find()->andWhere(['persons.contest_id' => $contest]);

	}

	public static function findEvery()
	{
		return parent::find();
	}

}
