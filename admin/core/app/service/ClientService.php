<?php
namespace App\Service;

/**
 * Capa de servicio para los clientes de la tienda (tabla `client`, separada
 * de `user` que es para el staff/admin).
 */
class ClientService {
    public function getAll(): array {
        return \ClientData::all();
    }

    public function getById($id) {
        return \ClientData::find($id);
    }

    public function create(array $data): bool {
        $client = new \ClientData();
        $client->name = $data['name'] ?? '';
        $client->lastname = $data['lastname'] ?? '';
        $client->email = $data['email'] ?? '';
        $client->phone = $data['phone'] ?? '';
        $client->address = $data['address'] ?? '';
        $client->password = sha1(md5($data['password'] ?? ''));
        return $client->save();
    }

    public function update(int $id, array $data): bool {
        $client = \ClientData::find($id);
        if (!$client) return false;
        $client->name = $data['name'] ?? $client->name;
        $client->lastname = $data['lastname'] ?? $client->lastname;
        $client->email = $data['email'] ?? $client->email;
        $client->phone = $data['phone'] ?? $client->phone;
        $client->address = $data['address'] ?? $client->address;
        if (!empty($data['password'])) {
            $client->password = sha1(md5($data['password']));
        }
        return $client->save();
    }

    /** @return true|string true si se elimino, o un mensaje de error si fallo (p.ej. tiene pedidos asociados) */
    public function delete(int $id) {
        $client = \ClientData::find($id);
        if (!$client) return false;
        try {
            return $client->delete();
        } catch (\PDOException $e) {
            return 'No se puede eliminar: el cliente tiene pedidos asociados.';
        }
    }
}
