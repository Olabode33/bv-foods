<?php
	
	//Load Data
	$product_range_data = $dash_obj->getDataForQuestion(10, $age_f, $gender_f);
	$beverage_quality_data = $dash_obj->getDataForQuestion(11, $age_f, $gender_f);
	$food_quality_data1 = $dash_obj->getDataForQuestion(12, $age_f, $gender_f);
	$food_quality_data2 = $dash_obj->getDataForQuestion(13, $age_f, $gender_f);
	$food_quality_data3 = $dash_obj->getDataForQuestion(14, $age_f, $gender_f);
	$value_data = $dash_obj->getDataForQuestion(15, $age_f, $gender_f);
	$ambassador_data = $dash_obj->getDataForQuestion(16, $age_f, $gender_f);
	$frequency_data = $dash_obj->getDataForQuestion(17, $age_f, $gender_f);
	
	//echo json_encode($food_quality_data1['labels']);
	//echo json_encode($food_quality_data1['points']);
	
	$scale_color = ["#f44336", "#FF9800", "#FFC107", "#CDDC39", "#4CAF50"];
?>
<div class="col-xs-3">
	<!--Filter-->
	<?php
		include 'pages/cms/dashboards/d-filters.php';
	?>
	<!--Legends-->
	<b>Legends</b><hr>
	<div class="legend">
		<p>
			<span style="background-color: <?php echo $scale_color[0]; ?>"></span>
			I strongly disagree
		</p>
		<p>
			<span style="background-color: <?php echo $scale_color[1]; ?>"></span>
			I disagree
		</p>
		<p>
			<span style="background-color: <?php echo $scale_color[2]; ?>"></span>
			Indifferent
		</p>
		<p>
			<span style="background-color: <?php echo $scale_color[3]; ?>"></span>
			I agree
		</p>
		<p>
			<span style="background-color: <?php echo $scale_color[4]; ?>"></span>
			I strongly agree
		</p>
	</div>
	<span id="sclegends"></span>
	<hr>
	<!--span id="rtlegends"></span>
	<hr-->
	<span id="tllegends"></span>
</div>

<div class="col-xs-9">
	<?php
		include 'pages/cms/dashboards/d-nav.php';
	?>
	<!--Quick Facts-->
	<!--div class="row">
		<div class="col-md-3">
			<div class="quickfact on_track">
				<p class="truncate">Average customer response</p>
				<p class="fact_figure">Good</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="quickfact in_progress">
				<p class="truncate">Average customer response</p>
				<p class="fact_figure">Warning</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="quickfact threatened">
				<p class="truncate">Average customer response</p>
				<p class="fact_figure">Bad</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="quickfact">
				<p class="truncate">Average customer response</p>
				<p class="fact_figure">Default</p>
			</div>
		</div>
	</div-->
	
	<!--Charts-->
	<div class="row">
		<div class="col-md-4">
			<canvas id="bq_chart" width="400" height="400"></canvas>
		</div>
		
		<div class="col-md-4">
			<canvas id="fq_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-4">
			<canvas id="fq2_chart" width="400" height="400"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-4">
			<canvas id="pr_chart" width="200" height="200"></canvas>
		</div>
		<div class="col-md-4">
			<canvas id="a_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-4">
			<canvas id="f_chart" width="400" height="400"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-4">
			<canvas id="v_chart" width="400" height="400"></canvas>
		</div>
	</div>
	<hr>
	
</div>



<script>
	var legends = function(chart) {
			console.log(chart.data);
			
			var text = [];
			text.push('<div class="legend">');
			for(var i=0; i<chart.data.datasets[0].data.length; i++) {
				text.push('<p>');
				text.push('<span style="background-color: ' + chart.data.datasets[0].backgroundColor[i] + '"></span>'); //+ chart.data.datasets[0].data[i] +  (Add data to legend)
				if (chart.data.labels[i]) {
					text.push(chart.data.labels[i]);
				}
				text.push('</p>');
			}
			text.push('</div>');
			return text.join("");
		}

	//Colors::
	var scale_color = ["#f44336", "#FF9800", "#FFC107", "#CDDC39", "#4CAF50"];
	var rate_color = ["#1E88E5", "#039BE5", "#00ACC1", "#00897B", "#43A047"];
	var bg_colors = ["#8E44AD", "#F62459", "#6C7A89", "#F89406", "#03C9A9"];
	var hover_colors = ["#8E44AD", "#F62459", "#6C7A89", "#F89406", "#03C9A9"];
	var timeline_color = ["#FB8C00", "#FFB300", "#FDD835", "#C0CA33", "#7CB342"];	
	var rate_color = ["#1E88E5", "#039BE5", "#00ACC1", "#00897B", "#43A047"];
	
	var pr_chart = $("#pr_chart");
	var bq_chart = $("#bq_chart");
	var fq_chart = $("#fq_chart");
	var fq2_chart = $("#fq2_chart");
	var v_chart = $("#v_chart");
	var a_chart = $("#a_chart");
	var f_chart = $("#f_chart");
	
	//Setup for Product Range Chart
	var pr_data = {
		labels: <?php echo json_encode($product_range_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($product_range_data['points']); ?>
		}]
	};
	var pr_option = {
        title: {
            display: true,
            text: 'Product Range'
        },
		legend: {
			display: false
		},
		legendCallback: legends
		// scales: {
			// yAxes: [{
				// ticks: {
					// beginAtZero: true
				// }
			// }]
		// }
    }	
	var prChart = new Chart(pr_chart, {
		type: "doughnut",
		data: pr_data,
		options: pr_option
	});

	//Setup for Beverage Quality Chart
	var bq_data = {
		labels: <?php echo json_encode($beverage_quality_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: bg_colors[1],
			borderColor: hover_colors[1],
			borderWidth: 1,
			data: <?php echo json_encode($beverage_quality_data['points']); ?>
		}]
	};
	var bq_option = {
        title: {
            display: true,
            text: 'Beverage Quality'
        },
		legend: {
			display: false
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					maxTicksLimit: 6
				}
			}]
		}
    }	
	var bqChart = new Chart(bq_chart, {
		type: "bar",
		data: bq_data,
		options: bq_option
	});

	//Setup for Food Quality (Excellence)Chart
	var fq_data = {
		labels: <?php echo json_encode($food_quality_data1['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: bg_colors[1],
			borderColor: hover_colors[1],
			borderWidth: 1,
			data: <?php echo json_encode($food_quality_data1['points']); ?>
		}]
	};
	var fq_option = {
        title: {
            display: true,
            text: 'Food Quality (Excellence) Chart'
        },
		legend: {
			display: false
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					maxTicksLimit: 6
				}
			}]
		}
    }	
	var fqChart = new Chart(fq_chart, {
		type: "bar",
		data: fq_data,
		options: fq_option
	}); 
	
	//Setup for Food Quality (tasty and flavor) Chart
	var fq2_data = {
		labels: <?php echo json_encode($food_quality_data2['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: bg_colors[1],
			borderColor: hover_colors[1],
			borderWidth: 1,
			data: <?php echo json_encode($food_quality_data2['points']); ?>
		}]
	};
	var fq2_option = {
        title: {
            display: true,
            text: 'Food Quality (Taste)'
        },
		legend: {
			display: false
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					maxTicksLimit: 6
				}
			}]
		}
    }	
	var fq2Chart = new Chart(fq2_chart, {
		type: "bar",
		data: fq2_data,
		options: fq2_option
	});

	//Setup for Value Chart
	var v_data = {
		labels: <?php echo json_encode($value_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($value_data['points']); ?>
		}]
	};
	var v_option = {
        title: {
            display: true,
            text: 'Value for money'
        },
		legend: {
			display: false
		},
		legendCallback: legends
		// scales: {
			// yAxes: [{
				// ticks: {
					// beginAtZero: true
				// }
			// }]
		// }
    }	
	var vChart = new Chart(v_chart, {
		type: "pie",
		data: v_data,
		options: v_option
	});

	//Setup for Ambassadors Chart
	var a_data = {
		labels: <?php echo json_encode($ambassador_data['labels']); ?>,
		datasets: [{
			label: "Respondse (%)",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($ambassador_data['points']); ?>
		}]
	};
	var a_option = {
        title: {
            display: true,
            text: 'Ambassadors'
        },
		legend: {
			display: false
		},
		legendCallback: legends
		// scales: {
			// yAxes: [{
				// ticks: {
					// beginAtZero: true
				// }
			// }]
		// }
    }	
	var aChart = new Chart(a_chart, {
		type: "pie",
		data: a_data,
		options: a_option
	});
	
	//Setup for Frequency Chart
	var f_data = {
		labels: <?php echo json_encode($frequency_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: timeline_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($frequency_data['points']); ?>
		}]
	};
	var f_option = {
        title: {
            display: true,
            text: 'Frequency Chart'
        },
		legend: {
			display: false
		},
		legendCallback: legends
		
    }	
	var fChart = new Chart(f_chart, {
		type: "doughnut",
		data: f_data,
		options: f_option
	});
	
	//$("#sclegends").html(aChart.generateLegend());
	//$("#rtlegends").html(vChart.generateLegend());
    $("#tllegends").html(fChart.generateLegend());
	
</script>