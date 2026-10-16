<?php
class UserData extends LbModel {
	public static $tablename = "user";

	public $id, $name, $lastname, $username, $email, $password, $is_active, $is_admin, $created_at;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->username = "";
		$this->email = "";
		$this->password = "";
		$this->is_active = 1;
		$this->is_admin = 0;
		$this->created_at = "NOW()";
	}

	/**
	 * Obtiene un usuario administrador activo por su username o email para el proceso de autenticacion
	 * @param string $username Nombre de usuario o correo electronico
	 * @return UserData|null
	 */
	public static function getByUsernameOrEmail(string $username) {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where (username = :u or email = :u) and is_active = 1 limit 1");
		$stmt->execute(['u' => $username]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}
}
