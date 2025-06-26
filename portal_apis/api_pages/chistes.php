<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/header.php"); ?>

<h2 class="mb-4">🤣 Chiste Aleatorio en Español</h2>

<?php
$chistes = [
    ["pregunta" => "¿Por qué los pájaros no usan Facebook?", "respuesta" => "¡Porque ya tienen Twitter!"],
    ["pregunta" => "¿Qué le dijo una iguana a su hermana gemela?", "respuesta" => "Somos iguana-les."],
    ["pregunta" => "¿Qué hace una abeja en el gimnasio?", "respuesta" => "¡Zum-ba!"],
    ["pregunta" => "¿Por qué los esqueletos no pelean entre ellos?", "respuesta" => "Porque no tienen agallas."],
    ["pregunta" => "¿Cuál es el animal más antiguo?", "respuesta" => "La cebra, porque está en blanco y negro."],
];

$indice = array_rand($chistes);
$chiste = $chistes[$indice];

echo "
<div class='card p-4 bg-light shadow'>
    <p><strong>🗣️ {$chiste['pregunta']}</strong></p>
    <p class='mt-3'>🤣 {$chiste['respuesta']}</p>
    <a href='chistes.php' class='btn btn-outline-primary mt-2'>Mostrar otro chiste</a>
</div>";
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/proyecto_tarea5/includes/footer.php"); ?>
