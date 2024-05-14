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

// Crear un registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear"])) {
    $nombres = limpiarDatos($_POST["nombres"]);
    $apaterno = limpiarDatos($_POST["apaterno"]);
    $amaterno = limpiarDatos($_POST["amaterno"]);
    $genero = limpiarDatos($_POST["genero"]);
    $fecha_nacimiento = limpiarDatos($_POST["fecha_nacimiento"]);
    $telefono = limpiarDatos($_POST["telefono"]);
    $email = limpiarDatos($_POST["email"]);
    $linkedin = limpiarDatos($_POST["linkedin"]);

    $sql = "INSERT INTO contactos (nombres, apaterno, amaterno, genero, fecha_nacimiento, telefono, email, linkedin)
            VALUES ('$nombres', '$apaterno', '$amaterno', '$genero', '$fecha_nacimiento', '$telefono', '$email', '$linkedin')";

    if ($conn->query($sql) === true) {

        header("Refresh: 2; URL=index.php");
    } else {
        echo "Error al crear el registro: " . $conn->error;
    }
}

// Eliminar un registro
if (isset($_GET["eliminar"])) {
    $id = limpiarDatos($_GET["eliminar"]);

    $sql = "DELETE FROM contactos WHERE id = $id";

    if ($conn->query($sql) === true) {
        header("Refresh: 2; URL=index.php");
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}

// Editar un registro
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
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

// Obtener todos los registros
$sql = "SELECT * FROM contactos";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Geovaanixd</title>
    
</head>
<body>
    <div class="container my-4">

        <!-- Formulario para crear un nuevo registro -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h2 class="mb-o">Crear contacto</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="nombres" class="col-sm-3 col-form-label font-weight-bold">Nombres:</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>
                    <div class="form-group">
                        <label for="apaterno" class="col-sm-3 col-form-label font-weight-bold">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="apaterno" name="apaterno" required>
                    </div>
                    <div class="form-group">
                        <label for="amaterno" class="col-sm-3 col-form-label font-weight-bold">Apellido Materno:</label>
                        <input type="text" class="form-control" id="amaterno" name="amaterno" required>
                    </div>
                    <div class="form-group">
                        <label for="genero" class="col-sm-3 col-form-label font-weight-bold">Género:</label>
                        <select class="form-control" id="genero" name="genero">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento" class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-sm-3 col-form-label font-weight-bold">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 col-form-label font-weight-bold">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form -group">
                        <label for="linkedin" class="col-sm-3 col-form-label font-weight-bold">LinkedIn:</label>
                        <input type="text" class="form-control" id="linkedin" name="linkedin">
                    </div>
                    <button type="submit" class="btn btn-primary" name="crear">Crear</button>
                </form>
            </div>
        </div>

        <!-- Mostrar la lista de contactos -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h2 class"text-center mb-4" style="color: #007bff;">Lista de contactos</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="border=; 1px solid #ccc; padding: 9px;">ID</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Nombres</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Apellido Paterno</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Apellido Materno</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Género</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Fecha de Nacimiento</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Teléfono</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Email</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">LinkedIn</th>
                            <th style="border=; 1px solid #ccc; padding: 9px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $fila["id"] . "</td>";
                                echo "<td>" . $fila["nombres"] . "</td>";
                                echo "<td>" . $fila["apaterno"] . "</td>";
                                echo "<td>" . $fila["amaterno"] . "</td>";
                                echo "<td>" . $fila["genero"] . "</td>";
                                echo "<td>" . $fila["fecha_nacimiento"] . "</td>";
                                echo "<td>" . $fila["telefono"] . "</td>";
                                echo "<td>" . $fila["email"] . "</td>";
                                echo "<td>" . $fila["linkedin"] . "</td>";
                                echo "<td>
                                    <a href='editar.php?id=" . $fila["id"] . "' class='btn btn-primary btn-sm'>Editar</a>
                                    <a href='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?eliminar=" . $fila["id"] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>No se encontraron registros</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
