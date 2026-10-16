<?php
namespace App\Service;

/**
 * Capa de servicio para los slides del carrusel principal de la tienda.
 */
class SlideService {
    private $storagePath;

    public function __construct() {
        // Carpeta de almacenamiento publica de la tienda
        $this->storagePath = dirname(__DIR__, 4) . '/storage/slides/';
    }

    public function getAll(): array {
        // SlideData::all() (heredado de LbModel) no ordena; replicamos el "order by created_at desc" del original
        $slides = \SlideData::all();
        usort($slides, fn($a, $b) => strcmp($b->created_at, $a->created_at));
        return $slides;
    }

    public function getById($id) {
        return \SlideData::find($id);
    }

    public function create(array $data, ?array $file): bool {
        $slide = new \SlideData();
        $slide->title = $data['title'] ?? '';
        $slide->is_public = isset($data['is_public']) ? 1 : 0;

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $handle = new \Upload($file);
            if ($handle->uploaded) {
                $handle->Process($this->storagePath);
                if ($handle->processed) {
                    $slide->image = $handle->file_dst_name;
                }
            }
        }

        return $slide->save();
    }

    public function update(int $id, array $data, ?array $file): bool {
        $slide = \SlideData::find($id);
        if (!$slide) return false;

        $slide->title = $data['title'] ?? $slide->title;
        $slide->is_public = isset($data['is_public']) ? 1 : 0;

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $handle = new \Upload($file);
            if ($handle->uploaded) {
                $handle->Process($this->storagePath);
                if ($handle->processed) {
                    $slide->image = $handle->file_dst_name;
                }
            }
        }

        return $slide->save();
    }

    public function delete(int $id): bool {
        $slide = \SlideData::find($id);
        return $slide ? $slide->delete() : false;
    }
}
