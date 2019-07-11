<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "monitoring_service_queue".
 *
 * @property int $id
 * @property int $service_id
 * @property string $status
 * @property string $results
 *
 * @property MonitoringService $service
 */
class MonitoringServiceQueue extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoring_service_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id'], 'integer'],
            [['status', 'results'], 'string'],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => MonitoringService::class, 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'status' => 'Status',
            'results' => 'Results',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(MonitoringService::class, ['id' => 'service_id']);
    }
}
