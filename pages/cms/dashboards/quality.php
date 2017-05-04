<?php
	
	//Load Data
	$customer_rating_data = $dash_obj->getDataForQuestion(7, $age_f, $gender_f);
	$service_rating_data = $dash_obj->getDataForQuestion(8, $age_f, $gender_f);
	$waiter_relationship_data = $dash_obj->getDataForQuestion(4, $age_f, $gender_f);
	$employee_relationship_data = $dash_obj->getDataForQuestion(5, $age_f, $gender_f);
	$ambiance_level_data = $dash_obj->getDataForQuestion(6, $age_f, $gender_f);
	$meal_service_data = $dash_obj->getDataForQuestion(9, $age_f, $gender_f);
	
	//echo json_encode($waiter_relationship_data['labels']);
	//echo json_encode($waiter_relationship_data['points']);
	
	$service_rating_label = array();
	foreach($service_rating_data['labels'] as $label){
		array_push($service_rating_label, substr($label, 0, 1));
	}
	
	//echo json_encode($service_rating_label);
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
	<div class="legend">
		<?php
			for($i = 0; $i < count($service_rating_label); $i++){
				echo '<p><span style="background-color: #afafaf; font-size: 8px;">'.$service_rating_label[$i].' </span> '.$service_rating_data['labels'][$i].'</p>';
			}
		?>
	</div>
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
			<canvas id="sr_chart" width="400" height="400"></canvas>
		</div>		
		<div class="col-md-4">
			<canvas id="cx_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-4">
			<canvas id="al_chart" width="400" height="400"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-4">
			<canvas id="wr_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-4">
			<canvas id="er_chart" width="200" height="200"></canvas>
		</div>
		<div class="col-md-4">
			<canvas id="ms_chart" width="400" height="400"></canvas>
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
	
	var cx_chart = $("#cx_chart");
	var sr_chart = $("#sr_chart");
	var wr_chart = $("#wr_chart");
	var er_chart = $("#er_chart");
	var al_chart = $("#al_chart");
	var ms_chart = $("#ms_chart");
	
	//Setup for Service Rating Chart
	var sr_datas = {
		datasets: [{
			label: "Response (%)",
			backgroundColor: "rgba(255,99,132,0.2)",
			borderColor: "rgba(255,99,132,1)",
			pointBackgroundColor: "rgba(255,99,132,1)",
			pointBorderColor: "#fff",
			pointHoverBackgroundColor: "#fff",
			pointHoverBorderColor: "rgba(255,99,132,1)",
			data: <?php echo json_encode($service_rating_data['points']); ?>
		}],
		labels: <?php echo json_encode($service_rating_label); ?>
	};
	var sr_options = {
        title: {
            display: true,
            text: 'Preferred Service Area'
        },
		legend: {
			display: false
		},
		scale: {
            reverse: false,
			ticks: {
				beginAtZero: true,
				maxTicksLimit: 6
			}
		}
    }	
	var srChart = new Chart(sr_chart, {
		type: 'radar',
		data: sr_datas,
		options: sr_options
	});
	
	//SetUp for Customer Experience 
	var cx_data = {
		labels: <?php  echo json_encode($customer_rating_data['labels']); ?>,
		datasets: [
			{
				label: "Ratings (%)",
				backgroundColor: bg_colors[1],
				borderColor: hover_colors[1],
				borderWidth: 1,
				data: <?php  echo json_encode($customer_rating_data['points']); ?>,
			}
		]
	};
	var cx_option = {
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
				}
			}]
		},
		legend: {
			display: false
		},
		title: {
			display: true,
			text: 'Cusomer Experience'
		}
	}
	var cxChart = new Chart(cx_chart, {
		type: 'bar',
		data: cx_data,
		options: cx_option
	})
	
	//Setup for Server Relationship Chart
	var wr_datas = {
		labels: <?php echo json_encode($waiter_relationship_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: bg_colors[1],
			borderColor: hover_colors[1],
			borderWidth: 1,
			data: <?php echo json_encode($waiter_relationship_data['points']); ?>
		}]
	};
	var wr_options = {
        title: {
            display: true,
            text: 'Attendant Relationship'
        },
		legend: {
			display: false
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					maxTicksLimit: 5
				}
			}]
		}
    }	
	var wrChart = new Chart(wr_chart, {
		type: "bar",
		data: wr_datas,
		options: wr_options
	});
	
	//Setup for Employee Relationship Chart
	var er_data = {
		labels: <?php echo json_encode($employee_relationship_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: bg_colors[1],
			borderColor: hover_colors[1],
			borderWidth: 1,
			data: <?php echo json_encode($employee_relationship_data['points']); ?>
		}]
	};
	var er_option = {
        title: {
            display: true,
            text: 'Employee Relationship'
        },
		legend: {
			display: false
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					maxTicksLimit: 5
				}
			}]
		}
    }	
	var erChart = new Chart(er_chart, {
		type: "bar",
		data: er_data,
		options: er_option
	});
	
	//Setup for Ambiance Level Chart
	var al_data = {
		labels: <?php echo json_encode($ambiance_level_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 3,
			data: <?php echo json_encode($ambiance_level_data['points']); ?>
		}]
	};
	var al_option = {
        title: {
            display: true,
            text: 'Ambiance'
        },
		legend: {
			display: false
		},
		legendCallback: legends
    }	
	var alChart = new Chart(al_chart, {
		type: "doughnut",
		data: al_data,
		options: al_option
	});
	
	//Setup for Meal Service Chart
	var ms_data = {
		labels: <?php echo json_encode($meal_service_data['labels']); ?>,
		datasets: [{
			label: "Response (%)",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($meal_service_data['points']); ?>
		}]
	};
	var ms_option = {
        title: {
            display: true,
            text: 'Completeness of Meal Served'
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
	var msChart = new Chart(ms_chart, {
		type: "pie",
		data: ms_data,
		options: ms_option
	});

	//$("#sclegends").html(alChart.generateLegend());
	
</script>