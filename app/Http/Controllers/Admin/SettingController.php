<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckPermissionsMiddleware:setting,manage')->only(['index']);
    }

    /**
     * Clear application cache and optimize.
     *
     * @throws Exception
     */
    public function optimize(): RedirectResponse
    {
        try {
            Artisan::call('optimize:clear');
            Artisan::call('optimize');
            $message = 'Application cache cleared successfully';
            $status = 'success';
        } catch (Throwable $e) {
            Log::error('Cache optimization failed: '.$e->getMessage());
            $message = 'An error occurred while clearing the application cache.';
            $status = 'fail';
        }

        return $this->viewResponseHandler($status, $message);
    }
}
