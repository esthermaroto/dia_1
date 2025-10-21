<?php
require_once 'models/PedidoRepository.php';
require_once 'models/DetallePedidoRepository.php';
require_once 'models/ProductoRepository.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'checkout':
        // 1. Comprobar que el usuario está logueado y el carrito no está vacío.
        if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
            header('Location: index.php?c=shop');
            exit;
        }

        // 2. Calcular el total del carrito.
        $cartTotal = 0;
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = ProductoRepository::getProductById($productId);
            if ($product) {
                $cartTotal += $product->getPrice() * $quantity;
            }
        }

        // 3. Crear el pedido en la tabla `pedido`.
        $idUsuario = $_SESSION['user']->getid();
        $idPedido = PedidoRepository::createPedido($idUsuario, $cartTotal);

        if ($idPedido) {
            // 4. Si el pedido se crea correctamente, guardar cada producto en `detalle_pedido`.
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $product = ProductoRepository::getProductById($productId);
                if ($product) {
                    DetallePedidoRepository::createDetalle($idPedido, $productId, $quantity, $product->getPrice());
                }
            }

            // 5. Limpiar el carrito de la sesión.
            unset($_SESSION['cart']);

            // 6. Redirigir a una página de confirmación.
            header('Location: index.php?c=order&action=confirm&id=' . $idPedido);
            exit;
        } else {
            // Manejar error si no se pudo crear el pedido.
            header('Location: index.php?c=cart&error=checkout_failed');
            exit;
        }
        break;

    // Aquí podrías añadir más casos, como 'confirm' para mostrar una página de éxito.
}