<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); 
?>

<h2 class="mb-4">🎓 Universidades por País</h2>

<form method="GET" class="mb-4">
  <div class="mb-3">
    <label for="pais" class="form-label">Escribe el nombre de un país (en inglés):</label>
    <input type="text" name="pais" id="pais" class="form-control" placeholder="Ejemplo: Dominican Republic" required>
  </div>
  <button type="submit" class="btn btn-primary">Buscar Universidades</button>
</form>

<?php
if (isset($_GET['pais'])) {
    $pais = htmlspecialchars(trim($_GET['pais']));

    if (!empty($pais)) {
        $api_url = "http://universities.hipolabs.com/search?country=" . urlencode($pais);
        $respuesta = @file_get_contents($api_url);

        if ($respuesta !== FALSE) {
            $universidades = json_decode($respuesta, true);

            if (!empty($universidades)) {
                echo "<h4 class='mb-3'>Universidades en <strong>" . ucfirst($pais) . "</strong>:</h4>";
                echo "<ul class='list-group'>";
                foreach ($universidades as $uni) {
                    $nombre = $uni['name'];
                    $web = $uni['web_pages'][0] ?? '#';
                    $dominio = $uni['domains'][0] ?? '';
                    
                    echo "<li class='list-group-item'>
                            <strong>$nombre</strong><br>
                            🌐 <a href='$web' target='_blank'>$web</a><br>
                            🏷️ Dominio: $dominio
                          </li>";
                }
                echo "</ul>";
            } else {
                echo "<div class='alert alert-warning mt-3'>⚠️ No se encontraron universidades para ese país.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>❌ No se pudo conectar con la API. Intenta más tarde.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>⚠️ Por favor, escribe un país válido en inglés.</div>";
    }
}
?>

<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); 
?>
