<?php
  include("../functions.php");

  if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
    header("Location: login.php");

  if($_SESSION['user_level'] != "admin")
    header("Location: /login.php");

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Valide</title>

    <!-- Bootstrap core CSS-->
    <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="public/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="public/css/sb-admine.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-------------------Navbar--and--------------->
    <!------------------ Sidebar ------------------->
	  <?php include('sidebar.php') ?>
    <!------------------ Sidebar ------------------->

      <div id="content-wrapper" class="wrap">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.php">Panneau de commande</a>
            </li>
            <li class="breadcrumb-item active">Validation</li>
          </ol>

          <!-- Page Content -->
          <h1>Comité administratif de la valide</h1>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-utensils"></i>
              Dernières commandes reçues</div>
            <div class="card-body">
            	<table id="tblCurrentOrder" class="table table-bordered text-center" width="100%" cellspacing="0">
					<thead>
						<th># de commande</th>
						<th>Catégorie</th>
						<th>Nom du menu</th>
						<th class='text-center'>Quantité</th>
						<th class='text-center'>Condition</th>
						<th class='text-center'>Choix</th>
					</thead>
					
					<tbody id="tblBodyCurrentOrder">
						
					</tbody>
				</table>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Final Bamsasin Design Service System de Gestion de Restaurante 2022</span>
            </div>
          </div>
        </footer>

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

    <script type="text/javascript">

		$( document ).ready(function() {
	    	refreshTableOrder();
		});

		function refreshTableOrder() {
			$( "#tblBodyCurrentOrder" ).load( "valide/displayorder.php?cmd=currentorder" );
		}


		function editStatus (objBtn,orderID) {
			var status = objBtn.value;

			$.ajax({
				url : "valide/editstatus.php",
					type : 'POST',
					data : {
						orderID : orderID,
						status : status 
					},

					success : function(output) {
						refreshTableOrder();
					}
				});
		}

		function delStatus (objBtn,orderID) {
			var status = objBtn.value;

			$.ajax({
				url : "valide/delete_order.php",
					type : 'POST',
					data : {
						orderID : orderID,
						status : status 
					},

					success : function(output) {
						refreshTableOrder();
					}
				});
		}

		//refresh order current list every 3 secs
		setInterval(function(){ refreshTableOrder(); }, 3000);

	</script>

  </body>

</html>