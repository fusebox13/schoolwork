<?php

/**
 *		CPS 276 Winter 2015-- Assignment 01
 * 	Aquarium Cost Estimator
 */

// first, some notes...

// <-- Comments in PHP can be added with two forward slashes -- the comment continues until the next line
#  <-- Or with an octothorp (hash sign)
/* <-- Or for mutiple lines,
		 sandwiched between these characters -->  */

		 
// Variables are identified with a dollar sign:
$a = 42;

// -------------------------------------------------------

// Your assignment is to calculate the following values...

$materials_cost = 0;		// cost of materials: glass, fish, water, etc
$labor_cost = 0;			// cost of putting it together
$total_cost = 0;			// the grand total
$time_required = 0;		// the total number of hours required
$total_fish = 0;			// total fish in a fully-stocked tank
$regular_fish = 0;
$fancy_fish = 0;
$tank_time=0;
$stock_time=0;

// here is the input... (no changes needed here)

//Changed from intval to floatval because dimensions are often fractional
$width = floatval(@$_REQUEST['width']);
$height = floatval(@$_REQUEST['height']);
$depth = floatval(@$_REQUEST['depth']);


$error='';


if ($width < 0 || $height < 0 || $depth < 0) {
    $error = 'Error: Dimensions cannot be negative.';
}
// you can set the following variable to a string, to report any errors at the end.

// Example: $error='Width cannot be a negative number.';


// START WORKING HERE...

// Part 1: Materials Cost

/*		
		A. Start by finding the total surface area of the aquarium. Assume that the aquarium is glass on all six sides. Store this as $glass_surface. Hint: (W*H)*2 + (W*D)*2 + (H*D)*2
		B. Also find the total volume of the aquarium, and store as $total_volume. Assume the tank will be filled completely to the top.
		C. Raw materials cost: glass costs $0.03 per cm/sq.
		D. Raw materials cost: purified water costs $0.001 per cm3 (cubic centimeter).
		E. Each fish requires 275 cm3 of space. Find the maximum number of fish that can fit in the tank. ** Hint: use the floor() function to round down.
		F. NOT more than 7% of the fish will be fancy fish ($1.98 each). There must be an even number of fancy fish. Add as many fancy fish as possible. The rest will be regular fish ($0.61 each).
		G. Add a small castle and lighting: $7.95
		H. The sum of C,D,F,and G and the total materials cost. 
*/

/*  Dimension calculations */
$glass_surface = ($width * $height) * 2 + ($width*$depth) * 2 +($height * $depth) * 2;
$total_volume = $width*$height*$depth;

//Print an error if the tank is too small to hold any fish.
if ($total_volume < 275 && ($width > 0 || $height > 0 || $depth > 0)) {
    $error = "Error: Tank is not large enough to hold any fish.";
}

/*  Fish population calculations and adjustments */
$total_fish = floor($total_volume/275);
$fancy_fish = floor(0.07 * $total_fish);
//If the amount of fancy fish is uneven, one is subtracted.
//Adding a fish pushes the fancy fish concentration above 7%
if ($fancy_fish % 2 != 0) {
    $fancy_fish--;
}
$regular_fish = $total_fish - $fancy_fish;

/*  Cost calculations */
$glass_cost = 0.03 * $glass_surface;
$water_cost = 0.001 * $total_volume;
$fancy_fish_cost = 1.98 * $fancy_fish;
$regular_fish_cost = 0.61 * $regular_fish;
$castle_and_lighting = 7.95;
$materials_cost = $glass_cost + $water_cost + $fancy_fish_cost + $regular_fish_cost;
//Prevents and erroneous total when all input(length/width/depth) are zero;
if ($materials_cost > 0)
    $materials_cost+=$castle_and_lighting;

// Part 2: Time Required

/*
		The time required will be used to calculate the labor costs
		A. There are two times to keep track of: time to construct the tank ($tank_time) and time to stock the fish ($stock_time), both measured in seconds.
		B. For the tank time, use the FOR loop below.
		   Start with x= the total volume of the tank (cm3)
		   The first side takes x seconds to construct
			Each successive side takes 10% less time than the previous
		C. Stock time is 3 seconds per fish.
		D. the total time is the sum of the tank time and the stock time, measured in minutes.
*/

/*  Time calculations */

/*  Tank time:
        Start with the first side, then add it to tank time, 
        reduce the side time by 10% and iterate 5 more times adding the reduced side
        time to the tank time during each iteration 
 */
$side_time = $total_volume;
for($i = 0; $i < 6; $i++){
    $tank_time += $side_time;
    $side_time *= 0.90;	
}

$stock_time = $total_fish*3;
$total_time_seconds = $tank_time + $stock_time;

/*  Time Conversions (Minutes/Hours) */
$total_time_minutes = $total_time_seconds / 60;
$total_time_hours = $total_time_minutes /60;
$time_required = number_format(ceil($total_time_minutes), 0);


// Part 3: Labor Costs and Grand Total

/* 	A. The staff are aquarium professionals, paid $33.71 per hour or portion thereof. ** Hint: round up to the nearest hour with the ceil() function
		B. Add $12 handling fee.
		C. Calculate the grand total (materials and labor and fees)
		D. There's a sale going on! If the total is greater than $250, give a 30% discount. If between $100-$249, give a 10% discount.
		E. Use the number_format function to alter the math precision for currency.
			Example: $amount = number_format($amount, 2);   -->  would turn 24.022278 into 24.02
*/
 
/*  Final cost calculations (Before discounts) */
$labor_cost = 33.71 * ceil($total_time_hours);
$handling_fee = 12.00;
$total_cost = $materials_cost + $labor_cost;
 
//Prevents erroneous total if all inputs(length/width/depth) are 0, and also will not format the other costs unless there is a total cost
//because formatting an empty string causes the output fields to show 0.00.
if ($total_cost > 0) { 
     
    $total_cost+=$handling_fee;

    /*  Discount calculations */
    if ($total_cost > 250.00) {
        $discount = $total_cost * 0.30;
    }
    else if ($total_cost >= 100 && $total_cost < 250) {
        $discount = $total_cost * 0.10;
    }
    else {
        $discount = 0;
    }
    
    /*  Number formatting */
    $labor_cost = "$".number_format($labor_cost, 2);
    $materials_cost = "$".number_format($materials_cost, 2);
    $total_cost = "$".number_format($total_cost - $discount, 2);
}


/*		What follows is the HTML form used to present the application.
 		No changes are needed beyond this point, but it's a good idea to look this over.
 		You will be making your own forms in future assignments. 

                Added title attribute so calculations can be seen on mouseover.
*/

echo $error;
?>
<form method='get' action='index.php'>
	<table border='1'>
		<tr>
			<th colspan='2'>Aquarium Cost Estimator</th>
		</tr>
		<tr>
			<td>Width</td>
			<td><input type='text' name='width' value='<?=@$_REQUEST['width']?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>Height</td>
			<td><input type='text' name='height' value='<?=@$_REQUEST['height']?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>Depth</td>
			<td><input type='text' name='depth' value='<?=@$_REQUEST['depth']?>' size='5'/> cm</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type='submit' value='Calculate'/></td>
		</tr>
		<tr>
			<th colspan='2'>Results</th>
		</tr>
		<tr>
			<td>Total Fish</td>
			<td title='<?="Regular Fish: ".$regular_fish." Fancy Fish: ".$fancy_fish?>'><?php if($total_fish) echo $total_fish.' ('.$fancy_fish.' fancy)'; else echo '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Materials Cost</td>
			<td title='<?="Glass: $glass_cost Water: $water_cost Fancy Fish: $fancy_fish_cost Regular Fish: $regular_fish_cost Castle and Lighting: $castle_and_lighting" ?>'><?=($materials_cost) ? $materials_cost: '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Labor Cost</td>
			<td title='<?="Total time(hours): $total_time_hours * $33.71 per hour"?>'><?=($labor_cost) ? $labor_cost : '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Total Cost</td>
			<td title='<?= "Material Cost: $materials_cost Labor Cost: $labor_cost Discount: $discount" ?>'><?=($total_cost) ? $total_cost : '&nbsp;'?></td>
		</tr>
		<tr>
			<td>Time Required</td>
			<td title='<?= "Tank time: $tank_time Stock time: $stock_time" ?>'><?=($time_required)?$time_required.' minutes':'&nbsp;'?></td>
		</tr>
	</table>
</form>







