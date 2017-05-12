<?php
ob_start( );

$action = 'login';
if (isset($_GET['a']) && isset($_SESSION['user_id'])) {
	$action = $_GET['a'];
}
// elseif(isset($_SESSION['restuarant_id']))
	// $action = "home";
// else
	// $action = "login";

$title = ucfirst($action);
//require_once 'include/header.php';
//include 'include/navigation.php';
require_once 'include/new-top.php';
require_once 'include/new-header.php';
//--------------------------------
?>

	<div class="container-fluid">
		<div class="container" style="background-color: #FFFAFA;">
		<?php
			if(isset($_SESSION['feedback'])){
				echo '<div class="">';
				echo $_SESSION['feedback'];
				echo '</div>';

				unset($_SESSION['feedback']);
			}
		?>
		</div>
		<div class="">
			<?php
				require 'pages/'.$action.'.php';
			?>
		</div>
	</div>
	<script>
		// if('serviceWorker' in navigator){
			// window.addEventListener('load', function() {
				// navigator.serviceWorker.register('sw.js').then(function(registration) {
					//Registration Successfull
					// console.log('ServiceWorker registration successful with scope: ', registration.scope);
				// }, function (err) {
					//registration failed
					// console.log('ServiceWorker registration failed:', err);
				// } 
				
				// )
			// });
		// }
	</script>
<?php
//--------------------------------
//require_once 'include/footer.php';
require_once 'include/new-footer.php';
ob_flush();
ob_end_clean();
?>
