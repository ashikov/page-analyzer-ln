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
        // [$scheme, $host] = $parsedUrl;
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
        // dd($domains);

        return view('domains.index', compact('domains'));
    }

    public function show($id)
    {
        $domain = DB::table('domains')->where('id', $id)->first();
        
        return view('domains.show', compact('domain'));
    }
}
