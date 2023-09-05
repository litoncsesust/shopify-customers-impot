<?php
// Read the contents of file1.csv
$file1 = 'file1.csv';
$file1Data = array_map('str_getcsv', file($file1));

// Read the contents of file2.csv
$file2 = 'file2.csv';
$file2Data = array_map('str_getcsv', file($file2));

// Extract email IDs from file1.csv
$emailIds1 = [];
foreach ($file1Data as $row) {
    $emailIds1[] = $row[0]; // Assuming email IDs are in the first column
}

// Filter missing email IDs and store their data
$missingEmailsData = [];
$filteredData = [];
foreach ($file2Data as $row) {
    $email = $row[0]; // Assuming email IDs are in the first column
    if (!in_array($email, $emailIds1)) {
        $missingEmailsData[] = $row;
    } else {
        $filteredData[] = $row;
    }
}

// Store data of missing emails in a separate CSV file
$missingEmailsFile = 'missing_emails.csv';
$missingEmailsFileHandle = fopen($missingEmailsFile, 'w');
foreach ($missingEmailsData as $row) {
    fputcsv($missingEmailsFileHandle, $row);
}
fclose($missingEmailsFileHandle);

// Store filtered data in file2_filtered.csv
$filteredFile = 'file2_filtered.csv';
$filteredFileHandle = fopen($filteredFile, 'w');
foreach ($filteredData as $row) {
    fputcsv($filteredFileHandle, $row);
}
fclose($filteredFileHandle);

echo "Missing email data saved to '$missingEmailsFile'.\n";
echo "Filtered data saved to '$filteredFile'.\n";
?>
