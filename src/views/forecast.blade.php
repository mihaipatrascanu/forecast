<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">  
</head>
<body> 
    
    <div class="myForm">
        <h1 class="namePage">Weather Forecast For Next Days in {{$cityName ?? ''}} 
        <a href="{{route('weather')}}" class="btn btn-default">Back</a></h1> 
    </div>
    <div id = "myContainer">
        <div id="myRow">  
        @foreach($days as $day)
            <div class = "day">
                <p class="weather">{{$day->dt_txt}}</p>
                <p class="weather">{{date('l',strtotime($day->dt_txt))}}</p>
                <div class="image"><img src="https://openweathermap.org/img/wn/{{$day->weather[0]->icon}}.png" class="imgClass"></div>
                <p class="minValues">Min Temp: {{$day->main->temp_min-273.15}} °C</p>
                <p class="maxValues">Max Temp: {{$day->main->temp_max-273.15}} °C</p>
            </div>            
        @endforeach
        </div>
    </div>
</body>
</html>