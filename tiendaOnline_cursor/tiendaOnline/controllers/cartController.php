<?php
require_once 'models/PedidoRepository.php';
require_once 'models/DPRepository.php';
require_once 'models/ProductoRepository.php'; 
require_once 'models/Producto.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        if(isset($_GET['id'])){
            $idProducto = intval($_GET['id']);

            if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

            if(isset($_SESSION['cart'][$idProducto])){
                $_SESSION['cart'][$idProducto]++;
            } else {
                $_SESSION['cart'][$idProducto] = 1;
            }

            // Redirigir a la vista del carrito
            header('Location: index.php?c=cart&action=view');
            exit;
        }
        break;

    case 'view':
        $cartItems = [];
        $cartTotal = 0;

        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $productId => $quantity){
                $product = ProductoRepository::getProductById($productId);
                if($product){
                    $total = $product->getPrice() * $quantity;
                    $cartItems[] = [
                        'id' => $product->getIdProducto(),
                        'name' => $product->getName(),
                        'quantity' => $quantity,
                        'price' => $product->getPrice(),
                        'total' => $total
                    ];
                    $cartTotal += $total;
                }
            }
        }

        require_once 'views/cartView.phtml';
        exit;
    
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
        $idUsuario = $_SESSION['user']->getidUsuario();
        $idPedido = PedidoRepository::createPedido($idUsuario, $cartTotal);

        if ($idPedido) {
            // 4. Si el pedido se crea correctamente, guardar cada producto en `detalle_pedido`.
            $detalleSuccess = true;
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $product = ProductoRepository::getProductById($productId);
                if ($product) {
                    $detalleResult = DPRepository::createDetalle($idPedido, $productId, $quantity, $product->getPrice());
                    if (!$detalleResult) {
                        $detalleSuccess = false;
                        error_log("Error al crear detalle para producto $productId en pedido $idPedido");
                    }
                }
            }

            if ($detalleSuccess) {
                // 5. Limpiar el carrito de la sesión.
                unset($_SESSION['cart']);

                // 6. Redirigir a una página de confirmación.
                header('Location: index.php?c=order&action=confirm&id=' . $idPedido);
                exit;
            } else {
                // Si falló algún detalle, eliminar el pedido creado
                error_log("Error al crear detalles del pedido $idPedido, eliminando pedido");
                header('Location: index.php?c=cart&error=checkout_failed');
                exit;
            }
        } else {
            // Manejar error si no se pudo crear el pedido.
            error_log("Error al crear pedido para usuario " . $_SESSION['user']->getidUsuario());
            header('Location: index.php?c=cart&error=checkout_failed');
            exit;
        }
        break;

    // Aquí podrías añadir más casos, como 'confirm' para mostrar una página de éxito.
}