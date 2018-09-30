
$(document).ready(function(){
	//console.log("Load Page")
	loadGame()
	})

var gameObject = null;
function gameControl(gameName){
	//console.log("GameName: "+gameName)
	// The buttons on the page need to have a binding. This is so when the
	// user clicks on an item. The click action does something on the page.
	function setupButtonBindings(){
		for (var countX = 0; countX < 3 ; countX++)
			for (var countY = 0 ; countY < 3 ; countY++){
				//console.log("Binding: "+ countX + " "+ countY)
				$('#cell'+countX+'_'+countY).click(function(data){
					var cellTarget = $(data.currentTarget).attr('id');
					//console.log("Click function: "+cellTarget )
					// If the cell is marked as empty. Allow an update, else don't allow a 
					// click to occur.
					if ( $($('#'+cellTarget + " img")[0]).attr('src').indexOf('Empty')>-1 )
						// Click the button.
						buttonClickScript(cellTarget)
						// Mark the item as a cross for the human player.
						$($('#'+cellTarget + " img")[0]).attr('src','./images/Cross.png');

				})
			}
	this.updateBoard = function(inputData){
		// Loop around the data set. See to update the board for the target.
		for (var countX = 0; countX < 3 && inputData.length == 3 ; countX++){
			// Read the row data.
			rowData = inputData[countX]
			// Ensure the row data is always the correct length and loop around
			// the cells.
			for (var countY = 0 ; countY < 3 && rowData.length == 3 ; countY++){
				itemValue = rowData[countY]
				cellImage = $($('#cell'+countX+'_'+countY + " img")[0])
	
				// Check to see what the response looks like. Update the board based
				// on the corresponding bits of response information.
				if (itemValue.trim().length == 0){
					cellImage.attr('src','./images/Empty.png')
				}else if (itemValue == 'red'){
					cellImage.attr('src','./images/Circle2.png')
				}else if(itemValue == 'blue')
					cellImage.attr('src','./images/Cross.png')

			}		
		}

	}
}
/***********************************
	Function - buttonClickScript.
		This is utility function. Its here to allow a decision to be made
		with regards to calling the PHP script to request that a move is made.
************************************/
function buttonClickScript(action){
	buttonCodes = action.substr(4)
	splitCode = buttonCodes.split('_')

	inputObject = JSON.stringify({"gameName":gameName, 
																"cordX":splitCode[0],
																"cordY":splitCode[1] })
	$.post({url:'http://localhost/naughtsAndCrosses.php',
					data: inputObject,
					success: function(data){
						resultJson = JSON.parse(data);
						//console.log("Data: "+ data)

						// Display the corresponding items on the board.
						updateBoard(resultJson)

						if (validateBoard() ){
							//console.log("Game Complete");
							// Prompt the user to the completeness of the game.
							$('#completeNotice').css('visibility','visible')
						}

					}});
	}
	setupButtonBindings()
}

function loadGame(){
	//console.log("Start Game")

	$.getJSON("http://localhost/nextGameNumber.php",
		// Function to handle the response from the request.
		function(responseData){
			//console.log("Response: "+ responseData)
			// Looks like it's possible to look into starting a game.
			if (responseData.gameCode != undefined){
				//console.log("Game: ",responseData.gameCode )
				window.gameObject = new gameControl(responseData.gameCode)
			}
	})
}

