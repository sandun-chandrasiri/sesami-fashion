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

	<!-- Include the Google Charts library -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	    // Load the Visualization API and the corechart package.
	    google.charts.load('current', {'packages':['corechart']});
	      
	    // Set a callback to run when the Google Visualization API is loaded.
	    google.charts.setOnLoadCallback(drawChart);

	    function drawChart() {
	        var data = new google.visualization.DataTable();
	        data.addColumn('string', 'Month');
	        data.addColumn('number', 'Units');

	        // Add your data to the chart
	        <?php foreach ($monthlyData as $row): ?>
	            data.addRow(['<?= $row->month ?>', <?= $row->units ?>]);
	        <?php endforeach; ?>

	        var options = {
	            title: 'Monthly Electricity Consumption',
	            curveType: 'function',
	            legend: { position: 'bottom' }
	        };

	        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

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
	
	<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
		<?php $this->view('includes/crumbs',['crumbs'=>$crumbs])?>

		<h5>Electricity</h5>
 		<nav class="navbar navbar-light bg-light">
		  <form class="form-inline">
		    <div class="input-group">
		      <div class="input-group-prepend">
		        <button class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i>&nbsp</button>
		      </div>
		      <input name="find" value="<?=isset($_GET['find'])?$_GET['find']:'';?>" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
		    </div>
		  </form>
 				<?php if(Auth::access('dataEntryClerk')):?>
					<div style="justify-content-end;">
 						<!-- <?php var_dump($_SESSION);?> -->
 						<a href="<?= ROOT ?>/Electricity_pdf/">
 							<!-- <?= var_dump($rows)?> -->
							<button class="btn btn-sm btn-success">Print</button>
						</a>
						<a href="<?=ROOT?>/electricity/add">
							<button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add New</button>
						</a>
 					</div>
				<?php endif;?>
 		</nav>

		<?php include(views_path('electricity'))?>

		<?php $pager->display()?>
 
	</div>
 
<?php $this->view('includes/footer')?>