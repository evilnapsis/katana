<?php
class BuyProductData extends LbModel {
	public static $tablename = "buy_product";

	public $id, $buy_id, $product_id, $q;

	public function getProduct() { return ProductData::find($this->product_id); }

	public static function getAllByBuyId($id): array {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where buy_id = :id");
		$stmt->execute(['id' => $id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}
}
