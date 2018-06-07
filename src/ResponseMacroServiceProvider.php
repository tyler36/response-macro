<?php

namespace Tyler36\ResponseMacro;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

/**
 * ResponseMacroServiceProvider class
 */
class ResponseMacroServiceProvider extends ServiceProvider
{
    protected $macros = [
        'success',
        'noContent',
        'error',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        collect($this->macros)->each(function ($item) {
            $this->{$item}();
        });
    }

    /**
     * Prepare response array
     *
     * @param array $data
     * @param bool  $errors
     *
     * @return void
     */
    public static function prepareData($data = [], $errors = false)
    {
        return array_merge(
            self::convertData($data),
            [
                'errors' => $errors,
            ]
        );
    }

    /**
     * MACRO:       'success' JSON response (200)
     *
     * @return void
     */
    protected function success()
    {
        Response::macro('success', function ($data, $status = 200) {
            return Response::json(
                ResponseMacroServiceProvider::prepareData($data),
                $status
            );
        });
    }

    /**
     * Convert response data
     *
     * @param [type] $data
     *
     * @return void
     */
    protected static function convertData($data)
    {
        return ('array' !== gettype($data))
            ? ['message' => $data]
            : $data;
    }

    /**
     * MACRO:       'no content' JSON response (204)
     *
     * @return void
     */
    protected function noContent()
    {
        Response::macro('noContent', function () {
            return Response::json(null, 204);
        });
    }

    /**
     * MACRO:       'error' JSON response
     *
     * @return void
     */
    protected function error()
    {
        Response::macro('error', function ($data, $status = 400) {
            return Response::json(
                ResponseMacroServiceProvider::prepareData($data, $errors = true),
                $status
            );
        });
    }
}
