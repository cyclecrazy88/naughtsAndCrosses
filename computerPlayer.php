<?php
class ComputerPlayer{
	# Colour of the computer player.
	private $computerPlayerColour = 'red';
	# Reference to the board currently in play.
	private $currentBoardSettings = null;
	private $suggestedMove = null;
	private $movePossible = false;
	
	public function __construct($currentBoardSettings){
		#print("\nStart computer player.");
		logActivity("\nStart computer player.");
		$this->currentBoardSettings = $currentBoardSettings; 
		$this->lookAtMap($currentBoardSettings);

		# Look at the allowed combinations.
		$possibleMoves = $this->lookAtCombinations();

		if (count($possibleMoves)>0){
			# Fetch the next suggested move.
			$this->suggestedMove = $this->decideMoveCombination($possibleMoves);
		}	


	}
	public function __destruct(){
		#print("\nEnd computer player.");
		logActivity("\nEnd computer player.");
	}

	# Public function - Allow the calling function to know what the next 
	# requested move is.
	public function getSuggestedMove(){
		return $this->suggestedMove;
	}

	public function getComputerPlayerColour(){
		return $this->computerPlayerColour;
	}
	
	# Handler function - Try to decide what move combination is possible to
	# to make.
	private function decideMoveCombination($possibleMoves){
		$indexNumber = rand(0,count($possibleMoves)-1 );
		#print("\nItemNumber. ".$indexNumber);
		logActivity("\nItemNumber. ".$indexNumber);
		return $possibleMoves[ $indexNumber ];
	}

	# -----------------------------------------------------------------------
	# Combination Lookup Function - Try to indentify some combinations on the 
	# board.
	# This function is really here to try to find out which moves are possible
	# and can be made.
	# -----------------------------------------------------------------------
	private function lookAtCombinations(){
		#print("\nCombinations.");
		$availableMoves = [];
		for ($countX = 0 ; $countX < 3 ; $countX++)
			for ($countY = 0 ; $countY < 3 ; $countY++)
				if ($this->moveCanBePlayed($countX,$countY)){	
					# For all of the available items. - Look for something 
					# worthwhile to play.
					$dataItem = [$countX , $countY];
					array_push($availableMoves , $dataItem);
				}
		#print("Total Number of items: ". count($availableMoves) );
		logActivity("Total Number of items: ". count($availableMoves) );
		return $availableMoves;
	}

	private function moveCanBePlayed($cordX , $cordY){
		if ($this->isEmpty($cordX,$cordY)){
			#print("\nPossible to play move: ". $cordX .' '.$cordY);
			return true;
			}
		else{
			#print("\nNot Possible to play move: ". $cordX .' '.$cordY);
			return false;
			}
	}

	# True or false - Check to see if the string is empty
	private function isEmpty($cordX , $cordY){
		if ( strlen( $this->currentBoardSettings[$cordX][$cordY] ) == 0 )
			return true;
		else
			return false;
	} 
	
	
	# Logging function - Check the values loaded.
	private function lookAtMap($currentBoardSettings){
		for ($countX = 0 ; $countX < count($currentBoardSettings) ; $countX++){
			$rowYdata = $currentBoardSettings[$countX];
			#print("\nCountX - Row Loop: ".$countX);
			for ($countY = 0 ; $countY < count($rowYdata) ; $countY++ ){
				$dataValue =  $currentBoardSettings[$countX][$countY];

				#print("\n\tCountX: ".$countX . " CountY: ".$countY . " Data: ".$dataValue);
				logActivity("\n\tCountX: ".$countX . " CountY: ".$countY . 
											" Data: ".$dataValue);
			}
		}
	}

}
?>
