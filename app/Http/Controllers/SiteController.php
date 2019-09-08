<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSite;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController extends Controller
{
    public function index()
    {
    	$sites = Site::all();

    	return view('dashboard.sites', ['sites' => $sites]);
    }

    public function new()
    {
	    return view('dashboard.create');
    }

    public function store(CreateSite $request)
    {
		Site::create([
			'key' => uniqid(),
			'name' => $request->input('name'),
			'domain' => $request->input('domain')
		]);

		return redirect('/sites');
    }

    public function show(int $siteId)
    {
    	$site = Site::find($siteId);

    	if (is_null($site)) throw new NotFoundHttpException();

    	$views = DB::table('page_views')
		    ->select('path', DB::raw('count(*) as total'))
		    ->groupBy('path')
		    ->orderBy('total', 'desc')
		    ->get();

    	return view('dashboard.show', ['site' => $site, 'views' => $views]);
    }
}
