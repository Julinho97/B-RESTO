<?php
  include("../functions.php");

  if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
    header("Location: login.php");

  if($_SESSION['user_level'] != "admin")
    header("Location: login.php");

  if (!empty($_POST['role'])) {
    $role = $sqlconnection->real_escape_string($_POST['role']);
    $staffID = $sqlconnection->real_escape_string($_POST['staffID']);

    $updateRoleQuery = "UPDATE tbl_staff SET role = '{$role}'  WHERE staffID = {$staffID}  ";

      if ($sqlconnection->query($updateRoleQuery) === TRUE) {
        echo "";
      } 

      else {
        //handle
        echo "someting wong";
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

    <title>Administración de Empleados</title>

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
              <a href="index.html">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">Emplois</li>
          </ol>

          <!-- Page Content -->
          <h1>Administration de Emplois</h1>

          <div class="row">
            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-user-circle"></i>
                  Liste Actuel des emplois</div>
                <div class="card-body">
                  <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                      <th>#</th>
                      <th>Nom d'utilisateur</th>
                      <th>Etat</th>
                      <th>Fonction</th>
                      <th class="text-center">Option</th>
                    </tr>
                    
                      <?php 

                        $displayStaffQuery = "SELECT * FROM tbl_staff";

                        if ($result = $sqlconnection->query($displayStaffQuery)) {

                          if ($result->num_rows == 0) {
                            echo "<td colspan='4'>There are currently no staff.</td>";
                          }

                          $staffno = 1;
                          while($staff = $result->fetch_array(MYSQLI_ASSOC)) {
                          ?>  
                          	<tr class="text-center">
                            	<td><?php echo $staffno++; ?></td>
                            	<td><?php echo $staff['username']; ?></td>

                              <?php

                            	if ($staff['status'] == "Online") {
                                echo "<td><span class=\"badge badge-success\">Online</span></td>";
                              }

                              if ($staff['status'] == "Offline") {
                                echo "<td><span class=\"badge badge-secondary\">Ofline</span></td>";
                              }

                              ?>

                              <td>
                                <form method="POST">
                                <input type="hidden" name="staffID" value="<?php echo $staff['staffID']; ?>"/>
                                <select name="role" class="form-control" onchange="this.form.submit()">
                                  <?php

                                  $roleQuery = "SELECT role FROM tbl_role";

                                  if ($res = $sqlconnection->query($roleQuery)) {
                                    
                                    if ($res->num_rows == 0) {
                                      echo "no role";
                                    }

                                    while ($role = $res->fetch_array(MYSQLI_ASSOC)) {

                                      if ($role['role'] == $staff['role']) 
                                        echo "<option selected='selected' value='".$staff['role']."'>".ucfirst($staff['role'])."</option>";

                                      else
                                        echo "<option value='".$role['role']."'>".ucfirst($role['role'])."</option>";
                                    }
                                  }

                                  ?>
                                </select>
                                <noscript><input type="submit" value="Retirer"></noscript>
                                </form>
                              </td>

                            	<td class="text-center"><a href="deletestaff.php?staffID=<?php echo $staff['staffID']; ?>" class="btn btn-sm btn-danger">Suprimer</a></td>
                        	</tr>

                          <?php 
                          }

                        }
                        else {
                          echo $sqlconnection->error;
                          echo "Something wrong.";
                        }

                      ?>

                  </table>
                </div>
              <!-- Contraseña predeterminada para nuevo usuario : 1234abcd -->
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-chart-bar"></i>
                  Ajouter un nouvel employé</div>
                <div class="card-body">
                  <form action="addstaff.php" method="POST" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                    <div class="input-group">
                      <select name="staffrole" class="form-control">
                      <?php
  
                      $roleQuery = "SELECT role FROM tbl_role";

                      if ($res = $sqlconnection->query($roleQuery)) {
                        
                        if ($res->num_rows == 0) {
                          echo "no role";
                        }

                        while ($role = $res->fetch_array(MYSQLI_ASSOC)) {
                            echo "<option value='".$role['role']."'>".ucfirst($role['role'])."</option>";
                        }
                      }

                      ?>
                      </select>
                      <input type="text" required="required" name="staffname" class="form-control" placeholder="New emplois" aria-label="Add" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button type="submit" name="addstaff" class="btn btn-primary">
                          <i class="fas fa-plus"></i>
                        </button> 
                      </div>
                    </div>
                  </form>
                </div>
              </div>
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