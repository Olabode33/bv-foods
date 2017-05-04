<?php
	include_once 'app/cls-dashboard.php';
	include_once 'utility/utility.php';

	$util_obj = new Utility();
	$dash_obj = new Dashboard();
	
	//Load Data
	$wait_time_data = $dash_obj->getDataForQuestion(3);
	$customer_rating_data = $dash_obj->getDataForQuestion(7);
	$service_rating_data = $dash_obj->getDataForQuestion(8);
	$waiter_relationship_data = $dash_obj->getDataForQuestion(4);
	$employee_relationship_data = $dash_obj->getDataForQuestion(5);
	$ambiance_level_data = $dash_obj->getDataForQuestion(6);
	$meal_service_data = $dash_obj->getDataForQuestion(9);
	$product_range_data = $dash_obj->getDataForQuestion(10);
	$beverage_quality_data = $dash_obj->getDataForQuestion(11);
	$food_quality_data1 = $dash_obj->getDataForQuestion(12);
	$food_quality_data2 = $dash_obj->getDataForQuestion(13);
	$food_quality_data3 = $dash_obj->getDataForQuestion(14);
	$value_data = $dash_obj->getDataForQuestion(15);
	$ambassador_data = $dash_obj->getDataForQuestion(16);
	$frequency_data = $dash_obj->getDataForQuestion(17);
	
	//echo json_encode($food_quality_data1['labels']);
	//echo json_encode($food_quality_data1['points']);
	
?>
<div class="col-xs-3">
	<!--Filter-->
	<p><span class="fa fa-filter"></span> Filter<hr></p>
	<select class="btn btn-primary btn-block" onchange="filter();">
		<option value="AllTime">All time</option>	
		<option value="year">Year</option>	
		<option value="month">Month</option>	
		<option value="week">Week</option>	
		<option value="day">Day</option>	
	</select>
	<hr>
	<!--Legends-->
	<b>Legends</b><hr>
	<span id="wtLegends"></span>
	<hr>
	<span id="sclegends"></span>
	<hr>
	<span id="rtlegends"></span>
	<hr>
	<span id="tllegends"></span>
</div>

<div class="col-xs-9">
	<!--Quick Facts-->
	<div class="row">
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
	</div>
	
	<!--Charts-->
	<div class="row">
		<div class="col-md-6">
				<canvas id="wt_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<canvas id="sr_chart" width="400" height="400"></canvas>
		</div>		
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-6">
			<canvas id="cx_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<canvas id="al_chart" width="400" height="400"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-6">
			<canvas id="wr_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<canvas id="er_chart" width="200" height="200"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-6">
			<canvas id="ms_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<canvas id="pr_chart" width="200" height="200"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-6">
			<canvas id="bq_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<canvas id="fq2_chart" width="400" height="400"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-6">
			<canvas id="fq_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<canvas id="v_chart" width="400" height="400"></canvas>
		</div>
	</div>
	<hr>
	
	<div class="row">
		<div class="col-md-6">
			<canvas id="a_chart" width="400" height="400"></canvas>
		</div>
		<div class="col-md-6">
			<canvas id="f_chart" width="400" height="400"></canvas>
		</div>
	</div>
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

	//General Variables
	var bg_colors = ["#8E44AD", "#F62459", "#6C7A89", "#F89406", "#03C9A9"];
	var hover_colors = ["#8E44AD", "#F62459", "#6C7A89", "#F89406", "#03C9A9"];
	
	//Colors::
	var scale_color = ["#E53935", "#D81B60", "#8E24AA", "#5E35B1", "#3949AB"];
	var scale_hover = ["#D32F2F", "#C2185B", "#7B1FA2", "#512DA8", "#303F9F"];
	
	var waittime_color = ["#FFB300", "#FB8C00", "#F4511E"];
	var waittime_hover = ["#FFA000", "#F57C00", "#E64A19"];
	
	//var service_color = ["#8E44AD", "#F62459", "#6C7A89", "#F89406", "#03C9A9"];
	
	var timeline_color = ["#FB8C00", "#FFB300", "#FDD835", "#C0CA33", "#7CB342"];
	
	var rate_color = ["#1E88E5", "#039BE5", "#00ACC1", "#00897B", "#43A047"];

	var wt_chart = $("#wt_chart");
	var cx_chart = $("#cx_chart");
	var sr_chart = $("#sr_chart");
	var wr_chart = $("#wr_chart");
	var er_chart = $("#er_chart");
	var al_chart = $("#al_chart");
	var ms_chart = $("#ms_chart");
	var pr_chart = $("#pr_chart");
	var bq_chart = $("#bq_chart");
	var fq_chart = $("#fq_chart");
	var fq2_chart = $("#fq2_chart");
	var v_chart = $("#v_chart");
	var a_chart = $("#a_chart");
	var f_chart = $("#f_chart");
	
	

	
	//SetUp for Waiting Time
	var wt_datas = {
		labels: <?php  echo json_encode($wait_time_data['labels']); ?>,
		datasets: [{
				label: "Response Count",
				backgroundColor: waittime_color,
				hoverBackgroundColor: waittime_hover,
				borderColor: '#ffffff',
				borderWidth: 1,
				data: <?php  echo json_encode($wait_time_data['points']); ?>,
			}]
	};
	var wt_options = {
		title: {
			display: true,
			text: 'Waiting Time Chart'
		},
		legend: {
			display: false
		},
		legendCallback: legends
	}
	var wtChart = new Chart(wt_chart, {
		type: 'polarArea',
		data: wt_datas,
		options: wt_options
	});
	$("#wtLegends").html(wtChart.generateLegend());
	
	//Setup for Service Rating Chart
	var sr_datas = {
		datasets: [{
			label: "Response Count",
			backgroundColor: "rgba(255,99,132,0.2)",
			borderColor: "rgba(255,99,132,1)",
			pointBackgroundColor: "rgba(255,99,132,1)",
			pointBorderColor: "#fff",
			pointHoverBackgroundColor: "#fff",
			pointHoverBorderColor: "rgba(255,99,132,1)",
			data: <?php echo json_encode($service_rating_data['points']); ?>
		}],
		labels: <?php echo json_encode($service_rating_data['labels']); ?>
	};
	var sr_options = {
        title: {
            display: true,
            text: 'Service Rating Chart'
        },
		scale: {
            reverse: false,
			ticks: {
				beginAtZero: true
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
				label: "Ratings Count",
				backgroundColor: bg_colors[3],
				borderColor: hover_colors[3],
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
		title: {
			display: true,
			text: 'Cusomer Experience Rating Chart'
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
			label: "Response Count",
			backgroundColor: bg_colors[1],
			borderColor: hover_colors[1],
			borderWidth: 1,
			data: <?php echo json_encode($waiter_relationship_data['points']); ?>
		}]
	};
	var wr_options = {
        title: {
            display: true,
            text: 'Server Relationship Chart'
        },
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
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
			label: "Response Count",
			backgroundColor: bg_colors[2],
			borderColor: hover_colors[2],
			borderWidth: 1,
			data: <?php echo json_encode($employee_relationship_data['points']); ?>
		}]
	};
	var er_option = {
        title: {
            display: true,
            text: 'Employee Relationship Chart'
        },
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
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
			label: "Response Count",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 3,
			data: <?php echo json_encode($ambiance_level_data['points']); ?>
		}]
	};
	var al_option = {
        title: {
            display: true,
            text: 'Ambiance Level to Customer Taste Chart'
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
			label: "Response Count",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($meal_service_data['points']); ?>
		}]
	};
	var ms_option = {
        title: {
            display: true,
            text: 'Completeness of Meal Service Chart'
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

	//Setup for Product Range Chart
	var pr_data = {
		labels: <?php echo json_encode($product_range_data['labels']); ?>,
		datasets: [{
			label: "Response Count",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($product_range_data['points']); ?>
		}]
	};
	var pr_option = {
        title: {
            display: true,
            text: 'Product Range Chart'
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
			label: "Response Count",
			backgroundColor: bg_colors[0],
			borderColor: hover_colors[0],
			borderWidth: 1,
			data: <?php echo json_encode($beverage_quality_data['points']); ?>
		}]
	};
	var bq_option = {
        title: {
            display: true,
            text: 'Beverage Quality Chart'
        },
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
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
			label: "Response Count",
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
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
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
			label: "Response Count",
			backgroundColor: bg_colors[2],
			borderColor: hover_colors[2],
			borderWidth: 1,
			data: <?php echo json_encode($food_quality_data2['points']); ?>
		}]
	};
	var fq2_option = {
        title: {
            display: true,
            text: 'Food Quality (Taste and Flavour) Chart'
        },
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
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
			label: "Response Count",
			backgroundColor: rate_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($value_data['points']); ?>
		}]
	};
	var v_option = {
        title: {
            display: true,
            text: 'Value Chart'
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
			label: "Respondse Count",
			backgroundColor: scale_color,
			borderColor: '#fff',
			borderWidth: 2,
			data: <?php echo json_encode($ambassador_data['points']); ?>
		}]
	};
	var a_option = {
        title: {
            display: true,
            text: 'Ambassadors Chart'
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
			label: "Response Count",
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
	
	var data2 = {
		labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
		datasets: [
			{
				label: "My First dataset",
				backgroundColor: "rgba(179,181,198,0.2)",
				borderColor: "rgba(179,181,198,1)",
				pointBackgroundColor: "rgba(179,181,198,1)",
				pointBorderColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointHoverBorderColor: "rgba(179,181,198,1)",
				data: [65, 59, 90, 81, 56, 55, 40]
			},
			{
				label: "My Second dataset",
				backgroundColor: "rgba(255,99,132,0.2)",
				borderColor: "rgba(255,99,132,1)",
				pointBackgroundColor: "rgba(255,99,132,1)",
				pointBorderColor: "#fff",
				pointHoverBackgroundColor: "#fff",
				pointHoverBorderColor: "rgba(255,99,132,1)",
				data: [28, 48, 40, 19, 96, 27, 100]
			}
		]
	};
	
	
	function filter(){
		var filt = $(event.currentTarget);
		var opt = filt.val();
		window.location.href = 'index.php?a=cms&s=dashboard&t='+opt;
	}
	
	//$('wt_chart').html(wtChart.generateLegend());
	
    var optionsPie = {
        responsive: true,
        scaleBeginAtZero: true,
		legend: {display: false},
     }

    $("#sclegends").html(alChart.generateLegend());
    $("#rtlegends").html(vChart.generateLegend());
    $("#tllegends").html(fChart.generateLegend());

</script>