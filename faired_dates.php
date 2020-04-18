<?php
include "config.php";

$continentData = mysqli_query($con,"select * from virus_agg ORDER BY Country");

$response = array();
$tempdate=$prevdate="2019-04-09";
$tempcountry=$prevcountry="";
$tempstate=$prevstate="";
$countries=array();


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
                $countries[count($countries)-1]=[$response[$i]['Country'],$response[$i]['State'],$response[$i]['Date'],$response[$i]['Confirmed'],$response[$i]['Recovered'],$response[$i]['Deaths'],$response[$i]['Continents']];
            }
        }
        else
        {
            $countries[count($countries)]=[$response[$i]['Country'],$response[$i]['State'],$response[$i]['Date'],$response[$i]['Confirmed'],$response[$i]['Recovered'],$response[$i]['Deaths'],$response[$i]['Continents']];
            $prevcountry=$response[$i]['Country'];
            $prevstate=$response[$i]['State'];
            $prevdate=$response[$i]['Date'];
        }
    }
    else
    {
        $countries[count($countries)]=[$response[$i]['Country'],$response[$i]['State'],$response[$i]['Date'],$response[$i]['Confirmed'],$response[$i]['Recovered'],$response[$i]['Deaths'],$response[$i]['Continents']];
        $prevcountry=$response[$i]['Country'];
        $prevstate=$response[$i]['State'];
        $prevdate=$response[$i]['Date'];
    }

}
echo $countries[count($countries)-1][6];
echo count($countries);
echo json_encode($countries);

exit;

?>