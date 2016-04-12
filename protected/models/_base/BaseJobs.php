<?php

/**
 * This is the model base class for the table "jobs_info".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Jobs".
 *
 * Columns in table "jobs_info" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property integer $nprocs
 * @property string $total_bytes
 * @property integer $runtime
 * @property double $unique_iotime
 * @property string $start_time
 * @property string $end_time
 * @property string $uid
 * @property string $projid
 * @property string $appname
 * @property double $agg_perf_MB
 *
 */
abstract class BaseJobs extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'jobs_info';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Jobs|Jobs', $n);
	}

	public static function representingColumn() {
		return 'start_time';
	}

	public function rules() {
		return array(
			array('id, nprocs, runtime', 'numerical', 'integerOnly'=>true),
			array('unique_iotime, agg_perf_MB', 'numerical'),
			array('total_bytes, uid, projid', 'length', 'max'=>20),
			array('appname', 'length', 'max'=>50),
			array('start_time, end_time', 'safe'),
			array('id, nprocs, total_bytes, runtime, unique_iotime, start_time, end_time, uid, projid, appname, agg_perf_MB', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, nprocs, total_bytes, runtime, unique_iotime, start_time, end_time, uid, projid, appname, agg_perf_MB', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'nprocs' => Yii::t('app', 'Nprocs'),
			'total_bytes' => Yii::t('app', 'Total Bytes'),
			'runtime' => Yii::t('app', 'Runtime'),
			'unique_iotime' => Yii::t('app', 'Unique Iotime'),
			'start_time' => Yii::t('app', 'Start Time'),
			'end_time' => Yii::t('app', 'End Time'),
			'uid' => Yii::t('app', 'Uid'),
			'projid' => Yii::t('app', 'Projid'),
			'appname' => Yii::t('app', 'Real Exe'),
			'agg_perf_MB' => Yii::t('app', 'Agg Perf Mb'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('nprocs', $this->nprocs);
		$criteria->compare('total_bytes', $this->total_bytes, true);
		$criteria->compare('runtime', $this->runtime);
		$criteria->compare('unique_iotime', $this->unique_iotime);
		$criteria->compare('start_time', $this->start_time, true);
		$criteria->compare('end_time', $this->end_time, true);
		$criteria->compare('uid', $this->uid, true);
		$criteria->compare('projid', $this->projid, true);
		$criteria->compare('appname', $this->appname, true);
		$criteria->compare('agg_perf_MB', $this->agg_perf_MB);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}