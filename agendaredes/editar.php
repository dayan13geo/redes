<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "agenda";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para limpiar los datos enviados por el formulario
function limpiarDatos($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Obtener el ID del contacto a editar

if (isset($_GET["id"])) {
    $id = limpiarDatos($_GET["id"]);

    // Obtener los datos del contacto seleccionado
    $sql = "SELECT * FROM contactos WHERE id = $id";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        echo '<div class="container my-4">';
        echo '<h1 class="text-center mb-4">Editar contacto</h1>';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<input type="hidden" name="id" value="' . $fila["id"] . '">';
        echo '<div class="form-group">';
        echo '<label for="nombres">Nombres:</label>';
        echo '<input type="text" class="form-control" id="nombres" name="nombres" value="' . $fila["nombres"] . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="apaterno">Apellido Paterno:</label>';
        echo '<input type="text" class="form-control" id="apaterno" name="apaterno" value="' . $fila["apaterno"] . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="amaterno">Apellido Materno:</label>';
        echo '<input type="text" class="form-control" id="amaterno" name="amaterno" value="' . $fila["amaterno"] . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="genero">Género:</label>';
        echo '<select class="form-control" id="genero" name="genero">';
        echo '<option value="Masculino"' . ($fila["genero"] == "Masculino" ? " selected" : "") . '>Masculino</option>';
        echo '<option value="Femenino"' . ($fila["genero"] == "Femenino" ? " selected" : "") . '>Femenino</option>';
        echo '</select>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="fecha_nacimiento">Fecha de Nacimiento:</label>';
        echo '<input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="' . $fila["fecha_nacimiento"] . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="telefono">Teléfono:</label>';
        echo '<input type="text" class="form-control" id="telefono" name="telefono" value="' . $fila["telefono"] . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="email">Email:</label>';
        echo '<input type="email" class="form-control" id="email" name="email" value="' . $fila["email"] . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="linkedin">LinkedIn:</label>';
        echo '<input type="text" class="form-control" id="linkedin" name="linkedin" value="' . $fila["linkedin"] . '">';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary" name="editar">Editar</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "No se encontró el contacto";
    }
}


// Actualizar el registro editado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar"])) {
    $id = limpiarDatos($_POST["id"]);
    $nombres = limpiarDatos($_POST["nombres"]);
    $apaterno = limpiarDatos($_POST["apaterno"]);
    $amaterno = limpiarDatos($_POST["amaterno"]);
    $genero = limpiarDatos($_POST["genero"]);
    $fecha_nacimiento = limpiarDatos($_POST["fecha_nacimiento"]);
    $telefono = limpiarDatos($_POST["telefono"]);
    $email = limpiarDatos($_POST["email"]);
    $linkedin = limpiarDatos($_POST["linkedin"]);

    $sql = "UPDATE contactos SET nombres='$nombres', apaterno='$apaterno', amaterno='$amaterno', genero='$genero', fecha_nacimiento='$fecha_nacimiento', telefono='$telefono', email='$email', linkedin='$linkedin'
            WHERE id = $id";

    if ($conn->query($sql) === true) {

        header("Refresh: 2; URL=index.php");
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

$conn->close();
?>