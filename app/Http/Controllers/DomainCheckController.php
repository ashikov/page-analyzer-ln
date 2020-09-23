<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class DomainCheckController extends Controller
{
    public function store($domainId)
    {
        $domain = DB::table('domains')->where('id', $domainId)->first();

        try {
            $response = Http::get($domain->name);
        } catch (ConnectionException $exception) {
            flash('Could not check domain')->error();
            return redirect()->route('domains.show', $domainId);
        }
        
        $statusCode = $response->status();

        DB::table('domain_checks')->insert([
                'domain_id' => $domainId,
                'status_code' => $statusCode,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
        ]);

        return redirect()->route('domains.show', $domainId);
    }
}
