<?php
require("Db.class.php");
/*
Error Codes
-2: Incorrect Key
-3: Team or Match Incorrect
*/
function confirmKey($key)
{
	$listofkeys = array();
	$listofkeys[] = "oldman";
	foreach($listofkeys as $testKey)
	{
		if($key == $testKey)
		{
			return true;
		}
	}
	return false;
}
function API($db, $inputs)
{
	$mode = isset($inputs['MODE']) ? $inputs['MODE'] : $_POST['MODE'];
	if($mode == "finishScout")
	{
		if(!confirmKey($inputs['KEY'])) return array("status" => -2); // Confirm KEY
		$db->bind("match",$inputs['MATCH']);
		$result   =  $db->getAll("CALL getTeamsInMatch(:match)")[0];
		$teaminmatch = false;
		foreach($result as $t)
		{
			if($inputs['TEAM'] == $t)
				$teaminmatch = true;
		}
		if(!$teaminmatch)
			return array("status" => -3);
		

	  
		$db->bind("match",$inputs['MATCH']);
		$db->bind("team" ,$inputs['TEAM']);
		$db->bind("noshow",$inputs['SHOWED_UP']);
		$db->bind("startingposition",$inputs['STARTING_POSITION']); // 0: 
		$db->bind("functionalAllMatch",!$inputs['FUNCTION_ENTIRE_MATCH']);
		$db->bind("elevation",$inputs['ELEVATION']);
		$db->bind("elevationheight",$inputs['ELEVATION_HEIGHT']);
		$db->bind("elevationpart",$inputs['ELEVATION_PART']);
		$db->bind("autoshotmade",$inputs['AUTO_SHOTS_MADE']);
		$db->bind("autoshotsmissed",$inputs['AUTO_SHOTS_MISSED']);
		$db->bind("drivershotmade",$inputs['DRIVER_SHOTS_MADE']);
		$db->bind("driverlowshotsmade",$inputs['DRIVER_LOW_SHOTS_MADE']);
		$db->bind("drivershotsmissed",$inputs['DRIVER_SHOTS_MISSED']);
		$db->bind("stacksintaked",$inputs['STACKS_INTAKED']);
		$res = $db->getAll("CALL addScoutRecord(:match, :team, :noshow, :startingposition, :functionalAllMatch, :elevation, :elevationheight, :elevationpart, :autoshotmade, :autoshotsmissed, :drivershotmade, :driverlowshotsmade, :drivershotsmissed, :stacksintaked)");
		return array("status" => 1);
	}
	else if($mode == "addPitScout")
	{
		if(!confirmKey($inputs['KEY'])) return array("status" => -2); // Confirm KEY
		/*team_in, 
                                drivetype_in, 
                                intakehold_in,
                                shootertype_in, 
                                aimedgoal_in, 
                                shooterspeed_in, 
                                autodesc_in, 
                                eleposs_in, 
                                elespeed_in, 
                                drivercontrolballs_in, 
                                driverstrat_in);*/
		$db->bind("team_in",$inputs['team_in']);
		$db->bind("intakehold_in" ,$inputs['intakehold_in']);
		$db->bind("drivetype_in" ,$inputs['drivetype_in']);
		$db->bind("shootertype_in",$inputs['shootertype_in']);
		$db->bind("aimedgoal_in",$inputs['aimedgoal_in']); // 0: 
		$db->bind("shooterspeed_in",!$inputs['shooterspeed_in']);
		$db->bind("autodesc_in",$inputs['autodesc_in']);
		$db->bind("eleposs_in",$inputs['eleposs_in']);
		$db->bind("elespeed_in",$inputs['elespeed_in']);
		$db->bind("drivercontrolballs_in",$inputs['drivercontrolballs_in']);
		$db->bind("driverstrat_in",$inputs['driverstrat_in']);
		$res = $db->getAll("CALL addPitScout(:team_in, :drivetype_in, :intakehold_in, :shootertype_in, :aimedgoal_in, :shooterspeed_in, :autodesc_in, :eleposs_in, :elespeed_in, :drivercontrolballs_in, :driverstrat_in)");
		return array("status" => 1);
	}
	else if($mode == "submitMatches")
	{
		if(!confirmKey($_POST['KEY'])) return array("status" => -2); // Confirm KEY
		$matches = (array) json_decode($_POST['matches']);
		foreach($matches as $match)
		{
			$match = (array) $match;
			var_dump($match);
			var_dump($match['red a']);
			$db->bind("match_num",$match['match number']);
			$db->bind("rA",$match['red a']);
			$db->bind("rB",$match['red b']);
			$db->bind("bA",$match['blue a']);
			$db->bind("bB",$match['blue b']);
			$db->getAll("CALL addMatch(:match_num, :rA, :rB, :bA, :bB)");
			$db->bind("match_num",$match['match number']);
			$db->bind("rScore",$match['red score']);
			$db->bind("bScore",$match['blue score']);
			$db->getAll("CALL updateMatchScore(:rScore, :bScore, :match_num)");
		}
		return array("status" => 1);
		
	
	}
	else if($mode == "getMatches")
	{
	
		$res = $db->getAll("SELECT * FROM matches");
		return array("status" => 1, "result" => $res);
		
	
	}
}

$db = new DB();
$result = API($db, $_GET);
echo json_encode($result);
?>
