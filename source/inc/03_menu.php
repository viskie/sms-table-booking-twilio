<?
$permissionArray = getUserGroupPermissions();
//echo "<pre>"; print_r($permissionArray);
?>
<!-- Main menu -->
<!-- This is the structure of main menu -->
<ul id="main-menu" class="radius-top clearfix" >
  <? if($_SESSION['user_main_group'] == '1') { ?>
    <li>
        <!-- Make sure to include the class submenu-active if you are planning to have a submenu with this category/link -->
        <a href="javascript:callPage('<?=$permissionArray['Manage Customers']['page_name']?>','show_data')" <?php if ( $page_name == 'manage_customers.php' ) echo 'class="active submenu-active"'; ?>>
            <img src="img/customers.png" alt="Users" />
            <span>Customers</span>
            <span class="submenu-arrow"></span><!-- Also this is required for the submenu -->
        </a>
    </li>
    <li>
        <!-- Make sure to include the class submenu-active if you are planning to have a submenu with this category/link -->
        <a href="javascript:callPage('<?=$permissionArray['Manage Users']['page_name']?>','show_data')" <?php if ( $page_name == 'manage_users.php' ) echo 'class="active submenu-active"'; ?>>
            <img src="img/m-users.png" alt="Users" />
            <span>Users</span>
            <span class="submenu-arrow"></span><!-- Also this is required for the submenu -->
        </a>
    </li>
    <li>
        <!-- Make sure to include the class submenu-active if you are planning to have a submenu with this category/link -->
        <a href="javascript:callPage('manage_plans.php','show_data')" <?php if ( $page_name == 'manage_plans.php' ) echo 'class="active submenu-active"'; ?>>
            <img src="img/plans.png" alt="Users" />
            <span>Product Plans</span>
            <span class="submenu-arrow"></span><!-- Also this is required for the submenu -->
        </a>
    </li>
    <li>
        <!-- Make sure to include the class submenu-active if you are planning to have a submenu with this category/link -->
        <a href="javascript:callPage('view_payments.php','show_data')" <?php if ( $page_name == 'view_payments.php' ) echo 'class="active submenu-active"'; ?>>
            <img src="img/payments.png" alt="Users" />
            <span>View Payments</span>
            <span class="submenu-arrow"></span><!-- Also this is required for the submenu -->
        </a>
    </li>
    <li>
        <!-- Make sure to include the class submenu-active if you are planning to have a submenu with this category/link -->
        <a href="javascript:callPage('<?=$permissionArray['Activity Logs']['page_name']?>','show_data')" <?php if ( $page_name == 'view_Activity_logs.php' ) echo 'class="active submenu-active"'; ?>>
            <img src="img/m-statistics.png" alt="Activity" />
            <span>Activity Logs</span>
            <span class="submenu-arrow"></span><!-- Also this is required for the submenu -->
        </a>
    </li> 
    <li>
        <a href="javascript:callPage('<?=$permissionArray['Application Settings']['page_name']?>','show_data')" <?php if ( $page_name == 'settings.php' ) echo 'class="active"'; ?>>
            <img src="img/m-settings.png" alt="Settings" />
            <span>Settings</span>
        </a>
    </li>
    <? } ?>	
       
        <!-- Main menu - Hover -->
    
    <? if($_SESSION['user_main_group'] == '3') { ?>
     <li>
        <a href="javascript:callPage('<?=$permissionArray['Queue Managers']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Queue Managers']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/user-manager.png" alt="Queue Managers" />
            <span>Queue Managers</span>
        </a>
    </li>
    <li>
        <a href="javascript:callPage('<?=$permissionArray['Phone Numbers']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Phone Numbers']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/phone.png" alt="Phone Numbers" />
            <span>Phone Numbers</span>
        </a>
    </li>
    <li>
        <a href="javascript:callPage('<?=$permissionArray['Manage Client Customers']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Manage Client Customers']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/customers.png" alt="Customers" />
            <span>Customers</span>
        </a>
    </li>
    <li>
        <a href="javascript:callPage('<?=$permissionArray['Manage Queue']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Manage Queue']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/queue.png" alt="Queue" />
            <span>Queue</span>
        </a>
    </li>
     <li>
        <a href="javascript:callPage('<?=$permissionArray['View History']['page_name']?>','show_history')" <?php if ( $page_name == $permissionArray['View History']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/history.png" alt="View History" />
            <span>Queue History</span>
        </a>
    </li>
    <li>
        <a href="javascript:callPage('<?=$permissionArray['Broadcast']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Broadcast']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/broadcast.png" alt="Boradcast" />
            <span>Broadcast</span>
        </a>
    </li>
    <li>
        <a href="javascript:callPage('<?=$permissionArray['View Unsuscribers']['page_name']?>','show_unsub')" <?php if ( $page_name == $permissionArray['View Unsuscribers']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/unsub.png" width="50px" alt="Un-Subscribers" />
            <span>Un Subscribers</span>
        </a>
    </li>
    <li>
        <a href="javascript:callPage('<?=$permissionArray['Customer Profile']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Customer Profile']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/profile.png" alt="Profile" />
            <span>Profile</span>
        </a>
    </li>
    <!-- <li>
        <a href="javascript:callPage('<?=$permissionArray['Customer Settings']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Customer Settings']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/m-settings.png" alt="Settings" />
            <span>Settings</span>
        </a>
    </li>-->
    <? } ?>
    <? if($_SESSION['user_main_group'] == '4') { ?>
     <li>
        <a href="javascript:callPage('<?=$permissionArray['Manage Queue']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Manage Queue']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/queue.png" alt="Queue" />
            <span>Queue</span>
        </a>
    </li>
    <li>
        <a href="javascript:callPage('<?=$permissionArray['Add Store Customers']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['Add Store Customers']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/customers.png" alt="Add Customers" />
            <span>Add Customer</span>
        </a>
    </li>
     <li>
        <a href="javascript:callPage('<?=$permissionArray['User Profile']['page_name']?>','show_data')" <?php if ( $page_name == $permissionArray['User Profile']['page_name'] ) echo 'class="active"'; ?>>
            <img src="img/profile.png" alt="User Profile" />
            <span>My Profile</span>
        </a>
    </li>
     <? } ?>
    </li>
</ul>
<!-- END Main menu -->

<!-- Submenu -->
<!-- Depending on the page we are, we make visible the submenu we need -->
<? //echo "<pre>"; print_r($_REQUEST); exit; ?>
<?php if ( isset($_REQUEST['page'])) { if($_REQUEST['page'] == 'manage_customers.php' ) { ?>
<ul id="sub-menu" class="clearfix">
    <li><a href="javascript:callPage('manage_customers.php','show_data')" >View Customers</a></li>
    <li><a href="javascript:callPage('manage_customers.php','show_add_customer')"  >Add Customer</a></li>
</ul>
<? } } ?>
<?php if ( isset($_REQUEST['page'])) { if(($_REQUEST['page'] == 'view_phone_numbers.php') || (($_REQUEST['page'] == 'buy_phone_number.php'))) { ?>
<ul id="sub-menu" class="clearfix">
    <li><a href="javascript:callPage('view_phone_numbers.php','show_data')" >View Phone Numbers</a></li>
    <li><a href="javascript:callPage('buy_phone_number.php','buy_new')" >Buy Phone Number</a></li>
</ul>
<? } } ?>
<?php if ( isset($_REQUEST['page'])) { if(($_REQUEST['page'] == 'manage_plans.php') || (($_REQUEST['page'] == 'manage_plans.php'))) { ?>
<ul id="sub-menu" class="clearfix">
    <li><a href="javascript:callPage('manage_plans.php','show_data')" >View All Plans</a></li>
    <li><a href="javascript:callPage('manage_plans.php','add_plan')" >Add New Plan</a></li>
</ul>
<? } } ?>
<!-- END Submenu -->