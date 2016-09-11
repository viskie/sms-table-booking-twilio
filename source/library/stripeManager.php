<? error_reporting(-1);

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');
require(dirname(__FILE__) . '/stripe/Stripe.php');
Stripe::setApiKey('sk_test_2KlMZe3oQgWfmF18zsv0DMSB');

class StripeManager extends commonObject
{
		//Tested
		function getAllPlans()
		{
			$returnArr = Stripe_Plan::all();
			return $returnArr = json_decode($returnArr, true);
		}
		
		//Tested
		function createPlan($planDetails)
		{
			try 
			{
				$name = $planDetails['plan_name'];
				$planId = $planDetails['plan_id'];
				$amount = ((int)$planDetails['cost'])*(100);
				$returnArr = array();
				$returnArr = Stripe_Plan::create(array( "amount" => $amount, 
										"interval" => "month", 
										"name" => $name, 
										"currency" => "usd", 
										"id" => $planId) );
				$returnArr = json_decode($returnArr, true);
				$returnArr['stripeStatus'] = 1;
			}
			 catch (Exception $e) 
			{
				$returnArr['error'] = $e->getMessage();
				$returnArr['stripeStatus'] = 0;
			}
			return $returnArr;
		}
		
		function updatePlan($planDetails)
		{
			try 
			{
				$p = Stripe_Plan::retrieve($planDetails['plan_id']); 				
				$p->name = $planDetails['plan_name'];
				$p->save();
				$returnArr['stripeStatus'] = 1;
			}
			 catch (Exception $e) 
			{
				$returnArr['error'] = $e->getMessage();
				$returnArr['stripeStatus'] = 0;
			}
			return $returnArr;		
		}
		
		function deletePlan($resourceId)
		{
			$p = Stripe_Plan::retrieve($resourceId); 
			$plan->delete();
		}
		
		function createCustomer($customerDetails)
		{
			//echo "<pre>"; print_r($customerDetails); exit;			
			try 
			{
				$customerId = $customerDetails['customer_id'];
				$description = $customerDetails['customer_biz_name'];
				$email = $customerDetails['customer_email'];
				$plan = $customerDetails['customer_plan'];
				$card = array("number" => $customerDetails['card']['number'],
							  "exp_month" => $customerDetails['card']['exp_month'],
							  "exp_year" => $customerDetails['card']['exp_year'],
							  "cvc" => $customerDetails['card']['cvc'],
							  "name" => $customerDetails['card']['name']								
							 );
				
				$returnArr = array();
				$returnArr = Stripe_Customer::create(array( 
										"id" => $customerId, 
										"description" => $description, 
										"email" => $email, 
										"plan" => $plan,
										"card" => $card,
										) );
				$returnArr = json_decode($returnArr, true);
				$returnArr['stripeStatus'] = 1;
			}
			 catch (Exception $e) 
			{
				$returnArr['error'] = $e->getMessage();
				$returnArr['stripeStatus'] = 0;
			}
			return $returnArr;	
		}
		
		function updateCustomerPlan($customerId, $planId)
		{
			try 
			{
				$c = Stripe_Customer::retrieve($customerId);
				$returnArr = $c->updateSubscription(array("plan" => $planId, "prorate" => true));
				
				$returnArr = json_decode($returnArr, true);
				$returnArr['stripeStatus'] = 1;
			}
			 catch (Exception $e) 
			{
				$returnArr['error'] = $e->getMessage();
				$returnArr['stripeStatus'] = 0;
			}
			
			return $returnArr;			
		}
		
		function chargeForAddonPlan($customerId, $customerPlan)
		{
			$planDetails = getRow("select * from plans where plan_id='".$customerPlan."' ");
			try 
			{
				$returnArr = Stripe_Charge::create(array(
						  "amount" => ((int)$planDetails['cost']*100),
						  "currency" => "usd",
						  "customer" => $customerId,
						  "description" => "Charged for purchase of addon plan:".$planDetails['plan_name']
						  ));
				
				$returnArr = json_decode($returnArr, true);
				$returnArr['stripeStatus'] = 1;
			}
			 catch (Exception $e) 
			{
				$returnArr['error'] = $e->getMessage();
				$returnArr['stripeStatus'] = 0;
			}
			
			return $returnArr;			
		}
}

?>
