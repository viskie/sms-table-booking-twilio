<?php  
include_once('library/Config.php');
include_once("library/checkSession.php");
include_once("library/commonFunctions.php");
include_once("library/constants.php");
/* Choose Turboadmin layout
 * 
 * ''                     => leave empty for default fixed layout
 * 'fluid'                => fluid layout
 * 'fixed-adminbar'       => fixed layout + fixed adminbar
 * 'fluid-fixed-adminbar' => fluid layout + fixed adminbar
 * 
 */
$turboadmin_layout = '';

?>

<head>

    <title><?php echo $page_title; ?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="author" content="pixelcave" />
    <meta name="robots" content="nofollow" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" />
    


    <!-- Jquery plugins styles -->
    <!-- Include all the corresponding plugin styles depending on the plugins you would like to use -->
    <link type="text/css" rel="stylesheet" href="css/jquery-ui-1.8.11.custom.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.fullcalendar.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.fullcalendar.print.css" media="print" />
    <link type="text/css" rel="stylesheet" href="css/jquery.tiptip.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.wysiwyg.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.uniform.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.apprise.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.datatables.css" />
        <!-- TurboAdmin main style -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />
     
     <script src="js/jquery-1.5.2.min.js"></script>

<!-- Jquery UI, used for FullCalendar, Autocomplete & Datepicker-->
<script src="js/jquery-ui-1.8.11.custom.min.js"></script>

<!-- Flot, jquery plugin for graphs -->
<script src="js/jquery.flot.min.js"></script>

<!-- FullCalendar, jquery plugin for calendar -->
<script src="js/jquery.fullcalendar.js"></script>

<!-- WYSIWYG, jquery plugin for textarea wysiwyg editor -->
<script src="js/jquery.wysiwyg.js"></script>

<!-- Tabify, jquery plugin for tabs -->
<script src="js/jquery.tabify.js"></script>

<!-- Limit, jquery plugin for twitter limit character -->
<script src="js/jquery.limit.js"></script>

<!-- Tiptip, jquery plugin for tooltips -->
<script src="js/jquery.tiptip.js"></script>

<!-- Elastic, jquery plugin for auto expanding textareas -->
<script src="js/jquery.elastic.js"></script>

<!-- Uniform, jquery plugin for styling form elements -->
<script src="js/jquery.uniform.js"></script>

<!-- Apprise, jquery plugin for modals -->
<script src="js/jquery.apprise.js"></script>

<!-- DataTables, jquery plugin for table data handling -->
<script src="js/jquery.dataTables.min.js"></script>

<!-- Custom javascript code for TurboAdmin -->
<script src="js/page.js"></script>

     <script type="text/javascript" src="js/main.js" ></script>
     <script type="text/javascript" src="js/userManagement.js" ></script>

<!-- END Javascript code -->

</head>
