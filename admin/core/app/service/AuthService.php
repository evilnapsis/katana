<?php
namespace App\Service;

/**
 * Clase AuthService
 * 
 * Capa de servicio encargada de la logica de autenticacion,
 * inicio de sesion con password_verify y cierre de sesion.
 */
class AuthService {
    /**
     * Procesa el intento de inicio de sesion de un usuario utilizando password_verify
     * @param string $username Nombre de usuario o correo electronico
     * @param string $password Contrasena en texto plano
     * @return bool True si las credenciales son validas, False en caso contrario
     */
    public function login(string $username, string $password): bool {
        $user = \UserData::getByUsernameOrEmail($username);
        
        if ($user && !empty($user->password)) {
            // Verificacion segura moderna con password_verify
            if (password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                return true;
            }

            // Soporte de migracion transparente para contrasenas legadas (sha1(md5))
            if ($user->password === sha1(md5($password))) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                // Rehash automatico al nuevo estandar seguro password_hash
                $user->password = password_hash($password, PASSWORD_DEFAULT);
                $user->save();
                return true;
            }
        }
        
        return false;
    }

    /**
     * Cierra la sesion activa destruyendo los datos guardados
     */
    public function logout(): void {
        session_destroy();
    }

    /**
     * Verifica si existe un usuario autenticado en la sesion actual
     * @return bool
     */
    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }
}
