<?php

use yii\helpers\Url;
use app\models\Invoice;
use app\models\Report;
use app\models\PaymentMethod;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Contract;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", $title);
$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Manage Contracts'),
        'url' => Url::to(['contract/index'])
    ]
];
?>

<div>
    <ul>
        <?php
        /* @var $model \app\models\Contract*/
        $customer = User::findOne($model->customer_id);
        $createdBy = User::findOne($model->created_by);
        ?>
        <li>ID # <?php echo $model->id;?></li>
        <li>Contract # <?php echo $model->contract_id;?></li>
        <li>Customer: <?= $customer->first_name . ' ' . $customer->last_name?></li>
        <li>Act Number: <?=$model->act_number?></li>
        <li>Start Date: <?=date("d/m/Y", strtotime($model->start_date))?></li>
        <li>End Date: <?=date("d/m/Y", strtotime($model->end_date))?></li>
        <li>Act Date: <?=date("d/m/Y", strtotime($model->act_date))?></li>
        <li>Total: $<?=number_format($model->total, 2)?></li>
        <li>Created By: <?=$createdBy->first_name . ' ' . $createdBy->last_name?></li>
    </ul>
    <?php if ($model->hasInvoices()):?>
        <?php if (!User::hasPermission([User::ROLE_SALES]) || (User::hasPermission([User::ROLE_SALES]) && $model->created_by == Yii::$app->user->id)) :?>
        <div>
            <?= Html::a('Download Contract', ['contract/downloadcontract?id=' . $model->contract_id]) ?>
        </div>
        <?php endif;?>
        <?php if (($invoice = Invoice::findOne(['contract_id' => $model->id, 'is_delete' => 0])) && $invoice->status != Invoice::STATUS_CANCELED) :?>
            <?php if (!User::hasPermission([User::ROLE_SALES]) || (User::hasPermission([User::ROLE_SALES]) && $invoice->created_by == Yii::$app->user->id)) :?>

                <div>
                    <?= Html::a('Download Act of Work', ['contract/downloadactofwork?id=' . $model->contract_id]) ?>
                </div>

                <div>
                    <?= Html::a('Download PDF Invoice', ['invoice/download?id=' . $invoice->id]) ?>
                </div>

                <div>
                    <?= Html::a('Download Reports', ['invoice/downloadreports?id=' . $invoice->id]) ?>
                </div>
            <?php endif;?>
        <?php endif;?>
    <?php endif;?>
</div>


