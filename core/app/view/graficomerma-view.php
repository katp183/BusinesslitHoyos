<?php
// view/graficomerma-view.php

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Leer mensajes de PRG si hubiera
$status  = $_SESSION['status']  ?? '';
$message = $_SESSION['message'] ?? '';
unset($_SESSION['status'], $_SESSION['message']);

// Selección de mes (por GET o mes actual)
$selectedMonth = isset($_GET['mes']) ? $_GET['mes'] : date('Y-m');  // formato YYYY-MM
list($Y, $m) = explode('-', $selectedMonth);
$startDate = new DateTime("{$Y}-{$m}-01");
$endDate = clone $startDate;
$endDate->modify('last day of this month');

// Recoger datos de mermas agrupadas por día
$con = Database::getCon();
$sql = sprintf(
    "SELECT DATE(fecha) AS dia, SUM(cantidad) AS total
     FROM mermas
     WHERE DATE(fecha) BETWEEN '%s' AND '%s'
       AND almacen_id = %d
     GROUP BY DATE(fecha)
     ORDER BY DATE(fecha)",
    $startDate->format('Y-m-d'),
    $endDate->format('Y-m-d'),
    StockData::getPrincipal()->id
);
$res = mysqli_query($con, $sql);
$dataMap = [];
while ($r = mysqli_fetch_assoc($res)) {
    $dataMap[$r['dia']] = (float) $r['total'];
}
mysqli_close($con);
?>

<div class="content">
  <section class="content-header">
    <h1>Gráfico de Mermas</h1>
  </section>
  <section class="content">
    <!-- Selector de mes -->
    <form method="get" class="form-inline mb-3">
      <input type="hidden" name="view" value="graficomerma">
      <label for="mes">Mes:</label>
      <input type="month"
             id="mes"
             name="mes"
             class="form-control mx-2"
             value="<?php echo htmlspecialchars($selectedMonth); ?>">
      <button type="submit" class="btn btn-default">Ver</button>
    </form>

    <!-- Contenedor del gráfico -->
    <div class="box box-primary">
      <div class="box-body">
        <div id="chart-mermas" style="height:300px;"></div>
      </div>
    </div>
  </section>
</div>

<!-- Script Morris.js -->
<script>
var total = [];
<?php
for ($dt = clone $startDate; $dt <= $endDate; $dt->modify('+1 day')) {
    $d = $dt->format('Y-m-d');
    $v = isset($dataMap[$d]) ? $dataMap[$d] : 0;
    echo "total.push({ x: '$d', y: $v });\n";
}
?>

Morris.Area({
    element: 'chart-mermas',
    data: total,
    xkey: 'x',
    ykeys: ['y'],
    labels: ['Cantidad'],
    parseTime: false
});
</script>
