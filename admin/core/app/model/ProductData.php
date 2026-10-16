<?php
class ProductData extends LbModel {
	public static $tablename = "product";

	public $id, $short_name, $name, $code, $description, $offer_txt, $image, $link;
	public $is_featured, $is_public, $in_existence, $created_at, $order_at, $price;
	public $category_id, $unit_id;
	public $meta_title, $meta_description, $meta_keywords;

	public function __construct(){
		$this->name = "";
		$this->code = "";
		$this->short_name = "";
		$this->description = "";
		$this->offer_txt = "";
		$this->image = "";
		$this->link = "";
		$this->price = 0;
		$this->is_featured = 0;
		$this->is_public = 0;
		$this->in_existence = 0;
		$this->created_at = "NOW()";
		$this->order_at = "NOW()";
	}

	public function getUnit() { return UnitData::find($this->unit_id); }
	public function getCategory() { return CategoryData::find($this->category_id); }

	public static function getAll(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." order by created_at desc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getLike(string $q): array {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where name like :q or description like :q limit 50");
		$stmt->execute(['q' => "%$q%"]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getFeatureds(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." where is_featured = 1 and is_public = 1 order by created_at desc limit 6");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getNews(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." where is_public = 1 order by created_at desc limit 4");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getOffers(): array {
		return [];
	}

	public static function getPublicsByCategoryId($id): array {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where category_id = :id and is_public = 1 order by created_at desc");
		$stmt->execute(['id' => $id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}
}
