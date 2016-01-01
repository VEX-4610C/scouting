<!doctype html>
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
  <script src="lib/RevolutionScout/main.js"></script>
  <style>
  textarea{
-webkit-box-shadow: 5px 5px 5px 5px ##eee;
-moz-box-shadow: 5px 5px 5px 5px ##eee;
box-shadow: 5px 5px 5px 5px ##eee;
}</style>

  
</head>

<body ng-controller="AppController">    

  <ons-tabbar id="mainTabBar" var="mainTabBar">
    <ons-tab active="true" page="pre.html">
      <div class="tab">
        <div class="tab-label">Before</div>
      </div>
    </ons-tab>

    <ons-tab persistent="true" page="auto.html">
      <div class="tab">
        <div class="tab-label">Auto</div>
      </div>
    </ons-tab>
    <ons-tab persistent="true" page="drive.html">
      <div class="tab">
        <div class="tab-label">Driver</div>
      </div>
    </ons-tab>
    <ons-tab persistent="true" page="post.html">
      <div class="tab">
        <div class="tab-label">After</div>
      </div>
    </ons-tab>
    
  </ons-tabbar>
  
  <ons-template id="pre.html">
    <ons-navigator>
      <ons-page>
        <ons-toolbar>
          <div class="left"><ons-toolbar-button disabled></ons-toolbar-button></div>
          <div class="center">Pre Match</div>
          <div class="right"><ons-toolbar-button disabked></ons-toolbar-button></div>
        </ons-toolbar>
        
        
        <ons-button var="xx"  ng-click="startScout();" modifier="large" style="margin-left: 25%; margin-right: 25%; width: 50%;" >
			Start/Setup Scouting
		</ons-button><br>
		<div ng-show="scouting">
		<label>Showed Up:</label> <input type="checkbox" ng-model="switches.showedup" class="js-switch" ui-switch="{color: '#FF4444', size: 'large', secondaryColor: '#44AA44 '}" /><br>
		<label  >Starting Position:</label><br> <div style="margin-left: 5%"> <label for="goal">Own Goal </label> <input  id="goal" type="checkbox" ng-model="switches.goals" class="js-switch" ui-switch="{color: '#44FF44', size: 'large', secondaryColor: '#44FF44 '}" /> <label for="goal">Other Goal</label></div><br>
		<div data-role="fieldcontain" class="demo-cont" id="demo_cont_select">
            
			
			
			
			
        </div>
      </div>
	</ons-navigator>
  </ons-template>
  <ons-template id="auto.html">
    <ons-navigator>
      <ons-page>
        <ons-toolbar>
          <div class="left"><ons-toolbar-button disabled></ons-toolbar-button></div>
          <div class="center">Autonomous</div>
          <div class="right"><ons-toolbar-button disabled></ons-toolbar-button></div>
        </ons-toolbar>
        
		<h3>Team {{scout_team}} has made {{ashots_made}} shots and missed {{ashots_missed}} shots during the Autonomous Period</h3>
         
        <ons-button var="autoShot"  ng-click="enableAuto()" modifier="large">
			Took Autonomous Shot
		</ons-button><br>
		 <ons-button var="autoMade" ng-click="disableAuto(1)" modifier="large--cta" disabled>
			Made Autonomous Shot
		</ons-button><br>
		<ons-button var="autoMissed"  ng-click="disableAuto(0)" modifier="large--cta" disabled>
			Missed Autonomous Shot
		</ons-button><br>
		

      </ons-page>
    </ons-navigator>
  </ons-template>
  <ons-template id="drive.html">
    <ons-navigator>
      <ons-page>
        <ons-toolbar>
          <div class="left"><ons-toolbar-button disabled></ons-toolbar-button></div>
          <div class="center">Autonomous</div>
          <div class="right"><ons-toolbar-button disabled></ons-toolbar-button></div>
        </ons-toolbar>
		<h3>Team {{scout_team}} has made {{dshots_made}} shots, missed {{dshots_missed}} shots and intaked {{stack_in}} stacks during the Driver Controlled Period</h3>
         <ons-button var="driverShot"  ng-click="enableDriver()" modifier="large" >
			Took Driver Shot
		</ons-button><br>
		 <ons-button var="driverMade"  ng-click="disableDriver(1)" modifier="large" disabled>
			Made Driver Shot
		</ons-button><br>
		<ons-button var="driverLowMissed"  ng-click="disableDriver(-1)" modifier="large" disabled>
			Made Low Driver Shot
		</ons-button><br>
		<ons-button var="driverMissed"  ng-click="disableDriver(0)" modifier="large" disabled>
			Missed Driver Shot
		</ons-button><br>
		<ons-button var="intaked"  ng-click="intakedStack()"  modifier="large--cta" >
			Stack Intaked
		</ons-button><br>
      </ons-page>
     
    </ons-navigator>
  </ons-template>
  <ons-template id="post.html">
    <ons-navigator>
      <ons-page>
        <ons-toolbar>
          <div class="left"><ons-toolbar-button disabled></ons-toolbar-button></div>
          <div class="center">Autonomous</div>
          <div class="right"><ons-toolbar-button disabled></ons-toolbar-button></div>
        </ons-toolbar>
        <br><br>
		<label>Functional Entire Match:</label> <input type="checkbox" ng-model="switches.funtional" class="js-switch" ui-switch="{color: '#44FF44', secondaryColor: '#FF4444', size: 'large'}" /><br> 
	  <label>Completed Legal Elevation:</label> <input type="checkbox" ng-model="switches.elevation" class="js-switch" ui-switch="{color: '#44FF44', secondaryColor: '#FF4444', size: 'large'}" /><br> 
	  <div ng-show="switches.elevation"><label>Elevation Height:</label> <br> <span style="margin-left: 5%"> <label>Low</label> <input type="checkbox" ng-model="switches.eleheight" class="js-switch" ui-switch="{color: '#4444FF', secondaryColor: '#4444FF', size: 'large'}" /> <label>High</label> <br></span>
	  <label>Elevation Part:</label> <br> <span style="margin-left: 5%"> <label>Elevator</label> <input type="checkbox" ng-model="switches.elepart" class="js-switch" ui-switch="{color: '#4444FF', secondaryColor: '#4444FF', size: 'large'}" /> <label>Elevatee </label><br></span>
	  </div>
	  <label for="team">Team: </label> <input type="text" id="team" ></input><br>
		<label for="matchnum">Match Number: </label> <input type="number" id="matchnum"></input><br>
				<label for="key">Scout Key: </label> <input type="password" id="key"></input><br>
			<div> {{selectedTeam}} </div>
	  <!-- label>Scouters Notes:</label><br> <textarea style="margin-left: 5%;" id="notes" ng-model="notes" rows="10" cols="35"></textarea --><br>
      <ons-button var="btn_elevated" ng-click="finishScout();" modifier="large" style="margin-left: 25%; margin-right: 25%; width: 50%;"  >
			Finish Scouting
		</ons-button><br>
      </ons-page>
    </ons-navigator>
  </ons-template>
  </ons-template>
 
    
  </script>

</body>
</html>
