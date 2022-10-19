<?php

namespace Mihai\Weather\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mihai\Weather\Models\Forecast;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Validator;
use Mihai\Weather\Models\Day;

class ForecastController extends Controller
{
    public function get_ip_addreess()
    {
        $ip = '';
        $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        if($ip == '')
            {
                $ip = request()->ip();
            }
        return $ip;
    }

    public function get_curent_location($ip)
    {
        $currentUserInfo = Location::get($ip);
        return $currentUserInfo->cityName;
    }
    
   

    public function get_lat_long_by_ip($ip)
    {
        return explode(",", file_get_contents('https://ipapi.co/' . $ip . '/latlong/'));
    }

    public function get_forecast_by_location($city_name)
    {
        $weather = file_get_contents('https://api.openweathermap.org/data/2.5/forecast?q='.$city_name.'&appid=32ba0bfed592484379e51106cef3f204');
        return $weather;
    }
    
    public function weather()
    {
        $weather = $this->get_forecast_by_location($this->get_curent_location($this->get_ip_addreess()));
        $result = json_decode($weather);

        $data = ["ip"=> $this->get_ip_addreess(),
                "cityName" => $this->get_curent_location($this->get_ip_addreess()),
                "days"=>$result->list
                ];

        return view('weather::weather',$data);
    }


    public function forecast(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ip' =>'required',
        ]);

        if ($validator->fails()) {
            return view('weather::weather')->with('message','Please input an ip');
        }
        //we have to check if is an ip or someyhing else 

        $request_data = 
        [
            'ip'=>$request->input('ip'),
            'datetime'=>$request->input('datetime'),
        ];

        $forecast = Forecast::create($request_data);

        $weather = $this->get_forecast_by_location($this->get_curent_location($request_data['ip']));
        $result = json_decode($weather);

        $data = ["ip"=> $request_data['ip'],
                "cityName" => $this->get_curent_location($request_data['ip']),
                "days"=>$result->list
                ];

        $days=[];

        foreach($data['days'] as $key=>$value){
            $days[$key]['datetime'] = $value->dt_txt;
            $days[$key]['forecast_id'] = $forecast->id;
            $days[$key]['temp_min'] = $value->main->temp_min;
            $days[$key]['temp_max'] = $value->main->temp_max;
        }
        
        Day::insert($days);

        return view('weather::forecast',$data);

    }
}
