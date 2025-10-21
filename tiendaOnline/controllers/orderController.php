<?php
require_once 'models/PedidoRepository.php';
require_once 'models/DPRepository.php';
require_once 'models/ProductoRepository.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'confirm':
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?c=shop');
            exit;
        }

        // Obtener el ID del pedido desde la URL
        $idPedido = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($idPedido <= 0) {
            header('Location: index.php?c=shop&error=invalid_order');
            exit;
        }

        // Aquí podrías obtener los detalles del pedido para mostrar en la confirmación
        // Por ahora, simplemente mostramos un mensaje de éxito
        $message = "¡Pago realizado con éxito! Tu pedido #$idPedido ha sido procesado correctamente.";
        
        require_once 'views/orderConfirmView.phtml';
        exit;
        break;

    case 'view':
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?c=shop');
            exit;
        }

        // Aquí podrías implementar la vista de pedidos del usuario
        // Por ahora redirigimos a la tienda
        header('Location: index.php?c=shop');
        exit;
        break;

    default:
        // Redirigir a la tienda si no hay acción válida
        header('Location: index.php?c=shop');
        exit;
        break;
}
?>
