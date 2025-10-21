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
            
            // Verificar que el usuario está logueado
            if (!isset($_SESSION['user']) || !$_SESSION['user']) {
                header('Location: index.php?c=register');
                exit;
            }
            
            // Verificar que el producto existe y tiene stock
            $product = ProductoRepository::getProductById($idProducto);
            if (!$product) {
                header('Location: index.php?c=shop&error=product_not_found');
                exit;
            }

            $userId = $_SESSION['user']->getidUsuario();
            if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            if(!isset($_SESSION['cart'][$userId])) $_SESSION['cart'][$userId] = [];

            // Calcular la cantidad que se añadiría al carrito
            $newQuantity = isset($_SESSION['cart'][$userId][$idProducto]) ? $_SESSION['cart'][$userId][$idProducto] + 1 : 1;
            
            // Verificar si hay suficiente stock
            if (!ProductoRepository::hasEnoughStock($idProducto, $newQuantity)) {
                $currentStock = ProductoRepository::getCurrentStock($idProducto);
                header('Location: index.php?c=shop&error=insufficient_stock&product=' . urlencode($product->getName()) . '&stock=' . $currentStock);
                exit;
            }

            // Añadir al carrito del usuario específico
            if(isset($_SESSION['cart'][$userId][$idProducto])){
                $_SESSION['cart'][$userId][$idProducto]++;
            } else {
                $_SESSION['cart'][$userId][$idProducto] = 1;
            }

            // Redirigir a la vista del carrito
            header('Location: index.php?c=cart&action=view');
            exit;
        }
        break;

    case 'view':
        // Verificar que el usuario está logueado
        if (!isset($_SESSION['user']) || !$_SESSION['user']) {
            header('Location: index.php?c=register');
            exit;
        }

        $userId = $_SESSION['user']->getidUsuario();
        $cartItems = [];
        $cartTotal = 0;

        if(isset($_SESSION['cart'][$userId]) && !empty($_SESSION['cart'][$userId])){
            foreach($_SESSION['cart'][$userId] as $productId => $quantity){
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
        if (!isset($_SESSION['user']) || !$_SESSION['user']) {
            header('Location: index.php?c=register');
            exit;
        }

        $userId = $_SESSION['user']->getidUsuario();
        if (!isset($_SESSION['cart'][$userId]) || empty($_SESSION['cart'][$userId])) {
            header('Location: index.php?c=shop');
            exit;
        }

        // 2. Verificar stock disponible antes de proceder
        $stockAvailable = true;
        $stockErrors = [];
        foreach ($_SESSION['cart'][$userId] as $productId => $quantity) {
            if (!ProductoRepository::hasEnoughStock($productId, $quantity)) {
                $stockAvailable = false;
                $product = ProductoRepository::getProductById($productId);
                $currentStock = ProductoRepository::getCurrentStock($productId);
                $stockErrors[] = "Producto '{$product->getName()}' - Disponible: $currentStock, Solicitado: $quantity";
            }
        }

        if (!$stockAvailable) {
            // Redirigir con error de stock insuficiente
            $errorMessage = "Stock insuficiente: " . implode(", ", $stockErrors);
            header('Location: index.php?c=cart&error=insufficient_stock&details=' . urlencode($errorMessage));
            exit;
        }

        // 3. Calcular el total del carrito.
        $cartTotal = 0;
        foreach ($_SESSION['cart'][$userId] as $productId => $quantity) {
            $product = ProductoRepository::getProductById($productId);
            if ($product) {
                $cartTotal += $product->getPrice() * $quantity;
            }
        }

        // 4. Crear el pedido en la tabla `pedido`.
        $idUsuario = $_SESSION['user']->getidUsuario();
        $idPedido = PedidoRepository::createPedido($idUsuario, $cartTotal);

        if ($idPedido) {
            // 5. Si el pedido se crea correctamente, guardar cada producto en `detalle_pedido` y reducir stock.
            $detalleSuccess = true;
            $stockReductionSuccess = true;
            
            foreach ($_SESSION['cart'][$userId] as $productId => $quantity) {
                $product = ProductoRepository::getProductById($productId);
                if ($product) {
                    // Crear detalle del pedido
                    $detalleResult = DPRepository::createDetalle($idPedido, $productId, $quantity, $product->getPrice());
                    if (!$detalleResult) {
                        $detalleSuccess = false;
                        error_log("Error al crear detalle para producto $productId en pedido $idPedido");
                    } else {
                        // Reducir stock del producto
                        $stockResult = ProductoRepository::reduceStock($productId, $quantity);
                        if (!$stockResult) {
                            $stockReductionSuccess = false;
                            error_log("Error al reducir stock para producto $productId en pedido $idPedido");
                        }
                    }
                }
            }

            if ($detalleSuccess && $stockReductionSuccess) {
                // 6. Limpiar el carrito del usuario específico.
                unset($_SESSION['cart'][$userId]);

                // 7. Redirigir a una página de confirmación.
                header('Location: index.php?c=order&action=confirm&id=' . $idPedido);
                exit;
            } else {
                // Si falló algún detalle o reducción de stock, eliminar el pedido creado
                error_log("Error al procesar pedido $idPedido, eliminando pedido");
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

    case 'clear':
        // Limpiar el carrito del usuario actual
        if (isset($_SESSION['user']) && $_SESSION['user']) {
            $userId = $_SESSION['user']->getidUsuario();
            if (isset($_SESSION['cart'][$userId])) {
                unset($_SESSION['cart'][$userId]);
            }
        }
        header('Location: index.php?c=cart&action=view');
        exit;
        break;

    // Aquí podrías añadir más casos, como 'confirm' para mostrar una página de éxito.
}