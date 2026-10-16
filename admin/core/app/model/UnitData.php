<?php
class UnitData extends LbModel {
	public static $tablename = "unit";

	public $id, $name;

	public function __construct(){
		$this->name = "";
	}
}
