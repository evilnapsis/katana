<?php
namespace App\Service;

/**
 * Capa de servicio para los ajustes del sistema (tabla `configuration`) y los
 * metodos de pago disponibles (tabla `paymethod`).
 */
class SettingService {
    public function getGeneral(): array {
        return $this->getByPrefix('general_');
    }

    public function getByPrefix(string $prefix): array {
        $all = \ConfigurationData::all();
        return array_values(array_filter($all, fn($c) => strpos($c->name, $prefix) === 0));
    }

    /** Actualiza cualquier clave de configuracion presente en $data (ignora csrf_token) */
    public function update(array $data): void {
        foreach ($data as $name => $val) {
            if ($name === 'csrf_token') continue;
            \ConfigurationData::updateValFromName($name, $val);
        }
    }

    public function getPaymethods(): array {
        return \PaymethodData::all();
    }

    public function isPaymethodActiveByShortName(array $paymethods, string $shortName): bool {
        foreach ($paymethods as $pm) {
            if ($pm->short_name === $shortName) return (bool)$pm->is_active;
        }
        return false;
    }

    public function togglePaymethod(int $id): void {
        $pm = \PaymethodData::find($id);
        if (!$pm) return;
        $pm->is_active = $pm->is_active ? 0 : 1;
        $pm->save();
    }
}
