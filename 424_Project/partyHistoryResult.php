<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <title>History of Presidential Elections</title>

	    <!-- Bootstrap -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">

	    <!--My own style-->
	    <link href="css/style.css" rel="stylesheet">
	    <link href="css/font-awesome.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>

	<body>

		<!--Fixed Navbar-->
		<!--********************************************************************************-->
	    <nav class="navbar navbar-default navbar-fixed-top">
	    	<div class="container">
	    		<div class="navbar-header">
	    			<a class="navbar-brand" href="index.html">History of Presidential Elections</a>
	    		</div>

	    		<div class="navbar-collapse collapse navbar-right">
		          	<ul class="nav navbar-nav">
		          		<!--Home icon-->
		            	<li>
					  		<a href="index.html">
								<span class="glyphicon glyphicon-home"></span>
								<br>
								Home
					  		</a>
						</li>
						<!--Query icon-->
		            	<li>
							<a href="query.html">
								<span class="glyphicon glyphicon-search"></span>
				                <br>
								Query
							</a>
						</li>
						<!--About icon-->
		            	<li>
						  	<a href="#footerwrap">
								<span class="glyphicon glyphicon-info-sign"></span>
				                <br>
								About
					  		</a>
						</li>
		          	</ul>
		        </div><!--/.nav-collapse -->
	    	</div>
	    </nav>

	    <!--Main content-->
	    <!--********************************************************************************-->
	    <div id="headerwrap">
	    	<div class="container">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<h3 class="single-query-tip">Query Result</h3>
						<p class="single-query-detail">
							<?php
								$party = $_POST["party-historical-query"];

								echo "selected party : " . $party;
							?> 
						</p>	
					</div>
				</div><!-- /row -->

				<div class="row">
					<?php
						$con = mysqli_connect("127.0.0.1", "root", "root", "presidential_election_database");

						if (mysqli_connect_errno())
                        {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }

                        $sql = 
                        '
                        	select temp.year, temp.vote_sum, temp.party_ID, pp.party_ID as success_ID
							from
							(
							select rep.year, party.party_ID, sum(vote_count) as vote_sum
							from Party party, Represents rep, Candidate can,
							    Gets g, Count c
							where party.party_name="' . $_POST['party-historical-query'] . '"
							    and party.party_ID=rep.party_ID
							    and rep.CID=can.CID
							    and g.CID=can.CID and g.year=rep.year
							    and g.count_ID=c.count_ID
							group by party.party_ID, rep.year) temp
							left outer join
							president_party pp
							on temp.year=pp.year;
                        ';

                        $result = mysqli_query($con, $sql);

                        echo "
                        <table>
                        	<thead>
                        		<tr>
                        			<th>Election Year</th>
                        			<th>Result</th>
                        			<th>Vote Counts Sum</th>
                        		</tr>
                        	</thead>

                        	<tbody>
                        ";

                        $winCount = 0;
                        $lossCount = 0;

                        while($row = mysqli_fetch_array($result))
                        {
                        	echo "<tr>";

                            echo "<td>" . $row['year'] . "</td>";

                            if($row['party_ID']==$row['success_ID'])
                            {
                            	$winCount++;
                            	echo "<td>win</td>"; 
                            }
                            else
                            {
                            	$lossCount++;
                            	echo "<td>loss</td>";
                            }

                            echo "<td>" . $row['vote_sum'] . "</td>";

                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";

                        echo "<h2><p class='single-query-detail'>win/loss : </h2>"; 
                        echo "<h2>" . $winCount . "/" . $lossCount . "</h2>";
                        echo "</p>";

                        mysqli_close($con);
					?>
				</div>

	    	</div> <!-- /container -->

	 

		</div><!-- /headerwrap -->

		<!--Footer-->
		<!--********************************************************************************-->
		<div id="footerwrap">
		 	<div class="container">
			 	<div class="row">
			 		<div class="col-lg-6">
					  	<div class="centered">
			 				<h4>Course</h4>
		 					<p>just for fun</p>
				  		</div>
		 			</div>
					<div class="col-lg-6">
				  		<div class="centered">
				 			<h4>Author</h4>
				 			<p>Liang kai</p>
				  		</div>
		 			</div>
		 		</div><!--row -->
	 		</div><!--container-->
	 	</div><!--footerwrap-->


		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>

	    <!-- Latest compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

		<!-- (Optional) Latest compiled and minified JavaScript translation files -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/i18n/defaults-*.min.js"></script>


	</body>
</html>