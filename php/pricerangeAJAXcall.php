<?php

//  error checking POST variables.
    if($_POST['daterange']!==null & $_POST['price-min']>=0 & $_POST['price-max']<=10000 &
       is_numeric($_POST['price-min']) & is_numeric($_POST['price-max'])){
        $daterange = $_POST['daterange'];
        // substringing each date range since its original format is YYYY-MM-DD - YYYY-MM-DD
        $date1 = substr($daterange, 0, 10);
        $date2 = substr($daterange, 12);
        $pricemin = $_POST['price-min']; // get min price sent to server
        $pricemax = $_POST['price-max']; // get max price sent to server
        include("shared.php");
        $db = new mysqli($servername, $username, $password, $dbname);  // make the db connection and query
        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $query = "SELECT s.ticker, AVG(s.close) AS 'Average Price Across Date Range'
        FROM sp500_quotes AS s
        WHERE  (s.close BETWEEN " . $pricemin . " AND ". $pricemax . ") AND
	      (s.date BETWEEN '". $date1 . "' AND '" . $date2 . "')
        GROUP BY s.ticker;";


        if(!$result = $db->query($query)){
            die('There was an error running the query [' . $db->error . ']');
        }
        $row_count = $result->num_rows;
         //$row_count = $result->num_rows;
         //echo $row_count;
        if($row_count < 1){
            echo '<h2>No data!</h2>';
        } else{
            echo '<table id="companies">';
            echo '<caption>Average closing prices between ' . $date1 .' and ' .$date2 . '
            when ticker closing price fell between ' .$pricemin.' and ' . $pricemax .'!</caption>';
            echo '<th>index</th><th>ticker</th><th>avg price</th>';
            $i = 1;
            while($row = $result->fetch_assoc()){
                echo '<tr>';

                echo '<td>' . $i++ .
                 '<td>' . $row['ticker'] .
                    '</td><td>' . $row['Average Price Across Date Range'] . '</tr>';
            }
        }
    }
    else{

        echo '<h3>incorrect values in the form!!</h3>';
    }


?>
