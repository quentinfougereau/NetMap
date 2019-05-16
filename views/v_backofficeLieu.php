<?php
include('../views/v_backoffice.php'); 
?>

<div style="background-color:white" class="col-11">
	<h1>BACKOFFICE ADMIN</h1>
	<h2 style='color:grey'>Places list</h2>
	<form action="../controllers/routes.php?action=manageUser" method="POST">
	<button type="submit" class="btn btn-primary">Submit</button>
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Libelle</th>
				<th scope="col">Rating</th>
				<th scope="col">Description</th>
				<th scope="col">Longitude</th>
				<th scope="col">Latitude</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM place ORDER BY idPlace DESC";
				$result = mysqli_query($con, $query);
				$i=1;

				while($resrow = mysqli_fetch_assoc($result)) {
					$queryLoc = 'SELECT location.longitude, location.latitude FROM location, place WHERE location.idLocation = '.$resrow['idLocation'].' LIMIT 1';
					$resultLoc = mysqli_query($con, $queryLoc);
					echo "
					<tr>
						<th scope='row'>".$i."</th>
						<td scope='row'>".$resrow['libelle']."</td>
						<td scope='row'>".$resrow['rating']."</td>
						<td scope='row'>".$resrow['description']."</td>";
					while($locrow = mysqli_fetch_assoc($resultLoc)){
						echo "<td scope='row'>".$locrow['longitude']."</td>";
						echo "<td scope='row'>".$locrow['latitude']."</td>";
					}
					echo "</tr>";	
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