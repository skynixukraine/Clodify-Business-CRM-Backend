<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "surveys".
 *
 * @property integer $id
 * @property string $shortcode
 * @property string $question
 * @property string $description
 * @property string $date_start
 * @property string $date_end
 * @property integer $is_private
 * @property integer $user_id
 * @property integer $total_votes
 * @property integer $is_delete
 */
class Surveys extends \yii\db\ActiveRecord
{
    const SKYNIX_SURVEY_COOKIE = 'SKYNIX_SURVEY';

    public $result;
    public $model;
    public $name;
    public $descriptions;
    public $survayOptions = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'surveys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['shortcode', 'question', 'date_start', 'date_end' ], 'required'],
            [['shortcode'], 'unique', 'message' => 'Sorry, the entered shortcode already exists'],
            [['name'],'string', 'max' => 250],
            [['descriptions'], 'string', 'max' => 1200],
            [['date_start', 'date_end'], 'safe'],
            [['is_private', 'user_id', 'total_votes', 'is_delete'], 'integer'],
            [['shortcode'], 'string', 'max' => 25],
            [['question'], 'string', 'max' => 250]
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveys()
    {
        return $this->hasMany(SurveysOption::className(), ['survey_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shortcode' => 'Shortcode',
            'question' => 'Question',
            'description' => 'Description',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'is_private' => 'Is Private',
            'user_id' => 'User ID',
            'total_votes' => 'Total Votes',
            'is_delete'    => 'Is Delete'
        ];
    }

    /**
     * This function checks if the survey is live and can be voted
     * @return bool
     */
    public function isLive()
    {
        $start  = strtotime( $this->date_start );
        $end    = strtotime( $this->date_end );
        $now    = strtotime( 'now' );

        if ( $now >= $start && $now <= $end && $this->is_delete != 1 ) {

            return true;

        } else {

            return false;

        }

    }

    /**
     * This function checks if user still can vote
     * @return bool
     */
    public function canVote()
    {

        if ( $this->is_private || !Yii::$app->user->isGuest ) {
        //If the survey is private, than one user may make a vote only one time per one survey.
            if ( SurveyVoter::find()
                            ->where([
                                'user_id'   => Yii::$app->user->id,
                                'survey_id' => $this->id
                            ])->count() == 0 ) {

                return true;

            }

        } else {
            //If the survey is public
            //Check if user is logged in, logged in users go by a normal flow.
            //Check if user has a cookie SKYNIX_SURVEY_XX - where XX is survey ID, then do not let user to change the decision.
            $cookieName = self::SKYNIX_SURVEY_COOKIE . "_" . $this->id;
            if ( !Yii::$app->request->cookies->has( $cookieName ) ) {

                //If cookie does not exist, check if IP and UA_HASH pair exists for this survey then display the following message: This seems you took a part in this survey. And do not let user to see or edit survey options.
                $ipAddress  = Yii::$app->request->userIP;
                $uaHash     = md5( Yii::$app->request->userAgent );
                if ( SurveyVoter::find()
                                ->where([
                                    'survey_id' => $this->id,
                                    'ip'        => $ipAddress,
                                    'ua_hash'   => $uaHash
                                ])->count() == 0 ) {

                    //If cookie does not exist, and the pair if IP and UA_HASH does not exist as well, let user to make a decision and submit VOTE.
                    return true;

                }


            }

        }
        return false;

    }

    public function getUsersVote()
    {

        if ( $this->is_private || !Yii::$app->user->isGuest ) {
            //If the survey is private, than one user may make a vote only one time per one survey.

            if ( ( $voter = SurveyVoter::find()
                ->where([
                    'user_id'   => Yii::$app->user->id,
                    'survey_id' => $this->id
                ])->one() ) ) {

                return $voter->option_id;

            }

        } else {

              //If cookie does not exist, check if IP and UA_HASH pair exists for this survey then display the following message: This seems you took a part in this survey. And do not let user to see or edit survey options.
            $ipAddress  = Yii::$app->request->userIP;
            $uaHash     = md5( Yii::$app->request->userAgent );
            if ( ( $voter = SurveyVoter::find()
                    ->where([
                        'survey_id' => $this->id,
                        'ip'        => $ipAddress,
                        'ua_hash'   => $uaHash
                    ])->one() ) ) {

                return $voter->option_id;

            }

        }
        return false;

    }

    /**
     * This submits a vote
     */
    public function vote( $optionId )
    {
        // If only it is a public survey and user is not logged in when user submits a vote:
        // set a COOKIE SKYNIX_SURVEY_XX for a period until a survey goes.
        // Create UA_HASH string (just do MD5 of User Agent header).
        // Insert a record to survey_voters table with UA_HASH and user's IP address data.
        $ipAddress          = Yii::$app->request->userIP;
        $uaHash             = md5( Yii::$app->request->userAgent );
        $voter              = new SurveyVoter();
        $voter->ip          = $ipAddress;
        $voter->ua_hash     = $uaHash;
        $voter->survey_id   = $this->id;
        $voter->option_id   = $optionId;
        if ( !Yii::$app->user->isGuest ) {

            $voter->user_id = Yii::$app->user->id;

        }
        $voter->save();

        if ( $this->is_private == 0) {

            $cookie = new \yii\web\Cookie;
            $cookie->path   = "/s";
            $cookie->name   = self::SKYNIX_SURVEY_COOKIE . "_" . $this->id;
            $cookie->value  = $this->id;
            $cookie->expire = strtotime( $this->date_end ) + 3600;
            Yii::$app->response->cookies->add($cookie);

        }
        /** @var $option SurveysOption */
        if ( ($option = SurveysOption::findOne($optionId)) && $option->survey_id == $this->id) {

            $this->total_votes++;
            $this->save(false, ['total_votes']);

            $option->votes++;
            $option->save(false, ['votes']);

        }

    }

}
