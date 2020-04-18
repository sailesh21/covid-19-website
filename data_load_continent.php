<?php

include 'config.php';

$open = fopen('covid_19_data_new.csv','r');

$qry = "INSERT INTO virus_agg (Country,State,Date,Confirmed,Recovered,Deaths,Continents) VALUES ";

while (!feof($open)) 
{
    $getTextLine = fgets($open);
    list($Country,$State,$Date,$Confirmed,$Recovered,$Deaths,$Continents)=explode(',',$getTextLine);
    #echo "$Country,$State,$Date,$Confirmed,$Recovered,$Deaths,$Continents";
    
    
    
    $qry.="('$Country','$State','$Date','$Confirmed','$Recovered','$Deaths','$Continents'),";

    
    #echo "$id";
    #echo "$name";
    #echo "$symptoms";

    #$qry = "insert into disease (id,name,link,symptons) VALUES ('$id','$name','$link','$symptons')";
    
    

}

$qry=substr($qry, 0,-1);

echo "$qry";
if(mysqli_query($con,$qry)){
        echo "Success inserted \n";
    }
    else{
        echo "failure";
    }
fclose($open);



?>

