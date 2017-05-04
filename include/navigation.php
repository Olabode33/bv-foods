
<nav class="navbar navbar-default navbar-fixed-top" id="nav">
	
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navMenu" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="fa fa-bars"  style="height:40px; width:40px; color: #fff; font-size:40px;"></span>
			</button>

			<a class="navbar-brand" id="navBrand" href="index.php?a=login&s=exit">
				<div class="nav-icon">
					<img src="assets/images/UtaziNG.jpg" class="img- img-rounded" height="60px" width="auto"/> 
				</div>
				<?php //echo '<b>&nbsp;'.((isset($_SESSION['restaurant_id']))?$_SESSION['restaurant']:'BV Foods').'</b>'; ?><!--small class="text-primary"> <b>Restaurants</b></small-->
			</a>	
		</div>
		
		<div  class="collapse navbar-collapse"  id="navMenu">   
			<ul class="nav navbar-nav navbar-right" >
				<?php
					if($action != 'menu' || $action != 'place-order' )
						echo '<li '.(($action == 'actions')?'class="active"': '').'>
									<a href="index.php?a=actions" style="text-align: center;">
										<div class="nav-icon">
											<img src="assets/icons/restaurant_set/restaurant.svg" class="img-responsive img-rounded" height="40px" width="40px"/>  
										</div>
										Home
									</a>
								 </li>';
					if(isset($_SESSION['table_id']) && $_SESSION['table_id'] != 0)
						echo '<li '.(($action == 'menu')?'class="active"': '').'>
									<a href="index.php?a=actions" style="text-align: center;">
										<div class="nav-icon">
											<img src="assets/icons/restaurant_set2/table.svg" class="img-responsive img-rounded" height="40px" width="40px"/>  
										</div>
										'.$_SESSION['table'].'
									</a>
								 </li>';
					if(isset($_SESSION['table_id']) && $_SESSION['table_id'] != 0){
						echo '<li '.(($action == 'place-order')?'class="active"': '').'>
									<a href="index.php?a=place-order" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle" style="text-align: center;">
										<div class="nav-icon">
											<img src="assets/icons/restaurant_set/dish.svg" class="img-responsive img-rounded" height="40px" width="40px"/>  
										</div>
										Item'.((isset($_SESSION['order']) && count($_SESSION['order']) != 1)?'':'s').' <span id="order_count" class="badge"> '.((isset($_SESSION['order']))?count($_SESSION['order']):' 0').'</span>
									</a>';
									if(isset($_SESSION['order']) && count($_SESSION['order']) > 0){
										echo '<ul class="dropdown-menu" role="menu">';
										foreach($_SESSION['order'] as $id=>$value){
												echo '<li>'.$id.'</li>';
											}
										echo '</ul>';
										}
						echo '</li>';
					}
					if(isset($_SESSION['user']))
						echo '<li>
									<a href="index.php?a=actions" style="text-align: center;">
										<div class="nav-icon">
											<img src="assets/icons/restaurant_set/waiter.svg" class="img-responsive img-rounded" height="40px" width="40px"/> 
										</div>
										'.$_SESSION['fname'].' '.$_SESSION['lname'].' ('.$_SESSION['role'].')
									</a>
								 </li>';
				?>
			</ul>
		</div>
	</div>
	
	<div class="container-fluid orange" style="height:8px;"></div>
</nav>


