<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
  <meta charset="utf-8">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  
  <title>Revolution Scout</title>  
  
  <link rel="stylesheet" href="lib/onsen/css/onsenui.css">  
  <link rel="stylesheet" href="lib/onsen/css/onsen-css-components.css">  
  <link rel="stylesheet" href="lib/uiSwitch/css/switch.css">  
  <link rel="stylesheet" href="lib/switchery/dist/switchery.css">  
  <link rel="stylesheet" href="styles/app.css"/>
  <link rel="stylesheet" href="https://rawgit.com/nostalgiaz/bootstrap-switch/master/dist/css/bootstrap3/bootstrap-switch.css"/>
  <script src="lib/onsen/js/angular/angular.js"></script> 
  
  <script src="lib/onsen/js/jquery.js"></script>  
  <script src="lib/switchery/dist/switchery.js"></script>   
  <script src="lib/ng-switchery/src/ng-switchery.js"></script>  
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>   
  <script src="lib/onsen/js/onsenui.js"></script>
  <script src="lib/uiSwitch/js/switch.js"></script>  
  <script src="https://rawgit.com/nostalgiaz/bootstrap-switch/master/dist/js/bootstrap-switch.js"></script>
    

  <script src="cordova.js"></script>
  <script src="js/app.js"></script> 
  <script src="lib/RevolutionScout/pitscoutjs.js"></script>
  <style>
  textarea{
-webkit-box-shadow: 5px 5px 5px 5px ##eee;
-moz-box-shadow: 5px 5px 5px 5px ##eee;
box-shadow: 5px 5px 5px 5px ##eee;
}</style>

  <script>
  
  </script>
</head>
<body ng-controller="AppController">
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Pit Scouting Form</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="team">Team Number</label>  
  <div class="col-md-4">
  <input id="team" name="team" type="text" placeholder="Team" class="form-control input-md" required="">
  <span class="help-block">Place the Team Number</span>  
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="key">Scouting Key</label>
  <div class="col-md-4">
    <input id="key" name="key" type="password" placeholder="Pass Key" class="form-control input-md" required="">
    <span class="help-block">Pass Key -- Go to Admin if not known</span>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="driveType">Type of Drive</label>
  <div class="col-md-4">
    <select id="driveType" name="driveType" class="form-control">
      <option value="1">Tank Drive</option>
      <option value="2">H Drive</option>
      <option value="3">Mecanum Wheel Drive</option>
      <option value="4">X Drive</option>
      <option value="5">Kiwi Drive</option>
      <option value="6">Other</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="intakeHold">Number of Balls Intake can Hold</label>
  <div class="col-md-4">
    <select id="intakeHold" name="intakeHold" class="form-control">
      <option value="0">Zero</option>
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
      <option value="4">Four</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="shootertype">Shooter Type</label>
  <div class="col-md-4">
    <select id="shootertype" name="shootertype" class="form-control">
      <option value="1">Double Flywheel</option>
      <option value="2">Single Flywheel</option>
      <option value="3">Puncher</option>
      <option value="4">Catapult</option>
      <option value="5">Kicker</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="goalaimed">Goal Aimed For</label>
  <div class="col-md-4">
    <select id="goalaimed" name="goalaimed" class="form-control">
      <option value="1">High</option>
      <option value="2">Low</option>
      <option value="3">Both</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="shootSpeed">Speed of Shooter</label>
  <div class="col-md-6">
    <select id="shootSpeed" name="shootSpeed" class="form-control">
      <option value="1">More Than One Ball Per Second</option>
      <option value="2">One Ball Per Second</option>
      <option value="3">One Ball Per Two Seconds</option>
      <option value="4">One Ball Per Three Seconds</option>
      <option value="5">Less than One Ball Per Three Seconds</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="autodesc">Auto Description</label>
  <div class="col-md-4">
    <select id="autodesc" name="autodesc" class="form-control">
	  <option value="0">None</option>
      <option value="1">One Ball</option>
      <option value="2">Two Ball</option>
      <option value="3">Three Ball</option>
      <option value="4">Four Ball</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="elevation">Elevation Possiblities</label>
  <div class="col-md-4">
    <select id="elevation" name="elevation" class="form-control">
      <option value="1">None</option>
      <option value="2">High Elevation</option>
      <option value="3">Low Elevation</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="elespeed">Elevation Speed</label>
  <div class="col-md-4">
    <select id="elespeed" name="elespeed" class="form-control">
      <option value="1">0-5 Seconds</option>
      <option value="2">5-10 Seconds</option>
      <option value="3">10-20 Seconds</option>
      <option value="4">More than 20 Seconds</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="ballscored">Balls Scored during Driver Control</label>
  <div class="col-md-4">
    <select id="ballscored" name="ballscored" class="form-control">
      <option value="1">0-5 Balls</option>
      <option value="2">5-10 Balls</option>
      <option value="3">10-15 Balls</option>
      <option value="4">15-20 Balls</option>
      <option value="5">20-30 Balls</option>
      <option value="6">More than 30 Balls</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="matchstrat">Driver Control Strategy</label>
  <div class="col-md-4">
    <select id="matchstrat" name="matchstrat" class="form-control">
      <option value="1">Driver Loads</option>
      <option value="2">Field Bot</option>
      <option value="3">Mix</option>
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" ng-click="finishPit()" class="btn btn-danger" type="button">Submit</button>
  </div>
</div>
</fieldset>
</form>

</body>
</html>