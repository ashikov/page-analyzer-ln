<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DomainCheckControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $time = \Carbon\Carbon::now();

        $this->id = DB::table('domains')->insertGetId([
            'name' => 'http://google.com',
            "created_at" =>  $time,
            "updated_at" => $time
        ]);

    }

    public function testStore()
    {
        $response = $this->post(route('domains.checks.store', $this->id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
