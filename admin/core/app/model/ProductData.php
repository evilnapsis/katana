<?php
class ProductData {
	public static $tablename = "product";

	public $id, $short_name, $code, $name, $description, $image, $price, $link, $category_id, $unit_id, $is_public, $in_existence, $is_featured, $created_at;
	public $offer_txt, $order_at, $meta_title, $meta_description, $meta_keywords, $is_offert;

	public function __construct(){
		$this->short_name = "";
		$this->code = "";
		$this->name = "";
		$this->description = "";
		$this->image = "";
		$this->link = "";
		$this->category_id = "";
		$this->unit_id = "";
		$this->is_public = "0";
		$this->in_existence = "0";
		$this->is_featured = "0";
		$this->created_at = "NOW()";
	}

	public function getUnit(){ return UnitData::getById($this->unit_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (short_name,code,name,description,image,price,link,category_id,unit_id,is_public,in_existence,is_featured,is_offert,created_at) ";
		$sql .= "value (\"$this->short_name\",\"$this->code\",\"$this->name\",\"$this->description\",\"$this->image\",\"$this->price\",\"$this->link\",$this->category_id,$this->unit_id,$this->is_public,$this->in_existence,$this->is_featured,$this->is_offert,$this->created_at)";
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
		$sql = "update ".self::$tablename." set code=\"$this->code\",name=\"$this->name\",description=\"$this->description\",link=\"$this->link\",price=\"$this->price\",in_existence=\"$this->in_existence\",is_public=\"$this->is_public\",is_featured=\"$this->is_featured\",unit_id=\"$this->unit_id\",category_id=\"$this->category_id\",is_offert=\"$this->is_offert\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_image(){
		$sql = "update ".self::$tablename." set image=\"$this->image\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ProductData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getPublicsByCategoryId($id){
		$sql = "select * from ".self::$tablename." where category_id=$id and is_public=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%' or description like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getFeatureds(){
		$sql = "select * from ".self::$tablename." where is_featured=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getNews(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getOffers(){
		$sql = "select * from ".self::$tablename." where is_offert=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

}

?>
