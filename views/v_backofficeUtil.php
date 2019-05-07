<?php
include('../views/v_backoffice.php'); 
?>

<div style="background-color:white" class="col-11">
			<h1>BACKOFFICE ADMIN</h1>
			<p style='color:grey'>liste utilisateurs</p>
			<div class="row">
				<div class="col-md">
				<ul class="list-group">
				<?php
					$query = "SELECT * FROM User ORDER BY isAdmin DESC";
					$result = mysqli_query($con, $query);
					while($resrow = mysqli_fetch_assoc($result)) {
						$tags = '';
						if($resrow['isAdmin'] == '2'){
							$tags = 'list-group-item-warning';
						}else{
							if($resrow['isAdmin'] == '1'){
								$tags = 'list-group-item-primary';
							}else{
								$tags = '';
							}
						}
						
						if($resrow['login'] == $adresse){
							echo "<button onclick='myFunction()'><li class='list-group-item active'>".$resrow['pseudo']."</li></button>";
						}else{
							echo "<button onclick='myFunction()'><li class='list-group-item ".$tags."'>".$resrow['pseudo']."
							<a href='../controllers/routes.php?action=manageUser&user=" . $resrow['login'] . "&oper=flag'>
								<div style='padding:4px;' class='float-sm-right'>
									<i class='fa fa-exclamation-triangle'></i>
								</div>
							</a>
							<a href='../controllers/routes.php?action=manageUser&user=" . $resrow['login'] . "&oper=modify'>
								<div style='padding:4px;' class='float-sm-right'>
									<i class='fa fa-cog'></i>
								</div>
							</a>
							</li></button>";					
						}
					}
				?>
				</ul>
				</div>
				
				<div id="utilInfo" class="col-md">
					<ul class="list-group">
						<li class="list-group-item">Cras justo odio</li>
						<li class="list-group-item">Dapibus ac facilisis in</li>
						<li class="list-group-item">Morbi leo risus</li>
						<li class="list-group-item">Porta ac consectetur ac</li>
						<li class="list-group-item">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</li>
					</ul>
				</div>
		</div>
	</div>
<script>
function myFunction() {
  var x = document.getElementById("utilInfo");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
<?php
include('../views/footer.php'); 
?>