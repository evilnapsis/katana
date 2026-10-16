<?php
class PaymethodData extends LbModel {
	public static $tablename = "paymethod";

	public $id, $short_name, $name, $is_active;

	public function __construct(){
		$this->name = "";
		$this->short_name = "";
		$this->is_active = 0;
	}

	public static function getActives(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." where is_active = 1");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}
}
