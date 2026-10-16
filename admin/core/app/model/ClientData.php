<?php
class ClientData extends LbModel {
	public static $tablename = "client";

	public $id, $name, $lastname, $email, $phone, $address, $password, $is_active, $created_at;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->phone = "";
		$this->address = "";
		$this->password = "";
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function getFullname(): string { return trim($this->name." ".$this->lastname); }

	public static function getByEmail(string $email) {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where email = :email limit 1");
		$stmt->execute(['email' => $email]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}
}
