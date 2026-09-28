<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Grupo Morami | Ventas</title>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  </head>

  <body>
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h2 class="page-header">
              <i class="fas fa-file-invoice"></i> Nota de venta
              <br />
              <small class="float-left">Fecha de solicitud: 2/02/2026</small>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <b>Folio de nota:</b> 4F3S8J<br />
            <address>
              <strong>Cliente: Juan Lopez </strong><br />
              Boulevar San Jose, no. 56<br />
              San Martin Texmelucan, Puebla 50698<br />
              Telefono: 221 154894<br />
            </address>
          </div>

          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Vendedor: Maria</b>
          </div>
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nombre producto</th>
                  <th>Tipo de material</th>
                  <th>Unidad de medida</th>
                  <th>Cantidad</th>
                  <th>Precio unitario</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Loseta Verona</td>
                  <td>Loseta</td>
                  <td>Cajas</td>
                  <td>10</td>
                  <td>$250.00</td>
                  <td>$2500.00</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Crest</td>
                  <td>Pega azulejo</td>
                  <td>Bultos</td>
                  <td>12</td>
                  <td>$200.00</td>
                  <td>$2400.00</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
      </section>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
          <p class="lead">Métodos de pago:</p>
          <img src="dist/img/credit/Transferenca.jpg" alt="Transferencia" />
          <img src="dist/img/credit/pagoefectivo.jpg" alt="Pago en efectivo" />

          <p class="text-muted well well-sm shadow-none" style="margin-top: 10px">
            Estos son los métodos de pago que aceptamos: <br />
            °Pago en efectivo <br />
            °Pago con transferencia
          </p>
        </div>
        <!-- /.col -->

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width: 50%">Subtotal:</th>
              <td>$4900.00</td>
            </tr>
            <tr>
              <th>Fletes:</th>
              <td>$200.00</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>$5100.00</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
      <!-- /.row -->
      <!-- Page specific script -->
      <script>
        window.addEventListener("load", window.print());
      </script>
    </div>
  </body>
</html>
