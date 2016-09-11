<?php error_reporting(E_ALL); ini_set('display_errors', 'On'); set_time_limit(0);

session_start();
// Variables used by included files for different pages
//echo "<pre>"; print_r($_SESSION); 
$page_title = 'Classy-SMS-Service - Dashboard';
$page_name ="";
if(isset($_REQUEST['page']))
{
	$page_name  = $_REQUEST['page'];
}
?>
<!DOCTYPE html>
<html>

    <!-- Include head tag -->
  <?php include_once('inc/01_head.php'); ?>

    <!--
        If you would like to change the layout of TurboAdmin just add one of the following classes to body element
        
        Fixed layout + Fixed Adminbar: 'fixed-adminbar'
        Fluid layout: 'fluid'
        Fluid layout + Fixed Adminbar: 'fluid-fixed-adminbar'
    
        In PHP version you can change the layout style from the inc/01_head.php
    -->
    <body<?php if ($turboadmin_layout) echo ' class="'.$turboadmin_layout.'"'; ?>>
    <form action="" method="post" name="mainForm" id = "mainForm" />
	<input type="hidden" name="page" id="page" value="" />
	<input type="hidden" name="function" id="function" value="" />
	
		<!-- Container -->
		<div id="container">

            <!-- Include Adminbar -->
			<?php include('inc/02_adminbar.php'); ?>

			<!-- Panel Outer -->
			<div id="panel-outer" class="radius">

				<!-- Panel -->
				<div id="panel" class="radius">

                    <!-- Include main menu -->
                    <?php include('inc/03_menu.php'); ?>
					<!- - Main Controller -->
					<? require_once('controller.php'); ?>
					<!-- Controller Ends -->
                    <!-- Include Footer -->
					<?php include('inc/04_footer.php'); ?>

				</div>
				<!-- END Panel -->

			</div>
			<!-- END Panel Outer -->

		</div>
		<!-- END Container -->

		<!-- Push -->
		<div class="push"></div>
		<!-- END Push -->

        <!-- Include Javascript -->
        <?php include('inc/05_scripts.php'); ?>
        
        
        </form>

	</body>

</html>

<?
//echo $page."<br />";
//echo $function;

?>


