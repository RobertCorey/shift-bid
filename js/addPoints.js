function generateAddPointForm (id, url, target){
	url += id;
	$.get(url, function(data){
		$(target).empty();
		var employeeJSON = $.parseJSON(data);
		var wellElement = document.createElement('div');
		var nameElement = document.createElement('div');
		var pointsElement = document.createElement('div');
		var inputPointsElement = document.createElement('input');
		var addButton = document.createElement('button');
		wellElement.className = "well";
		//Name
		nameElement.className = "h3";
		nameElement.innerHTML = "Name: " + employeeJSON.emp_f_name + " " + employeeJSON.emp_l_name;
		//Points
		pointsElement.className = "h3";
		pointsElement.innerHTML = "Points: " + employeeJSON.emp_points;
		//input
		inputPointsElement.name = "pointAmount";
		inputPointsElement.id = "pointAmount";
		inputPointsElement.type = "number";
		//submit button
		addButton.id = "addPointToUser";
		addButton.innerHTML = "Add Points";
		addButton.className = "btn btn-default";
		addButton.type = "submit";
		//add to well
		wellElement.appendChild(nameElement);
		wellElement.appendChild(pointsElement);
		wellElement.appendChild(inputPointsElement);
		wellElement.appendChild(addButton);
		//add well to DOM
		$(target).append(wellElement);
		addPointsListen( $('#pointAmount'), $('#addPointToUser') ,"php/addPointsAJAX.php" );
	})
}
function addPointsListen (input, button, url) {
	$(button).on("click", function(){
		var amount = $(input).val();
		var id = $('#employee').val();
		$.post( url, { amount: amount, id: id} ).done(function(data){
			url += "?empID="
			generateAddPointForm(id, url, "#employeeDetail");
		});
	});
}

$(document).ready(function(){
	var employeeID = $('#employee').val();
	var url = "php/addPointsAJAX.php?empID=";
	var target = "#employeeDetail";
	generateAddPointForm(employeeID, url, target);
	$('#employee').on( "change", function (){
		var employeeID = $('#employee').val();
		var url = "php/addPointsAJAX.php?empID=";
		var target = "#employeeDetail";
		generateAddPointForm(employeeID, url, target);
		$('#addPointToUser').on("click", function(){
			var key = $('#pointAmount').val();
			var amount = $() 
		});
	});
});