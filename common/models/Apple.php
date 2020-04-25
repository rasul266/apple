<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Exception;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string|null $color
 * @property int|null $created_at
 * @property int|null $fall_date
 * @property int|null $status
 * @property int|null $size
 */
class Apple extends \yii\db\ActiveRecord
{


    const STATUS_HANGING_ON_A_TREE = 1; //яблоко висит на дереве
    const STATUS_FELL_TO_THE_GROUND = 2; //яблоко лежит на земле
    const STATUS_ROTTEN = 3; //яблоко испортилось

    const MAX_SIZE = 100; // %
    const MIN_SIZE = 0;

    const APPLE_LIFE_AFTER_FALL = 5;//срок яблок после падения

    public $colorList = ['green', 'blue', 'red', 'black'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    public function __construct($color = null, $config = [])
    {
        if (!is_null($color)) {
            $this->color = $color;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'fall_date'], 'integer'],
            [['color'], 'string', 'max' => 50],

            [['status'], 'in', 'range' => [self::STATUS_HANGING_ON_A_TREE, self::STATUS_FELL_TO_THE_GROUND, self::STATUS_ROTTEN]],
            ['status', 'default', 'value' => self::STATUS_HANGING_ON_A_TREE],

            ['size', 'default', 'value' => self::MAX_SIZE],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'created_at' => 'Дата появления',
            'fall_date' => 'Дата падения',
            'status' => 'Состояние',
            'size' => 'Сколько съели (%)',
        ];
    }

    public function afterFind()
    {
        if ($this->hasExpired()) {
            $this->rotten();
        }

        parent::afterFind(); // TODO: Change the autogenerated stub
    }


    public function hasExpired()
    {
        if ($this->isFell() and $this->fall_date + (5 * 3600) <= time()) {

            return true;
        }

        return false;
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
            $this->having();
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_HANGING_ON_A_TREE => 'Висит на дереве',
            self::STATUS_FELL_TO_THE_GROUND => 'Лежит на земле',
            self::STATUS_ROTTEN => 'Испортилось',
        ];
    }


    public function rotten()
    {
        $this->status = self::STATUS_ROTTEN;
        return $this->save(false, ['status']);
    }

    public function having()
    {
        $this->status = self::STATUS_HANGING_ON_A_TREE;
    }


    public function isHaving()
    {
        if ($this->status == self::STATUS_HANGING_ON_A_TREE) {
            return true;
        }

        return false;
    }

    public function isRotten()
    {
        if ($this->status == self::STATUS_ROTTEN) {
            return true;
        }

        return false;
    }

    public function isFell()
    {
        if ($this->status == self::STATUS_FELL_TO_THE_GROUND) {
            return true;
        }

        return false;
    }

    public function fallToGround()
    {
        $this->status = self::STATUS_FELL_TO_THE_GROUND;
        $this->fall_date = time();
    }

    public function eat($percent)
    {

        if ($percent > $this->size) {

            $this->size = self::MIN_SIZE;
        } else {
            $this->size -= $percent;
        }

        return true;
    }

    public function isEaten()
    {
        if ($this->size == self::MIN_SIZE) {
            return true;
        }

        return false;
    }


    public static function getAllApples()
    {
        return self::find()->orderBy('id desc')->all();
    }

    public function getDate()
    {
        return $this->created_at = Yii::$app->formatter->asDatetime($this->created_at);
    }

    public function getFallDate()
    {
        return $this->created_at = Yii::$app->formatter->asDatetime($this->fall_date);
    }


}
