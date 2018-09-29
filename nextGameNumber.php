<?php
function nextGameNumber(){
	$countNumber = 0;
	$directoryList = scandir('./gameData/');
	for ($count = 0 ; $count < count( $directoryList ) ; $count++){
		$matchCount = preg_match('/[a-z]{1,5}[0-9]{1,10}+[.]txt$/',
															$directoryList[$count]);
		if ($matchCount > 0){
			#print("\nDirectoryItem: ".$directoryList[$count] );
			$countNumber++;
		}

	}

	#print("NextNumber: ".$countNumber);
	return 'input'.($countNumber+1);
}

class CreateGameCode{
	public $gameCode = null;
	public function __construct(){
			$this->gameCode = nextGameNumber();
		}
	}

# Create an empty object - Then format the output
$outputObject = new CreateGameCode();
print(json_encode(  $outputObject ))
?>
