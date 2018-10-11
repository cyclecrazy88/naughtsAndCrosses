
var gameHistory = null;

function gameHistoryControl(controlData){
	gameHistory = new historyManager(controlData);
}

function historyManager(controlData){
	console.log("Load Manager")

	if (controlData.average != undefined){
		const averagesDetails = controlData.average;
		$('#averageRed').text(averagesDetails.averageRed);
		$('#averageBlue').text(averagesDetails.averageBlue);
	}

	if (controlData.details != undefined){
		// Empty out the result section.
		$('#gameDetails').empty()

		// Provide some updated heading details/
		const headingDetails =
			'<tr><td  width="100%" colspan="3" class="textStyle2">Game Details - Table Details for the game.</td></tr>'+
			'<tr><td  width="33%" class="textStyle2">Game Number</td>'+
			'<td  width="33%" class="textStyle2">Game Player</td>'+
			'<td  width="33%" class="textStyle2">Resulting Counters</td>'+
			'</tr>'
		$('#gameDetails').append(headingDetails)


		// Add some extra details to the listing.
		const detailsList = controlData.details;
		for (var count = 0 ; count < detailsList.length ; count++ ){
			var redItem = detailsList[count].red;
			var blueItem = detailsList[count].blue;			
			var outputData = 
			'<tr>'+	
			'<td class="textStyle" width="33%">'+count+'</td>'+
			'<td class="textStyle" width="33%">Computer</td>'+
			'<td id="averageRed" width="33%" class="textStyle">'+redItem+'</td>'+'</tr>';
			// Append the item on the end - next one in the list.
			$('#gameDetails').append(outputData)

		
			var outputData = 
			'<tr>'+	
			'<td class="textStyle" width="33%">'+count+'</td>'+
			'<td class="textStyle" width="33%">User</td>'+
			'<td id="averageBlue" width="33%" class="textStyle">'+blueItem+'</td>'+'</tr>';
			// Append the item on the end - next one in the list.
			$('#gameDetails').append(outputData)

		}
	}
}

