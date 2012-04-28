<?php

	include "functions.php";

	// If the form was submitted

	if(isset($_POST['urls'])):
		// Get Data
		$urls = $_POST['urls'];
		$check = $_POST['check'];
		$pause = $_POST['pause'];
		$urls = explode("\n",$urls);

		$pageRankOptions = array("","0","1","2","3","4","5","6","7","8","9","10");

		$noPR = 0;

		// Loop through URLs
		foreach($urls as $url):

			// If we're going to check root domain only, get the root domain
			if($check == "1"){
				// Check root domain PR
				$url = "http://".parse_url($url, PHP_URL_HOST);				
			}

			// Check the PageRank
			$pagerank = pagerank($url);

			// Loop through the PageRank array
			foreach($pageRankOptions as $pageRanks):
			
				// If the PageRank in the loop matches the PageRank of the URL
				if($pageRanks == $pagerank):

					// See if the PageRank is zero or not
					if($pagerank == ""){
						$noPR++;
					}else{
						$prResults[$pageRanks] = $prResults[$pageRanks] + 1;	
					}	

				endif;		
			endforeach;

			// Pause here so we don't piss Google off
			sleep($pause);


		endforeach;

		// Check to see if there are any results so we're not sorting a blank array
		if($prResults)
			ksort($prResults);
		
	endif;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PageRank Distribution Checker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="container">
	
		<div class="page-header">
			<h1>PageRank Distribution Checker</h1>
		</div>
		
		<div class="row">
			
			<script type="text/javascript">

		      // Load the Visualization API and the piechart package.
		      google.load('visualization', '1.0', {'packages':['corechart']});

		      // Set a callback to run when the Google Visualization API is loaded.
		      google.setOnLoadCallback(drawChart);

		      // Callback that creates and populates a data table,
		      // instantiates the pie chart, passes in the data and
		      // draws it.
		      function drawChart() {

		        // Create the data table.
		        var data = new google.visualization.DataTable();
		        data.addColumn('string', 'Topping');
		        data.addColumn('number', 'Total');
		        data.addRows([
				<?php
					if($noPR >= 0)
						echo "['No PR',".$noPR."],";
					
					if($prResults){
					?>
						['PR0', <?php if($prResults['0'] == ""){ echo "0"; }else{ echo $prResults['0']; } ?> ],
						['PR1', <?php if($prResults['1'] == ""){ echo "0"; }else{ echo $prResults['1']; } ?> ],
						['PR2', <?php if($prResults['2'] == ""){ echo "0"; }else{ echo $prResults['2']; } ?>],
						['PR3', <?php if($prResults['3'] == ""){ echo "0"; }else{ echo $prResults['3']; } ?>],
						['PR4', <?php if($prResults['4'] == ""){ echo "0"; }else{ echo $prResults['4']; } ?>],
						['PR5', <?php if($prResults['5'] == ""){ echo "0"; }else{ echo $prResults['5']; } ?>],
						['PR6', <?php if($prResults['6'] == ""){ echo "0"; }else{ echo $prResults['6']; } ?>],
						['PR7', <?php if($prResults['7'] == ""){ echo "0"; }else{ echo $prResults['7']; } ?>],
						['PR8', <?php if($prResults['8'] == ""){ echo "0"; }else{ echo $prResults['8']; } ?>],
						['PR9', <?php if($prResults['9'] == ""){ echo "0"; }else{ echo $prResults['9']; } ?>],
						['PR10', <?php if($prResults['10'] == ""){ echo "0"; }else{ echo $prResults['10']; } ?>],
					
					<?php

					}else{
						echo "['PR1',0],['PR2',0],['PR3',0],['PR4',0],['PR5',0],['PR6',0],['PR7',0],['PR8',0],['PR9',0],['PR10',0]";
					}
				?>
				]);

		        // Set chart options
		        var options = {'width':1000,
		                       'height':500};

		        // Instantiate and draw our chart, passing in some options.
		        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
		        chart.draw(data, options);
		      }
		    </script>
		
			<div class="span12">
				<!--Div that will hold the pie chart-->
			    <div id="chart_div"></div>
			</div>
			
			
			<div class="span12">
				<form method="post" class="form-horizontal" >
					<div class="control-group">
						<label class="control-label" for="urls">URLs to check:</label>
						<div class="controls">
							<textarea rows="10" name="urls" col="150"  style="width: 600px;" /></textarea>
							<p class="help-block">One URL per line</p>
						</div>
					</div>
					<div class="control-group">
					            <label for="select01" class="control-label">Check PR of</label>
					            <div class="controls">
					              <select id="select01" name="check">
					                <option value="1">Root Domain</option>
					                <option value="2">Actual URL</option>
					              </select>
					            </div>
					          </div>
					<div class="control-group">
			            <label for="select02" class="control-label">Pause between query</label>
			            <div class="controls">
			              <select id="select02" name="pause">
			                <option value="1">1 Second</option>
			                <option value="2" selected>2 Seconds</option>
			                <option value="3">3 Seconds</option>
			                <option value="5">5 Seconds</option>
			                <option value="10">10 Seconds</option>
			              </select>
			            </div>
			          </div>
					<div class="form-actions">
			            <button class="btn btn-primary" name="submit" type="submit">Submit</button>
			        </div>
				</form>
			</div>
			



		</div>


    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>


