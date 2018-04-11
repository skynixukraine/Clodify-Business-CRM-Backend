<?php
/**
 * Created by Skynix Team
 * Date: 8/26/16
 * Time: 06:06
 */

namespace app\modules\api\components;


class SortHelper
{
    const ASC           = 'ASC';
    const DESC          = 'DESC';
    const DEFAULT_LIMIT = 10;
    const MAX_LIMIT     = 200;

    public static function sort( \yii\db\ActiveQuery $query, array $sorts )
    {
        $orderBy = [];
        foreach ( $sorts as $k=>$v ) {

            $orderBy[$k] = $v == self::ASC ? SORT_ASC : SORT_DESC;

        }
        $query->orderBy( $orderBy );
        return $query;
    }
}