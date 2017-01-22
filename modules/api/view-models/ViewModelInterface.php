<?php
namespace viewModel;
use app\modules\api\models\ApiAccessToken;
use yii\db\ActiveRecordInterface;

/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 09:37
 */
interface ViewModelInterface
{
    public function define();

    public function render();

    public function setModel( ActiveRecordInterface $model);

    public function setAccessTokenModel( ApiAccessToken $token );

    public function addError( $error, $message = null );

    public function setPostData( $postData );

    public function getErrors();
}