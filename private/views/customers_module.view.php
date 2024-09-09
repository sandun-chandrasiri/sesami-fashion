<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
  	<meta name="description" content="Free Web tutorials">
  	<meta name="keywords" content="HTML, CSS, JavaScript">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/all.min.css">

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

      	// Use PHP variable to populate data
        var orderStatusCounts = <?php echo json_encode($orderStatusCounts); ?>;

        var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Status');
	    data.addColumn('number', 'Count');

	    for (var i = 0; i < orderStatusCounts.length; i++) {
	        data.addRow([orderStatusCounts[i].status, orderStatusCounts[i].count]);
	    }

        var options = {
          title: 'Order Status Distribution',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

</head>
<body>
	<style>
		.fa{
			margin-right: 4px;
		}

		a{
			text-decoration:  none;
		}
	</style>
<div style="min-width:350px;">

<?php $this->view('includes/nav')?>

<style>
	h1{
		font-size: 80px;
		color: limegreen;
	}

	a{
		text-decoration: none;
	}

	.card-header{
		font-weight: bold;
	}

	.card{
		min-width: 250px;
	}
</style>

	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>
	 
	 	<div class="row justify-content-center ">

		 	<?php if(Auth::access('head')):?>

		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/customers">
		 			<div class="card-header text-center">CUSTOMER MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/customer.png" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View all Customer Details</div>
	 				</a>
		 		</div>
		 		
		 	<?php endif;?>

		 	<?php if(Auth::access('head')):?>
		 		<div class="card col-3 shadow rounded m-4 p-0 border">
	 				<a href="<?=ROOT?>/orders">
		 			<div class="card-header text-center">ORDER MANAGEMENT</div>
		 			<h1 class="text-center">
		 				<img src="<?=ROOT?>/assets/orders.jpg" class="border border-primary" style="width:248px; height:150px">
		 			</h1>
		 			<div class="card-footer text-center">View all Orders</div>
		 			</a>
		 		</div>

		 	<?php endif;?>

		 	<div id="piechart" style="width: 900px; height: 500px;"></div>

	 	</div>
	</div>
 
<?php $this->view('includes/footer')?>
