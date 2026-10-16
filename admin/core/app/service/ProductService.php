<?php
namespace App\Service;

/**
 * Capa de servicio para el catalogo de productos (Katana Lite).
 */
class ProductService {
    private $storagePath;

    public function __construct() {
        // Carpeta de almacenamiento publica de la tienda
        $this->storagePath = dirname(__DIR__, 4) . '/storage/products/';
    }

    public function getAll(): array {
        return \ProductData::getAll();
    }

    public function getById($id) {
        return \ProductData::find($id);
    }

    private function randomCode(int $len = 11): string {
        $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
        $code = "";
        for ($i = 0; $i < $len; $i++) {
            $code .= $alphabeth[random_int(0, strlen($alphabeth) - 1)];
        }
        return $code;
    }

    public function create(array $data, ?array $file): bool {
        $product = new \ProductData();
        $product->short_name = $this->randomCode();
        $product->code = $data['code'] ?? '';
        $product->name = $data['name'] ?? '';
        $product->description = $data['description'] ?? '';
        $product->price = (float)($data['price'] ?? 0);
        $product->link = $data['link'] ?? '';
        $product->category_id = (int)($data['category_id'] ?? 0);
        $product->unit_id = (int)($data['unit_id'] ?? 0);
        $product->is_public = isset($data['is_public']) ? 1 : 0;
        $product->in_existence = isset($data['in_existence']) ? 1 : 0;
        $product->is_featured = isset($data['is_featured']) ? 1 : 0;

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $handle = new \Upload($file);
            if ($handle->uploaded) {
                $handle->Process($this->storagePath);
                if ($handle->processed) {
                    $product->image = $handle->file_dst_name;
                }
            }
        }

        return $product->save();
    }

    public function update(int $id, array $data, ?array $file): bool {
        $product = \ProductData::find($id);
        if (!$product) return false;

        $product->code = $data['code'] ?? $product->code;
        $product->name = $data['name'] ?? $product->name;
        $product->description = $data['description'] ?? $product->description;
        $product->price = (float)($data['price'] ?? $product->price);
        $product->link = $data['link'] ?? $product->link;
        $product->category_id = (int)($data['category_id'] ?? $product->category_id);
        $product->unit_id = (int)($data['unit_id'] ?? $product->unit_id);
        $product->is_public = isset($data['is_public']) ? 1 : 0;
        $product->in_existence = isset($data['in_existence']) ? 1 : 0;
        $product->is_featured = isset($data['is_featured']) ? 1 : 0;

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $handle = new \Upload($file);
            if ($handle->uploaded) {
                $handle->Process($this->storagePath);
                if ($handle->processed) {
                    $product->image = $handle->file_dst_name;
                }
            }
        }

        return $product->save();
    }

    public function delete(int $id): bool {
        $product = \ProductData::find($id);
        if (!$product) return false;
        return $product->delete();
    }
}
