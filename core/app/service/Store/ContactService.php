<?php
namespace App\Service\Store;

/**
 * Capa de servicio para el formulario de contacto. Envia notificacion al
 * correo administrativo y una confirmacion al remitente (best-effort, igual
 * que el resto de notificaciones por correo del sistema).
 */
class ContactService {
    public function send(array $data): void {
        $name = htmlspecialchars(trim($data['name'] ?? ''));
        $email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $subject = htmlspecialchars(trim($data['subject'] ?? ''));
        $message = nl2br(htmlspecialchars(trim($data['message'] ?? '')));

        if (!$email) return;

        $adminEmail = (\ConfigurationData::getByPreffix('general_main_email')->val ?? '');

        $toAdmin = "<html><body><h3>Nuevo mensaje de contacto</h3>"
            . "<p><strong>Nombre:</strong> {$name}</p>"
            . "<p><strong>Correo:</strong> {$email}</p>"
            . "<p><strong>Asunto:</strong> {$subject}</p>"
            . "<p><strong>Mensaje:</strong><br>{$message}</p></body></html>";

        @mail($adminEmail, "Contacto: {$subject}", $toAdmin,
            "From: {$adminEmail}\r\nReply-To: {$email}\r\nContent-Type: text/html; charset=UTF-8");

        $toUser = "<html><body><p>Estimado {$name}:</p><p>Gracias por contactarnos. Te responderemos a la brevedad.</p></body></html>";
        @mail($email, "Gracias por contactarnos", $toUser,
            "From: {$adminEmail}\r\nReply-To: {$adminEmail}\r\nContent-Type: text/html; charset=UTF-8");
    }
}
