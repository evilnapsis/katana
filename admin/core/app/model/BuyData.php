<?php
class BuyData extends LbModel {
	public static $tablename = "buy";

	public $id, $k, $code, $client_id, $status_id, $created_at, $paymethod_id;

	public function __construct(){
		$this->created_at = "NOW()";
	}

	public function getStatus() { return StatusData::find($this->status_id); }
	public function getClient() { return ClientData::find($this->client_id); }
	public function getPaymethod() { return PaymethodData::find($this->paymethod_id); }

	public function getTotal(): float {
		$products = BuyProductData::getAllByBuyId($this->id);
		$total = 0;
		foreach ($products as $bp) {
			$p = $bp->getProduct();
			if ($p) $total += $p->price * $bp->q;
		}
		return $total;
	}

	public function changeStatus(int $statusId): bool {
		$this->status_id = $statusId;
		return $this->save();
	}

	public static function getAll(): array {
		$db = static::getDb();
		$stmt = $db->query("select * from ".self::$tablename." order by created_at desc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getAllByClientId($id): array {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where client_id = :id order by created_at desc");
		$stmt->execute(['id' => $id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function getByCode(string $code) {
		$db = static::getDb();
		$stmt = $db->prepare("select * from ".self::$tablename." where code = :code limit 1");
		$stmt->execute(['code' => $code]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}
}
