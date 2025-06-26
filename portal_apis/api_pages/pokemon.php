<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); ?>

<h2 class="mb-4">🎮 Información de un Pokémon</h2>

<form method="GET" class="mb-3">
  <div class="mb-3">
    <label for="nombre" class="form-label">Escribe el nombre de un Pokémon:</label>
    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: pikachu" required>
  </div>
  <button type="submit" class="btn btn-primary">Buscar Pokémon</button>
</form>

<?php
if (isset($_GET['nombre'])) {
    $nombre = strtolower(trim($_GET['nombre']));

    if (!empty($nombre)) {
        $api_url = "https://pokeapi.co/api/v2/pokemon/" . urlencode($nombre);
        $respuesta = @file_get_contents($api_url);

        if ($respuesta !== FALSE) {
            $data = json_decode($respuesta, true);

            $nombre = ucfirst($data['name']);
            $imagen = $data['sprites']['front_default'];
            $experiencia = $data['base_experience'];
            $id = $data['id'];

            $habilidades = [];
            foreach ($data['abilities'] as $habilidad) {
                $habilidades[] = $habilidad['ability']['name'];
            }

            // Sonido dinámico según el ID del Pokémon
            $audio = "https://raw.githubusercontent.com/PokeAPI/cries/main/cries/pokemon/latest/$id.ogg";

            echo "<div class='card p-3'>";
            echo "<h4>Pokémon: <strong>$nombre</strong></h4>";
            echo "<img src='$imagen' alt='$nombre' width='150'>";
            echo "<p>Experiencia base: <strong>$experiencia</strong></p>";
            echo "<p>Habilidades:</p><ul>";

            foreach ($habilidades as $hab) {
                echo "<li>" . ucfirst($hab) . "</li>";
            }

            echo "</ul>";

            // Reproducir sonido si existe
            echo "<p>🔊 Escucha su sonido:</p>
                  <audio controls>
                    <source src='$audio' type='audio/ogg'>
                    Tu navegador no soporta el audio.
                  </audio>";

            echo "</div>";
        } else {
            echo "<div class='alert alert-danger'>❌ Pokémon no encontrado. Verifica el nombre.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Por favor, escribe un nombre de Pokémon.</div>";
    }
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); ?>
