<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\View\View;

class DomainController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validator = app('validator')->make($request->input('domain'), [
            'name' => 'required|url'
        ]);

        if ($validator->fails()) {
            return redirect()->route('welcome')->withErrors($validator)->withInput();
        };

        $domainData = $request->input('domain');
        $url = $domainData['name'];
        $parsedUrl = parse_url(strtolower($url));
        $host = $parsedUrl['host'];
        $scheme = $parsedUrl['scheme'];
        $domainName = "{$scheme}://{$host}";

        $domain = DB::table('domains')->where('name', $domainName)->first();

        if (isset($domain)) {
            flash('Domain exists');
            return redirect()->route('domains.show', $domain->id);
        }

        $newDomainId = DB::table('domains')
            ->insertGetId([
                'name' => $domainName,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ]);


        flash('Domain has been added')->success();
        return redirect()->route('domains.show', $newDomainId);
    }

    public function index(): View
    {
        $domains = DB::table('domains')->orderBy('id', 'desc')->get();
        $lastChecks = DB::table('domain_checks')
            ->distinct('domain_id')
            ->orderBy('domain_id')
            ->latest()
            ->whereIn('domain_id', $domains->pluck('id'))
            ->get()
            ->keyBy('domain_id');

        return view('domain.index', compact('domains', 'lastChecks'));
    }

    public function show(int $id): View
    {
        $domain = DB::table('domains')->find($id);
        $checks = DB::table('domain_checks')->where('domain_id', $id)->get();

        return view('domain.show', compact('domain', 'checks'));
    }
}
