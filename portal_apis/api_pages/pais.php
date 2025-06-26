<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); ?>

<h2 class="mb-4">🌍 Información de un País</h2>

<form method="GET" class="mb-3">
  <div class="mb-3">
    <label for="pais" class="form-label">Escribe el nombre de un país :</label>
    <input type="text" name="pais" id="pais" class="form-control" placeholder="Ejemplo: Dominican Republic" required>
  </div>
  <button type="submit" class="btn btn-primary">Buscar Información</button>
</form>

<?php
if (isset($_GET['pais'])) {
    $pais = trim($_GET['pais']);

    if (!empty($pais)) {
        $api_url = "https://restcountries.com/v3.1/name/" . urlencode($pais);
        $respuesta = @file_get_contents($api_url);

        if ($respuesta !== FALSE) {
            $data = json_decode($respuesta, true);

            if (!empty($data) && isset($data[0])) {
                $paisInfo = $data[0];

                $nombre_oficial = $paisInfo['name']['official'] ?? 'N/A';
                $capital = $paisInfo['capital'][0] ?? 'N/A';
                $poblacion = isset($paisInfo['population']) ? number_format($paisInfo['population']) : 'N/A';
                $bandera = $paisInfo['flags']['png'] ?? '';
                $monedas = $paisInfo['currencies'] ?? [];

               
                $moneda_info = 'N/A';
                foreach ($monedas as $codigo => $info) {
                    $nombre_moneda = $info['name'] ?? '';
                    $simbolo = $info['symbol'] ?? '';
                    $moneda_info = trim("$nombre_moneda ($simbolo)");
                    break; 
                }

                echo "
                <div class='card p-3'>
                    <h4>$nombre_oficial</h4>
                    " . ($bandera ? "<img src='$bandera' alt='Bandera de $nombre_oficial' width='100'>" : "") . "
                    <p>Capital: <strong>$capital</strong></p>
                    <p>Población: <strong>$poblacion</strong></p>
                    <p>Moneda: <strong>$moneda_info</strong></p>
                </div>";
            } else {
                echo "<div class='alert alert-warning'>😕 País no encontrado. Intenta con otro nombre.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>❌ Error al conectar con la API.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Por favor, escribe un nombre de país válido.</div>";
    }
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); ?>
