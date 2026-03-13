<?php
class ClientData {
	public static $tablename = "client";

	public $id, $name, $lastname, $phone, $address, $email, $password, $created_at, $is_active;

	public function __construct(){
		$this->id = null;
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,lastname,phone,address,email,password,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->phone\",\"$this->address\",\"$this->email\",\"$this->password\",$this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",address=\"$this->address\",phone=\"$this->phone\",email=\"$this->email\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_passwd(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}

	public function getFullname(){ return $this->name." ".$this->lastname; }

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ClientData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename."";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ClientData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ClientData());
	}

	public static function getByMail($email){
		$sql = "select * from ".self::$tablename." where email='$email'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ClientData());
	}

}

?>
