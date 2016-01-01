<?php 
require("backend/Db.class.php");
$db = new DB();
$res = $db->getAll("CALL getMatches()");

?>
<!DOCTYPE html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<title>Match View</title>
</head>
<body>
<table class="table table-condensed table-bordered">
<tr>
<td class="text-center" style="width:10%">Match Number</td>
<td class="text-center" colspan="2" style="width:35%">Red Alliance</td>
<td class="text-center"  colspan="2" style="width:35%">Blue Alliance</td>
<td class="text-center" style="width:10%">Red Score</td>
<td class="text-center" style="width:10%">Blue Score</td>
</tr>
<?php
foreach($res as $match)
{
	// Get Scout ID Records
	$redAScout = $db->getAll("CALL getScoutRecord('" . $match['team_redA'] . "'," . $match['match_number'] . ")");
	$redBScout = $db->getAll("CALL getScoutRecord('" . $match['team_redB'] . "'," . $match['match_number'] . ")");
	$blueAScout = $db->getAll("CALL getScoutRecord('" . $match['team_blueA'] . "'," . $match['match_number'] . ")");
	$blueBScout = $db->getAll("CALL getScoutRecord('" . $match['team_blueB'] . "'," . $match['match_number'] . ")");
	
	echo "<tr>";
	echo "<td class=\"text-center\" style=\"width:50px\"><a href=\"match.php?match=" . $match['match_number'] . "\">---" . $match['match_number'] . "---</td>"; // Match Number
	//if(count($redAScout) == 1) // RedA
	$teamLink = 0;
	if($teamLink == 1)
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/scoutrecord.php?record=" . $redAScout[0]['id'] . "\">" . $match['team_redA'] . "</a></td>";
	}
	else
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/team.php?team=" . $match['team_redA'] . "\">" . $match['team_redA'] . "</a></td>"; 
	}
	
	//if(count($redBScout) == 1) // RedB
	if($teamLink == 1)
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/scoutrecord.php?record=" . $redBScout[0]['id'] . "\">" . $match['team_redB'] . "</a></td>";
	}
	else
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/team.php?team=" . $match['team_redB'] . "\">" . $match['team_redB'] . "</a></td>"; 
	}
	
	if($teamLink == 1) // BlueA
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/scoutrecord.php?record=" . $blueAScout[0]['id'] . "\">" . $match['team_blueA'] . "</a></td>";
	}
	else
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/team.php?team=" . $match['team_blueA'] . "\">" . $match['team_blueA'] . "</a></td>"; 
	}
	
	if($teamLink == 1) // BlueA
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/scoutrecord.php?record=" . $blueBScout[0]['id'] . "\">" . $match['team_blueB'] . "</a></td>";
	}
	else
	{
		echo "<td class=\"text-center\" style=\"width:75px\"><a href=\"/team.php?team=" . $match['team_blueB'] . "\">" . $match['team_blueB'] . "</a></td>"; 
	}
	if($match['redScore'] == null)
		echo "<td class=\"text-center\">---</td>";
	else
		echo "<td class=\"text-center\" >" . $match['redScore'] . "</td>";
	
	if($match['blueScore'] == null)
		echo "<td class=\"text-center\">---</td>";
	else
		echo "<td class=\"text-center\">" . $match['blueScore'] . "</td>";
	
	echo "</tr>";
}
// Output Matches
?>
</table>
</body>
</html>

