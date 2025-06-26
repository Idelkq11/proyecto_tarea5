<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); ?>

<h2 class="mb-4">💱 Conversión de Monedas</h2>

<form method="GET" class="mb-3">
  <div class="mb-3">
    <label for="cantidad" class="form-label">Cantidad en USD ($):</label>
    <input type="number" step="0.01" name="cantidad" id="cantidad" class="form-control" placeholder="Ejemplo: 100" required>
  </div>
  <button type="submit" class="btn btn-primary">Convertir</button>
</form>

<?php
if (isset($_GET['cantidad'])) {
    $usd = floatval($_GET['cantidad']);

    if ($usd > 0) {
        $api_url = "https://api.exchangerate-api.com/v4/latest/USD";
        $respuesta = @file_get_contents($api_url);

        if ($respuesta !== FALSE) {
            $data = json_decode($respuesta, true);

            $monedas = [
                "DOP" => "🇩🇴 Peso Dominicano",
                "EUR" => "🇪🇺 Euro",
                "MXN" => "🇲🇽 Peso Mexicano",
                "COP" => "🇨🇴 Peso Colombiano"
            ];

            echo "<h4 class='mt-4'>Resultados para <strong>\$$usd USD</strong>:</h4>";
            echo "<table class='table table-bordered mt-3'>
                    <thead class='table-light'>
                      <tr>
                        <th>Moneda</th>
                        <th>Nombre</th>
                        <th>Equivalente</th>
                      </tr>
                    </thead>
                    <tbody>";

            foreach ($monedas as $codigo => $nombre) {
                if (isset($data['rates'][$codigo])) {
                    $valor = round($usd * $data['rates'][$codigo], 2);
                    echo "<tr>
                            <td><strong>$codigo</strong></td>
                            <td>$nombre</td>
                            <td><strong>$valor</strong></td>
                          </tr>";
                }
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-danger'>❌ No se pudo conectar con la API de monedas.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Por favor, ingresa una cantidad mayor que 0.</div>";
    }
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); ?>
