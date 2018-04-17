<!DOCTYPE HTML>
<html>
    <head>
        <title>Stock Overflow</title>
        <script type="text/javascript" src="../d3/d3.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="../buttons.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <link rel="stylesheet" href="../generalStyle.css">
    </head>
    <body>
        
        
        
        <div class="jumbotron">
          <div class="container text-center" id="logo">

              <a href="../homepage.html"><img src="../images/logo.png" height="250px"></a>

          </div>
        </div>
        <div id="buttonArea">
      
            <div class="container-fluid bg-3 text-center">    
              <h3>Graph of AVG Closing, High, and Low Price of Company per Year:</h3><br>
              <div class="row" id="paragraphArea">
                <?php 
                include("shared.php");
                $db = new mysqli($servername, $username, $password, $dbname);
                if($db->connect_errno > 0){
                    die('Unable to connect to database [' . $db->connect_error . ']');
                }              
                $query2 = "SELECT DISTINCT ticker from sp500_quotes
                order by ticker;";

                if(!$result3 = $db->query($query2)){
                    die('There was an error running the query [' . $db->error . ']');
                }
                ?>
                    <select id="select" name="ticker" onchange="myFunction(this.value)">
                        <option value="null"></option>
                        <?php
                            while($row = $result3->fetch_assoc()){
                                echo '<option value="' . $row['ticker'] . '">' . $row['ticker'] .'</option>';
                            }
                        ?>
                    </select>
                <script>
                function myFunction(selection){
                    $.post('graphingAJAXcall.php', {ticker:selection},
                          function(data){
                        $('#chart').html(data);
                    });
                }    
                </script>
                  <div id="outerChart"></div><div id="chart"></div></div>
                  
                  
                  
                  
                  
                  
                  
              </div>
            </div><br>
            
            
            
            
            
            
            <div class="container-fluid bg-3 text-center">    
              <div class="row">
                <div class="col-sm-6"> 
                  
                    <form action="top5date.php">
                    <button class="bttn-fill bttn-lg bttn-warning">Top 5, Top 5, Top 5</button>
                    </form>
                </div>
                <div class="col-sm-6"> 
                  
                    <form action="topFivePerSector.php">
                        <button class="bttn-fill bttn-lg bttn-danger">Top 5, Top 5, Top 5 ... per sector</button>
                    </form>
                </div>
                

              </div>
                
                <br>
                
                <div class="row">
                
                <div class="col-sm-6">
                  
                    <form action="pricerange.php">
                        <button class="bttn-fill bttn-lg bttn-success">Date-ta-Pricefy</button>
                    </form>
                    </div>
                <div class="col-sm-6"> 
                  <form action="bargraph.php">
                      <button class="bttn-fill bttn-lg bttn-royal">(Top 10 Closing Prices) Bargraphify</button>
                    </form>
                </div>

              </div>
            </div><br><br>
            <footer class="container-fluid text-center">
              <p>StockOverFlow 2017</p>
            </footer>
        </div>
        
        
        
        
    </body>
</html>