<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); ?>

<h2>🖼️ Generador de Imágenes con IA </h2>

<form method="GET" class="mb-3">
  <div class="mb-3">
    <label for="palabra" class="form-label">Escribe una palabra clave en español:</label>
    <input type="text" name="palabra" id="palabra" class="form-control" placeholder="Ejemplo: naturaleza, ciudad, animales" required>
  </div>
  <button type="submit" class="btn btn-primary">Buscar Imagen</button>
</form>

<?php
function obtener_api_unsplash($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if(curl_errno($curl)) {
        curl_close($curl);
        return false;
    }
    curl_close($curl);
    return $response;
}

if (isset($_GET['palabra'])) {
    $palabra = trim($_GET['palabra']);
    if ($palabra === '') {
        echo "<div class='alert alert-warning'>Por favor ingresa una palabra válida.</div>";
    } else {
       
        $traducciones = [
            "agua" => "water",
            "perro" => "dog",
            "gato" => "cat",
            "naturaleza" => "nature",
            "ciudad" => "city",
            "animales" => "animals",
            "playa" => "beach",
            "bosque" => "forest",
            "cielo" => "sky",
            "montaña" => "mountain",
            "nieve" => "snow",
            "flor" => "flower",
            "mar" => "sea",
            "lago" => "lake"
        ];

        $palabra_ingles = $traducciones[strtolower($palabra)] ?? $palabra;

        $access_key = 'NMtA_L1MYHzue_kAAw40M0QN6Wao_IzhL9d8wqkR5kM'; 

        $query = urlencode($palabra_ingles);
        $url = "https://api.unsplash.com/search/photos?query=$query&per_page=1&client_id=$access_key";

        $respuesta = obtener_api_unsplash($url);
        if ($respuesta !== FALSE) {
            $data = json_decode($respuesta, true);

            if (!empty($data['results'])) {
                $imagen = $data['results'][0];
                $imagen_url = $imagen['urls']['regular'];
                $descripcion = $imagen['alt_description'] ?? 'Imagen sin descripción';

             
                $fotografo_nombre = $imagen['user']['name'] ?? 'Desconocido';
                $fotografo_url = $imagen['user']['links']['html'] ?? '#';

                echo "<h3>Resultado para: <strong>" . htmlspecialchars($palabra) . "</strong> (buscando: <em>" . htmlspecialchars($palabra_ingles) . "</em>)</h3>";

                echo "<img src='$imagen_url' alt='" . htmlspecialchars($descripcion) . "' style='max-width:100%; height:auto; border-radius:8px; box-shadow: 0 0 8px rgba(0,0,0,0.2);'>";

                echo "<p style='margin-top:10px; font-size: 0.9em;'>Foto por <a href='$fotografo_url' target='_blank' rel='noopener noreferrer'>$fotografo_nombre</a> en <a href='https://unsplash.com' target='_blank' rel='noopener noreferrer'>Unsplash</a></p>";
            } else {
                echo "<div class='alert alert-info'>No se encontraron imágenes para esa palabra clave.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error al conectar con la API de Unsplash.</div>";
        }
    }
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); ?>
