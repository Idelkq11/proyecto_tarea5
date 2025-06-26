<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); ?>

<h2 class="mb-4">📰 Últimas Noticias desde WordPress</h2>

<form method="GET" class="mb-3">
  <div class="mb-3">
    <label for="fuente" class="form-label">Selecciona una fuente de noticias:</label>
    <select name="fuente" id="fuente" class="form-select" required>
      <option value="">-- Elige una fuente --</option>
      <option value="wordpress">WordPress.org</option>
      <option value="wptavern">WPTavern</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Cargar Noticias</button>
</form>

<?php
if (isset($_GET['fuente'])) {
    $fuente = $_GET['fuente'];
    $api_url = "";
    $logo = "";

    switch ($fuente) {
        case "wordpress":
            $api_url = "https://wordpress.org/news/wp-json/wp/v2/posts?per_page=3";
            $logo = "https://s.w.org/style/images/about/WordPress-logotype-wmark.png";
            break;
        case "wptavern":
            $api_url = "https://wptavern.com/wp-json/wp/v2/posts?per_page=3";
            $logo = "https://wptavern.com/wp-content/themes/wptavern-2021/images/logo.svg";
            break;
        default:
            echo "<div class='alert alert-warning'>⚠️ Fuente no válida.</div>";
            exit;
    }

    $respuesta = @file_get_contents($api_url);

    if ($respuesta !== FALSE) {
        $data = json_decode($respuesta, true);

        echo "<div class='mt-4'>";
        echo "<img src='$logo' alt='Logo' width='100' class='mb-3'>";
        echo "<h4 class='mb-3'>Últimas 3 noticias de " . ucfirst($fuente) . "</h4>";

        foreach ($data as $noticia) {
            $titulo = $noticia['title']['rendered'];
            $contenido = strip_tags($noticia['excerpt']['rendered']);
            $link = $noticia['link'];

            echo "
              <div class='card mb-3 p-3'>
                <h5>$titulo</h5>
                <p>$contenido</p>
                <a href='$link' target='_blank' class='btn btn-outline-primary'>Leer más</a>
              </div>";
        }

        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ No se pudieron obtener noticias. Verifica tu conexión.</div>";
    }
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); ?>
