<?php
namespace App\Service;

/**
 * Capa de servicio para los usuarios del panel admin (tabla `user`, staff/admin).
 * Distinta de ClientService (clientes de la tienda, tabla `client`).
 */
class UserService {
    public function getAll(): array {
        return \UserData::all();
    }

    public function getById($id) {
        return \UserData::find($id);
    }

    public function create(array $data): bool {
        $user = new \UserData();
        $user->name = $data['name'] ?? '';
        $user->lastname = $data['lastname'] ?? '';
        $user->username = $data['username'] ?? '';
        $user->email = $data['email'] ?? '';
        $user->is_admin = isset($data['is_admin']) ? 1 : 0;
        $user->is_active = 1;
        $user->password = sha1(md5($data['password'] ?? ''));
        return $user->save();
    }

    public function update(int $id, array $data): bool {
        $user = \UserData::find($id);
        if (!$user) return false;
        $user->name = $data['name'] ?? $user->name;
        $user->lastname = $data['lastname'] ?? $user->lastname;
        $user->username = $data['username'] ?? $user->username;
        $user->email = $data['email'] ?? $user->email;
        $user->is_admin = isset($data['is_admin']) ? 1 : 0;
        $user->is_active = isset($data['is_active']) ? 1 : 0;
        if (!empty($data['password'])) {
            $user->password = sha1(md5($data['password']));
        }
        return $user->save();
    }
}
