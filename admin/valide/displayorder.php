
<?php
	include("../../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	//display none when open /displayorder.php
	if(empty($_GET['cmd'])) 
		die(); 

	//display current order list for kitchen management
	if ($_GET['cmd'] == 'currentorder')	{
		
		$displayOrderQuery =  "
					SELECT o.orderID, m.menuName, OD.itemID,MI.menuItemName,OD.quantity,O.status
					FROM tbl_order O
					LEFT JOIN tbl_orderdetail OD
					ON O.orderID = OD.orderID
					LEFT JOIN tbl_menuitem MI
					ON OD.itemID = MI.itemID
					LEFT JOIN tbl_menu M
					ON MI.menuID = M.menuID
					WHERE O.status 
					IN ( 'ready','	Completed')
				";

			if ($orderResult = $sqlconnection->query($displayOrderQuery)) {
					
				$currentspan = 0;

				//if no order
				if ($orderResult->num_rows == 0) {

					echo "<tr><td class='text-center' colspan='7' >No order for now :) </td></tr>";
				}

				else {
					while($orderRow = $orderResult->fetch_array(MYSQLI_ASSOC)) {

						$rowspan = getCountID($orderRow["orderID"],"orderID","tbl_orderdetail"); 

						if ($currentspan == 0)
							$currentspan = $rowspan;

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

							$color = "badge badge-warning";
							switch ($orderRow['status']) {
							
							}

							echo "<td class='text-center' rowspan=".$rowspan."><span class='{$color}'>".$orderRow['status']."</span></td>";
							
							echo "<td class='text-center' rowspan=".$rowspan.">";

							//options based on status of the order
							switch ($orderRow['status']) {
								case '	Completed':
									
									echo "<button onclick='editStatus(this,".$orderRow['orderID'].")' class='btn btn-outline-success' value = 'Completed'>Valider</button>";

									break;
								
							

							}

							
							echo "</td>";

							/*
							echo "<td rowspan=".$rowspan."><button class='btn btn-danger'>".$orderRow['status']."</button>";
							//temporary
							echo "<button class='btn btn-primary'>preparando</button>";
							echo "<button class='btn btn-success'>listo</button></td>";
							*/
						}

						echo "</tr>";

						$currentspan--;
					}
				}	
			}
	}

	//display current ready order list in staff index
	if ($_GET['cmd'] == 'currentready') {

		$latestReadyQuery = "SELECT orderID FROM tbl_order WHERE status IN ( '0','1') ";

		if ($result = $sqlconnection->query($latestReadyQuery)) {

			if ($result->num_rows == 0) {
				echo "<tr><td class='text-center'>Pas liste pour servir.
. </td></tr>";
			}

            while($latestOrder = $result->fetch_array(MYSQLI_ASSOC)) {
            	echo "<tr><td><i class='fas fa-bullhorn' style='color:green;'></i><b> Orden #".$latestOrder['orderID']."</b>commande demandée pour le moment :)<a href='editstatus.php?orderID=".$latestOrder['orderID']."'><i class='fas fa-check float-right'></i></a></td></tr>";
            }
        }
	}

?>