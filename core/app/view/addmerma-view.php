<?php
// addmerma-view.php

// 1) Arrancar sesión sólo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errorMsg = '';
$status   = '';
$message  = '';

// 2) Si vienen datos por POST, procesamos y redirigimos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $con = Database::getCon();

    // Escapar valores
    $codigo_producto = mysqli_real_escape_string($con, $_POST['codigo_producto']);
    $cantidad        = mysqli_real_escape_string($con, $_POST['cantidad']);
    $categoria       = mysqli_real_escape_string($con, $_POST['categoria']);
    $fecha           = mysqli_real_escape_string($con, $_POST['fecha']);
    $motivo          = mysqli_real_escape_string($con, $_POST['motivo']);
    $almacen_id      = mysqli_real_escape_string($con, $_POST['almacen_id']);

    // Comprobar existencia de producto
    $sqlProd = "SELECT id FROM product WHERE code = '$codigo_producto' LIMIT 1";
    $resProd = mysqli_query($con, $sqlProd);

    if ($resProd && mysqli_num_rows($resProd) > 0) {
        $rowProd     = mysqli_fetch_assoc($resProd);
        $producto_id = $rowProd['id'];

        // Insertar merma
        $sql = "INSERT INTO mermas 
                   (cantidad, categoria, fecha, motivo, almacen_id, product_id) 
                VALUES 
                   ('$cantidad', '$categoria', '$fecha', '$motivo', '$almacen_id', '$producto_id')";

        if (mysqli_query($con, $sql)) {
            $_SESSION['status']  = 'success';
            $_SESSION['message'] = '¡Merma registrada exitosamente!';
        } else {
            $_SESSION['status']  = 'error';
            $_SESSION['message'] = 'Error al registrar la merma: ' . mysqli_error($con);
        }
    } else {
        $_SESSION['status']  = 'error';
        $_SESSION['message'] = "El código <strong>{$codigo_producto}</strong> no existe. Verifícalo e inténtalo de nuevo.";
    }

    mysqli_close($con);

    // Redirijo siempre a GET para PRG
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

// 3) Si venimos de POST (ahora GET), leo y borro el mensaje de sesión
if (isset($_SESSION['status'])) {
    $status  = $_SESSION['status'];
    $message = $_SESSION['message'];
    unset($_SESSION['status'], $_SESSION['message']);
}
?>

<div class="container">
  <h2>Registrar Nueva Merma</h2>

  <!-- 4) Alertas -->
  <?php if ($status === 'success'): ?>
    <div class="alert alert-success"><?= $message ?></div>
  <?php elseif ($status === 'error'): ?>
    <div class="alert alert-danger"><?= $message ?></div>
  <?php endif; ?>

  <!-- 5) Formulario COMPLETO -->
  <form method="POST" action="">
    <!-- Código del Producto -->
    <div class="form-group">
      <label for="codigo_producto">Código del Producto:</label>
      <input type="text"
             class="form-control"
             id="codigo_producto"
             name="codigo_producto"
             required>
    </div>

    <!-- Cantidad -->
    <div class="form-group">
      <label for="cantidad">Cantidad:</label>
      <input type="number"
             step="0.01"
             class="form-control"
             id="cantidad"
             name="cantidad"
             required>
    </div>

    <!-- Categoría -->
    <div class="form-group">
      <label for="categoria">Categoría:</label>
      <select class="form-control"
              id="categoria"
              name="categoria"
              required>
        <option value="Perecedero">Perecedero</option>
        <option value="Error Humano">Error Humano</option>
        <option value="Caducidad">Caducidad</option>
        <option value="Daño">Daño</option>
        <option value="Otro">Otro</option>
      </select>
    </div>

    <!-- Fecha -->
    <div class="form-group">
      <label for="fecha">Fecha:</label>
      <input type="date"
             class="form-control"
             id="fecha"
             name="fecha"
             required>
    </div>

    <!-- Motivo -->
    <div class="form-group">
      <label for="motivo">Motivo:</label>
      <textarea class="form-control"
                id="motivo"
                name="motivo"
                rows="3"
                required></textarea>
    </div>

    <!-- Almacén (oculto) -->
    <input type="hidden"
           name="almacen_id"
           value="<?php echo StockData::getPrincipal()->id; ?>">

    <button type="submit"
            class="btn btn-primary">
      Guardar Merma
    </button>
  </form>
</div>