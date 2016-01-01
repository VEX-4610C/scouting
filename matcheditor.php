<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Match List Editor for Revolution Scouter</title>
		<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore.js"></script>
		<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet"></link>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"></link>
		
		
		<style>
		input {
		width: 85%;
		}
		.table-editable {
  position: relative;
}
.table-editable .glyphicon {
  font-size: 20px;
}

.table-remove {
  color: #700;
  cursor: pointer;
}
.table-remove:hover {
  color: #f00;
}

.table-up, .table-down {
  color: #007;
  cursor: pointer;
}
.table-up:hover, .table-down:hover {
  color: #00f;
}

.table-add {
  color: #070;
  cursor: pointer;
  position: absolute;
  top: 8px;
  right: 0;
}
.table-add:hover {
  color: #0b0;
}

		</style>
		
	</head>
	
	<body onload="javascript:loadmatch()">
		<div class="container">
  
  <div id="table" class="table-editable">
    <span class="table-add glyphicon glyphicon-plus"></span>
    <table class="table">
      <tr>
		<th>Match Number</th>
        <th>Red A</th>
        <th>Red B</th>
        <th>Blue A</th>
        <th>Blue B</th>
        <th>Red Score</th>
        <th>Blue Score</th>
        <th></th>
        <th></th>
      </tr>
      <!-- This is our clonable table line -->
      <tr class="hide">
        <td contenteditable="false"><input type="number" placeholder="Put Match #"></input></td>
        <td contenteditable="false"><input type="text" name="redA" placeholder="Put Red 1"></input></td>
        <td contenteditable="false"><input type="text" name="redB" placeholder="Put Red 2"></input></td>
        <td contenteditable="false"><input type="text" name="blueA" placeholder="Put Blue 1"></input></td>
        <td contenteditable="false"><input type="text" name="blueB" placeholder="Put Blue 2"></input></td>
        <td contenteditable="false"><input type="number" placeholder="Put Red Score"></input></td>    
        <td contenteditable="false"><input type="number" placeholder="Put Blue Score"></input></td>
        <td>
          <span class="table-remove glyphicon glyphicon-remove"></span>
        </td>
        <td>
          <span class="table-up glyphicon glyphicon-arrow-up"></span>
          <span class="table-down glyphicon glyphicon-arrow-down"></span>
        </td>
      </tr>
    </table>
  </div>
  
  <button id="export-btn" class="btn btn-primary">Upload Data</button>
  <p id="export"></p>
</div>
<script>
var matchnum = 0;
		var $TABLE = $('#table');
var $BTN = $('#export-btn');
var $EXPORT = $('#export');

$('.table-add').click(function () {
matchnum++;
  var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide table-line');
  $clone[0].childNodes[1].childNodes[0].value = matchnum;
  $TABLE.find('table').append($clone);
  
});

$('.table-remove').click(function () {
  $(this).parents('tr').detach();
});

$('.table-up').click(function () {
  var $row = $(this).parents('tr');
  if ($row.index() === 1) return; // Don't go above the header
  $row.prev().before($row.get(0));
});

$('.table-down').click(function () {
  var $row = $(this).parents('tr');
  $row.next().after($row.get(0));
});

// A few jQuery helpers for exporting only
jQuery.fn.pop = [].pop;
jQuery.fn.shift = [].shift;

$BTN.click(function () {
  var $rows = $TABLE.find('tr:not(:hidden)');
  var key = prompt("What is the Upload Key?");

  var headers = [];
  var data = [];
  
  // Get the headers (add special header logic here)
  $($rows.shift()).find('th:not(:empty)').each(function () {
    headers.push($(this).text().toLowerCase());
  });
  
  // Turn all existing rows into a loopable array
  $rows.each(function () {
    var $td = $(this).find('td');
    var h = {};
    
    // Use the headers from earlier to name our hash keys
    headers.forEach(function (header, i) {
      h[header] = $td.eq(i)[0].childNodes[0].value;   
    });
    data.push(h);
  });
  
  // Output the result
			$.ajax({
			  data: {"MODE": "submitMatches", "KEY" : key, "matches": JSON.stringify(data)},
			  type: "POST",
			  dataType: "json",
			  url: "/backend/SUPER_API.php?",
			}).done(function( dataa ) {
				});
});

function loadmatch(){
$.ajax({
	data: {"MODE": "getMatches", },
	type: "GET",
	dataType: "json",
	url: "/backend/SUPER_API.php?",
}).done(function( dataa ) {
	dataa = dataa['result'];
	for(var i = 0; i < dataa.length; i++)
	{
		var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide table-line');
		$clone[0].childNodes[1].childNodes[0].value = dataa[i]['match_number'];
		$clone[0].childNodes[3].childNodes[0].value = dataa[i]['team_redA'];
		$clone[0].childNodes[5].childNodes[0].value = dataa[i]['team_redB'];
		$clone[0].childNodes[7].childNodes[0].value = dataa[i]['team_blueA'];
		$clone[0].childNodes[9].childNodes[0].value = dataa[i]['team_blueB'];
		$clone[0].childNodes[11].childNodes[0].value = dataa[i]['redScore'];
		$clone[0].childNodes[13].childNodes[0].value = dataa[i]['blueScore'];
		$TABLE.find('table').append($clone);
		matchnum++;
	}
});
}
		</script>
	</body>

</html>