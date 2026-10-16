<?php
class SlideData extends LbModel {
	public static $tablename = "slide";

	public $id, $title, $image, $is_public, $position, $created_at;

	public function __construct(){
		$this->title = "";
		$this->image = "";
		$this->is_public = 0;
		$this->position = 0;
		$this->created_at = "NOW()";
	}

	public static function getPublics(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." where is_public = 1 order by created_at desc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}
}
