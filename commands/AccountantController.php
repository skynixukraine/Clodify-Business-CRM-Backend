<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 3/29/18
 * Time: 3:43 PM
 */

namespace app\commands;

use app\models\FixedAsset;
use app\models\FixedAssetOperation;
use app\models\Operation;
use app\models\OperationType;
use app\models\ReferenceBook;
use app\models\Transaction;
use yii\console\Controller;
use yii\log\Logger;

/**
 * Accountant operations automatization
 * Class AccountantController
 * @package app\commands
 */
class AccountantController extends Controller
{
    /**
     * Calculate monthly amortization of fixed assets and creates proper operations
     * @see https://jira.skynix.co/browse/SCA-109
     */
    public function actionCalcAssetsAmmortization()
    {
        echo " * Calculate Assets Ammortization * \n";

        $currency = 'UAH';
        /**
         *  fetch all fixed assets where
            current day >= date_of_purchase
            current day <= date_write_off
            count of operations on a credit 131 reference for this month == 0
         */
        $today = date('Y-m-d');
        $fixedAssets = FixedAsset::find()
            ->leftJoin(FixedAssetOperation::tableName(),
                FixedAsset::tableName() . '.id=' . FixedAssetOperation::tableName() . '.fixed_asset_id')
            ->leftJoin(Operation::tableName(),
                Operation::tableName() . '.id=' . FixedAssetOperation::tableName() . '.operation_id' .
                ' AND MONTH(FROM_UNIXTIME(' . Operation::tableName() . '.date_created))=' . date('m') .
                ' AND YEAR(FROM_UNIXTIME(' . Operation::tableName() . '.date_created))=' . date('Y')
            )
            ->where(['<=', FixedAsset::tableName() . '.date_of_purchase', $today])
            ->andWhere(['>=', FixedAsset::tableName() . '.date_write_off', $today])
            ->groupBy(FixedAsset::tableName() . '.id')
            ->having('COUNT(' . Operation::tableName() . '.id )=0')
            ->all();

        /**
         * For each asset calculate amortization using its own method:
            LINEAR:
            num months = date_write_off - date_of_purchase
            amortization = ( cost / num months )
            50/50
            at date_of_purchase month amortization = cost / 2
            other mothes no amortization
            at date_write_off month amortization = cost / 2
         */
        /** @var  $asset FixedAsset */
        foreach ( $fixedAssets as $asset ) {

            $amortizationValue = 0;
            if ( $asset->amortization_method === FixedAsset::AMORTIZATION_METHOD_LINEAR ) {

                $datetime1  = date_create($asset->date_of_purchase);
                $datetime2  = date_create($asset->date_write_off);
                $interval   = date_diff($datetime1, $datetime2);
                $numMonthes = (int)$interval->format('%m');

                $amortizationValue = $asset->cost / $numMonthes;

            } elseif ( $asset->amortization_method === FixedAsset::AMORTIZATION_METHOD_5050 &&
                ( date('Y-m', strtotime($asset->date_of_purchase)) === date('Y-m') ||
                    date('Y-m', strtotime($asset->date_write_off)) === date('Y-m') ) ) {

                $amortizationValue = $asset->cost / 2;

            }
            if ( $amortizationValue > 0 ) {

                /**
                 * Create operation
                    Debit Reference = (operation of type 3 "Придбання ОЗ" pick up Credit Reference)
                    Credit Reference = 131
                    Amount (calculated on previous step)
                    Counterparty: none
                    Name: "Амортизація основних засобів, інвентариний №123"
                    Transaction Name: none
                 */
                $transaction = \Yii::$app->db->beginTransaction();

                $operation = new Operation();
                /** @var $assetOperation FixedAssetOperation */
                $assetOperation = $asset->getFixedAssetsOperations()->limit(1)->one();
                $operation->business_id       = $assetOperation->operation_business_id;
                $operation->name              = \Yii::t("app", 'Amortization of main assets, inventory number %s', [$asset->inventory_number]);
                $operation->status            = Operation::DONE;
                $operation->date_created      = time();
                $operation->operation_type_id = OperationType::TYPE_AMORTIZATION;
                $operation->setScenario(Operation::SCENARIO_OPERATION_CREATE);
                if ($operation->validate() && $operation->save()) {


                    $transaction2 = new Transaction();
                    $transaction2->type                  = Transaction::CREDIT;
                    $transaction2->name                  = "";
                    $transaction2->date                  = time();
                    $transaction2->amount                = $amortizationValue;
                    $transaction2->currency              = $currency;
                    $transaction2->reference_book_id     = ReferenceBook::find()->where(['code' => 131])->one()->id;
                    $transaction2->counterparty_id       = null;
                    $transaction2->operation_id          = $operation->id;
                    $transaction2->operation_business_id = $assetOperation->operation_business_id;
                    $transaction2->setScenario(Transaction::SCENARIO_TRANSACTION_CREATE);

                    if ($transaction2->validate() && $transaction2->save()) {

                        echo " Created Operation #" . $operation->id . " Transaction #" . $transaction2->id . "\n";

                        $fixedAssetsOperation = new FixedAssetOperation();
                        $fixedAssetsOperation->fixed_asset_id        = $asset->id;
                        $fixedAssetsOperation->operation_id          = $operation->id;
                        $fixedAssetsOperation->operation_business_id = $operation->business_id;
                        if ($fixedAssetsOperation->validate()) {

                            $fixedAssetsOperation->save();

                        } else {

                            $transaction->rollBack();
                            \Yii::getLogger()->log($fixedAssetsOperation->getErrors(), Logger::LEVEL_ERROR);

                        }

                        $transaction->commit();

                    } else {

                        $transaction->rollBack();
                        \Yii::getLogger()->log($transaction2->getErrors(), Logger::LEVEL_ERROR);

                    }

                } else {

                    \Yii::getLogger()->log($operation->getErrors(), Logger::LEVEL_ERROR);

                }

            }

        }
    }
}