<?php
class CategoryData extends LbModel {
	public static $tablename = "category";

	public $id, $image, $name, $short_name, $in_home, $in_menu, $is_active;

	public function __construct(){
		$this->name = "";
		$this->short_name = "";
		$this->in_home = 0;
		$this->in_menu = 0;
		$this->is_active = 1;
	}

	public static function getAll(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." order by name asc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getPublics(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." where is_active = 1 order by name asc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getPublicsRoot(): array {
		return static::getPublics();
	}

	public static function getAllRoot(): array {
		return static::getAll();
	}

	public static function getByPreffix(string $shortName) {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where short_name = :s limit 1");
		$stmt->execute(['s' => $shortName]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}
}
