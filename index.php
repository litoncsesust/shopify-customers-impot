<?php

function read_csv($filename)
{
    $rows = array();
    if (($handle = fopen($filename, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $rows[] = $data;
        }
        fclose($handle);
    }
    return $rows;
}

function create_email_id_mapping($data)
{
    $mapping = array();
    foreach ($data as $row) {
        $mapping[$row[1]] = $row[0]; // Assuming ID is in the first column (index 0) and email is in the second column (index 1)
    }
    return $mapping;
}

function find_matching_rows($data1, $data2, $email_id_mapping)
{
    $matching_rows = array();

    foreach ($data2 as $row) {
        $email = $row[1]; // Assuming email is in the second column (index 1)
        if (isset($email_id_mapping[$email])) {
            $row[0] = $email_id_mapping[$email]; // Replace the ID value with the one from the mapping
            $matching_rows[] = $row;
        }
    }

    return $matching_rows;
}

function write_csv($filename, $data)
{
    if (($handle = fopen($filename, "w")) !== false) {
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}

// Replace these with the actual filenames
$file1 = 'Customers-UK-EU.csv';
$file2 = 'Customers-US.csv';

$data1 = read_csv($file1);
$data2 = read_csv($file2);

$email_id_mapping = create_email_id_mapping($data1);

$matching_rows = find_matching_rows($data1, $data2, $email_id_mapping);

// Replace 'matching_rows.csv' with the desired output filename
$output_file = 'matching_rows_ukeu_us.csv';

write_csv($output_file, $matching_rows);

echo "Matching rows with replaced ID values have been written to $output_file.";
