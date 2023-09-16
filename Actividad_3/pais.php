<!DOCTYPE html>
<html>
<head>
    <title>Saludo por País</title>
    <link rel="stylesheet" type="text/css" href="style_pais.css">
</head>

<?php
class Pais {
    public $nombre;

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function obtenerSaludo() {
        $pais = strtolower($this->nombre);

        switch ($pais) {
            case 'españa':
                date_default_timezone_set('Europe/Madrid');
                break;
            case 'méxico':
                date_default_timezone_set('America/Mexico_City');
                break;
            case 'argentina':
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                break;
            case 'estados unidos':
                date_default_timezone_set('America/New_York');
                break;
            case 'reino unido':
                date_default_timezone_set('Europe/London');
                break;
            case 'australia':
                date_default_timezone_set('Australia/Sydney');
                break;
            case 'japón':
                date_default_timezone_set('Asia/Tokyo');
                break;
            case 'canadá':
                date_default_timezone_set('America/Toronto');
                break;
            case 'venezuela':
                date_default_timezone_set('America/Caracas');
                break;
            case 'francia':
                date_default_timezone_set('Europe/Paris');
                break;
            case 'brasil':
                date_default_timezone_set('America/Sao_Paulo');
                break;
            case 'china':
                date_default_timezone_set('Asia/Shanghai');
                break;
            case 'sudáfrica':
                date_default_timezone_set('Africa/Johannesburg');
                break;
            default:
                return "El país no está disponible o no se pudo obtener la zona horaria.";
        }
    
        $horaActual = new DateTime("now");
        $hora = $horaActual->format("H");
    
        if ($hora >= 5 && $hora < 12) {
            $saludo = "¡Buenos días!";
        } elseif ($hora >= 12 && $hora < 18) {
            $saludo = "¡Buenas tardes!";
        } else {
            $saludo = "¡Buenas noches!";
        }
    
        return ucfirst($this->nombre) . "<br>$saludo <br>(Zona Horaria: " . date_default_timezone_get() . ")";
    }
}

if (isset($_POST['pais'])) {
    $nombrePais = $_POST['pais'];
    $paisElegido = new Pais($nombrePais);

    $saludo = $paisElegido->obtenerSaludo();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saludo por País</title>
</head>
<body>
<div class="container">
    <h1 class="titulo">Saludo por País</h1>
    <form method="post">
        <label for="pais">¿Qué país quieres visitar?</label>
        <input type="text" name="pais" id="pais">
        <br>
        <input type="submit" value="Visitar">
    </form>
    <?php if (isset($saludo)): ?>
        <p class="saludo"><?php echo $saludo; ?></p>
    <?php endif; ?>
</div>

</body>
</html>
