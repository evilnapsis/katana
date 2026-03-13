<?php
class CouponData {
	public static $tablename = "coupon";

	public $id, $name, $description, $product_id, $val, $kind, $is_multiple, $is_active, $start_at, $finish_at, $created_at;

	public function __construct(){
		$this->id = null;
		$this->name = "";
		$this->description = "";
		$this->product_id = "null";
		$this->val = "0";
		$this->kind = "1";
		$this->is_multiple = "0";
		$this->is_active = "1";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,description,product_id,val,kind,is_multiple,is_active,start_at,finish_at,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->description\",$this->product_id,$this->val,$this->kind,$this->is_multiple,$this->is_active,\"$this->start_at\",\"$this->finish_at\",$this->created_at)";
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
		$sql = "update ".self::$tablename." set name=\"$this->name\",description=\"$this->description\",val=\"$this->val\",kind=\"$this->kind\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CouponData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CouponData());
	}
}
?>
