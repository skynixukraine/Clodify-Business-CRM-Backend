<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Create a Contract'),
        'url' => Url::to(['contract/create'])
    ]
];
