<?php
class ConfigurationData extends LbModel {
	public static $tablename = "configuration";

	public $id, $name, $label, $kind, $val, $cfg_id;

	public function __construct(){
		$this->name = "";
		$this->label = "";
		$this->val = "";
	}

	public static function getByPreffix(string $name) {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where name = :name limit 1");
		$stmt->execute(['name' => $name]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}

	public static function updateValFromName(string $name, $val): bool {
		$db = static::getDb();
		$stmt = $db->prepare("update ".self::$tablename." set val = :val where name = :name");
		return $stmt->execute(['val' => $val, 'name' => $name]);
	}
}
