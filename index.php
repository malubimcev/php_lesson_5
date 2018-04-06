<?php
    $celsiusZero = 273.15;//температура 0 град. по Цельсию
    $city = "Murmansk,ru";
    $userKey = "c75ecbe2264d2b9f9e34626b184ba756";//личный код пользователя OpenWeatherMap
    $request = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$userKey";//запрос на сервер OpenWeatherMap
    $response = file_get_contents($request);//ответ сервера
    if($response){
        file_put_contents('weather.json', $response);
        $weather_data = json_decode($response, true);
        unset($response);
        foreach ($weather_data as $key => $data) {
            switch ($key) {
                case "weather":
                    $cloudiness =$data[0]['description'];
                    break;
                case "main":
                    $celsius = $data['temp'] - $celsiusZero;
                    $pressure = $data['pressure'];
                    $humidity = $data['humidity'];
                    break;
                case "wind":
                    $wind_speed = $data['speed'];
                    $wind_direction = $data['deg'];
                    break;
                case "sys":
                    $sunrise = strftime("%c", $data['sunrise']);
                    $sunset = strftime("%c", $data['sunset']);
                    break;
            }
        }
    } else {
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PHP_lesson_4</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <div class="container">
            <?php echo "<h1>Current weather in $city</h1>"; ?>
            <table>
                <tbody>
                    <tr>
                        <td>Temperature</td>
                        <td><?php echo $celsius." <sup>o</sup>C" ?></td>
                    </tr>
                    <tr>
                        <td>Cloudiness</td>
                        <td><?php echo $cloudiness ?></td>
                    </tr>
                    <tr>
                        <td>Pressure</td>
                        <td><?php echo $pressure." hPa" ?></td>
                    </tr>
                    <tr>
                        <td>Humidity</td>
                        <td><?php echo $humidity." %" ?></td>
                    </tr>
                    <tr>
                        <td>Wind speed</td>
                        <td><?php echo $wind_speed." m/s" ?></td>
                    </tr>
                    <tr>
                        <td>Wind direction</td>
                        <td><?php echo $wind_direction." deg" ?></td>
                    </tr>
                    <tr>
                        <td>Sunrise</td>
                        <td><?php echo $sunrise ?></td>
                    </tr>
                    <tr>
                        <td>Sunset</td>
                        <td><?php echo $sunset ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
