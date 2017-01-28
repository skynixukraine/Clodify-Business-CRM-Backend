<?php
/**
 * Created by PhpStorm.
 * User: Oleksii
 * Date: 20.05.2015
 * Time: 17:01
 */

namespace app\components;

use Yii;
use yii\log\Logger;
use app\models\User;

class DataTable {

    /**
     * @var \yii\db\ActiveQuery
     */
    private $query;
    private $limit;
    private $start;
    private $searchValue;
    private $totalCount;
    private $orderColumn;
    private $orderDir;
    private $filters = array();
    private $searchParams = [];

    private static $instance;

    private function __construct(){}

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getData()
    {
       // Yii::getLogger()->log("this->orderColumn" . $this->orderColumn, Logger::LEVEL_TRACE);

        if ( $this->searchValue ) {


             $this->query->andFilterWhere($this->searchParams);

        }
        if ( count($this->filters) ) {

            foreach ($this->filters as $filter ) {

                $this->query->andWhere( $filter );

            }

        }
        $countQuery = clone $this->query;
        $this->totalCount = $countQuery->count();

        $this->query->limit( $this->limit )
        ->offset( $this->start );

        if ( is_array( $this->orderColumn ) ) {

            $this->query->orderBy( $this->orderColumn );

        } else {

            $this->query->orderBy( array( $this->orderColumn => ($this->orderDir == "asc" ? SORT_ASC : SORT_DESC ) ) );

        }

        Yii::getLogger()->log("this->searchValue" . $this->searchValue, Logger::LEVEL_TRACE);

        return $this->query->all();

    }

    /**
     * This function returns the current ActiveRecord
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param $searchParams
     * @return $this
     */
    public function setSearchParams( $searchParams )
    {
        $this->searchParams = $searchParams;
        return $this;
    }

    public function getTotal()
    {
        return $this->totalCount;
    }

    /**
     * @param $query
     * @return $this
     */
    public function setQuery( $query )
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function setLimit( $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param $start
     * @return $this
     */
    public function setStart( $start )
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @param $searchValue
     * @return $this
     */
    public function setSearchValue( $searchValue )
    {
        $this->searchValue = trim($searchValue);
        return $this;
    }

    /**
     * @param $filter
     * @return $this
     */
    public function setFilter( $filter )
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @param $column
     * @param $dir
     * @return $this
     */
    public function setOrder ( $column, $dir = null)
    {
        $this->orderColumn  = $column;
        $this->orderDir     = $dir;
        return $this;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getDraw( $name = "default" )
    {
        $name = "data_" . $name;
        $draw = 1;
        if ( Yii::$app->session->has( $name ) ) {

            $draw = Yii::$app->session->get( $name );

        }
        $draw++;
        Yii::$app->session->set( $name, $draw );
        return $draw;
    }

    /**
     * @return DataTable
     */
    public static function getInstance()
    {
        if ( !self::$instance ) {


            self::$instance = new self();

        }
        return self::$instance;
    }
}