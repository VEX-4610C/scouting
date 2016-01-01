// Angular services are singletons so data is preserved when you change scope.

angular.module('app', ['onsen', 'uiSwitch', 'NgSwitchery']);
angular.module('app').controller('AppController', function($scope) {
	window.MY_SCOPE = $scope;
	
	ons.ready(function() {

                                            document.getElementsByClassName("tab-bar")[0].style.display = "none";
                                            //$(".switch-boot").bootstrapSwitch();
                                            $(".bootstrap-switch").css("margin-left","50px");
                                            /* Load User Data */
                                            json = [];
                                            json['MODE'] = "loadUserData";
										
										
                });
	$scope.finishPit = function(){	
  var json = [];
  json['MODE'] = "addPitScout"; 
  json['team_in'] = $("#team").val();
  json['KEY'] = $("#key").val();
  
  json['drivetype_in'] = $("#team").val();
  json['shootertype_in'] = $("#team").val();
  json['aimedgoal_in'] = $("#team").val();
  json['shooterspeed_in'] = $("#team").val();
  json['autodesc_in'] = $("#team").val();
  json['eleposs_in'] = $("#team").val();
  json['elespeed_in'] = $("#team").val();
  json['drivercontrolballs_in'] = $("#team").val();
  json['driverstrat_in'] = $("#team").val();
  ons.notification.confirm({
		  message: "You are submitting a scouting report for team " + json['TEAM'] + ". By submitting this report, you confirm that all information is correct to your best knowledge.",
		  title: 'Confirmation',
		  buttonLabels: ['Cancel', 'Yes'],
		  animation: 'default', // or 'none'
		  primaryButtonIndex: 1,
		  cancelable: false,
		  callback: function(index) {
			if(index == 1)
			{
			//	console.log(json);
			$.ajax({
			  data: json,
			  dataType: "json",
			  url: "/SUPER_API.php?",
			})
			  .done(function( dataa ) {
				console.log(dataa);
				if(dataa['status'] == -2) // Incorrect Passkey
				{
					ons.notification.alert({
					  message: 'The Scout Key Is Incorrect',
					  title: 'Error',
					  buttonLabel: 'OK',
					  animation: 'default', // or 'none'
					});
				}
				else if(dataa['status'] == -3) // Team or Match Incorrect
				{
					ons.notification.alert({
					  message: 'The Team Number or Match Number is Incorrect; Please Try Again.',
					  title: 'Error',
					  buttonLabel: 'OK',
					  animation: 'default', // or 'none'
					});
				}
				else
				{
				location.reload()
				}
			  });
			
			}
		  }
		});

	}
    $scope.enableAuto = function() {
        console.log(($scope.ashots_made + $scope.ashots_missed) % 4);
        if (($scope.ashots_made + $scope.ashots_missed < 4) || $scope.auto_intaked) {
            autoMade.setDisabled(false);
            autoMissed.setDisabled(false);
            autoShot.setDisabled(true);
        } else {
            if (!$scope.auto_intaked) {
                ons.notification.confirm({
                    message: 'Did They Intake A Stack?',
                    title: 'Auto Check',
                    buttonLabels: ['No', 'Yes'],
                    animation: 'default', // or 'none'
                    primaryButtonIndex: 1,
                    cancelable: false,
                    callback: function(index) {
                        if (index) {
                            $scope.auto_intaked = 1;
                            $scope.stack_in++;
                            autoMade.setDisabled(false);
                            autoMissed.setDisabled(false);
                            autoShot.setDisabled(true);
                        }
                    }
                });

            }
        }
        if ($scope.ashots_made + $scope.ashots_missed % 4 == 0) {
            $scope.auto_intaked = 0;
        }

    };
    $scope.disableAuto = function(made) {
        autoMade.setDisabled(true);
        autoMissed.setDisabled(true);
        autoShot.setDisabled(false);
        if (made) {
            $scope.balls_intaked--;
            $scope.ashots_made++;
        } else {
            $scope.balls_intaked--;
            $scope.ashots_missed++;
        }
        if (($scope.ashots_made + $scope.ashots_missed) % 4 == 0) {
            $scope.auto_intaked = 0;

        }
    };
    $scope.enableDriver = function() {
        driverMade.setDisabled(false);
        driverMissed.setDisabled(false);
        driverShot.setDisabled(true);
        driverLowMissed.setDisabled(false);
    };
    $scope.intakedStack = function() {
        ons.notification.confirm({
            message: 'Did They Intake A Stack?',
            // or messageHTML: '<div>Message in HTML</div>',
            title: 'Intake Check',
            buttonLabels: ['No', 'Yes'],
            animation: 'default', // or 'none'
            primaryButtonIndex: 1,
            cancelable: false,
            callback: function(index) {
                if (index) {
                    $scope.stack_in++;
                    $scope.balls_intaked = 4;
                }
            }
        });
    };
    $scope.intakedCheckStack = function() {
        ons.notification.confirm({
            message: 'Did They Intake A Stack?',
            // or messageHTML: '<div>Message in HTML</div>',
            title: 'Intake Check',
            buttonLabels: ['No', 'Field', 'Human'],
            animation: 'default', // or 'none'
            primaryButtonIndex: 1,
            cancelable: false,
            callback: function(index) {
                if (index) {
                    $scope.balls_intaked = 4;
                }
                if (index == 1) {
                    $scope.stack_in++;
                }
            }
        });
    };
    $scope.intakedHStack = function() {
        ons.notification.confirm({
            message: 'Did They Intake A Stack?',
            // or messageHTML: '<div>Message in HTML</div>',
            title: 'Intake Check',
            buttonLabels: ['No', 'Yes'],
            animation: 'default', // or 'none'
            primaryButtonIndex: 1,
            cancelable: false,
            callback: function(index) {
                if (index) {
                    $scope.balls_intaked = 4;
                }
            }
        });
    };
    $scope.disableDriver = function(made) {
        driverMade.setDisabled(true);
        driverMissed.setDisabled(true);
        driverLowMissed.setDisabled(true);
        driverShot.setDisabled(false);
        if (made == 1) {
            $scope.dshots_made++;
        } else if (made == 0) {
            $scope.dshots_missed++;
        } else if (made == -1) {
            $scope.dlowshots_made++;
		}
    };
    $scope.disableButton = function() {
        $scope.driverMade.setDisabled(true);
        driverMissed.setDisabled(true);
        driverLowMissed.setDisabled(true);
        driverShot.setDisabled(true);
        autoMade.setDisabled(true);
        autoMissed.setDisabled(true);
        autoShot.setDisabled(true);
        intaked.setDisabled(true);
    };
     $scope.enabledButton = function() {
        driverMade.setDisabled(false);
        driverMissed.setDisabled(false);
        driverLowMissed.setDisabled(false);
        driverShot.setDisabled(false);
        autoMade.setDisabled(false);
        autoMissed.setDisabled(false);
        autoShot.setDisabled(false);
        intaked.setDisabled(false);
    };
    $scope.startScout = function() {
		$scope.teamlist = ["", "150", "161", "161R", "750E", "750W", "1574N", "1574P", "2616D", "2616E", "2616F", "2616G",
										"2616H", "2616K", "2616N", "3199G", "4610", "4610C", "4610D", "4610N", "4610X", "4610Y", "4610Z", "5249A", 
										"5249B", "5249C", "5249D", "6474T", "7405M", "8008A", "8008K", "8008Z", "99200Z"];
		
		$scope.switches = $scope.start_switches;
		$scope.scouting = true;
		
		document.getElementsByClassName("tab-bar")[0].style.display = "";
        $scope.scoutteamtext = "" ;
        $scope.dshots_made = 0;
        $scope.dshots_missed = 0;
        $scope.ashots_made = 0;
        $scope.ashots_missed = 0;
        $scope.alow_goal = 0;
        $scope.dlow_goal = 0;
        $scope.auto_intaked = 1;
        $scope.stack_in = 0;
        $scope.balls_intaked = 4;
        $scope.dlowshots_made = 0;
		$("#matchnum").val("");
		$("#team").val("");
    };
    $scope.finishScout = function() {
		
          json = {};
        json['MODE'] = "finishScout";
        json['MATCH'] = $scope.match;
        json['SHOWED_UP'] = $scope.switches.showedup;
        json['STARTING_POSITION'] = $scope.switches.goals;
        json['FUNCTION_ENTIRE_MATCH'] = $scope.switches.funtional;
		json['ELEVATION'] = $scope.switches.elevation;
		json['ELEVATION_HEIGHT'] = $scope.switches.eleheight;
		json['ELEVATION_PART'] = $scope.switches.elepart;
		json['AUTO_SHOTS_MADE'] = $scope.ashots_made;
		json['AUTO_LOW_SHOTS_MADE'] = $scope.alow_goal;
		json['AUTO_SHOTS_MISSED'] = $scope.ashots_missed;
		json['DRIVER_SHOTS_MADE'] = $scope.dshots_made;
		json['DRIVER_LOW_SHOTS_MADE'] = $scope.dlowshots_made;
		json['DRIVER_SHOTS_MISSED'] = $scope.dshots_missed;
		json['STACKS_INTAKED'] = $scope.stack_in;
		var team = $("#team").find(":selected").text().replace(/\W+/g, " ");
		json['TEAM'] = team; //team.substring(0, team.length - 1);
		json['KEY'] = $("#key").val()
		json['MATCH'] = $("#matchnum").val();
		if(json['TEAM'] == "" || json['MATCH'] == "") return;
		ons.notification.confirm({
		  message: "You are submitting a scouting report for team " + json['TEAM'] + " for match number " + json['MATCH'] + ". By submitting this report, you confirm that all information is correct to your best knowledge.",
		  // or messageHTML: '<div>Message in HTML</div>',
		  title: 'Confirmation',
		  buttonLabels: ['Cancel', 'Yes'],
		  animation: 'default', // or 'none'
		  primaryButtonIndex: 1,
		  cancelable: false,
		  callback: function(index) {
			if(index == 1)
			{
			//	console.log(json);
			$.ajax({
			  data: json,
			  dataType: "json",
			  url: "/backend/SUPER_API.php?",
			})
			  .done(function( dataa ) {
				console.log(dataa);
				if(dataa['status'] == -2) // Incorrect Passkey
				{
					ons.notification.alert({
					  message: 'The Scout Key Is Incorrect',
					  title: 'Error',
					  buttonLabel: 'OK',
					  animation: 'default', // or 'none'
					});
				}
				else if(dataa['status'] == -3) // Team or Match Incorrect
				{
					ons.notification.alert({
					  message: 'The Team Number or Match Number is Incorrect; Please Try Again.',
					  title: 'Error',
					  buttonLabel: 'OK',
					  animation: 'default', // or 'none'
					});
				}
				else
				{
				mainTabBar.setActiveTab(0);
				$scope.scouting = false;
				document.getElementsByClassName("tab-bar")[0].style.display = "none";
				console.log(JSON.stringify(json));
				$scope.scoutteamtext = "Please Click to Get Team to Scout";
				}
			  });
			
			}
		  }
		});
		/*if(confirm() == true)
		{
			
		}*/
    };
    $scope.start_switches = {
		alliance: false,
		showedup: true,
		goals: false,
		funtional: true,
		elevation: false,
		eleheight: false,
		elepart: false
		};
	 $scope.switches = {
		alliance: false,
		showedup: false,
		goals: false,
		funtional: true,
		elevation: false,
		eleheight: false,
		elepart: false
		};
    $scope.scoutteamtext = "Please Click to Get Team to Scout";
    $scope.nextTeam = "";
    $scope.match = -1;
    $scope.scouting = false;
    $scope.dshots_made = 0;
    $scope.dlowshots_made = 0;
    $scope.dshots_missed = 0;
    $scope.ashots_made = 0;
    $scope.ashots_missed = 0;
    $scope.alow_goal = 0;
    $scope.dlow_goal = 0;
    $scope.auto_intaked = 1;
    $scope.stack_in = 0;
    $scope.balls_intaked = 4;
    $scope.disableButton = 0;
    $scope.disableButtonT = 0;
	
});
