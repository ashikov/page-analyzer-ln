<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use DiDom\Document;

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

        $document = new Document($domain->name, true);

        if ($document->has('h1')) {
            $h1 = $document->first('h1')->text();
        }

        if ($document->has('meta[name=keywords]')) {
            $keywords = $document->first('meta[name=keywords]')->getAttribute('content');
        }

        if ($document->has('meta[name=description]')) {
            $description = $document->first('meta[name=description]')->getAttribute('content');
        }

        DB::table('domain_checks')->insert([
                'domain_id' => $domainId,
                'status_code' => $statusCode,
                'h1' => $h1 ?? null,
                'keywords' => $keywords ?? null,
                'description' => $description ?? null,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
        ]);

        return redirect()->route('domains.show', $domainId);
    }
}
