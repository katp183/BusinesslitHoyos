<?php
// addmerma-view.php

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos utilizando tu sistema de conexión
    $con = Database::getCon();

    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];
    $fecha = $_POST['fecha'];
    $motivo = $_POST['motivo'];
    $almacen_id = $_POST['almacen_id'];

    // Insertar en la base de datos
    $sql = "INSERT INTO mermas (cantidad, categoria, fecha, motivo, almacen_id) 
            VALUES ('$cantidad', '$categoria', '$fecha', '$motivo', '$almacen_id')";

    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>¡Merma registrada exitosamente!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al registrar la merma: " . mysqli_error($con) . "</div>";
    }

    mysqli_close($con);
}
?>

<!-- Formulario para agregar nueva merma -->
<div class="container">
  <h2>Registrar Nueva Merma</h2>
  <form method="POST" action="">
    <div class="form-group">
      <label for="cantidad">Cantidad:</label>
      <input type="number" step="0.01" class="form-control" id="cantidad" name="cantidad" required>
    </div>

    <div class="form-group">
      <label for="categoria">Categoría:</label>
      <select class="form-control" id="categoria" name="categoria" required>
        <option value="Perecedero">Perecedero</option>
        <option value="Error Humano">Error Humano</option>
        <option value="Caducidad">Caducidad</option>
        <option value="Daño">Daño</option>
        <option value="Otro">Otro</option>
      </select>
    </div>

    <div class="form-group">
      <label for="fecha">Fecha:</label>
      <input type="date" class="form-control" id="fecha" name="fecha" required>
    </div>

    <div class="form-group">
      <label for="motivo">Motivo:</label>
      <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
    </div>

    <!-- Almacén: Puede ser automático o seleccionable -->
    <input type="hidden" name="almacen_id" value="<?php echo StockData::getPrincipal()->id; ?>">

    <button type="submit" class="btn btn-primary">Guardar Merma</button>
  </form>
</div>
