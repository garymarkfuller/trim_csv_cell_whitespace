<?php 
// Define filename for new CSV file
$newfilename = "newfile"; 
// Set header to csv to make the script automatically download the new csv in the browser 
// This must be near the top of the file so that the header information isn't already sent by the time this portion of the script runs
header("Content-type: text/csv");  
header("Content-Disposition: attachment; filename={$newfilename}.csv");
header("Pragma: no-cache");
header("Expires: 0");
// Define filename of existing file 
$filename = "file.csv";
// Open the existing file with read access only
$existingfile = fopen($filename, "r");
// Create an empty array for the new data
$newdata = [];
// Open the output buffer with write access
$outputBuffer = fopen("php://output", 'w');
// While not at the end of the existing file get a row from the csv and remove any whitespace at the end of each cell
while(!feof($existingfile)) {
	// Get a row from the csv file
	$data = fgetcsv($existingfile, 0, ",");
	// Create an empty array for the new row
	$newrow = [];
	// If the row is an array remove any whitespace at the end of the cell and add the cell to a new array
	if(is_array($data)) {
		// Use each of the values of the existing array of cell values as the variable $value 
		foreach($data as $value) {
			// Remove the whitespace from the existing cell and assign the resulting value to the variable $newvalue
			$newvalue = preg_replace('/[\pZ\pC]+$/u', '',$value);
			// Add the variable $newvalue to the array $newrow
			$newrow[] = $newvalue;
		}
	}
	// Use the $newrow array to add a new row to the csv file being generated in the output buffer
	fputcsv($outputBuffer, $newrow);
}

