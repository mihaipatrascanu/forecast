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
        <h1 class="namePage">Weather Forecast For Next Days in {{$cityName ?? ''}}</h1>
        <form action="{{route('forecast')}}" method="post" class="formPage">
            @csrf
            <label for="ip">Your IP Address</label>
            <input type="text" id="ip" name="ip" placeholder="Your IP Address" value="{{$ip ?? ''}}" required>
            <label for="datetime">Select A Date</label>
            <input type="datetime-local" id="datetime" name="datetime" autocomplete="on" value="{{ date('Y-m-d H:i') }}" required>
            <input  type="submit" value="Submit">
        </form>
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