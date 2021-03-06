<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 19.02.16
 * Time: 16:16
 */
use yii\helpers\Url;
use app\models\Invoice;
use app\models\Report;
use app\models\PaymentMethod;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.dataTables.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/dataTables.bootstrap.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.slimscroll.min.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/modal.bootstrap.js');
$this->title                    = Yii::t("app", $title);
$this->params['breadcrumbs']  = [
    [
        'label' => Yii::t('app', 'List of invoices'),
        'url' => Url::to(['invoice/index'])
    ]
];
$this->params['menu'] = [
    [
        'label' => Yii::t('app', 'Invoices'),
        'url' => Url::to(['invoice/index'])
    ]
];
?>

<div>
    <ul>

            <li>Invoice #        <?php echo $model->id;?></li>
        <?php /** @var $model Invoice */
        if ($model->getUser()->one()) : ?>
            <li>Customer Name:   <?php echo $model->getUser()->one()->first_name . ' ' .
                                            $model->getUser()->one()->last_name;?></li>
            <li>Customer Email:  <?php echo $model->getUser()->one()->email;?></li>
        <?php endif;?>
        <li>Start Date:      <?php echo $model->date_start;?></li>
            <li>End Date:        <?php echo $model->date_end;?></li>
            <li>Total hours:     <?php echo Yii::$app->Helper->timeLength( $model->total_hours * 3600)?></li>
            <li>Sub total:       <?php echo '$' . $model->subtotal;?></li>
            <li>Discount:        <?php echo '$' . $model->discount;?></li>
            <li>Total:           <?php echo '$' . $model->total;?></li>
            <li>Notes:           <?php echo $model->note;?></li>
            <li>Create date:     <?php echo $model->date_created;?></li>
            <li>Sent date:       <?php echo $model->date_sent;?></li>
            <li>Paid date:       <?php echo $model->date_paid;?></li>
            <li>Status:          <?php echo $model->status;?></li>
    </ul>
</div>
<label style="display: none"></label>

    <?php $form = ActiveForm::begin([
                                    'action' =>['invoice/send'],
                                    'options' => [
                                        'class' => 'horizontal'
                                    ]
    ]);?>
        <?php echo $form->field($model, 'id')
                        ->textInput(['style' => 'display: none'])
                        ->label(null,['style' => 'display: none']);?>

       <!-- <?php /*if(($model->status) == (Invoice::STATUS_NEW) && $model->date_sent == null):*/?>
            --><?php /*$payMethods = PaymentMethod::find()->all();
            $listMethods = \yii\helpers\ArrayHelper::map( $payMethods, 'id', 'name' );

            echo $form->field( $model, 'method')
                      ->dropDownList( $listMethods, ['prompt' => 'Choose...'] )
                      ->label('Pay Methods');*/?>

       <!-- --><?php /*endif;*/?>


<?= Html::a('Download PDF Invoice', ['invoice/download?id=' . $model->id]) ?>

<br>

<?= Html::a('Download Reports', ['invoice/downloadreports?id=' . $model->id]) ?>

<br>

        <?php if(($model->status) == (Invoice::STATUS_NEW) && $model->date_sent == null):?>

            <?= Html::a('Send Now', ['invoice/send' ], [
                'data' => [
                    'method' => 'post',
                   ]
            ]) ?>
        <?php endif;?>

    <?php ActiveForm::end();?>


