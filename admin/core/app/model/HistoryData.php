<?php
class HistoryData extends LbModel {
	public static $tablename = "history";

	public $id, $buy_id, $status_id, $created_at;

	public function __construct(){
		$this->created_at = "NOW()";
	}

	public function getStatus() { return StatusData::find($this->status_id); }

	public static function getAllByBuyId($id): array {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where buy_id = :id order by created_at asc");
		$stmt->execute(['id' => $id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}
}
