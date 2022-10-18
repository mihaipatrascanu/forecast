<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
</head>
<body>
    <h1>Weather Forecast For Next 5 Days</h1>
    <form action="{{route('forecast')}}" method="post">
        @csrf
        <label for="ip">Your IP Address</label>
        <input type="text" id="ip" name="ip" placeholder="Your IP Address">
        <label for="datetime">Select A Date</label>
        <input type="datetime-local" id="datetime" name="datetime">
        <input  type="submit" value="Submit">
    </form>
</body>
</html>