<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="jquery-3.1.1.min.js"></script>
 <script src="https://www.google.com/jsapi"></script>
 <script type="text/javascript">
	
	var chart_temp;
	var chart_pres;
	//data temperature
	var data_temp;
	var data_temp_30T;
	var data_temp_7T;
	var data_temp_24h;
	//data pressure
	var data_pres;
	var data_pres_30T;
	var data_pres_7T;
	var data_pres_24h;
	
	//options
	var options_temp = {
            title: 'Temperaturverlauf',
			explorer: { maxZoomOut: 8, axis: 'horizontal' }
          };
	var options_pres = {
            title: 'Luftdruckverlauf',
			explorer: { maxZoomOut: 8, axis: 'horizontal' }
          };
	// onload callback
      function drawChart() {
		  chart_temp = new google.visualization.LineChart($('#chart_temp').get(0));
		  chart_pres = new google.visualization.LineChart($('#chart_pres').get(0));
		  //initialize temp data
		  data_temp = new google.visualization.DataTable();
		  data_temp_30T = new google.visualization.DataTable();
		  data_temp_7T = new google.visualization.DataTable();
		  data_temp_24h = new google.visualization.DataTable();
		  //intialize pressure data
		  data_pres = new google.visualization.DataTable();
		  data_pres_30T = new google.visualization.DataTable();
		  data_pres_7T = new google.visualization.DataTable();
		  data_pres_24h = new google.visualization.DataTable();
		  $('input').on('change', function() {
				var checkedItem = $('input[name=bereich]:checked').val(); 
				if( checkedItem == "alles"){
					chart_temp.clearChart();
					chart_temp.draw(data_temp,options_temp);
					chart_pres.clearChart();
					chart_pres.draw(data_pres,options_pres);
					
				}
				else if( checkedItem == "l30T"){
					chart_temp.clearChart();
					chart_temp.draw(data_temp_30T,options_temp);
					chart_pres.clearChart();
					chart_pres.draw(data_pres_30T,options_pres);
				}
				else if( checkedItem == "l7T"){
					chart_temp.clearChart();
					chart_temp.draw(data_temp_7T,options_temp);
					chart_pres.clearChart();
					chart_pres.draw(data_pres_7T,options_pres);
				}
				else if( checkedItem == "l24h"){
					chart_temp.clearChart();
					chart_temp.draw(data_temp_24h,options_temp);
					chart_pres.clearChart();
					chart_pres.draw(data_pres_24h,options_pres);
				}
					
			});
			var lines;
		  $.ajax({
				cache: false,
				url: 'readtemp.php',
				success: function(dataAJAX) {
					lines = dataAJAX.split('\n');	
					//add columns
					//all values
					data_temp.addColumn('datetime', 'Time');
					data_temp.addColumn('number', 'Temperatur');
					data_pres.addColumn('datetime', 'Time');
					data_pres.addColumn('number', 'Luftdruck');
					//last 30 days
					data_temp_30T.addColumn('datetime', 'Time');
					data_temp_30T.addColumn('number', 'Temperatur');
					data_pres_30T.addColumn('datetime', 'Time');
					data_pres_30T.addColumn('number', 'Luftdruck');
					//last 7 days
					data_temp_7T.addColumn('datetime', 'Time');
					data_temp_7T.addColumn('number', 'Temperatur');
					data_pres_7T.addColumn('datetime', 'Time');
					data_pres_7T.addColumn('number', 'Luftdruck');
					//last 24 hours
					data_temp_24h.addColumn('datetime', 'Time');
					data_temp_24h.addColumn('number', 'Temperatur');
					data_pres_24h.addColumn('datetime', 'Time');
					data_pres_24h.addColumn('number', 'Luftdruck');
					//parse each row of the data from the php file
					$.each(lines, function (i, row) {
					  var values = row.split('/');
					  //if last item display current values
						if(i === (lines.length -2)){
							$("#temp").text(values[1]);
							$("#pres").text(values[2]);
							$("#zeitstempel").text(values[0]);
						}
						//last 30 days
						if(i > (lines.length -722)){
							data_temp_30T.addRow([
							(new Date(values[0])),
							parseFloat(values[1])
							]);
							data_pres_30T.addRow([
							(new Date(values[0])),
							parseFloat(values[2])
							]);
						}
						//last 7 days
						if(i > (lines.length -170)){
							data_temp_7T.addRow([
							(new Date(values[0])),
							parseFloat(values[1])
							]);
							data_pres_7T.addRow([
							(new Date(values[0])),
							parseFloat(values[2])
							]);
						}
						//last 24 hours
						if(i > (lines.length -26)){
							data_temp_24h.addRow([
							(new Date(values[0])),
							parseFloat(values[1])
							]);
							data_pres_24h.addRow([
							(new Date(values[0])),
							parseFloat(values[2])
							]);
						}
						data_temp.addRow([
							(new Date(values[0])),
							parseFloat(values[1])
							]);
						data_pres.addRow([
							(new Date(values[0])),
							parseFloat(values[2])
							]);
					});

					//draw chart
					chart_temp.draw(data_temp, options_temp);
					chart_pres.draw(data_pres,options_pres)
				},
				error: function(){
					alert("Error fechting temp data!");
				},
			});
			

        };

      

      // load chart lib
      google.load('visualization', '1', {
        packages: ['corechart']
      });

      // call drawChart once google charts is loaded
      google.setOnLoadCallback(drawChart);
</script>
<title>Wetterstation</title></head>
<body>
<h1>Wetterstation</h1>
<h2>Temperatur</h2>
<div id="temp">NODATA</div> Grad Celsius
<h2>Luftdruck</h2>
<div id="pres">NODATA</div> hPa
<h2>Zeitstempel</h2>
<div id="zeitstempel">NODATA</div>
<h2>Charts:</h2>
<p>Anzeige wählen:</p>
<input type="radio" name="bereich" id="alles" value="alles"/>
<label for="always">Alles</label>
<input type="radio" name="bereich" id="l30T" value="l30T"/>
<label for="never">Letzten 30 Tage</label>
<input type="radio" name="bereich" id="l7T" value="l7T"/>
<label for="change">Letzten 7 Tage</label>
<input type="radio" name="bereich" id="l24h" value="l24h"/>
<label for="change">Letzten 24 Stunden</label>
<br>
<div id="chart_temp" style="width: 100%;"></div>
<div id="chart_pres" style="width: 100%;"></div>
</body>
</html>
