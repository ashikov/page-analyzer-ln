<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\View\View;

class UrlController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validator = app('validator')->make($request->input('url'), [
            'name' => 'required|url'
        ]);

        if ($validator->fails()) {
            return redirect()->route('welcome')->withErrors($validator)->withInput();
        };

        $data = $request->input('url');
        $url = $data['name'];
        $parsedUrl = parse_url(strtolower($url));
        $host = $parsedUrl['host'];
        $scheme = $parsedUrl['scheme'];
        $normalizedUrl = "{$scheme}://{$host}";

        $url = DB::table('urls')->where('name', $normalizedUrl)->first();

        if (isset($url)) {
            flash('Url exists');
            return redirect()->route('urls.show', $url->id);
        }

        $id = DB::table('urls')
            ->insertGetId([
                'name' => $normalizedUrl,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ]);


        flash('Url has been added')->success();
        return redirect()->route('urls.show', $id);
    }

    public function index(): View
    {
        $urls = DB::table('urls')->orderBy('id', 'desc')->get();
        $lastChecks = DB::table('url_checks')
            ->distinct('url_id')
            ->orderBy('url_id')
            ->latest()
            ->whereIn('url_id', $urls->pluck('id'))
            ->get()
            ->keyBy('url_id');

        return view('url.index', compact('urls', 'lastChecks'));
    }

    public function show(int $id): View
    {
        $url = DB::table('urls')->find($id);
        $checks = DB::table('url_checks')->where('url_id', $id)->get();

        return view('url.show', compact('url', 'checks'));
    }
}
