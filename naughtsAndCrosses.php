<?php
# Include the definition for the computer player.
include "./activityLog.php";
include "./computerPlayer.php";

# Define and run the input player - this is the user input.
class NaughtsAndCrossesGame{

	private $boardMapping = null;
	private $gameHandle = null;
	private $directoryName = './gameData/';

	public function __construct($gameHandle){
		#print("\nLoad Game: ".$gameHandle);
		$this->gameHandle = $gameHandle;
		logActivity("Load Game: ".$gameHandle);
		if (gettype($gameHandle) != "string"){
			throw new Exception('$gameHandle is not a string');		
		}

		# Check the game name is a valid name. Use regex to check the format.
		# - 5 letters / a to z
		# - 10 numbers 0-9. (Minimum 1 and up to 10
		#	- End of String - Length should be 15 characters only.
		$matchCount = preg_match('/[a-z]{5,}+[0-9]{1,10}$/',$gameHandle);
		#print("Matches: ".$matchCount );
		logActivity("Matches: ".$matchCount.' Input: '.$gameHandle);
		if ($matchCount == 0){
			throw new Exception("Game input for $gameHandle not valid");
		}

		# Check to see if the game data directory exists or not.
		if (!file_exists($this->directoryName)){
			# Looks like a game data folder doesn't exist - so create it
			mkdir($this->directoryName);
		}

		# Check to see if the game data has been loaded - is this a previous game?
		$fullPath = $this->directoryName.$this->gameHandle.'.txt';
		$boardDataX = [];
		if (!file_exists($fullPath)){
			
			# Naughts and Crosses has a 3 x 3 board. So attempt to create a 
			# board with this sizing.
			
			for ($xAxis = 0 ; $xAxis < 3 ; $xAxis++){
				$yAxisDataY = [];
	
				for ($yAxis = 0 ; $yAxis < 3 ; $yAxis++){
					$dataItem = 'X: '.$xAxis. ' Y: '.$yAxis;
					#print("\nData: ".$dataItem );
					logActivity("\nSetData: ".$dataItem );
					# Add some entry data into the data set.
					$initialValue = '';
					array_push($yAxisDataY, $initialValue);
				}

				array_push( $boardDataX , $yAxisDataY );
				#print("\nCount: ". count($boardDataX) );
				logActivity("\nCurrent Count: ". count($boardDataX) );
			}	

		}
		else{
			$fileHandle = fopen($fullPath,'r');
			$inputDataString = fgets($fileHandle,1024);
			if ($inputDataString != null){
				#print("\n\tSet entry: ". $inputDataString);
				# Load the previous running data from a json file
				$boardDataX = json_decode($inputDataString,false);

			}
			
			fclose($fileHandle);

		}


		// Setup a board and put some data on it.
		$this->boardMapping = $boardDataX;
	}
	public function __destruct(){
		#print("\n\nUnload Game\n");
		logActivity("Unload Game: ".$this->gameHandle);

		# Once the object is no longer in use
		$fileHandle = fopen($this->directoryName.$this->gameHandle.'.txt','w');
		#print("Write File: ". $this->directoryName.$this->gameHandle.'.txt');
		fputs($fileHandle , json_encode($this->boardMapping) , 1024);

		fclose($fileHandle);


	}

	/***************************************************
		Add the board entry to the corresponding value in the dataset.
	***************************************************/
	public function addBoardEntry($cordX , $cordY , $value){
		# Validate the input types. Do we have coords and a string value for the item?
		if (gettype($cordX)!='integer')
			throw new Exception("CordX is not an integer");
		if (gettype($cordY)!='integer')
			throw new Exception("CordY is not an integer");
		if (gettype($value)!='string')
			throw new Exception("Value is not a string");

		# Try to find the entry on the board
		if ( $cordX < count($this->boardMapping) ){
			$cordYData = $this->boardMapping[$cordX];
			if ($cordY < count($cordYData)){
				$this->boardMapping[$cordX][$cordY]=$value;
				#print("\nValueSet: ". $value);
				logActivity("\nValueSet: ". $value);
			}
		}
		else{
			#print("\nAddBoardEntry - Unable to set entry");
			logActivity("\nAddBoardEntry - Unable to set entry");
		}


	}

	public function playComputer(){
		# Initialise the computer player. - Try to find a mapping of interest.
		$computerPlayer = new ComputerPlayer($this->boardMapping);
		$move = $computerPlayer->getSuggestedMove();
		if ($move != null){
			$playerColour = $computerPlayer->getComputerPlayerColour();
			#print('CordX: '.$move[0]. " CordY: ". $move[1] . " Colour: ".$playerColour );
			$this->boardMapping[$move[0]][$move[1]]=$playerColour;
		}		
		else{
			#print("Game Finished.");
		}
	}

	public function getBoard(){
		return $this->boardMapping;
	}

}

function loadMove(){
	$inputData = file_get_contents('php://input');
	$gameName = $_POST["gameName"];
	#print("\nGame: ".$gameName);
	#print("\nInputData: ".$inputData );
	$postData = json_decode(file_get_contents('php://input'), true);
	#print("\nPostData: ". $postData);

	$itemValue = $postData["gameName"];
	$cordX = $postData["cordX"];
	$cordY = $postData["cordY"];
	#print("\nGameName: ".$itemValue . " CordX: ".$cordX . " CordY: ". $cordY );

	$game = new NaughtsAndCrossesGame($itemValue);
	$game->addBoardEntry((int)$cordX,(int)$cordY,'blue');
	$game->playComputer();

	$boardData = $game->getBoard();
	$jsonBoard =	json_encode($boardData);
	print($jsonBoard);

	/*****************
	foreach ( array_keys( $postData ) as $arrayKey ){

		$itemValue = $postData[$arrayKey];
		print("\nArrayKey: ".$arrayKey . " Value: ".$itemValue );		
	}

	foreach ($postData as $dataItem){
		print("\nItem: ".$dataItem  );
	}
	*****************/

	


}

try{
loadMove();
}
catch(Exception $e){print($e);}

/*
$game = new NaughtsAndCrossesGame("input3");
$game->addBoardEntry(1,1,'red');
$game->addBoardEntry(0,1,'blue');
$game->addBoardEntry(0,0,'blue');
$game->playComputer();
*/
?>
