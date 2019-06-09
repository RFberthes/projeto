<!doctype html>
<html lang="pt-br">

<head>
  <?php
  require_once "header-atendente.php";
  //Buscas
  $sql1 = "SELECT * FROM usuarios";
  $usuarios = $pdo->query($sql1);

  $sql2 = "SELECT * FROM mesas";
  $mesas = $pdo->query($sql2);

  $sql3 = "SELECT * FROM bebidas";
  $bebidas = $pdo->query($sql3);

  $sql4 = "SELECT * FROM lanches";
  $lanches = $pdo->query($sql4);

  $sql5 = "SELECT * FROM comandas JOIN clientes ON clientes.idcliente = comandas.cliente_idcliente";
  $comandas = $pdo->query($sql5);

  $sql6 = "SELECT * FROM clientes";
  $clientes = $pdo->query($sql6);
  ?>
</head>

<body>
  <div class="container bg-dark text-white mt-2 mb-2 pb-2">

    <div class="pull-right">
      <button type="button" class="btn btn-xs btn-success mt-2 mb-2" data-toggle="modal"
        data-target="#ModalNovaComanda">Nova Comanda</button>
    </div>
    <div class="row">
      <?php while ($rowcm = $comandas->fetch()) { ?>
      <div class="card text-dark mt-2 ml-3" style="width:20%">
        <a href="apagar-comanda.php?idcomanda=<?php echo $rowcm['idcomanda']; ?>"><button type="button"
            class="close float-rigth mr-2 mt-1"> <span aria-hidden="true">&times;</span></button></a>
        <h6 class="card-title" style="text-align:center"><b>Comanda nº <?php echo $rowcm['idcomanda']; ?></b></h6>
        <p class="card-text pl-2">
          Mesa: <?php echo $rowcm['mesa_idmesa']; ?> <br>
          Cliente: <?php echo $rowcm['nome']; ?>
          <div class="row pr-3 pl-3 pb-2">
            <div class="col-4">
              <button type="button" class="btn btn-xs btn-info " data-toggle="modal" data-target="#ModalNovoPedido"
                data-whatever="<?php echo $rowcm['idcomanda']; ?>"> <img src="open-iconic/png/dinner.png"> </button>
            </div>
            <div class="col-4">
              <button type="button" class="btn btn-xs btn-warning " data-toggle="modal" data-target="#ModalNovaBebida"
                data-whatever="<?php echo $rowcm['idcomanda']; ?>"> <img src="open-iconic/png/cola.png"> </button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#ModalNovaBebida">
                <img src="open-iconic/png/share-2x.png"> </button>
            </div>
          </div>
      </div>
      <?php } ?>
    </div>


    <!-- Inicio Modal Nova Comanda -->
    <div class="modal fade text-dark" id="ModalNovaComanda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Cadastrar Comanda</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form action="registro-comanda.php" method="POST">
              <div class="form-group">
                <label>Mesa</label>
                <select name="mesa" id="mesa" class="form-control">
                  <?php while ($rowm = $mesas->fetch()) { ?>
                  <option value="<?php echo $rowm['idmesa']; ?>"><?php echo $rowm['idmesa']; ?></option>
                  <?php } ?>
                </select>

                <label>Cliente</label>
                <select name="cliente" id="cliente" class="form-control">
                  <?php while ($rowc = $clientes->fetch()) { ?>
                  <option value="<?php echo $rowc['idcliente']; ?>"><?php echo $rowc['nome']; ?></option>
                  <?php } ?>
                </select>
              </div>

              <input type="hidden" id="atendente" name="atendente" value="<?php echo $_SESSION['idusuario']; ?>">

              <div class="form-group"
                style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
                <button type="submit" class="btn btn-primary btn-block mb-3" style="width:25%;"> Cadastrar </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Fim Modal -->

    <!-- Inicio Modal Pedido -->
    <div class="modal fade text-dark" id="ModalNovoPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Novo Pedido</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form action="registro-pedido.php" method="POST">
              <div class="row ">
                <div class="col">
                  <label>Lanche</label>
                  <select name="lanche" id="lanche" class="form-control">
                    <?php while ($row = $lanches->fetch()) { ?>
                    <option value="<?php echo $row['idlanche']; ?>"><?php echo $row['nome_lanche']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col">
                  <label>Quantidade</label>
                  <input class="form-control" type="number" min="0" max="10" name="quantidade" id="quantidade">
                </div>
              </div>
              <label>Observação</label>
              <input type="text" name="obs" id="obs" class="form-control">

              <input type="hidden" id="atendente" name="atendente" value="<?php echo $_SESSION['idusuario']; ?>">
              <input type="hidden" id="recepient-idcomanda" name="idcomanda">

              <div class="form-group mt-2"
                style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
                <button type="submit" class="btn btn-primary btn-block mt-3 mb-2" style="width:25%;"> Salvar </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal -->

        <!-- Inicio Modal Bebida -->
        <div class="modal fade text-dark" id="ModalNovaBebida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Nova Bebida</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form action="registro-pedido.php" method="POST">
              <div class="row ">
                <div class="col">
                  <label>Bebida</label>
                  <select name="bebida" id="bebida" class="form-control">
                    <?php while ($row = $bebidas->fetch()) { ?>
                    <option value="<?php echo $row['idbebida']; ?>"><?php echo $row['nome_bebida']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col">
                  <label>Quantidade</label>
                  <input class="form-control" type="number" min="0" max="10" name="quantidade" id="quantidade">
                </div>
              </div>
              <label>Observação</label>
              <input type="text" name="obs" id="obs" class="form-control">

              <input type="hidden" id="atendente" name="atendente" value="<?php echo $_SESSION['idusuario']; ?>">
              <input type="hidden" id="recepient-idcomanda" name="idcomanda">

              <div class="form-group mt-2"
                style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
                <button type="submit" class="btn btn-primary btn-block mt-3 mb-2" style="width:25%;"> Salvar </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fim Modal -->

  </div>

  <!-- popup informativos -->
  <?php if (isset($_GET['sucesso'])) { ?>
  <script>
    Swal.fire({
      type: 'success',
      title: 'Feito!',
      text: 'Sucesso!!',
    })
  </script>
  <?php } elseif (isset($_GET['erro'])) { ?>
  <script>
    Swal.fire({
      type: 'error',
      title: 'Oops...',
      text: 'Erro, tente novamente',
    })
  </script>
  <?php } ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- Modal JavaScript -->
  <script type="text/javascript">
    $('#ModalNovoPedido').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('ID do Comanda: ' + recipient)
      modal.find('#recepient-idcomanda').val(recipient)

    })
  </script>

</body>

</html>