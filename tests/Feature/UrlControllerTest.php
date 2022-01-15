<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UrlControllerTest extends TestCase
{
    private int $id;

    protected function setUp(): void
    {
        parent::setUp();

        $time = \Carbon\Carbon::now();

        DB::table('urls')->insert([
            'name' => 'http://yandex.ru',
            "created_at" =>  $time,
            "updated_at" => $time
        ]);

        DB::table('urls')->insert([
            'name' => 'http://duckduckgo.com',
            "created_at" =>  $time,
            "updated_at" => $time
        ]);

        $this->id = DB::table('urls')->insertGetId([
            'name' => 'http://google.com',
            "created_at" =>  $time,
            "updated_at" => $time
        ]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testShow(): void
    {
        $response = $this->get(route('urls.show', $this->id));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $url = 'http://jopa.ru';
        $response = $this->post(route('urls.store', ['url[name]' => $url]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
