<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "monitoring_services".
 *
 * @property int $id
 * @property int $project_id
 * @property string $url
 * @property int $is_enabled
 * @property string $status
 * @property string $notification_emails
 * @property string $notification_sent_date
 *
 * @property MonitoringServiceQueue[] $monitoringServiceQueues
 * @property Project $project
 */
class MonitoringService extends ActiveRecord
{
    public const STATUS_NEW = 'new';

    public const STATUS_READY = 'ready';

    public const STATUS_FAILED = 'failed';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoring_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id'], 'integer'],
            [['status'], 'string'],
            [['notification_sent_date'], 'safe'],
            [['url', 'notification_emails'], 'string', 'max' => 250],
            [['is_enabled'], 'boolean'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'url' => 'Url',
            'is_enabled' => 'Is Enabled',
            'status' => 'Status',
            'notification_emails' => 'Notification Emails',
            'notification_sent_date' => 'Notification Sent Date',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getMonitoringServiceQueues()
    {
        return $this->hasMany(MonitoringServiceQueue::class, ['service_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }
}
