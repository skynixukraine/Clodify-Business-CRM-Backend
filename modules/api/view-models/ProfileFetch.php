<?php
/**
 * Created by Skynix Team
 * Date: 18.04.17
 * Time: 10:48
 */

namespace viewModel;

use app\models\User;
use app\models\Project;
use yii\helpers\ArrayHelper;
use app\components\DataTable;
use app\modules\api\components\SortHelper;
use yii;

class ProfileFetch extends ViewModelAbstract
{

    public function define()
    {
        $keyword = Yii::$app->request->getQueryParam('slug') ?: null;
        $order = Yii::$app->request->getQueryParam('order', []);

        $query = User::find()
            ->where(['role' => [User::ROLE_FIN, User::ROLE_DEV, User::ROLE_SALES]])
            ->andWhere(['is_delete' => !User::DELETED_USERS])
            ->andWhere(['is_active' => User::ACTIVE_USERS])
            ->andWhere(['is_published' => 1])
            ->with(['developers' => function ($query) {
                $query->where(['projects.is_published' => 1]);
            }]);

        $dataTable = DataTable::getInstance()
            ->setQuery($query);

        if ($keyword) {
            $dataTable->setFilter(['like', 'slug', $keyword]);
        }

        if ($order) {
            foreach ($order as $name => $value) {
                $dataTable->setOrder(User::tableName() . '.' . $name, $value);
            }

        } else {
            $dataTable->setOrder(User::tableName() . '.' . 'id', SortHelper::ASC);
        }

        $profiles = $dataTable->getData();

        if ($profiles) {
            $profiles = ArrayHelper::toArray($profiles, [
                User::className() => [
                    'id', 'slug', 'photo' => function($profile) {
                        return '/api/user/' . $profile->id . '/photo';
                    },
                    'first_name', 'last_name', 'email', 'phone', 'about',
                    'tags' => function($profile) {
                        return User::getTags($profile);
                    },
                    'position', 'birthday', 'experience_year',
                    'languages', 'degree', 'residence', 'link_linkedin',
                    'link_video', 'portfolio' => 'developers'
                ],
                Project::className() => [
                    'photo', 'description'
                ],
            ]);
        }

        $data = [
            'profiles' => $profiles,
            'total_records' => count($profiles),
        ];
        $this->setData($data);
    }

}