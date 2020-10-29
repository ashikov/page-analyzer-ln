<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{DB, Http};
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Http\Client\{RequestException, ConnectionException};
use DiDom\Document;

class DomainCheckController extends Controller
{
    public function store(int $domainId): RedirectResponse
    {
        $domain = DB::table('domains')->find($domainId);

        try {
            $response = Http::get($domain->name);

            $statusCode = $response->status();

            $html = $response->getBody()->getContents();
            $document = new Document($html);

            $h1 = optional($document->first('h1'))->text();
            $keywords = optional($document->first('meta[name=keywords]'))->getAttribute('content');
            $description = optional($document->first('meta[name=description]'))->getAttribute('content');

            DB::table('domain_checks')->insert([
                    'domain_id' => $domainId,
                    'status_code' => $statusCode,
                    'h1' => $h1,
                    'keywords' => $keywords,
                    'description' => $description,
                    "created_at" =>  \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
            ]);

            flash('Domain has been checked successfully')->success();
        } catch (RequestException | ConnectionException $exception) {
            $message = $exception->getMessage();
            flash($message)->error();
        }

        return redirect()->route('domains.show', $domainId);
    }
}
