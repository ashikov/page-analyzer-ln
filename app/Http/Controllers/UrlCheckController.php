<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{DB, Http};
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Http\Client\{RequestException, ConnectionException};
use DiDom\Document;

class UrlCheckController extends Controller
{
    public function store(int $urlId): RedirectResponse
    {
        $url = DB::table('urls')->find($urlId);

        try {
            $response = Http::get($url->name);

            $statusCode = $response->status();

            $html = $response->getBody()->getContents();
            $document = new Document($html);

            $h1 = optional($document->first('h1'))->text();
            $title = optional($document->first('title'))->text();
            $description = optional($document->first('meta[name=description]'))->getAttribute('content');

            DB::table('url_checks')->insert([
                    'url_id' => $urlId,
                    'status_code' => $statusCode,
                    'h1' => $h1,
                    'title' => $title,
                    'description' => $description,
                    "created_at" =>  \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now()
            ]);

            flash('Url has been checked successfully')->success();
        } catch (RequestException | ConnectionException $exception) {
            $message = $exception->getMessage();
            flash($message)->error();
        }

        return redirect()->route('urls.show', $urlId);
    }
}
