<?php

namespace Tests;

use Route;

/**
 * Class ResponseMacroTest
 *
 * @group macro
 * @group response
 */
class ResponseMacroTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->route = 'test/response';

        Route::get($this->route, function () {
            return $this->response;
        });
    }

    /**
     * @test
     * @group 200
     */
    public function it_returns_a_success_response()
    {
        $message = 'My unique success message';

        // SETUP:       Response
        $this->response = response()->success($message);

        // ASSERT:      Response
        $this->get($this->route)
            ->assertStatus(200)
            ->assertJsonFragment([
                'errors'  => false,
                'message' => $message,
            ]);
    }

    /**
     * @test
     */
    public function it_returns_a_success_response_with_custom_status_code()
    {
        $message = 'My unique success message';

        // SETUP:       Response
        $this->response = response()->success($message, 206);

        // ASSERT:      Response
        $this->get($this->route)
            ->assertStatus(206)
            ->assertJsonFragment([
                'errors'  => false,
                'message' => $message,
            ]);
    }

    /**
     * @test
     */
    public function it_returns_a_success_response_with_a_data_array()
    {
        $data    = ['apples' => 1];
        $message = 'My unique success message';

        // SETUP:       Response
        $this->response = response()->success([
            'data'    => $data,
            'message' => $message,
        ]);

        // ASSERT:      Response
        $this->get($this->route)
            ->assertJson([
                'errors'  => false,
                'data'    => $data,
                'message' => $message,
            ]);
    }

    /**
     * @test
     * @group error
     * @group 204
     */
    public function it_returns_a_no_content_response()
    {
        // SETUP:       Response
        $this->response = response()->noContent();

        // ASSERT:      Response
        $this->get($this->route)
            ->assertStatus(204);
    }

    /**
     * @test
     * @group error
     * @group 400
     */
    public function it_returns_an_error_response()
    {
        $message = 'Test 400 error';

        // SETUP:       Response
        $this->response = response()->error($message);

        // ASSERT:      Response
        $this->get($this->route)
            ->assertStatus(400)
            ->assertJsonFragment([
                'errors'  => true,
                'message' => $message,
            ]);
    }

    /**
     * @test
     * @group error
     * @group 500
     */
    public function it_returns_an_error_response_with_custom_status_code()
    {
        $message = 'Test 500 error';

        // SETUP:       Response
        $this->response = response()->error($message, 500);

        $this->get($this->route)
            ->assertStatus(500)
            ->assertJsonFragment([
                'errors'  => true,
                'message' => $message,
            ]);
    }

    /**
     * @test
     */
    public function it_returns_an_error_response_with_a_data_array()
    {
        $data    = ['apples' => 0];
        $message = 'There was a problem';

        // SETUP:       Response
        $this->response = response()->error([
            'data'    => $data,
            'message' => $message,
        ]);

        // ASSERT:      Response
        $this->get($this->route)
            ->assertJson([
                'errors'  => true,
                'data'    => $data,
                'message' => $message,
            ]);
    }
}
