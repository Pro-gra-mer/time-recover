<?php
/**
 * Time Recover - Procesador de formulario de contacto (PHP Puro)
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Configuración de destino
    $destinatario = "tu@email.com"; // CAMBIA ESTO POR TU EMAIL REAL
    $asunto = "Nueva solicitud de Auditoría - Time Recover";

    // 2. Saneamiento de datos
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $tareas = strip_tags(trim($_POST["tareas"]));

    // 3. Validación básica
    if (empty($nombre) || empty($tareas) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=error#contacto");
        exit;
    }

    // 4. Construcción del cuerpo del mensaje
    $contenido = "Has recibido una nueva candidatura desde la web Time Recover:\n\n";
    $contenido .= "Nombre: $nombre\n";
    $contenido .= "Email: $email\n\n";
    $contenido .= "Fricciones/Tareas identificadas:\n$tareas\n\n";
    $contenido .= "--------------------------------------------------\n";
    $contenido .= "Enviado el " . date("d/m/Y H:i:s") . "\n";

    // 5. Cabeceras del email
    $headers = "From: Time Recover <noreply@timerecover.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 6. Envío
    if (mail($destinatario, $asunto, $contenido, $headers)) {
        header("Location: index.html?status=success#contacto");
    } else {
        header("Location: index.html?status=error_server#contacto");
    }
} else {
    // Si no es POST, redirigir
    header("Location: index.html");
}
exit;
?>
