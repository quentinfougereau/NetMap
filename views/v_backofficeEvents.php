<?php
include('../views/v_backoffice.php'); 
?>

<div style="background-color:white" class="col-11">
	<h1>BACKOFFICE ADMIN</h1>
	<h2 style='color:grey'>Events list</h2>
	<form action="../controllers/routes.php?action=manageUser" method="POST">
	<button type="submit" class="btn btn-primary">Submit</button>
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Libelle</th>
				<th scope="col">Date</th>
				<th scope="col">Place</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM event ORDER BY idEvent DESC";
				$result = mysqli_query($con, $query);
				$i=1;

				while($resrow = mysqli_fetch_assoc($result)) {
					$queryLoc = 'SELECT place.libelle FROM event, place WHERE place.idPlace = '.$resrow['idPlace'].' LIMIT 1';
					$resultLoc = mysqli_query($con, $queryLoc);
					echo "
					<tr>
						<th scope='row'>".$i."</th>
						<td scope='row'>".$resrow['libelle']."</td>
						<td scope='row'>".$resrow['dateEvent']."</td>";
					while($locrow = mysqli_fetch_assoc($resultLoc)){
						echo "<td scope='row'>".$locrow['libelle']."</td>";
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