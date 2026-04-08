<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function assertApiSuccess($response, int $code = 200)
    {
        $response->assertStatus($code) //verifica el código de estado HTTP
                ->assertJsonStructure([ //verifica que la respuesta JSON tenga la estructura esperada
                    'success',
                    'code',
                    'location',
                    'data'
                ])
                ->assertJson([ //verifica que los valores de 'success' y 'code' sean los esperados
                    'success' => true,
                    'code' => $code
                ]);
    }

    protected function assertApiError($response, int $code = 400)
    {
        $response->assertStatus($code)
                ->assertJsonStructure([
                    'success',
                    'code',
                    'location',
                    'errors'
                ])
                ->assertJson([
                    'success' => false,
                    'code' => $code
                ]);
    }
}
