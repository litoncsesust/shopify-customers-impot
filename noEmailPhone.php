<?php
// Read the original CSV file
$originalCsvPath = 'original.csv';
$csvRows = [];

if (($handle = fopen($originalCsvPath, 'r')) !== false) {
    while (($data = fgetcsv($handle)) !== false) {
        $csvRows[] = $data;
    }
    fclose($handle);
}

// Filter rows based on conditions
$filteredRows = [];

foreach ($csvRows as $row) {
    // Check if email, phone, and last name are empty
    $email = $row[1]; // Assuming email is in the third column (index 2)
    $phone = $row[5]; // Assuming phone is in the fourth column (index 3)
    $lastName = $row[4]; // Assuming last name is in the second column (index 1)

    if (empty($email)  && !empty($phone)) {
        $filteredRows[] = $row;
    }
}

// Write filtered rows to a new CSV file
$filteredCsvPath = 'filterednewonlylastname.csv';

if (($handle = fopen($filteredCsvPath, 'w')) !== false) {
    foreach ($filteredRows as $row) {
        fputcsv($handle, $row);
    }
    fclose($handle);
    echo "Filtered rows have been written to '$filteredCsvPath'.";
} else {
    echo "Error creating the new CSV file.";
}
?>
