<?php

namespace frontend\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\User;
use yii\helpers\Url;

/**
 * This is the model class for table "tournament".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $game_id
 * @property integer $organisation_id
 * @property integer $hosted_by
 * @property string $name
 * @property string $begin
 * @property string $end
 * @property integer $location
 * @property string $description
 * @property string $url
 * @property integer $max_participants
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $has_sets
 * @property integer $participants_count
 * @property integer $is_team_tournament
 * @property integer $stage_type
 * @property integer $fs_format
 * @property integer $fs_third_place
 * @property integer $fs_de_grand_finals
 * @property integer $fs_rr_ranked_by
 * @property double $fs_rr_ppmw
 * @property double $fs_rr_ppmt
 * @property double $fs_rr_ppgw
 * @property double $fs_rr_ppgt
 * @property double $fs_s_ppb
 * @property integer $participants_compete
 * @property integer $participants_advance
 * @property integer $gs_format
 * @property integer $gs_rr_ranked_by
 * @property double $gs_rr_ppmw
 * @property double $gs_rr_ppmt
 * @property double $gs_rr_ppgw
 * @property double $gs_rr_ppgt
 * @property integer $gs_tie_break1
 * @property integer $gs_tie_break2
 * @property integer $quick_advance
 * @property integer $gs_tie_break3
 * @property integer $gs_tie_break1_copy1
 * @property integer $gs_tie_break2_copy1
 * @property integer $gs_tie_break3_copy1
 * @property integer $notifications
 *
 * @property Participant[] $participants
 * @property Game $game
 * @property mixed organisation
 * @property mixed user
 */
class Tournament extends ActiveRecord
{

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_RUNNING = 3;
    const STATUS_FINAL_STAGE = 4;
    const STATUS_FINISHED = 5;
    const STATUS_ABORT = 6;
    const STATUS_DELETED = 7;

    const FORMAT_SINGLE_ELIMINATION = 1;
    const FORMAT_DOUBLE_ELIMINATION = 2;
    const FORMAT_ROUND_ROBIN = 3;
    const FORMAT_SWISS = 4;

    const STAGE_TYPE_SINGLE_STAGE = 0;
    const STAGE_TYPE_TWO_STAGE = 1;

    const RANKED_BY_MATCH_WINS = 1;
    const RANKED_BY_GAME_SET_WINS = 2;
    const RANKED_BY_GAME_SET_PERCENT = 3;
    const RANKED_BY_POINTS_SCORED = 4;
    const RANKED_BY_POINTS_DIFFERENCE = 5;
    const RANKED_BY_CUSTOM = 6;
    const RANKED_BY_WINS_VS_TIED_PARTICIPANTS = 7;
    const RANKED_BY_MEDIAN_BUCHHOLZ_SYSTEM = 8;

    const SINGLE_TOURNAMENT = 0;
    const TEAM_TOURNAMENT = 1;

    const HAS_NO_SETS = 0;
    const HAS_SETS = 1;

    const STAGE_FS = 0;
    const STAGE_GS = 1;

    const ACTIVE_VIEW = 0;
    const ACTIVE_GROUP_STAGE = 1;
    const ACTIVE_FINAL_STAGE = 2;
    const ACTIVE_STANDINGS = 3;
    const ACTIVE_PARTICIPANTS = 4;
    const ACTIVE_SETTINGS = 5;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournament';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'game_id', 'organisation_id', 'hosted_by', 'location', 'max_participants', 'status', 'has_sets', 'participants_count', 'stage_type', 'fs_format', 'fs_third_place', 'fs_de_grand_finals', 'fs_rr_ranked_by', 'participants_compete', 'participants_advance', 'gs_format', 'gs_rr_ranked_by', 'gs_tie_break1', 'gs_tie_break2', 'quick_advance', 'gs_tie_break3', 'gs_tie_break1_copy1', 'gs_tie_break2_copy1', 'gs_tie_break3_copy1', 'notifications', 'is_team_tournament'], 'integer'],
            [['game_id', 'name', 'begin', 'location', 'max_participants', 'status', 'fs_format', 'notifications', 'is_team_tournament'], 'required'],
            [['begin', 'end'], 'safe'],
            [['description'], 'string'],
            [['fs_rr_ppmw', 'fs_rr_ppmt', 'fs_rr_ppgw', 'fs_rr_ppgt', 'fs_s_ppb', 'gs_rr_ppmw', 'gs_rr_ppmt', 'gs_rr_ppgw', 'gs_rr_ppgt'], 'double'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 512],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['gs_tie_break1', 'gs_tie_break1_copy1'], 'default', 'value' => 6],
            [['gs_tie_break2', 'gs_tie_break2_copy1'], 'default', 'value' => 2],
            [['gs_tie_break3', 'gs_tie_break3_copy1'], 'default', 'value' => 4],
            [['fs_rr_ppmw', 'gs_rr_ppmw'], 'default', 'value' => '1.0'],
            [['fs_rr_ppmt', 'gs_rr_ppmt'], 'default', 'value' => '0.5'],
            [['fs_rr_ppgw', 'gs_rr_ppgw'], 'default', 'value' => '0.0'],
            [['fs_rr_ppgt', 'gs_rr_ppgt'], 'default', 'value' => '0.0'],
            ['fs_s_ppb', 'default', 'value' => '1.0'],
            ['participants_compete', 'default', 'value' => 4],
            ['participants_advance', 'default', 'value' => 2],
            ['stage_type', 'default', 'value' => 0],
            ['fs_de_grand_finals', 'default', 'value' => 0],
            ['is_team_tournament', 'default', 'value' => 0],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'game_id' => Yii::t('app', 'Game'),
            'organisation_id' => Yii::t('app', 'Organisation ID'),
            'hosted_by' => Yii::t('app', 'Hosted By'),
            'name' => Yii::t('app', 'Name'),
            'begin' => Yii::t('app', 'Begin'),
            'end' => Yii::t('app', 'End'),
            'location' => Yii::t('app', 'Location'),
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
            'max_participants' => Yii::t('app', 'Max Participants'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'has_sets' => Yii::t('app', 'Has Sets'),
            'participants_count' => Yii::t('app', 'Participants Count'),
            'is_team_tournament' => Yii::t('app', 'Team Tournament'),
            'stage_type' => Yii::t('app', 'Stage Type'),
            'fs_format' => Yii::t('app', 'Format'),
            'fs_third_place' => Yii::t('app', 'Third Place'),
            'fs_de_grand_finals' => Yii::t('app', 'Grand Finals'),
            'fs_rr_ranked_by' => Yii::t('app', 'Ranked By'),
            'fs_rr_ppmw' => Yii::t('app', 'P. p. match win'),
            'fs_rr_ppmt' => Yii::t('app', 'P. p. match tie'),
            'fs_rr_ppgw' => Yii::t('app', 'P. p. game win'),
            'fs_rr_ppgt' => Yii::t('app', 'P. p. game tie'),
            'fs_s_ppb' => Yii::t('app', 'Fs S Ppb'),
            'participants_compete' => Yii::t('app', 'Participants Compete'),
            'participants_advance' => Yii::t('app', 'Participants Advance'),
            'gs_format' => Yii::t('app', 'Group Stage Format'),
            'gs_rr_ranked_by' => Yii::t('app', 'Ranked By'),
            'gs_rr_ppmw' => Yii::t('app', 'P. p. match win'),
            'gs_rr_ppmt' => Yii::t('app', 'P. p. match tie'),
            'gs_rr_ppgw' => Yii::t('app', 'P. p. game win'),
            'gs_rr_ppgt' => Yii::t('app', 'P. p. game tie'),
            'gs_tie_break1' => Yii::t('app', 'Tie Break 1'),
            'gs_tie_break2' => Yii::t('app', 'Tie Break 2'),
            'gs_tie_break3' => Yii::t('app', 'Tie Break 3'),
            'quick_advance' => Yii::t('app', 'Quick Advance'),
            'gs_tie_break1_copy1' => Yii::t('app', 'Tie Break 1'),
            'gs_tie_break2_copy1' => Yii::t('app', 'Tie Break 2'),
            'gs_tie_break3_copy1' => Yii::t('app', 'Tie Break 3'),
            'notifications' => Yii::t('app', 'Notifications'),
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['tournament_id' => 'id']);
    }

    public function getTournamentLocation(){
        return $this->hasOne(Location::className(), ['id' => 'location']);
    }

    /**
     * Returns the tournaments status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status;

        if ($status === self::STATUS_DRAFT) {
            return Yii::t('app', 'Draft');
        } else if ($status === self::STATUS_PUBLISHED) {
            return Yii::t('app', 'Published');
        } else if ($status === self::STATUS_RUNNING) {
            return Yii::t('app', 'Running');
        } else if ($status === self::STATUS_FINAL_STAGE) {
            return Yii::t('app', 'Running');
        } else if ($status === self::STATUS_FINISHED) {
            return Yii::t('app', 'Finished');
        } else if ($status === self::STATUS_ABORT) {
            return Yii::t('app', 'Abort');
        } else {
            return Yii::t('app', 'Deleted');
        }
    }


    /**
     * Returns the array of possible tournaments status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_DRAFT => Yii::t('app', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('app', 'Published'),
        ];

        return $statusArray;
    }


    /**
     * Returns the tournaments status in nice format.
     *
     * @param null $format
     * @return string Nicely formatted status.
     * @internal param int|null $status Status integer value if sent to method.
     */
    public function getFormatName($format = null)
    {
        $format = (empty($format)) ? $this->status : $format;

        if ($format === self::FORMAT_SINGLE_ELIMINATION) {
            return Yii::t('app', 'Single Elimination');
        } else if ($format === self::FORMAT_DOUBLE_ELIMINATION) {
            return Yii::t('app', 'Double Elimination');
        } else if ($format === self::FORMAT_ROUND_ROBIN) {
            return Yii::t('app', 'Round Robin');
        } else {
            return Yii::t('app', 'Swiss');
        }
    }

    /**
     * Returns the tournaments status in nice format.
     *
     * @param null $format
     * @return string Nicely formatted status.
     * @internal param int|null $status Status integer value if sent to method.
     */
    public function getFormatShortName($format = null)
    {
        $format = (empty($format)) ? $this->status : $format;

        if ($format === self::FORMAT_SINGLE_ELIMINATION) {
            return Yii::t('app', 'SE');
        } else if ($format === self::FORMAT_DOUBLE_ELIMINATION) {
            return Yii::t('app', 'DE');
        } else if ($format === self::FORMAT_ROUND_ROBIN) {
            return Yii::t('app', 'RR');
        } else {
            return Yii::t('app', 'SW');
        }
    }


    /**
     * Returns the array of possible tournaments status values.
     *
     * @return array
     */
    public function getFormatList()
    {
        $formatArray = [
            self::FORMAT_SINGLE_ELIMINATION => Yii::t('app', 'Single Elimination'),
            self::FORMAT_DOUBLE_ELIMINATION => Yii::t('app', 'Double Elimination'),
            self::FORMAT_ROUND_ROBIN => Yii::t('app', 'Round Robin'),
            self::FORMAT_SWISS => Yii::t('app', 'Swiss'),
        ];

        return $formatArray;
    }


    /**
     * Returns the array of possible tournaments status values.
     *
     * @return array
     */
    public function getGroupStageFormatList()
    {
        $formatArray = [
            self::FORMAT_SINGLE_ELIMINATION => Yii::t('app', 'Single Elimination'),
            self::FORMAT_DOUBLE_ELIMINATION => Yii::t('app', 'Double Elimination'),
            self::FORMAT_ROUND_ROBIN => Yii::t('app', 'Round Robin'),
        ];

        return $formatArray;
    }


    /**
     * Returns the tournaments ranked_by in nice format.
     *
     * @param  null|integer $rankedBy ranked_by integer value if sent to method.
     * @return string               Nicely formatted ranked_by.
     */
    public function getRankedByNameFS($rankedBy = null)
    {
        $rankedBy = (empty($rankedBy)) ? $this->fs_rr_ranked_by : $rankedBy;

        if ($rankedBy === self::RANKED_BY_MATCH_WINS) {
            return Yii::t('app', 'Match wins');
        } else if ($rankedBy === self::RANKED_BY_GAME_SET_WINS) {
            return Yii::t('app', 'Game/Set wins');
        } else if ($rankedBy === self::RANKED_BY_GAME_SET_PERCENT) {
            return Yii::t('app', 'Game/Set %');
        } else if ($rankedBy === self::RANKED_BY_POINTS_SCORED) {
            return Yii::t('app', 'Points scored');
        } else if ($rankedBy === self::RANKED_BY_POINTS_DIFFERENCE) {
            return Yii::t('app', 'Points difference');
        } else {
            return Yii::t('app', 'Custom Points');
        }
    }

    /**
     * Returns the tournaments ranked_by in nice format.
     *
     * @param  null|integer $rankedBy ranked_by integer value if sent to method.
     * @return string               Nicely formatted ranked_by.
     */
    public function getRankedByNameGS($rankedBy = null)
    {
        $rankedBy = (empty($rankedBy)) ? $this->gs_rr_ranked_by : $rankedBy;

        if ($rankedBy === self::RANKED_BY_MATCH_WINS) {
            return Yii::t('app', 'Match wins');
        } else if ($rankedBy === self::RANKED_BY_GAME_SET_WINS) {
            return Yii::t('app', 'Game/Set wins');
        } else if ($rankedBy === self::RANKED_BY_GAME_SET_PERCENT) {
            return Yii::t('app', 'Game/Set %');
        } else if ($rankedBy === self::RANKED_BY_POINTS_SCORED) {
            return Yii::t('app', 'Points scored');
        } else if ($rankedBy === self::RANKED_BY_POINTS_DIFFERENCE) {
            return Yii::t('app', 'Points difference');
        } else {
            return Yii::t('app', 'Custom Points');
        }
    }


    /**
     * Returns the array of possible tournaments ranked_by values.
     *
     * @return array
     */
    public function getRankedByList()
    {
        $rankedByArray = [
            self::RANKED_BY_MATCH_WINS => Yii::t('app', 'Match wins'),
            self::RANKED_BY_GAME_SET_WINS => Yii::t('app', 'Game/Set wins'),
            self::RANKED_BY_GAME_SET_PERCENT => Yii::t('app', 'Game/Set %'),
            self::RANKED_BY_POINTS_SCORED => Yii::t('app', 'Points scored'),
            self::RANKED_BY_POINTS_DIFFERENCE => Yii::t('app', 'Points difference'),
            self::RANKED_BY_CUSTOM => Yii::t('app', 'Custom Points'),
        ];

        return $rankedByArray;
    }

    /**
     * Returns the array of possible tournaments ranked_by values.
     *
     * @return array
     */
    public function getMatchTiesByList()
    {
        $rankedByArray = [
            self::RANKED_BY_MATCH_WINS => Yii::t('app', 'Match wins'),
            self::RANKED_BY_GAME_SET_WINS => Yii::t('app', 'Game/Set wins'),
            self::RANKED_BY_GAME_SET_PERCENT => Yii::t('app', 'Game/Set %'),
            self::RANKED_BY_POINTS_SCORED => Yii::t('app', 'Points scored'),
            self::RANKED_BY_POINTS_DIFFERENCE => Yii::t('app', 'Points difference'),
            self::RANKED_BY_WINS_VS_TIED_PARTICIPANTS => Yii::t('app', 'Wins vs Tied Participants'),
            self::RANKED_BY_MEDIAN_BUCHHOLZ_SYSTEM => Yii::t('app', 'Median-Buchholz system'),
        ];

        return $rankedByArray;
    }

    /**
     * Merges User_ID and Organisation_ID Array with readable labels
     * @return mixed
     */
    public function getHostedByList()
    {
        /** @var $user User*/
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $array[] = ["id" => -1, "name" => $user->username, "class" => Yii::t('app', 'User')];

        $playerOrganisationMember = OrganisationHasUser::find()->where(['user_id' => $user->id])->all();
        foreach ($playerOrganisationMember as $member) {
            /** @var $tmpOrganisation Organisation */
            /** @var $member OrganisationHasUser */
            $tmpOrganisation = Organisation::find()->where(['id' => $member->organisation_id])->one();
            $array[] = ["id" => $tmpOrganisation->id, "name" => $tmpOrganisation->name, "class" => Yii::t('app', 'Organisation')];
        }
        return $array;
    }

    /**
     * Returns the Hosted by Name
     * @return mixed
     */
    public function getHostedBy()
    {
        /** @var $this Tournament */
        if ($this->hosted_by == -1 && isset($this->user_id)) {
            return $this->user->username;
        } else if ($this->hosted_by >= 0 && isset($this->organisation_id)) {
            return $this->organisation->name;
        } else {
            return null;
        }
    }


    /**
     * Returns the Game
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }


    /**
     * Check if the Owner is a user or a organisation
     * @return bool
     */
    public function isUserOwner(){
        return $val = ($this->hosted_by == -1) ? true : false;
    }

    public function getCreatedBy(){
        if($this->isUserOwner()){
            return $this->getUser();
        } else {
            return $this->getOrganisation();
        }
    }
    /**
     * Returns the Owner Organisation if defined
     * @return array|null|ActiveRecord
     */
    public function getOrganisation()
    {
        if (!is_null($this->organisation_id)) {
            return Organisation::find()->where(['id' => $this->organisation_id])->one();
        } else return null;
    }

    /**
     * Returns the Owner User if defined
     * @return array|null|ActiveRecord
     */
    public function getUser()
    {
        if (!is_null($this->user_id)) {
            return User::find()->where(['id' => $this->user_id])->one();
        } else return null;
    }

    /**
     * Returns a countdown until the Tournament begins
     * @return string
     */
    public function getCountdown()
    {
        /* Datum bitte anpassen (Stunde, Minute, Sekunde, Monat, Tag, Jahr) */
        $bis = strtotime($this->begin);
        $rest = $bis - time();
        if ($rest <= 0) {
            return Yii::t('app', 'In the past');
        }
        $wochen = 0;
        $tage = 0;
        $stunden = 0;

        if ($rest >= 604800) {
            $wochen = floor($rest / 604800);
            $rest -= $wochen * 604800;
        }

        if ($rest >= 86400) {
            $tage = floor($rest / 86400);
            $rest -= $tage * 86400;
        }
        if ($rest >= 3600) {
            $stunden = floor($rest / 3600);
        }

        return $wochen . ' ' . Yii::t('app', 'weeks') . ', ' . $tage . ' ' . Yii::t('app', 'days') . ', ' . $stunden . ' ' . Yii::t('app', 'hours');
    }

    /**
     * Returns the Image of the Organisation or User who owns the tournament
     * @return array
     */
    public function getPhotoInfo()
    {
        $alt = $this->name;

        $imageInfo = ['alt' => $alt];

        if ($this->hosted_by !== -1 && isset($this->organisation_id)) {
            /** @var Organisation $organisation */
            $organisation = Organisation::find()->where(['id' => $this->organisation_id])->one();
            //Yii::$app->session->setFlash('error', $organisation->user_id);
            $organisation_photoInfo = $organisation->getPhotoInfo();
            $imageInfo['url'] = $organisation_photoInfo['url'];
        } else if ($this->hosted_by == -1 && isset($this->user_id)) {
            $imageInfo['url'] = Url::to('@web/images/players/default.jpg');
        } else {
            $imageInfo['url'] = Url::to('@web/images/organisations/default.png');
        }
        return $imageInfo;
    }

    /**
     * Will be called if a new Participant is added or removed.
     */
    public function setParticipantCount()
    {
        $this->participants_count = count($this->participants);
        $this->save();
        Yii::$app->session->setFlash('error', 'count($this->participants)');
    }

}
