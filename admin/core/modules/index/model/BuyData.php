<?php
class BuyData {
	public static $tablename = "buy";


	public function BuyData(){
		$this->title = "";
		$this->content = "";
		$this->image = "";
		$this->user_id = "";
		$this->is_public = "0";
		$this->created_at = "NOW()";
	}

	public function getStatus(){ return StatusData::getById($this->status_id);}
	public function getClient(){ return ClientData::getById($this->client_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (code,client_id,created_at,status_id) ";
		$sql .= "value (\"$this->code\",\"$this->client_id\",$this->created_at,$this->status_id)";
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

// partiendo de que ya tenemos creado un objecto BuyData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public function cancel(){
		$sql = "update ".self::$tablename." set status_id=5 where id=$this->id";
		Executor::doit($sql);
	}


	public function change_status(){
		$sql = "update ".self::$tablename." set status_id=\"$this->status_id\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BuyData());
	}

	public static function getByCode($id){
		$sql = "select * from ".self::$tablename." where code=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BuyData());
	}

	public static function getByPreffix($id){
		$sql = "select * from ".self::$tablename." where short_name=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BuyData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BuyData());
	}

	public  function getTotal(){
		$products = BuyProductData::getAllByBuyId($this->id);
		$total=0;
		foreach ($products as $px) {
			$p = ProductData::getById($px->product_id);
			$total+=$p->price*$px->q;
		}
		return $total;
	}


	public static function getAllByClientId($id){
		$sql = "select * from ".self::$tablename." where client_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new BuyData());
	}


	public static function getPublics(){
		$sql = "select * from ".self::$tablename." where is_public=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new BuyData());
	}

}

?>