<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "status".
 *
 * @property integer $id
 * @property integer $pilot_id
 * @property string $status
 * @property string $date
 * @property string $time
 * @property string $aliasModel
 */
abstract class Status extends \yii\db\ActiveRecord
{



    /**
    * ENUM field values
    */
    const STATUS_NOT_FLYING = 'Not Flying';
    const STATUS_GRIDDED = 'Gridded';
    const STATUS_LAUNCHED = 'Launched';
    const STATUS_STARTED = 'Started';
    const STATUS_OPS_NORMAL_TRACKING = 'Ops Normal Tracking';
    const STATUS_OPS_NORMAL_RADIO = 'Ops Normal Radio';
    const STATUS_LANDED_OUT = 'Landed Out';
    const STATUS_LANDED_BACK = 'Landed Back';
    const STATUS_FINISHED = 'Finished';
    var $enum_labels = false;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pilot_id'], 'required'],
            [['pilot_id'], 'integer'],
            [['status'], 'string'],
            [['date', 'time'], 'safe'],
            ['status', 'in', 'range' => [
                    self::STATUS_NOT_FLYING,
                    self::STATUS_GRIDDED,
                    self::STATUS_LAUNCHED,
                    self::STATUS_STARTED,
                    self::STATUS_OPS_NORMAL_TRACKING,
                    self::STATUS_OPS_NORMAL_RADIO,
                    self::STATUS_LANDED_OUT,
                    self::STATUS_LANDED_BACK,
                    self::STATUS_FINISHED,
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pilot_id' => 'Pilot',
            'status' => 'Status',
            'date' => 'Date',
            'time' => 'Time',
        ];
    }


    
    /**
     * @inheritdoc
     * @return \app\models\query\StatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\StatusQuery(get_called_class());
    }


    /**
     * get column status enum value label
     * @param string $value
     * @return string
     */
    public static function getStatusValueLabel($value){
        $labels = self::optsStatus();
        if(isset($labels[$value])){
            return $labels[$value];
        }
        return $value;
    }

    /**
     * column status ENUM value labels
     * @return array
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_NOT_FLYING => 'Not Flying',
            self::STATUS_GRIDDED => 'Gridded',
            self::STATUS_LAUNCHED => 'Launched',
            self::STATUS_STARTED => 'Started',
            self::STATUS_OPS_NORMAL_TRACKING => 'Ops Normal Tracking',
            self::STATUS_OPS_NORMAL_RADIO => 'Ops Normal Radio',
            self::STATUS_LANDED_OUT => 'Landed Out',
            self::STATUS_LANDED_BACK => 'Landed Back',
            self::STATUS_FINISHED => 'Finished',
        ];
    }

}
