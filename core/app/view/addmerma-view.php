<?php 
// addmerma-view.php

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $con = Database::getCon();

    // Escapar valores para evitar SQL Injection
    $codigo_producto = mysqli_real_escape_string($con, $_POST['codigo_producto']);
    $cantidad        = mysqli_real_escape_string($con, $_POST['cantidad']);
    $categoria       = mysqli_real_escape_string($con, $_POST['categoria']);
    $fecha           = mysqli_real_escape_string($con, $_POST['fecha']);
    $motivo          = mysqli_real_escape_string($con, $_POST['motivo']);
    $almacen_id      = mysqli_real_escape_string($con, $_POST['almacen_id']);

    // 1) Comprobar si existe el producto
    $sqlProd = "SELECT id FROM product WHERE code = '$codigo_producto' LIMIT 1";
    $resProd = mysqli_query($con, $sqlProd);

    if (mysqli_num_rows($resProd) > 0) {
        // 2) Recuperar el product_id
        $rowProd     = mysqli_fetch_assoc($resProd);
        $producto_id = $rowProd['id'];

        // 3) Insertar merma incluyendo product_id
        $sql = "INSERT INTO mermas 
                   (cantidad, categoria, fecha, motivo, almacen_id, product_id) 
                VALUES 
                   ('$cantidad', '$categoria', '$fecha', '$motivo', '$almacen_id', '$producto_id')";

        if (mysqli_query($con, $sql)) {
            echo "<div class='alert alert-success'>¡Merma registrada exitosamente!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar la merma: " 
                 . mysqli_error($con) . "</div>";
        }

    } else {
        // 4) Producto no encontrado
        echo "<div class='alert alert-danger'>
                El código de producto <strong>{$codigo_producto}</strong> no existe. 
                Por favor verifica e inténtalo de nuevo.
              </div>";
    }

    mysqli_close($con);
}
?>

<!-- Formulario para agregar nueva merma -->
<div class="container">
  <h2>Registrar Nueva Merma</h2>
  <form method="POST" action="">
    <!-- NUEVO: Código del Producto -->
    <div class="form-group">
      <label for="codigo_producto">Código del Producto:</label>
      <input type="text" class="form-control" id="codigo_producto" 
             name="codigo_producto" required>
    </div>

    <div class="form-group">
      <label for="cantidad">Cantidad:</label>
      <input type="number" step="0.01" class="form-control" 
             id="cantidad" name="cantidad" required>
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
      <textarea class="form-control" id="motivo" name="motivo" 
                rows="3" required></textarea>
    </div>

    <!-- Almacén (oculto) -->
    <input type="hidden" name="almacen_id" 
           value="<?php echo StockData::getPrincipal()->id; ?>">

    <button type="submit" class="btn btn-primary">Guardar Merma</button>
  </form>
</div>
