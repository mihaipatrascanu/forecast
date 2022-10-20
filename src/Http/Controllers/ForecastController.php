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
     /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $cityName;

    public function __construct()
    {
        $this->get_ip_addreess();
        $this->get_curent_location();
    }

    public function get_ip_addreess()
    {
        $ip = '';
        $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        if($ip == '')
            {
                $ip = request()->ip();
            }

        $this->ip = $ip;
    }

    public function get_curent_location()
    {
        $this->cityName = Location::get($this->ip)->cityName;
    }

    public function get_lat_long_by_ip()
    {
        return explode(",", file_get_contents('https://ipapi.co/' . $this->ip. '/latlong/'));
    }

    public function get_forecast_by_location()
    {
    
        try
        {
            $weather = file_get_contents('https://api.openweathermap.org/data/2.5/forecast?q='.$this->cityName.'&appid=32ba0bfed592484379e51106cef3f204');
        }
        catch (\Exception $e)
        {
            $weather = FALSE;
        }
     
        return $weather;
    }
    
    public function weather()
    {
        $weather = $this->get_forecast_by_location();

        if($weather) 
        {
        $result = json_decode($weather);

        $data = ["ip"=> $this->ip,
                "cityName" => $this->cityName,
                "days"=>$result->list
                ];
        } else {
            $data = ["ip"=> $this->ip,
                    "cityName" => $this->cityName,
                    "days"=>[]
                    ];

        }

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

        $weather = $this->get_forecast_by_location();
        $result = json_decode($weather);

        $data = ["ip"=> $request_data['ip'],
                "cityName" => $this->cityName,
                "days"=>$result->list
                ];

        $days=[];

        foreach($data['days'] as $key=>$value)
        {
            $days[$key]['datetime'] = $value->dt_txt;
            $days[$key]['forecast_id'] = $forecast->id;
            $days[$key]['temp_min'] = $value->main->temp_min;
            $days[$key]['temp_max'] = $value->main->temp_max;
        }
        
        Day::insert($days);

        return view('weather::forecast',$data);

    }
}
