<?php 
  include("../functions.php");

  if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
    header("Location: login.php");

  if($_SESSION['user_level'] != "admin")
    header("Location: login.php");

  /*
  echo $_SESSION['uid'];
  echo $_SESSION['username'];
  echo $_SESSION['user_level'];
  */

  function getStatus () {
      global $sqlconnection;
      $checkOnlineQuery = "SELECT status FROM tbl_staff WHERE staffID = {$_SESSION['uid']}";

      if ($result = $sqlconnection->query($checkOnlineQuery)) {
          
        if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
          return $row['status'];
        }
      }

      else {
          echo "Something wrong the query!";
          echo $sqlconnection->error;
      }
  }

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Panel de Control</title>

    <!-- Bootstrap core CSS-->
    <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="public/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->

    <link href="public/css/sb-admi.css" rel="stylesheet">

  </head>

  <body id="page-top">


       <!-- -----------------Navbar--and--------------->
    <!------------------ Sidebar ------------------->
	  <?php include('sidebar.php') ?>
    <!------------------ Sidebar ------------------->

      <div id="content-wrapper" class="wrap">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.php">Panneau de commande
</a>
            </li>
            <li class="breadcrumb-item active">Vue générale</li>
          </ol>

          <!-- Page Content -->
          <h1>Tableau de bord des employés</h1>

          <div class="row">
            <div class="col-lg-9">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-utensils"></i>
                  Commandes les plus récentes prêtes</div>
                <div class="card-body">
                	<table id="orderTable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                	</table>
                </div>
                <!-- <div class="card-footer small text-muted"><i>Se actualiza cada tres segundos</i></div>  -->
              </div>
            </div>

            <div class="col-lg-3">
              <div class="card mb-3 text-center">
                <div class="card-header">
                  <i class="fas fa-chart-bar""></i>
                  Condition</div>
                <div class="card-body">
                Salut , <b><?php echo $_SESSION['username'] ?></b><hr>
                Poste : <b><?php echo ucfirst($_SESSION['user_role']) ?></b><hr>

                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      <?php include('footer.php')  ?>
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Voulez-vous vraiment vous déconnecter ?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin à votre session en cours.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
            <a class="btn btn-primary" href="logout.php">Se déconnecter</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="public/js/sb-admin.min.js"></script>

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script type="text/javascript">

    $( document ).ready(function() {
        refreshTableOrder();
    });

    function refreshTableOrder() {
      $( "#orderTable" ).load( "valide/displayorder.php?cmd=currentready" );
    }

    //refresh order current list every 3 secs
    setInterval(function(){ refreshTableOrder(); }, 3000);

  </script>

  </body>

</html>