<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<?php
include "config.php";

$continentData = mysqli_query($con,"select * from virus_agg ORDER BY Country");

$response = array();
$tempdate=$prevdate="2019-04-09";
$tempcountry=$prevcountry="";
$tempstate=$prevstate="";
$statewise=array();


while($row = mysqli_fetch_assoc($continentData)){

    $response[] = $row;
    
 }
for($i=0; $i <count($response); $i++ )
{
    if($response[$i]['Country']==$prevcountry)
    {
        if($response[$i]['State']==$prevstate)
        {
            if($response[$i]['Date']> $prevdate)
            {
                $statewise[count($statewise)-1]=[$response[$i]['Country'],$response[$i]['State'],$response[$i]['Date'],$response[$i]['Confirmed'],$response[$i]['Recovered'],$response[$i]['Deaths'],$response[$i]['Continents']];
            }
        }
        else
        {
            $statewise[count($statewise)]=[$response[$i]['Country'],$response[$i]['State'],$response[$i]['Date'],$response[$i]['Confirmed'],$response[$i]['Recovered'],$response[$i]['Deaths'],$response[$i]['Continents']];
            $prevcountry=$response[$i]['Country'];
            $prevstate=$response[$i]['State'];
            $prevdate=$response[$i]['Date'];
        }
    }
    else
    {
        $statewise[count($statewise)]=[$response[$i]['Country'],$response[$i]['State'],$response[$i]['Date'],$response[$i]['Confirmed'],$response[$i]['Recovered'],$response[$i]['Deaths'],$response[$i]['Continents']];
        $prevcountry=$response[$i]['Country'];
        $prevstate=$response[$i]['State'];
        $prevdate=$response[$i]['Date'];
    }

}


$tempcountry=$prevcountry="";
$conf=0;
$reco=0;
$deat=0;
$countries=array();

for($i=0; $i <count($statewise); $i++ )
{
    if($statewise[$i][0]==$prevcountry)
    {
        $conf+=$statewise[$i][3];
        $reco+=$statewise[$i][4];
        $deat+=$statewise[$i][5];


        $countries[count($countries)-1]=[$statewise[$i][0],$statewise[$i][2],$conf,$reco,$deat,$statewise[$i][6]];
    }
    else
    {
        $countries[count($countries)]=[$statewise[$i][0],$statewise[$i][2],$statewise[$i][3],$statewise[$i][4],$statewise[$i][5],$statewise[$i][6]];
        $prevcountry=$statewise[$i][0];
        $conf=(int)$statewise[$i][3];
        $reco=(int)$statewise[$i][4];
        $deat=(int)$statewise[$i][5];
        
    }
}


echo "<table class='table'>  
<tr><th>Country</th><th>Confirmed</th><th>Recovered</th><th>Death</th><th>Continent</th></tr>";

for($i=0; $i<count($countries); $i++)
{
    echo "<tr><td>".$countries[$i][0]."</td><td>".$countries[$i][2]."</td><td>".$countries[$i][3]."</td><td>".$countries[$i][4]."</td><td>".$countries[$i][5]."</td></tr>";
}

?>