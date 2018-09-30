
/*********************************
	Function getPieceValue.

	Request the corresponding piece value for a cell. Try to
	identify the 'string' value for the cell.
**********************************/
function getPieceValue(cordX , cordY){
	cellValue = $($('#cell'+cordX+'_'+cordY + " img")[0]).attr('src')
	return cellValue
}
/*****************************************
	For the possible group combination. Attempt to validate
	whether or not the game has been successfully completed
	or not.
******************************************/
function getValidateGroup(cordX1 , cordY1,
													cordX2 , cordY2,
													cordX3 , cordY3){
	position1 = getPieceValue(cordX1 , cordY1)
	position2 = getPieceValue(cordX2 , cordY2)
	position3 = getPieceValue(cordX3 , cordY3)

	if ( position1.indexOf('Empty') >-1 || 
				position2.indexOf('Empty') >-1 ||
				position3.indexOf('Empty') >-1 )
		return false;

	return ( (position1 == position2) && (position2 == position3) )
}

function validateBoard(){
	var dataSet = Array(
										// Left to right
										[0,0,1,0,2,0],
										[0,1,1,1,2,1],
										[0,2,1,2,2,2],
										// Top to bottom
										[0,0,0,1,0,2],
										[1,0,1,1,1,2],				
										[2,0,2,1,2,2],
										// Diagonal		
										[0,0,1,1,2,2],			
										[2,0,1,1,0,2]
										)
	// Loop around the possible combinations to complete the game.
	for (var count = 0 ; count < dataSet.length ; count++){
		// Get the corresponding logic to be tested.
		logicArray = dataSet[count];
		// Return true or false - depending on whether the game is completed or not?
		if (getValidateGroup(logicArray[0],logicArray[1],logicArray[2],
												logicArray[3],logicArray[4],logicArray[5]))
			return true;
	}
		return false;

	}

