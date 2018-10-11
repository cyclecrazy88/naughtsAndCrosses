<?php

class ShowDetails{
	private $arrayData = [];
	private $resultSummaryData = [];

	private $totalSummaryItem = null;
	function __construct(){
		// Initialise the summary data
		$this->totalSummaryItem = array("red"=>0, "blue"=>0, "count"=>0);

		//echo "Load Details\n";
		$directoryList = scandir('./gameData/');
		$indexCount = 0;
		foreach ($directoryList as $item){
			// Run a Regex Expression to see if this is a string of interest.
			$matchCount = preg_match('/^[a-z]{0,20}[0-9]{0,10}.[a-z]{0,3}$/',$item);
			// Count the number of matches found for the item
			if ($matchCount > 0 && strlen( trim($item) ) > 3 ){
				//echo "Item: ".$item."\n";

				$fileData = fopen('./gameData/'.$item, 'r');
			
				$appendData = '';
				while ($fileLine = fgets($fileData, 1024) ){
					$appendData .= $fileLine; 
				}

				fclose($fileData);
				$jsonItem = json_decode($appendData);
				array_push($this->arrayData,$jsonItem);
				$dataSummary = $this->summariseData($jsonItem);
				//echo "ResultSummary: ".count($dataSummary);
				// Increment the file number for the counter.
				$indexCount++;
				$dataSummary["itemNumber"] = $indexCount;
				//echo "SummaryLength: ", count($this->resultSummaryData)."\n";
				array_push($this->resultSummaryData,$dataSummary);
				
			}
		}

	}
	function __destruct(){
		//echo "Unload Details\n";
	}
	// Format the response json into an output object for display to the web-browser.
	public function outputResult(){

		$totalRed = $this->totalSummaryItem["red"];
		$totalBlue = $this->totalSummaryItem["blue"];
		$totalCount = $this->totalSummaryItem["count"];

		//echo "Total Count: ". $totalCount;

		// Run a calculation over the averages. Basically, what's the total averages here.
		$averageRed = 0;
		$averageBlue = 0;

		if ($totalRed > 0 && $totalCount > 0){
			# Average and round the number nicely
			$averageRed = round($totalRed / $totalCount );
		}

		if ($totalBlue > 0 && $totalCount > 0){
			# Average and round the number nicely
			$averageBlue = round($totalBlue / $totalCount );
		}

		$averageArray = array("averageRed"=>$averageRed,"averageBlue"=>$averageBlue);

		// Format the response nicely into an output
		return array("details"=>$this->resultSummaryData,"summary"=>$this->totalSummaryItem,"average"=>$averageArray);
	}

	private function summariseData($inputData){
		// Increment the item count number
		$this->totalSummaryItem["count"]++;

		//echo "Summarise Data\n";
		# Initialise the data summary
		# Red/Blue for the player codes. Item number for the game number.
		$outputData = array("red"=>0, "blue"=>0,"itemNumber"=>NULL);
		foreach ($inputData as $firstItem){
			foreach ($firstItem as $secondItem){
				// Check to see if the item has a value or is currently set.				
				if ( strlen( trim($secondItem) ) > 0 ){
					//echo 'Item Data: '.	$secondItem."\n";
					if (isset( $outputData[$secondItem] )){
						//echo 'Increment Value: '.$outputData[$secondItem]."\n";
						$outputData[$secondItem]++;

						$this->totalSummaryItem[$secondItem]++;
					}
				}
			}
		}
		return $outputData;
	}

}

//echo "Show Details\n";
$details = new ShowDetails();
echo json_encode( $details->outputResult() );

?>
