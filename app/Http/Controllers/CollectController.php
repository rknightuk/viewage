<?php

namespace App\Http\Controllers;

use App\PageView;

class CollectController extends Controller
{
    public function collect()
    {
    	$input = request()->input();

    	info(print_r($input, true));

    	$view = new PageView([
    		'site_id' => $input['sid'],
		    'path' => $input['p'],
		    'referrer' => $input['r'],
	    ]);

    	$view->save();

    	return $this->image();
    }

    private function image()
    {
	    $response = response()->make(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='), 200);
	    $response->header('Content-Type', 'image/gif');
	    return $response;
    }
}
