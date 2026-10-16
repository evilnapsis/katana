<?php
class StatusData extends LbModel {
	public static $tablename = "status";

	public $id, $name;

	public function __construct(){
		$this->name = "";
	}
}
