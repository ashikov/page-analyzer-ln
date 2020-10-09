<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use DiDom\Document;
use Illuminate\Http\RedirectResponse;

class DomainCheckController extends Controller
{
    public function store(int $domainId): RedirectResponse
    {
        $domain = DB::table('domains')->find($domainId);

        try {
            $response = Http::get($domain->name);
        } catch (ConnectionException $exception) {
            flash('Could not check domain')->error();
            return redirect()->route('domain.show', $domainId);
        }
        
        $statusCode = $response->status();
        
        $document = new Document($domain->name, true);

        $h1 = optional($document->first('h1'))->text();
        $keywords = optional($document->first('meta[name=keywords]'))->getAttribute('content');
        $description = optional($document->first('meta[name=description]'))->getAttribute('content');
        
        DB::table('domain_checks')->insert([
                'domain_id' => $domainId,
                'status_code' => $statusCode,
                'h1' => $h1 ?? null,
                'keywords' => $keywords ?? null,
                'description' => $description ?? null,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
        ]);

        return redirect()->route('domain.show', $domainId);
    }
}
