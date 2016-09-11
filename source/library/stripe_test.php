<?php  error_reporting(-1);
// Stripe singleton
require('paymentManager.php');

$paymentObject = new PaymentManager();

$test = $paymentObject->getAllPlans();

