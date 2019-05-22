<?php
include('../views/v_backoffice.php'); 
?>

<div style="background-color:white" class="col-10">
	<h1>BACKOFFICE ADMIN</h1>
	<h2 style='color:grey'>Comments List</h2>
	<form action="../controllers/routes.php?action=manageComment" method="POST">
	<button type="submit" class="btn btn-netmap">Submit</button>
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Content</th>
				<th scope="col">Status</th>
				<th scope="col">Date</th>
				<th scope="col">User</th>
				<th scope="col">Event</th>
				<th scope="col">Approve</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM Comment ORDER BY status <> 'pending', status DESC";
				$result = mysqli_query($con, $query);
				$i=1;
				$approved = '';
				while($resrow = mysqli_fetch_assoc($result)) {
					$queryLoc = 'SELECT Event.libelle FROM Event, Comment WHERE Event.idEvent = '.$resrow['idEvent'].' LIMIT 1';
					$resultLoc = mysqli_query($con, $queryLoc);
					echo "
					<tr>
						<th scope='row'>".$i."</th>
						<td scope='row'>".$resrow['content']."</td>";
					if($resrow['status'] == 'pending'){
						echo "<td scope='row'><b>".$resrow['status']."</b></td>";
					}else{
						echo "<td scope='row'>".$resrow['status']."</td>";
						$approved = 'checked';
					}
					echo "
						<td scope='row'>".$resrow['datetime']."</td>
						<td scope='row'>".$resrow['userLogin']."</td>";
					while($locrow = mysqli_fetch_assoc($resultLoc)){
						echo "<td scope='row'>".$locrow['libelle']."</td>";
					}
					echo "<td scope='row'>
							<input ".$approved." type='checkbox' name='comment_list[]' value=".$resrow['idComment'].">
						</td>
					</tr>";	
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