<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link css file from outside  -->
    <link rel="stylesheet" href="style.css">
    <title>Air Quality Check</title>
</head>

<body>
    <!-- heading -->
    <h1>Air Quality Index Of Cities</h1>
    <h3>
        <span1>Green = good air quality</span1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span2>Yellow = modrate air quality</span2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span3>Orange = Unhealthy for Sensitive Groups</span3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span4>Red = Unhealthy</span4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span5>Purple = Very Unhealthy</span5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span6>Marron = Hazardous</span6>

    </h3>
    <!-- a wrapper class that contains class of container which include a form with 
city_name  & a button  -->
    <div class="wrapper">
        <div class="container">
            <form action="index.php" method="Get">

                <label for="fname">Enter City Name</label>
                <input type="text" name="station" placeholder="City name..">
                <input type="submit" value="Search">

            </form>
        </div>
    </div>


    <!-- I again use a wrapper class which contains all "PHP" code to 
add "AQICN API" in web page  -->
    <div class="wrapper">
        <?php
        // get city name from user and if the city_name null then
        //  by default "Delhi" will be considered 
        if (isset($_GET['station']) && $_GET['station'] != '') {
            $station = $_GET['station'];
        } else {
            $station = 'Delhi';
        }
        // Here my token or "API" key that I get from ( https://aqicn.org/api/)
        $token = "32242342824e6b4c038474a3477962a65b4e1fde";
        //sreach by using this url it contain my token & station name
        $api_url = 'http://api.waqi.info/search/?token=' . $token . '&keyword=' . $station;
        // decode the json request that we get from api
        $response = json_decode(file_get_contents($api_url));
        if (isset($response->status) && $response->status == "ok") {
            $stations = $response->data;
            foreach ($stations as $station) {
                $air_quality = ($station->aqi == '') ? '$aqi' : $station->aqi;
                //the condition that shows that quality of air by using color
                if ($air_quality < 50) {
                    $class = 'green';
                } elseif ($air_quality > 51 && $air_quality < 100) {
                    $class = "yellow";
                } elseif ($air_quality > 101 && $air_quality < 250) {
                    $class = "orange";
                } elseif ($air_quality > 251 && $air_quality < 300) {
                    $class = "red";
                } elseif ($air_quality > 301 && $air_quality < 400) {
                    $class = "redder";
                } elseif ($air_quality > 401 && $air_quality < 900) {
                    $class = "redest";
                }
                $updated_at = $station->time->stime;
                $station_name = $station->station->name;
        ?>
                <!-- display the aqi in the form of card view -->
                <div class="card <?php echo $class; ?>">
                    <p class="aqi-value"><?php echo $air_quality; ?></p>
                    <p><?php echo $station_name; ?></p>
                </div>
        <?php }
        }
        ?>
    </div>
</body>

</html>