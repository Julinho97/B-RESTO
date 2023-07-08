<?php
  include("../functions.php");

  if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
    header("Location: login.php");

  if($_SESSION['user_level'] != "admin")
    header("Location: login.php");

?>
<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ventas</title>

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



    <!-- -----------------Navbar--and--------------->
    <!------------------ Sidebar ------------------->
	  <?php include('sidebar.php') ?>
    <!------------------ Sidebar ------------------->
      

      <div id="content-wrapper" class="wrap">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.php">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">Ventes</li>
          </ol>

          <!-- Page Content -->
          <h1>Administration de Ventes</h1>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Statistiques sur les bénéfices des ventes

            </div>
            <div class="card-body">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <tbody>
                  <tr>
                    <td>Aujourd'hui</td>
                    <td>Total <?php echo getSalesGrandTotal("DAY"); ?>F</td>
                  </tr>
                  <tr>
                    <td>Semaine</td>
                    <td>Total <?php echo getSalesGrandTotal("WEEK"); ?>F</td>
                  </tr>
                  <tr>
                    <td>Mois</td>
                    <td>Total <?php echo getSalesGrandTotal("MONTH"); ?>F</td>
                  </tr>
                  <tr class="table-info">
                    <td><b>Global</b></td>
                    <td><b>Total <?php echo getSalesGrandTotal("ALLTIME"); ?>F</b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Liste des bons de commande
</div>
            <div class="card-body">
              <table id="tblCurrentOrder" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                      <th># Ordre</th>
                      <th>Menu</th>
                      <th>Nom du produit</th>
                      <th class='text-center'>Quantité</th>
                      <th class='text-center'>Condition
</th>
                      <th class='text-center'>Total (Total)</th>
                      <th class='text-center'>Date</th>
                    </thead>
                    
                    <tbody id="tblBodyCurrentOrder">
                      <?php 
                      $displayOrderQuery =  "
                        SELECT o.orderID, m.menuName, OD.itemID,MI.menuItemName,OD.quantity,O.status,mi.price ,o.order_date
                        FROM tbl_order O
                        LEFT JOIN tbl_orderdetail OD
                        ON O.orderID = OD.orderID
                        LEFT JOIN tbl_menuitem MI
                        ON OD.itemID = MI.itemID
                        LEFT JOIN tbl_menu M
                        ON MI.menuID = M.menuID
                        order by o.orderID DESC
                        ";

                      if ($orderResult = $sqlconnection->query($displayOrderQuery)) {
                          
                        $currentspan = 0;
                        $total = 0;

                        //if no order
                        if ($orderResult->num_rows == 0) {

                          echo "<tr><td class='text-center' colspan='7' >Il n'y a actuellement aucune commande pour le moment. </td></tr>";
                        }

                        else {
                          while($orderRow = $orderResult->fetch_array(MYSQLI_ASSOC)) {

                            //basically count rowspan so no repetitive display id in each table row
                            $rowspan = getCountID($orderRow["orderID"],"orderID","tbl_orderdetail"); 

                            if ($currentspan == 0) {
                              $currentspan = $rowspan;
                              $total = 0;
                            }

                            //get total for each order id
                            $total += ($orderRow['price']*$orderRow['quantity']);

                            echo "<tr>";

                            if ($currentspan == $rowspan) {
                              echo "<td rowspan=".$rowspan."># ".$orderRow['orderID']."</td>";
                            }

                            echo "
                              <td>".$orderRow['menuName']."</td>
                              <td>".$orderRow['menuItemName']."</td>
                              <td class='text-center'>".$orderRow['quantity']."</td>
                            ";

                            if ($currentspan == $rowspan) {

                              $color = "badge";

                              switch ($orderRow['status']) {
                               

                                case 'Completed':
                                  $color = "badge badge-success";
                                  break;
                              }

                              echo "<td class='text-center' rowspan=".$rowspan."><span style='background:green ; color:white;' class='{$color}'>".$orderRow['status'] = '	Completed'."</span></td>";

                              echo "<td rowspan=".$rowspan." class='text-center'>".getSalesTotal($orderRow['orderID'])."</td>";

                              echo "<td rowspan=".$rowspan." class='text-center'>".$orderRow['order_date']."</td>";

                            
                              echo "</td>";

                            }

                            echo "</tr>";

                            $currentspan--;
                          }
                        }
                        } 
                      ?>
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

  </body>

</html>