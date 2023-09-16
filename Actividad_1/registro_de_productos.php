<?php
session_start();

class Producto {
    public $nombre;
    public $monto;

    public function __construct($nombre, $monto) {
        $this->nombre = $nombre;
        $this->monto = $monto;
    }
}

class Inventario {
    private $contadorProductos;
    private $montoTotal;
    private $productosRegistrados;

    public function __construct() {
        if (!isset($_SESSION['contadorProductos'])) {
            $_SESSION['contadorProductos'] = 0;
        }
        if (!isset($_SESSION['montoTotal'])) {
            $_SESSION['montoTotal'] = 0;
        }
        if (!isset($_SESSION['productosRegistrados'])) {
            $_SESSION['productosRegistrados'] = [];
        }

        $this->contadorProductos = &$_SESSION['contadorProductos'];
        $this->montoTotal = &$_SESSION['montoTotal'];
        $this->productosRegistrados = &$_SESSION['productosRegistrados'];
    }

    public function agregarProducto($nombre, $monto) {
        if ($monto <= 3500 && $this->montoTotal + $monto <= 50000) {
            $this->contadorProductos++;
            $this->montoTotal += $monto;

            $producto = new Producto($nombre, $monto);
            $this->productosRegistrados[] = $producto;
        } else {
            echo "El monto supera el límite permitido o el monto total excede 50,000 Bs.<br>";
        }
    }

    public function eliminarTodo() {
        $this->contadorProductos = 0;
        $this->montoTotal = 0;
        $this->productosRegistrados = [];
    }

    public function getContadorProductos() {
        return $this->contadorProductos;
    }

    public function getMontoTotal() {
        return $this->montoTotal;
    }

    public function getProductosRegistrados() {
        return $this->productosRegistrados;
    }
}

$inventario = new Inventario();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["registrar"])) {
        $producto = $_POST["producto"];
        $monto = floatval($_POST["monto"]);
        $inventario->agregarProducto($producto, $monto);
    } elseif (isset($_POST["eliminarTodo"])) {
        $inventario->eliminarTodo();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Productos</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class='container'>
        <h1>Registro de Productos</h1>
        <form method="POST" action="">
            <label for="producto">Producto:</label>
            <input type="text" name="producto"><br>
        
            <label for="monto">Monto:</label>
            <input type="number" name="monto"><br>
        
            <input type="submit" name="registrar" value="Registrar">
        
            <input type="submit" name="eliminarTodo" value="Eliminar Todo">
        </form>
    </div>
    <br>
    <div class="resultados">
        <?php
        echo "Cantidad de productos registrados: {$inventario->getContadorProductos()}<br>";
        echo "El monto total actual es de: {$inventario->getMontoTotal()} Bs<br>";

        if ($inventario->getContadorProductos() > 0) {
            echo "<h2>Productos Registrados:</h2>";
            echo "<ul>";
            foreach ($inventario->getProductosRegistrados() as $productoRegistrado) {
                echo "<li>{$productoRegistrado->nombre} - {$productoRegistrado->monto} Bs</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>
</body>
</html>
