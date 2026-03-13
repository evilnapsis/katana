<?php
class SpendData {
	public static $tablename = "spend";

	public $id, $name, $amount, $category_id, $user_id, $date_at, $created_at;

	public function __construct(){
		$this->name = "";
		$this->amount = "";
		$this->category_id = "";
		$this->user_id = "";
		$this->date_at = "";
		$this->created_at = "NOW()";
	}

	public function getCategory(){ return CategoryData::getById($this->category_id); }
	public function getUser(){ return UserData::getById($this->user_id); }

	public function add(){
		$sql = "insert into ".self::$tablename." (name,amount,category_id,user_id,date_at,created_at) ";
		$sql .= "value (\"$this->name\",$this->amount,$this->category_id,$this->user_id,\"$this->date_at\",$this->created_at)";
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
		$sql = "update ".self::$tablename." set name=\"$this->name\",amount=$this->amount,category_id=$this->category_id,date_at=\"$this->date_at\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SpendData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new SpendData());
	}
	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SpendData());
	}

	public static function getByRange($start, $end){
		$sql = "select * from ".self::$tablename." where date_at>=\"$start\" and date_at<=\"$end\" order by date_at asc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SpendData());
	}
}
?>
