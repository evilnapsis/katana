<?php
namespace App\Service;

/**
 * Capa de servicio para el catalogo de categorias (Katana Lite - categorias planas).
 */
class CategoryService {
    public function getAll(): array {
        return \CategoryData::getAll();
    }

    public function getAllRoot(): array {
        return \CategoryData::getAll();
    }

    public function getById($id) {
        return \CategoryData::find($id);
    }

    public function create(array $data): bool {
        $cat = new \CategoryData();
        $cat->name = $data['name'] ?? '';
        $cat->short_name = $data['short_name'] ?? '';
        $cat->is_active = isset($data['is_active']) ? 1 : 0;
        return $cat->save();
    }

    public function update(int $id, array $data): bool {
        $cat = \CategoryData::find($id);
        if (!$cat) return false;
        $cat->name = $data['name'] ?? $cat->name;
        $cat->short_name = $data['short_name'] ?? $cat->short_name;
        $cat->is_active = isset($data['is_active']) ? 1 : 0;
        return $cat->save();
    }

    public function delete(int $id): bool {
        $cat = \CategoryData::find($id);
        return $cat ? $cat->delete() : false;
    }
}
