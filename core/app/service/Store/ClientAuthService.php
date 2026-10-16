<?php
namespace App\Service\Store;

/**
 * Capa de servicio para el acceso de clientes de la tienda (tabla `client`,
 * separada de `user` que es el staff/admin).
 */
class ClientAuthService {
    public function login(string $email, string $password): bool {
        $client = \ClientData::getByEmail($email);
        if (!$client || empty($client->password)) return false;

        if (password_verify($password, $client->password)) {
            $this->setSession($client);
            return true;
        }

        // Compatibilidad con el hash legacy sha1(md5()) usado por la tienda original
        if ($client->password === sha1(md5($password))) {
            $this->setSession($client);
            $client->password = password_hash($password, PASSWORD_DEFAULT);
            $client->save();
            return true;
        }

        return false;
    }

    private function setSession(\ClientData $client): void {
        $_SESSION['client_id'] = $client->id;
        $_SESSION['client_name'] = $client->name;
    }

    public function logout(): void {
        unset($_SESSION['client_id'], $_SESSION['client_name'], $_SESSION['cart'], $_SESSION['coupon']);
    }

    public static function check(): bool {
        return isset($_SESSION['client_id']);
    }

    /** @return string|null mensaje de error si el registro fallo (ej. email duplicado) */
    public function register(array $data): ?string {
        if (\ClientData::getByEmail($data['email'] ?? '')) {
            return 'Ya existe un usuario registrado con esta direccion email.';
        }

        $client = new \ClientData();
        $client->name = $data['name'] ?? '';
        $client->lastname = $data['lastname'] ?? '';
        $client->email = $data['email'] ?? '';
        $client->phone = $data['phone'] ?? '';
        $client->address = $data['address'] ?? '';
        $client->password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT);
        $client->save();

        return null;
    }
}
