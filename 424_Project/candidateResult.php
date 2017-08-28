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
								$name = $_POST["president-candidate-query"];

								echo "input name : " . $name;
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

                        $name = $_POST["president-candidate-query"];

                        $sql = 
                        "
                        select can.name, elec.year, party.party_name, can.home_state, 
							round((c.vote_count/ct.vote_total)*100,2) as vote_percentage,
						    elec.winner
						from Candidate can, Participates p, ELections elec,
							Represents rep, Party party, Gets g, Count c, count_total ct
						where name like '%" . $name . "%'
							and can.CID=p.CID and p.year=elec.year
						    and rep.CID=can.CID and rep.year=p.year
						    and party.party_ID=rep.party_ID
						    and can.CID=g.CID and elec.year=g.year
						    and g.count_ID=c.count_ID
						    and elec.year=ct.year;
                        ";

                        $result = mysqli_query($con, $sql);

                        if(($row = mysqli_fetch_array($result))==false)
                        {
                        	echo "<h2>There is no information about the input name.</h2>";
                        	echo "<h2>Please go back and check your input.</h2>";
                        }
                        else
                        {
	                        echo "
	                        <table>
	                        	<thead>
	                        		<tr>
	                        			<th>Candidate Name</th>
	                        			<th>Election Year</th>
	                        			<th>Party Affiliation</th>
	                        			<th>Home State</th>
	                        			<th>Vote Percentage</th>
	                        			<th>Result</th>
	                        		</tr>
	                        	</thead>

	                        	<tbody>
	                        ";

	                        //This part is to show the data in the $row which for judgement
	                        echo "<tr>";

                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['year'] . "</td>";
                            echo "<td>" . $row['party_name'] . "</td>";
                            echo "<td>" . $row['home_state'] . "</td>";
                            echo "<td>" . $row['vote_percentage'] . "%" . "</td>";
                            
                            if($row['winner']==$row['name'])
                            {
                                echo "<td>win</td>";
                            }
                            else
                            {
                            	echo "<td>loss</td>";
                            }

                            echo "</tr>";
                            //First $row part has been down

                            //while loop for show data if there has left in the result
	                        while($row = mysqli_fetch_array($result))
	                        {
	                        	echo "<tr>";

	                            echo "<td>" . $row['name'] . "</td>";
	                            echo "<td>" . $row['year'] . "</td>";
	                            echo "<td>" . $row['party_name'] . "</td>";
	                            echo "<td>" . $row['home_state'] . "</td>";
	                            echo "<td>" . $row['vote_percentage'] . "%" . "</td>";
	                            
	                            if($row['winner']==$row['name'])
	                            {
	                                echo "<td>win</td>";
	                            }
	                            else
	                            {
	                            	echo "<td>loss</td>";
	                            }

	                            echo "</tr>";
	                        }

	                        echo "</tbody>";
	                        echo "</table>";
						}

						//Close the connection at last
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