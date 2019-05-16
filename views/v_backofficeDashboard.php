<?php
include('../views/v_backoffice.php');
$result=mysqli_query($con, "SELECT count(*) as total from User");
$user=mysqli_fetch_assoc($result);
$result2=mysqli_query($con, "SELECT count(*) as total from Event");
$event=mysqli_fetch_assoc($result2);
$result3=mysqli_query($con, "SELECT count(*) as total from Place");
$place=mysqli_fetch_assoc($result3);
?>

<div style="background-color:white" class="col-11">
	<h1>BACKOFFICE ADMIN</h1>
	<h2 style='color:grey'>Dashboard</h2>
	<div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nb Users</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $user['total'];?></div>
						</div>
						<div class="col-auto">
							<i class="fa fa-users fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nb Events</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $event['total'];?></div>
						</div>
						<div class="col-auto">
							<i class="fa fa-calendar-alt fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
            </div>
        </div>
		
		<div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Nb Places</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $place['total'];?></div>
						</div>
						<div class="col-auto">
							<i class="fa fa-map-marker-alt fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
            </div>
        </div>
		
		<div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Server Status</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo 'Version PHP : ' . phpversion();?></div>
						</div>
						<div class="col-auto">
							<i class="fa fa-signal fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
            </div>
        </div>
</div>
	<div class="row">
		
		<div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
					<canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php
include('../views/footer.php'); 
?>