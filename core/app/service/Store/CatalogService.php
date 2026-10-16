<?php
namespace App\Service\Store;

/**
 * Capa de servicio para la tienda publica (Katana Lite): home, categorias, listado de
 * productos/busqueda y detalle de producto.
 */
class CatalogService {
    private $projectRoot;

    public function __construct() {
        $this->projectRoot = dirname(__DIR__, 5);
    }

    private function coin(): string {
        $c = \ConfigurationData::getByPreffix('general_coin');
        return $c ? $c->val : '$';
    }

    private function imgDefault(): string {
        $c = \ConfigurationData::getByPreffix('general_img_default');
        return $c ? $c->val : '';
    }

    /** Resuelve la URL relativa (desde la raiz del proyecto) de la imagen de un producto */
    public function resolveProductImage(\ProductData $p): string {
        $default = $this->imgDefault();
        if (empty($p->image)) return $default;
        if (file_exists($this->projectRoot . '/admin/storage/products/' . $p->image)) {
            return 'admin/storage/products/' . $p->image;
        }
        if (file_exists($this->projectRoot . '/' . $p->image)) {
            return $p->image;
        }
        return $default;
    }

    public function resolveSlideImage(\SlideData $s): ?string {
        if (!empty($s->image) && file_exists($this->projectRoot . '/admin/storage/slides/' . $s->image)) {
            return 'admin/storage/slides/' . $s->image;
        }
        return null;
    }

    /** Categorias activas para el menu de navegacion */
    public function getNavCategories(): array {
        $list = [];
        foreach (\CategoryData::getPublics() as $cat) {
            $list[] = [
                'id' => $cat->id,
                'name' => $cat->name,
                'short_name' => $cat->short_name,
            ];
        }
        return $list;
    }

    public function getHomeData(): array {
        $featureds = \ProductData::getFeatureds();
        return [
            'slides' => array_map(fn($s) => ['slide' => $s, 'image' => $this->resolveSlideImage($s)], \SlideData::getPublics()),
            'featureds' => array_map(fn($p) => ['product' => $p, 'image' => $this->resolveProductImage($p)], $featureds),
            'coin' => $this->coin(),
        ];
    }

    public function getCategoryPage(string $shortName): ?array {
        $cat = \CategoryData::getByPreffix($shortName);
        if (!$cat) return null;

        $products = \ProductData::getPublicsByCategoryId($cat->id);

        return [
            'cat' => $cat,
            'title' => $cat->name,
            'products' => array_map(fn($p) => ['product' => $p, 'image' => $this->resolveProductImage($p)], $products),
            'coin' => $this->coin(),
        ];
    }

    public function getProductsPage(array $query): array {
        if (!empty($query['q'])) {
            $products = \ProductData::getLike($query['q']);
            $title = 'Búsqueda: ' . $query['q'];
        } elseif (($query['opt'] ?? '') === 'news') {
            $products = \ProductData::getNews();
            $title = 'Novedades';
        } elseif (($query['opt'] ?? '') === 'offers') {
            $products = \ProductData::getOffers();
            $title = 'Ofertas';
        } else {
            $products = \ProductData::getAll();
            $title = 'Catálogo de Productos';
        }

        return [
            'title' => $title,
            'products' => array_map(fn($p) => ['product' => $p, 'image' => $this->resolveProductImage($p)], $products),
            'coin' => $this->coin(),
        ];
    }

    public function getProductDetail(int $id): ?array {
        $p = \ProductData::find($id);
        if (!$p) return null;

        return [
            'product' => $p,
            'image' => $this->resolveProductImage($p),
            'cat' => $p->category_id ? \CategoryData::find($p->category_id) : null,
            'coin' => $this->coin(),
        ];
    }
}
