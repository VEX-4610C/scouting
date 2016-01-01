<?php
require("backend/Db.class.php");
$db = new DB();
$res = $db->getAll("CALL getMatchInfo(" . $_GET['match'] . ")")[0];
$db->bind("match", $_GET['match']);
$db->bind("team", $res['team_redA']);
$redAScout = $db->getAll("CALL getScout(:match, :team)")[0];

$db->bind("match", $_GET['match']);
$db->bind("team", $res['team_redB']);
$redBScout = $db->getAll("CALL getScout(:match, :team)")[0];

$db->bind("match", $_GET['match']);
$db->bind("team", $res['team_blueA']);
$blueAScout = $db->getAll("CALL getScout(:match, :team)")[0];

$db->bind("match", $_GET['match']);
$db->bind("team", $res['team_blueB']);
$blueBScout = $db->getAll("CALL getScout(:match, :team)")[0];



?>
<!DOCTYPE html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<title>Match View</title>
</head>
<body>
<h1>Basic Match Info & Recap</h1><br>
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
<tr>
<?php
echo "<td class=\"text-center\">" . $res['match_number'] . "</td>";
echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_redA'] . "\">" . $res['team_redA'] . "</a></td>";
echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_redB'] . "\">" . $res['team_redB'] . "</a></td>";
echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_blueA'] . "\">" . $res['team_blueA'] . "</a></td>";
echo "<td class=\"text-center\"><a href=\"team.php?team=" . $res['team_blueB'] . "\">" . $res['team_blueB'] . "</a></td>";
echo "<td class=\"text-center\">" . $res['redScore'] . "</td>";
echo "<td class=\"text-center\">" . $res['blueScore'] . "</td>";

?>
</tr>
</table>
<h1>Match Scouting Info</h1>
<table class="table table-condensed table-bordered">
<thead>
<tr>
<td class="text-center" style="width:10%">Stat</td>
<td class="text-center" style="width:22.5%"><?php echo $res['team_redA']; ?> </td>
<td class="text-center" style="width:22.5%"><?php echo $res['team_redB']; ?> </td>
<td class="text-center" style="width:22.5%"><?php echo $res['team_blueA']; ?> </td>
<td class="text-center" style="width:22.5%"><?php echo $res['team_blueB']; ?> </td>
</tr>
</thead>
<?php
// Team Showed Up
echo '<tr><td style="width:10%">Team Showed Up</td>';
$text = isset($redAScout['showedup']) ? $redAScout['showedup'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text . '</td>';
$text = isset($redBScout['showedup']) ? $redAScout['showedup'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text. '</td>';
$text = isset($blueAScout['showedup']) ? $redAScout['showedup'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text.  '</td>';
$text = isset($blueBScout['showedup']) ? $redAScout['showedup'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text .  '</td></tr>';

echo '<tr><td style="width:10%">Team Function Entire Match</td>';
$text = isset($redAScout['functionalentirematch']) ? $redAScout['functionalentirematch'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text . '</td>';
$text = isset($redBScout['functionalentirematch']) ? $redBScout['functionalentirematch'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text. '</td>';
$text = isset($blueAScout['functionalentirematch']) ? $blueAScout['functionalentirematch'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text.  '</td>';
$text = isset($blueBScout['functionalentirematch']) ? $blueBScout['functionalentirematch'] == '1' ? "Yes" : "No" : "";
echo '<td class="text-center" style="width:22.5%">' . $text .  '</td></tr>';

echo '<tr><td style="width:10%">Starting Position</td>';
$text = isset($redAScout['startingposition']) ? $redAScout['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
echo '<td class="text-center" style="width:22.5%">' . $text . '</td>';
$text = isset($redBScout['startingposition']) ? $redBScout['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
echo '<td class="text-center" style="width:22.5%">' . $text. '</td>';
$text = isset($blueAScout['startingposition']) ? $blueAScout['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
echo '<td class="text-center" style="width:22.5%">' . $text.  '</td>';
$text = isset($blueBScout['startingposition']) ? $blueBScout['startingposition'] == '1' ? "Goal Wall" : "Driver Station Wall" : "";
echo '<td class="text-center" style="width:22.5%">' . $text .  '</td></tr>';

$redEleText = array();
$blueEleText = array();
if(isset($redAScout['elevation']) && isset($redBScout['elevation']))
{
	if($redAScout['elevation'] ||  $redBScout['elevation']== '1')
	{
		$redEleText[0] = '<td colspan=2 class="text-center" style="width:45%">' . 'Elevation Completed' . '</td>';
		$text = $redAScout['elevationheight'] == '1' ||  $redBScout['elevationheight']? "High Elevation" : "Low Elevation";
		$redEleText[1] = '<td colspan=2 class="text-center" style="width:45%">' . $text . '</td>';
		$APart = $redAScout['elevationpart'] == '1' ? "Elevator" : "Elevatee";
		$BPart = $redBScout['elevationpart'] == '1' ? "Elevator" : "Elevatee";
		$redEleText[2] = '<td class="text-center" style="width:22.5%">' . $APart . '</td>' . '<td class="text-center" style="width:22.5%">' . $BPart . '</td>';
	}
	else
	{
		$redEleText[0] = '<td colspan=2 class="text-center">' . 'No Elevation Completed' . '</td>';
		$redEleText[1] = '<td colspan=2 class="text-center" >' . 'Not Applicable' . '</td>';
		$redEleText[2] = '<td colspan=2 class="text-center" >' . 'Not Applicable' . '</td>';
	}
}
else
{
	$redEleText[0] = '<td colspan=2 class="text-center" >' . '' . '</td>';
	$redEleText[1] = '<td colspan=2 class="text-center" >' . '' . '</td>';
	$redEleText[2] = '<td colspan=2 class="text-center" >' . '' . '</td>';
}
if(isset($blueAScout['elevation']) && isset($blueBScout['elevation']))
{
	if($blueAScout['elevation'] == '1' ||  $blueBScout['elevation']== '1')
	{
		$blueEleText[0] = '<td colspan=2 class="text-center" style="width:45%">' . 'Elevation Completed' . '</td>';
		$text = $blueAScout['elevationheight'] == '1' ||  $blueBScout['elevationheight']? "High Elevation" : "Low Elevation";
		$blueEleText[1] = '<td colspan=2 class="text-center" style="width:45%">' . $text . '</td>';
		$APart = $blueAScout['elevationpart'] == '1' ? "Elevator" : "Elevatee";
		$BPart = $blueBScout['elevationpart'] == '1' ? "Elevator" : "Elevatee";
		$blueEleText[2] = '<td class="text-center" style="width:22.5%">' . $APart . '</td>' . '<td class="text-center" style="width:22.5%">' . $BPart . '</td>';
	}
	else
	{
		$blueEleText[0] = '<td colspan=2 class="text-center" >' . 'No Elevation Completed' . '</td>';
		$blueEleText[1] = '<td colspan=2 class="text-center" >' . 'Not Applicable' . '</td>';
		$blueEleText[2] = '<td colspan=2 class="text-center" >' . 'Not Applicable' . '</td>';
	}
}
else
{
	$blueEleText[0] = '<td colspan=2 class="text-center" >' . '' . '</td>';
	$blueEleText[1] = '<td colspan=2 class="text-center" >' . '' . '</td>';
	$blueEleText[2] = '<td colspan=2 class="text-center" >' . '' . '</td>';
}
echo "<tr><td style=\"width:10%\">Elevation Status</td>";
echo  $redEleText[0] . $blueEleText[0] . "</tr>";
echo "<tr><td style=\"width:10%\" >Elevation Height</td>";
echo $redEleText[1] . $blueEleText[1] . "</tr>";
echo "<tr><td style=\"width:10%\">Part in Elevation</td>";
echo $redEleText[2] . $blueEleText[2] . "</tr>";

echo '<tr><td style="width:10%">Auto Shots Made</td>';
echo '<td class="text-center" style="width:22.5%">' . $redAScout['automade'] . '</td>';
echo '<td class="text-center" style="width:22.5%">' . $redBScout['automade']. '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueAScout['automade'].  '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueBScout['automade'] .  '</td></tr>';

echo '<tr><td style="width:10%">Auto Shots Missed</td>';
echo '<td class="text-center" style="width:22.5%">' . $redAScout['automissed'] . '</td>';
echo '<td class="text-center" style="width:22.5%">' . $redBScout['automissed']. '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueAScout['automissed'].  '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueBScout['automissed'] .  '</td></tr>';

echo '<tr><td style="width:10%">Driver Shots Made</td>';
echo '<td class="text-center" style="width:22.5%">' . $redAScout['drivermade'] . '</td>';
echo '<td class="text-center" style="width:22.5%">' . $redBScout['drivermade']. '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueAScout['drivermade'].  '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueBScout['drivermade'] .  '</td></tr>';

echo '<tr><td style="width:10%">Driver Shots Made Low Goal</td>';
echo '<td class="text-center" style="width:22.5%">' . $redAScout['driverlow'] . '</td>';
echo '<td class="text-center" style="width:22.5%">' . $redBScout['driverlow']. '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueAScout['driverlow'].  '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueBScout['driverlow'] .  '</td></tr>';

echo '<tr><td style="width:10%">Driver Shots Missed</td>';
echo '<td class="text-center" style="width:22.5%">' . $redAScout['drivermissed'] . '</td>';
echo '<td class="text-center" style="width:22.5%">' . $redBScout['drivermissed']. '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueAScout['drivermissed'].  '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueBScout['drivermissed'] .  '</td></tr>';

echo '<tr><td style="width:10%">Stacks Intaked</td>';
echo '<td class="text-center" style="width:22.5%">' . $redAScout['stacksintaked'] . '</td>';
echo '<td class="text-center" style="width:22.5%">' . $redBScout['stacksintaked']. '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueAScout['stacksintaked'].  '</td>';
echo '<td class="text-center" style="width:22.5%">' . $blueBScout['stacksintaked'] .  '</td></tr>';

?>
</table>
