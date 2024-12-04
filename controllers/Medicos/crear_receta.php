<?php
include '../../db/Database.php';
include '../../db/Recetas.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar que los datos necesarios han sido enviados
if (
    !isset($_POST['paciente_id']) || empty($_POST['paciente_id']) ||
    !isset($_POST['cedula']) || empty($_POST['cedula']) ||
    !isset($_POST['correo_paciente']) || empty($_POST['correo_paciente']) ||
    !isset($_POST['medicamentos']) || empty($_POST['medicamentos'])
) {
    echo json_encode(['error' => 'Faltan datos obligatorios']);
    exit;
}

// Limpiar los datos recibidos
$paciente_id = htmlspecialchars($_POST['paciente_id']);
$cedula = htmlspecialchars($_POST['cedula']);
$correo_paciente = htmlspecialchars($_POST['correo_paciente']);
$medicamentos = htmlspecialchars($_POST['medicamentos']);

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$recetasModel = new Recetas($db);

// Crear la receta
$resultado = $recetasModel->crearReceta($paciente_id, $cedula, $correo_paciente, $medicamentos);

if ($resultado) {
    // Crear el objeto PHPMailer
    require '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta según tu estructura de directorios

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor de correo
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'sistemabibliotecau@gmail.com'; // Tu dirección de correo
        $mail->Password = 'epbr kzvp fdom ipsi'; // Tu contraseña de correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Cambia el puerto si es necesario

        // Remitente y destinatario
        $mail->setFrom('sistemabibliotecau@gmail.com
', 'Clinica Garcia'); // Cambia esto
        $mail->addAddress($correo_paciente); // Correo del paciente

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Receta Médica';
        $mail->Body = "Hola, <br><br> Se ha generado una nueva receta médica. A continuación se encuentra la lista de medicamentos recetados: <br><br>" . nl2br($medicamentos);

        // Enviar el correo
        $mail->send();

        // Respuesta de éxito
        echo json_encode(['success' => 'Receta creada y correo enviado exitosamente']);
    } catch (Exception $e) {
        // Si ocurre un error al enviar el correo
        echo json_encode(['error' => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
    }
} else {
    // Respuesta de error si no se puede crear la receta
    echo json_encode(['error' => 'Error al crear la receta']);
}
?>
