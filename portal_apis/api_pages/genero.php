<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); 
?>

<h2 class="mb-4">🔍 Predicción de Género</h2>

<form method="GET" class="mb-4">
  <div class="mb-3">
    <label for="nombre" class="form-label">Escribe un nombre:</label>
    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: Irma" required>
  </div>
  <button type="submit" class="btn btn-primary">Predecir Género</button>
</form>

<?php
if (isset($_GET['nombre'])) {
    $nombre = htmlspecialchars(trim($_GET['nombre']));

    if (!empty($nombre)) {
        $api_url = "https://api.genderize.io/?name=" . urlencode($nombre);
        $respuesta = @file_get_contents($api_url);

        if ($respuesta !== FALSE) {
            $data = json_decode($respuesta, true);
            $genero = $data['gender'];
            $probabilidad = $data['probability'] * 100;

            if ($genero == "male") {
                echo "
                <div class='alert alert-primary'>
                    💙 El nombre <strong>" . ucfirst($nombre) . "</strong> es probablemente <strong>Masculino</strong> 
                    (Confianza: " . round($probabilidad, 2) . "%)
                </div>";
            } elseif ($genero == "female") {
                echo "
                <div class='alert' style='background-color: #ffc0cb; color: black;'>
                    💖 El nombre <strong>" . ucfirst($nombre) . "</strong> es probablemente <strong>Femenino</strong> 
                    (Confianza: " . round($probabilidad, 2) . "%)
                </div>";
            } else {
                echo "<div class='alert alert-warning'>🤔 No se pudo determinar el género del nombre <strong>" . ucfirst($nombre) . "</strong>.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>❌ No se pudo conectar con la API. Verifica tu conexión o intenta más tarde.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>⚠️ Por favor, escribe un nombre válido.</div>";
    }
}
?>

<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); 
?>



