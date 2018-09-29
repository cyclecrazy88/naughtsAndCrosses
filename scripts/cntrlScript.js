
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
					var cellTarget = $(data.target).attr('id');
					console.log("Click function: "+cellTarget )
					buttonClickScript(cellTarget)
				})
			}
	}


	function buttonClickScript(action){
		buttonCodes = action.substr(4)
		splitCode = buttonCodes.split('_')

		inputObject = JSON.stringify({"gameName":gameName, 
																	"cordX":splitCode[0],
																	"cordY":splitCode[1] })
		$.post({url:'http://localhost/naughtsAndCrosses.php',
						data: inputObject});


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

