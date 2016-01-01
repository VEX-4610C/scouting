<?php
error_reporting(0);
require("backend/Db.class.php");
$db = new DB();


// Lookup Tables for Pit Scouting Data
$drivetypeLookup = array( // Driver Control Strategy
	1 => "Tank Drive",
	2 => "H Drive",
	3 => "Mecanum Wheel Drive",
	4 => "X Drive",
	5 => "Kiwi Drive",
	6 => "Other"
); 
$intakeballhold = array( // Driver Control Strategy
	0 => "Zero Balls",
	1 => "One Ball",
	2 => "Two Balls",
	3 => "Three Balls",
	4 => "Four Balls"
); 
$shoottype = array( // Driver Control Strategy
	1 => "Double Flywheel",
	2 => "Single Flywheel",
	3 => "Puncher",
	4 => "Catapult",
	5 => "Kicker"
); 
$goalaimed = array( // Driver Control Strategy
	1 => "High",
	2 => "Low",
	3 => "Both"
); 
$shootspeed = array( // Driver Control Strategy
	0 => "More Than One Ball Per Second",
	1 => "One Ball Per Second",
	2 => "One Ball Per Two Seconds",
	3 => "One Ball Per Three Seconds",
	4 => "Less than One Ball Per Three Seconds"
); 
$autodesc = array( // Driver Control Strategy
	0 => "None",
	1 => "One Ball",
	2 => "Two Ball",
	3 => "Three Ball",
	4 => "Four Ball"
); 
$elevationpossiblities = array( // Driver Control Strategy
	1 => "None",
	2 => "High Elevation",
	3 => "Low Elevation"
); 
$driverstrat = array( // Driver Control Strategy
	1 => "Driver Loads",
	2 => "Field Bot",
	3 => "Mix"
); 
$scoredballsdriver = array( // Driver Control Strategy
	1 => "0-5 Balls",
	2 => "5-10 Balls",
	3 => "10-15 Balls",
	4 => "15-20 Balls",
	5 => "20-30 Balls",
	6 => "More than 30 Balls",
); 
$timeforele = array( // Driver Control Strategy
	1 => "0-5 Seconds",
	2 => "5-10 Seconds",
	3 => "10-20 Seconds",
	4 => "More than 20 Seconds"
); 
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<title>Scout Record For Team <?php echo $_GET['team']; ?></title>
	</head>
	<body>
	<h1>Scouting Record for Team #<?php echo $_GET['team']; ?></h1>
	<h2>Pit Scouting Record</h2>
	<table style="text-align: center" class="table table-condensed table-bordered"
	<thead>
	<tr style="background: #BBBBBB">
		<td style="width: 50%;">Stat</td>
		<td style="width: 50%;">Value</td>
	</tr>
	</thead>
	<?php
	$db->bind("team", $_GET['team']);
	$pitscout = $db->getAll("CALL getPitScoutRecord(:team)")[0];
	if(count($pitscout))
	{
		echo "<tr><td>Drive Type</td><td>" . $drivetypeLookup[$pitscout['drivetype']] . "</td></tr>";
		echo "<tr><td># of Balls Intake Holds</td><td>" . $intakeballhold[$pitscout['intakehold']] . "</td></tr>";
		echo "<tr><td>Shooter Type</td><td>" . $shoottype[$pitscout['shootertype']] . "</td></tr>";
		
		echo "<tr><td>Goal Aimed At</td><td>" . $goalaimed[$pitscout['aimedgoal']] . "</td></tr>";
		echo "<tr><td>Shooter Speed</td><td>" . $shootspeed[$pitscout['shooterspeed']] . "</td></tr>";
		echo "<tr><td>Auto Description</td><td>" . $autodesc[$pitscout['autodesc']] . "</td></tr>";
		echo "<tr><td>Possibility of Elevation</td><td>" . $elevationpossiblities[$pitscout['eleposs']] . "</td></tr>";
		echo $pitscout['eleposs'] != '1' ? "<tr><td>Elevation Speed</td><td>" . $timeforele[$pitscout['elespeed']] . "</td></tr>" : "";
		echo "<tr><td>Balls Scored During Driver Control</td><td>" . $scoredballsdriver[$pitscout['drivercontrolballs']] . "</td></tr>";
		echo "<tr><td>Driver Control Strategy</td><td>" . $driverstrat[$pitscout['driverstrat']] . "</td></tr>";
	}
	?>
	</table>
	<h2>Match Schedule</h2>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<td class="text-center" style="width:10%">Match Number</td>
				<td class="text-center" colspan="2" style="width:35%">Red Alliance</td>
				<td class="text-center"  colspan="2" style="width:35%">Blue Alliance</td>
				<td class="text-center" style="width:10%">Red Score</td>
				<td class="text-center" style="width:10%">Blue Score</td>
			</tr>
		</thead>
	<?php
	$db->bind("team", $_GET['team']);
	$matches = $db->getAll("CALL getMatchesByTeam(:team)");
	foreach($matches as $res)
	{
		echo "<tr><td class=\"text-center\">" . $res['match_number'] . "</td>";
		echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_redA'] . "\">" . $res['team_redA'] . "</a></td>";
		echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_redB'] . "\">" . $res['team_redB'] . "</a></td>";
		echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_blueA'] . "\">" . $res['team_blueA'] . "</a></td>";
		echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_blueB'] . "\">" . $res['team_blueB'] . "</a></td>";
		echo "<td class=\"text-center\">" . $res['redScore'] . "</td>";
		echo "<td class=\"text-center\">" . $res['blueScore'] . "</td></tr>";
	}

	?>

	</table>
	<h2>Match Scouting Records</h2>

	<?php

	
	
	$tables = array_chunk($matches, 4);
	
	foreach($tables as $table)
	{
			echo "<table class=\"table table-condensed table-bordered\">";
			echo "<thead><tr>";
		echo "<td class=\"text-center\" style=\"width:10%\">Stat</td>";
		echo "<td class=\"text-center\" style=\"width:22.5%\">Match #" . $table[0]['match_number'] . "</td>";
		echo isset($table[1]) ? "<td class=\"text-center\" style=\"width:22.5%\">Match #" . $table[1]['match_number'] . "</td>" : "<td></td>"; 
		echo isset($table[2]) ? "<td class=\"text-center\" style=\"width:22.5%\">Match #" . $table[2]['match_number'] . "</td>" : "<td></td>";
		echo isset($table[3]) ? "<td class=\"text-center\" style=\"width:22.5%\">Match #" . $table[3]['match_number'] . "</td>" : "<td></td>";
		echo "</tr></thead>";
		
		$db->bind("match", $table[0]['match_number']);
		$db->bind("team", $_GET['team']);
		$matchA = $db->getAll("CALL getScout(:match, :team)")[0];

		if(isset($table[1])) {
		$db->bind("match", $table[1]['match_number']);
		$db->bind("team", $_GET['team']);
		$matchB = $db->getAll("CALL getScout(:match, :team)")[0];
		}
		else
		{
			$matchB = array();
		}
		if(isset($table[2])) {
		$db->bind("match", $table[2]['match_number']);
		$db->bind("team", $_GET['team']);
		$matchC = $db->getAll("CALL getScout(:match, :team)")[0];
		}
		else
		{
			$matchC = array();
		}
		if(isset($table[3])) {
		$db->bind("match", $table[3]['match_number']);
		$db->bind("team", $_GET['team']);
		$matchD = $db->getAll("CALL getScout(:match, :team)")[0];
		}
		else
		{
			$matchD = array();
		}
		echo '<tr><td style="width:10%">Team Showed Up</td>';
		$text = isset($matchA['showedup']) ? $matchA['showedup'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text . '</td>';
		$text = isset($matchB['showedup']) ? $matchB['showedup'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text. '</td>';
		$text = isset($matchC['showedup']) ? $matchC['showedup'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text.  '</td>';
		$text = isset($matchD['showedup']) ? $matchD['showedup'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text .  '</td></tr>';

		echo '<tr><td style="width:10%">Team Function Entire Match</td>';
		$text = isset($matchA['functionalentirematch']) ? $matchA['functionalentirematch'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text . '</td>';
		$text = isset($matchB['functionalentirematch']) ? $matchB['functionalentirematch'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text. '</td>';
		$text = isset($matchC['functionalentirematch']) ? $matchC['functionalentirematch'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text.  '</td>';
		$text = isset($matchD['functionalentirematch']) ? $matchD['functionalentirematch'] == '1' ? "Yes" : "No" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text .  '</td></tr>';

		echo '<tr><td style="width:10%">Starting Position</td>';
		$text = isset($matchA['startingposition']) ? $matchA['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text . '</td>';
		$text = isset($matchB['startingposition']) ? $matchB['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text. '</td>';
		$text = isset($matchC['startingposition']) ? $matchC['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text.  '</td>';
		$text = isset($matchD['startingposition']) ? $matchD['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
		echo '<td class="text-center" style="width:22.5%">' . $text .  '</td></tr>';

		echo '<tr><td style="width:10%">Auto Shots Made</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchA['automade'] . '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchB['automade']. '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchC['automade'].  '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchD['automade'] .  '</td></tr>';

		echo '<tr><td style="width:10%">Auto Shots Missed</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchA['automissed'] . '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchB['automissed']. '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchC['automissed'].  '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchD['automissed'] .  '</td></tr>';

		echo '<tr><td style="width:10%">Driver Shots Made</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchA['drivermade'] . '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchB['drivermade']. '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchC['drivermade'].  '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchD['drivermade'] .  '</td></tr>';

		echo '<tr><td style="width:10%">Driver Shots Made Low Goal</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchA['driverlow'] . '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchB['driverlow']. '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchC['driverlow'].  '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchD['driverlow'] .  '</td></tr>';

		echo '<tr><td style="width:10%">Driver Shots Missed</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchA['drivermissed'] . '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchB['drivermissed']. '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchC['drivermissed'].  '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchD['drivermissed'] .  '</td></tr>';

		echo '<tr><td style="width:10%">Stacks Intaked</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchA['stacksintaked'] . '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchB['stacksintaked']. '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchC['stacksintaked'].  '</td>';
		echo '<td class="text-center" style="width:22.5%">' . $matchD['stacksintaked'] .  '</td></tr>';
		echo '</table>';
	}
	?>
	</body>
</html>

