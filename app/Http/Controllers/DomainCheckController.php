<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DomainCheckController extends Controller
{
    public function store($domainId)
    {
        DB::table('domain_checks')->insert([
                'domain_id' => $domainId,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
        ]);

        return redirect()->route('domains.show', $domainId);
    }
}
