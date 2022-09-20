<?php


function outcsv($cols, $table)
{
    //Our MySQL connection details.
    //file_put_contents('/'.$table‘-’.date('Y-m-d').'-'.'.csv', ‘’);
    $servername = '127.0.0.1';
    $username = 'auser';
    $password = 'supereasypasslol';
    $dbname = "awakenla";
    $dsn = "mysql:host=" . $servername . ";dbname=" . $dbname . ";charset=UTF8";

    try {
        $pdo = new PDO($dsn, $username, $password);

        if ($pdo) {
            //echo "Connected to the $dbname database successfully!>
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    //echo "Columns:";
    //echo $cols;
    //echo "Table:";
    //echo $table;
    //Create our SQL query.
    $sql = "SELECT " . $cols . " FROM " . $table . " LIMIT 20";

    //Prepare our SQL query.
    $statement = $pdo->query($sql);

    //Executre our SQL query.
    //$statement->execute();

    //Fetch all of the rows from our MySQL table.
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    //Get the column names.
    $columnNames = array();
    if (!empty($rows)) {
        //We only need to loop through the first row of our result
        //in order to collate the column names.
        $firstRow = $rows[0];
        foreach ($firstRow as $colName => $val) {
            $columnNames[] = $colName;
            //echo $colName;
        }
    }

    //Setup the filename that our CSV will have when it is downloaded.
    $fName = "{$table}.csv";
    //echo $fileName;

    //Open up a file pointer
    $fp = fopen($fName, 'w');
    if ($fp === false) {
        exit("Error creating $fName");
    }
    //Start off by writing the column names to the file.
    fputcsv($fp, $columnNames);

    //Then, loop through the rows and write them to the CSV file.
    //var_dump($rows);
    foreach ($rows as $row) {
        fputcsv($fp, $row);
    }

    //Close the file pointer.
    fclose($fp);
}
