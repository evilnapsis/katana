<?php

/**
 * Clase Request
 * 
 * Facilita el acceso seguro a datos de entrada ($_GET, $_POST) y proporciona
 * un mecanismo liviano de validacion de campos de formulario.
 */
class Request {
    /**
     * Obtiene un parametro de la superglobal $_GET o el arreglo completo
     * @param string|null $key Nombre del parametro o null para todo
     * @param mixed $default Valor por defecto si no existe
     * @return mixed
     */
    public static function get(?string $key = null, $default = null) {
        if ($key === null) return $_GET;
        return $_GET[$key] ?? $default;
    }

    /**
     * Obtiene un parametro de la superglobal $_POST o el arreglo completo
     * @param string|null $key Nombre del parametro o null para todo
     * @param mixed $default Valor por defecto si no existe
     * @return mixed
     */
    public static function post(?string $key = null, $default = null) {
        if ($key === null) return $_POST;
        return $_POST[$key] ?? $default;
    }

    /**
     * Obtiene todos los parametros combinados de $_GET y $_POST
     * @return array
     */
    public static function all(): array {
        return array_merge($_GET, $_POST);
    }

    /**
     * Valida un arreglo de campos contra reglas simples (ej. 'required', 'email', 'min:3')
     * @param array $rules Reglas asociativas por campo
     * @return array Arreglo de errores encontrados (vacio si pasa la validacion)
     */
    public static function validate(array $rules): array {
        $errors = [];
        $data = self::all();

        foreach ($rules as $field => $ruleString) {
            $rulesList = explode('|', $ruleString);
            $value = trim($data[$field] ?? '');

            foreach ($rulesList as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $errors[$field] = "El campo {$field} es obligatorio.";
                } elseif ($rule === 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "El campo {$field} debe ser un correo electronico valido.";
                } elseif (strpos($rule, 'min:') === 0) {
                    $min = (int)substr($rule, 4);
                    if (strlen($value) < $min) {
                        $errors[$field] = "El campo {$field} debe tener al menos {$min} caracteres.";
                    }
                }
            }
        }

        return $errors;
    }
}
