<?php

namespace Mihai\Weather\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mihai\Weather\Models\Forecast;

class ForecastController extends Controller
{
    public function weather()
    {
        return view('weather::weather');
    }

    public function forecast(Request $request)
    {
        $data = 
        [
            'ip'=>$request->input('ip'),
            'datetime'=>$request->input('datetime'),
            'day_id'=>'0'
        ];

        Forecast::insert($data);

        //return $request->all();
        return view('weather::forecast', ['data'=>$data]);
    }
}
