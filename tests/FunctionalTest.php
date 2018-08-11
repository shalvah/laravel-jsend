<?php
/**
 * Created by shalvah
 * Date: 09-Aug-18
 * Time: 03:26
 */

namespace Shalvah\LaravelJsend\Tests;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;
use Symfony\Component\HttpFoundation\Response;

class Test extends TestCase
{
    /** @test */
    public function jsend_success_generates_a_response_with_status_code_200()
    {
        $response = jsend_success();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertArraySubset(['status' => 'success'], json_decode($response->getContent(), true));

        $response = jsend_success('hi');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertArraySubset(['status' => 'success', 'data' => 'hi'], json_decode($response->getContent(), true));
    }

    /** @test */
    public function jsend_success_works_with_eloquent_model_as_data()
    {
        $model = new class(['id' => 2, 'name' => 'Nein']) extends Model {
            public $id;
            public $name;
            protected $guarded = [];
        };

        $response = jsend_success($model);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertArraySubset([
            'status' => 'success',
            'data' => ['id' => 2, 'name' => 'Nein']
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function jsend_error_generates_a_response_with_status_code_500()
    {
        $message = 'Something happened.';
        $response = jsend_error($message);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertArraySubset(['status' => 'error', 'message' => $message], json_decode($response->getContent(), true));
    }

    /** @test */
    public function jsend_fail_generates_a_response_with_status_code_400()
    {
        $message = 'Something happened.';
        $response = jsend_fail(['message' => $message]);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), 400);
        $this->assertArraySubset([
            'status' => 'fail',
            'data' => ['message' => $message]
        ], json_decode($response->getContent(), true));
    }
}
