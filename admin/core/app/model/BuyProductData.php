<?php
class BuyProductData {
	public static $tablename = "buy_product";

	public $id, $buy_id, $product_id, $q;

	public function __construct(){
		$this->id = null;
		$this->buy_id = "";
		$this->product_id = "";
		$this->q = "";
	}

	public function getProduct() { return ProductData::getById($this->product_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (buy_id,product_id,q) ";
		$sql .= "value (\"$this->buy_id\",$this->product_id,$this->q)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BuyProductData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BuyProductData());
	}

	public static function getAllByBuyId($id){
		$sql = "select * from ".self::$tablename." where buy_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new BuyProductData());
	}

}

?>
