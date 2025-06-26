<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); 
?>

<h2 class="mb-4">🎂 Predicción de Edad</h2>

<form method="GET" class="mb-4">
  <div class="mb-3">
    <label for="nombre" class="form-label">Escribe un nombre:</label>
    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: Meelad" required>
  </div>
  <button type="submit" class="btn btn-success">Predecir Edad</button>
</form>

<?php
if (isset($_GET['nombre'])) {
    $nombre = htmlspecialchars(trim($_GET['nombre']));

    if (!empty($nombre)) {
        $api_edad = "https://api.agify.io/?name=" . urlencode($nombre);
        $api_genero = "https://api.genderize.io/?name=" . urlencode($nombre);

        $respuesta_edad = @file_get_contents($api_edad);
        $respuesta_genero = @file_get_contents($api_genero);

        if ($respuesta_edad !== FALSE && $respuesta_genero !== FALSE) {
            $data_edad = json_decode($respuesta_edad, true);
            $data_genero = json_decode($respuesta_genero, true);

            $edad = $data_edad['age'];
            $genero = $data_genero['gender']; 

            $mensaje = "";
            $imagen = "";

            if ($edad <= 12) {
                if ($genero == "female") {
                    $mensaje = "👧 Se estima que <strong>" . ucfirst($nombre) . "</strong> es una niña.";
                    $imagen = "https://i.pinimg.com/736x/7d/25/d2/7d25d2e85515399bed3e864082240eb1.jpg";
                } else {
                    $mensaje = "👦 Se estima que <strong>" . ucfirst($nombre) . "</strong> es un niño.";
                    $imagen = "https://i.pinimg.com/originals/3c/6f/02/3c6f02ed1baced9e9ef012f6909bd3b5.jpg";
                }
            } elseif ($edad <= 59) {
                if ($genero == "female") {
                    $mensaje = "🧑‍🦰 Se estima que <strong>" . ucfirst($nombre) . "</strong> es una mujer adulta.";
                    $imagen = "https://static.vecteezy.com/system/resources/previews/023/809/577/original/a-woman-with-a-satisfied-expression-gesticulates-with-her-hands-the-concept-of-human-emotions-flat-style-illustration-vector.jpg";
                } else {
                    $mensaje = "🧔 Se estima que <strong>" . ucfirst($nombre) . "</strong> es un hombre adulto.";
                    $imagen = "https://img.freepik.com/fotos-premium/feliz-hombre-negocios-3d-sobre-fondo-blanco-transparente_457222-3073.jpg";
                }
            } else {
                if ($genero == "female") {
                    $mensaje = "👵 Se estima que <strong>" . ucfirst($nombre) . "</strong> es una anciana.";
                    $imagen = "https://st3.depositphotos.com/6633222/17978/v/950/depositphotos_179787464-stock-illustration-vector-illustration-cartoon-elderly-woman.jpg";
                } else {
                    $mensaje = "👴 Se estima que <strong>" . ucfirst($nombre) . "</strong> es un anciano.";
                    $imagen = "https://img.freepik.com/free-vector/old-man-with-walking-stick_43633-2326.jpg?w=360";
                }
            }

            echo "
            <div class='card mb-3'>
              <div class='row g-0'>
                <div class='col-md-4 text-center'>
                  <img src='$imagen' alt='Edad estimada' class='img-fluid p-3' style='max-height: 180px;' />
                </div>
                <div class='col-md-8'>
                  <div class='card-body'>
                    <h5 class='card-title'>Edad Estimada: $edad años</h5>
                    <p class='card-text'>$mensaje</p>
                    <p class='card-text'><small class='text-muted'>Basado en datos estadísticos del nombre ingresado.</small></p>
                  </div>
                </div>
              </div>
            </div>";
        } else {
            echo "<div class='alert alert-danger'>❌ No se pudo conectar con una de las APIs. Intenta más tarde.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>⚠️ Por favor, escribe un nombre válido.</div>";
    }
}
?>

<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); 
?>
