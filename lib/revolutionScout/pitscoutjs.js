// Angular services are singletons so data is preserved when you change scope.

angular.module('app', ['onsen', 'uiSwitch', 'NgSwitchery']);
angular.module('app').controller('AppController', function($scope) {
	window.MY_SCOPE = $scope;
	
	ons.ready(function() {
										
										
                });
	$scope.finishPit = function(){	
  var json = {};
  json['MODE'] = "addPitScout"; 
  json['team_in'] = $("#team").val();
  json['KEY'] = $("#key").val();
  
  json['drivetype_in'] = $("#driveType").val();
  json['intakehold_in'] = $("#intakeHold").val();
  json['shootertype_in'] = $("#shootertype").val();
  json['aimedgoal_in'] = $("#goalaimed").val();
  json['shooterspeed_in'] = $("#shootSpeed").val();
  json['autodesc_in'] = $("#autodesc").val();
  json['eleposs_in'] = $("#elevation").val();
  json['elespeed_in'] = $("#elespeed").val();
  json['drivercontrolballs_in'] = $("#ballscored").val();
  json['driverstrat_in'] = $("#matchstrat").val();
  console.log('json: ' + json);
  if(json['team_in'] == "" || json['KEY'] == "") return;
  ons.notification.confirm({
		  message: "You are submitting a scouting report for team " + json['team_in'] + ". By submitting this report, you confirm that all information is correct to your best knowledge.",
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
			  type: "GET",
			  dataType: "json",
			  url: "/backend/SUPER_API.php?",
			}).done(function( dataa ) {
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
	
});
