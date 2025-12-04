<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * ------------------------------------------------------------------------------
 * Main Controller
 *
 * This class extends Laravel’s Base Controller and serves as the global
 * parent controller for all other controllers in your application.
 *
 * @package    Grow CRM
 * @author     NextLoop
 * ------------------------------------------------------------------------------
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Constructor
     *
     * Use this method for global middleware, shared data, or
     * initialization logic that applies to all controllers.
     */
    public function __construct()
    {
        // Example: Share global data with all views
        // view()->share('appName', config('app.name'));
    }
}
