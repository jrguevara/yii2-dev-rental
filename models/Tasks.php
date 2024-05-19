<?php

namespace app\models;

use app\modules\users\models\Users;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id_task
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property int $id_area
 * @property int $status
 * @property int $created_by
 * @property string $created_at
 * @property int $updated_by
 * @property string $updated_at
 *
 * @property Areas $area
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['id_area', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 25],
            [['name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['created_by' => 'id_user']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['updated_by' => 'id_user']],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::class, 'targetAttribute' => ['id_area' => 'id_area']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_task' => 'Id',
            'code' => 'Codigo',
            'name' => 'Nombre',
            'description' => 'Descripcion',
            'id_area' => 'Area',
            'status' => 'Estado',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updatedted By',
            'updated_at' => 'Updatedted At',
        ];
    }

    /**
     * Gets query for [[Area]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Areas::class, ['id_area' => 'id_area']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::class, ['id_user' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::class, ['id_user' => 'updated_by']);
    }
}
