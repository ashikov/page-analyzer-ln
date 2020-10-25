<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\{DB, Http};

class DomainCheckControllerTest extends TestCase
{
    public function testStore(): void
    {
        $id = DB::table('domains')->insertGetId([
            'name' => 'https://lz.com',
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ]);

        $path = __DIR__ . '/../fixtures/index.html';
        $fakeContent = file_get_contents($path);


        if ($fakeContent === false) {
            throw new \Exception('Something wrong with fixtures file');
        }

        Http::fake(fn($request) => Http::response($fakeContent, 200));

        $response = $this->post(route('domains.checks.store', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $checkData = [
            'domain_id' => $id,
            'status_code' => '200',
            'keywords' => 'hard rock',
            'description' => 'Led Zeppelin were an English rock band formed in London in 1968',
            'h1' => 'Led Zeppelin'
        ];

        $this->assertDatabaseHas('domain_checks', $checkData);
    }
}
