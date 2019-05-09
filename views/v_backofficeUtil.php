<?php
include('../views/v_backoffice.php'); 
?>

<div style="background-color:white" class="col-11">
	<h1>BACKOFFICE ADMIN</h1>
	<h2 style='color:grey'>Users list</h2>
	<form action="../controllers/routes.php?action=manageUser" method="POST">
	<button type="submit" class="btn btn-primary">Submit</button>
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Email</th>
				<th scope="col">Login</th>
				<th scope="col">Rights</th>
				<th scope="col">Set Rights Admin/Modo</th>
				<th scope="col">Set Rights User</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM User ORDER BY isAdmin DESC";
				$result = mysqli_query($con, $query);
				$i=1;
				$checked_admin = '';
				$checked_modo = '';
				$rightsRowLabel = '';
				while($resrow = mysqli_fetch_assoc($result)) {
					$tags = '';
					if($resrow['isAdmin'] == '2'){
						$tags = 'table-warning';
						$checked_admin = 'checked';
						$checked_modo = '';
						$rightsRowLabel = 'Administrateur';
					}else{
						if($resrow['isAdmin'] == '1'){
							$tags = 'table-success';
							$checked_admin = '';
							$checked_modo = 'checked';
							$rightsRowLabel = 'Moderateur';
						}else{
							$tags = '';
							$checked_admin = '';
							$checked_modo = '';
							$rightsRowLabel = 'Utilisateur';
						}
					}
						
					if($resrow['login'] == $adresse){
						echo "<tr class=".$tags.">
							<th scope='row'>".$i."</th>
							<th scope='row'>".$resrow['login']."</th>
							<th scope='row'>".$resrow['pseudo']."</th>
							<th scope='row'>".$rightsRowLabel."</th>
							<th scope='row'>
								<input ".$checked_admin." type='checkbox' name='admin_list[]' value=".$resrow['login'].">
								<input ".$checked_modo." type='checkbox' name='modo_list[]' value=".$resrow['login'].">
							</th>
							<th scope='row'>
								<a href='../controllers/routes.php?action=deleteUserRights&user=" . $resrow['login'] . "'>
										<i class='fa fa-trash'></i>
								</a>
							</th>
						</tr>";
					}else{
						echo "
						<tr class=".$tags.">
							<th scope='row'>".$i."</th>
							<td scope='row'>".$resrow['login']."</td>
							<td scope='row'>".$resrow['pseudo']."</td>
							<td scope='row'>".$rightsRowLabel."</td>
							<td scope='row'>
								<input ".$checked_admin." type='checkbox' name='admin_list[]' value=".$resrow['login'].">
								<input ".$checked_modo." type='checkbox' name='modo_list[]' value=".$resrow['login'].">
							</td>
							<td scope='row'>
								<a href='../controllers/routes.php?action=deleteUserRights&user=" . $resrow['login'] . "'>
										<i class='fa fa-trash'></i>
								</a>
							</td>
						</tr>";	
					}
					$i+=1;
				}
			?>
		</tbody>
	</table>
	</form>
</div>

<?php
include('../views/footer.php'); 
?>