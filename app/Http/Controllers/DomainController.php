<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function store(Request $request)
    {
        $url = $request->input('url');
        $parsedUrl = parse_url(strtolower($url));
        $host = $parsedUrl['host'];
        $scheme = $parsedUrl['scheme'];
        $domainName = "{$scheme}://{$host}";

        $domain = DB::table('domains')->where('name', $domainName)->first();

        if ($domain) {
            flash('Domain exists')->error();
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

    public function index()
    {
        $domains = DB::table('domains')->orderBy('id', 'desc')->get();
        $lastChecks = DB::table('domain_checks')->orderBy('created_at', 'asc')->get()->keyBy('domain_id');

        return view('domains.index', compact('domains', 'lastChecks'));
    }

    public function show($id)
    {
        $domain = DB::table('domains')->where('id', $id)->first();
        $checks = DB::table('domain_checks')->where('domain_id', $id)->get();
        
        return view('domains.show', compact('domain', 'checks'));
    }
}
