<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); ?>

<h2 class="mb-4">🌦️ Clima en República Dominicana</h2>

<form method="GET" class="mb-3">
  <div class="mb-3">
    <label for="ciudad" class="form-label">Escribe una ciudad de República Dominicana:</label>
    <input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Ejemplo: Santo Domingo" required>
  </div>
  <button type="submit" class="btn btn-primary">Consultar Clima</button>
</form>

<?php
if (isset($_GET['ciudad'])) {
    $ciudad = htmlspecialchars(trim($_GET['ciudad']));

    if (!empty($ciudad)) {
        $api_key = "cca9e51d866ff96701b403d810ef1492"; 
        $api_url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($ciudad) . ",DO&units=metric&appid=$api_key&lang=es";

        $respuesta = @file_get_contents($api_url);

        if ($respuesta !== FALSE) {
            $data = json_decode($respuesta, true);

            if (isset($data["cod"]) && $data["cod"] == 200) {
                $temp = $data["main"]["temp"];
                $desc = ucfirst($data["weather"][0]["description"]);
                $icono = $data["weather"][0]["icon"];
                $imagen = "https://openweathermap.org/img/wn/$icono@2x.png";

                echo "
                <div class='card p-3'>
                    <h4>Clima actual en <strong>" . ucfirst($ciudad) . "</strong>:</h4>
                    <img src='$imagen' alt='icono del clima'>
                    <p class='mb-1'>Descripción: $desc</p>
                    <p class='mb-1'>Temperatura: <strong>$temp °C</strong></p>
                </div>";
            } else {
                echo "<div class='alert alert-warning'>😕 Ciudad no encontrada. Verifica el nombre.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>❌ Error al conectar con la API.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Por favor, escribe el nombre de una ciudad.</div>";
    }
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); ?>
