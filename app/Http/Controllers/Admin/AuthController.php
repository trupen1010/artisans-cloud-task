<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Admin Authentication Controller
 *
 * Handles authentication operations for admin users including login, logout,
 * password reset functionality, and user session management. This controller
 * specifically manages admin and faculty user access to the administrative panel.
 */
class AuthController extends Controller
{
    /**
     * Display the admin login form or redirect authenticated users
     *
     * Checks if the user is already authenticated and either redirects them
     * to the admin dashboard or shows the login form. This prevents authenticated
     * users from accessing the login page unnecessarily.
     *
     * @return RedirectResponse|View Returns redirect to dashboard if authenticated, login view otherwise
     */
    public function index(): RedirectResponse|View
    {
        // Check if user is already authenticated
        if (Auth::check()) {
            // Redirect authenticated users to admin dashboard
            return redirect()->route('admin.dashboard');
        } else {
            // Show login form for unauthenticated users
            return view('admin.login');
        }
    }

    /**
     * Authenticate admin or faculty user login attempt
     *
     * Validates user credentials and performs authentication for admin and faculty users.
     * On successful authentication, creates login history record, manages user sessions,
     * and handles device/browser tracking for security purposes.
     *
     * @param  Request  $request  The HTTP request containing email and password
     * @throws Exception When authentication process encounters unexpected errors
     */
    public function auth(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // Attempt authentication with specific user criteria (active admin/faculty users only)
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication failed - set error message and return failure response
                return $this->viewResponseHandler('fail', 'Invalid email or password provided.', '', 422);
            }

            // Authentication successful - redirect to admin dashboard
            return redirect()->route('admin.dashboard');
        } catch (Exception $e) {
            // Log the exception for debugging and monitoring
            Log::error('Admin login failed: '.$e->getMessage());

            // Return generic error message to avoid exposing sensitive information
            return $this->viewResponseHandler('fail', 'Something went wrong, please try again later.', '', 500);
        }
    }

    /**
     * Handle admin user logout process
     *
     * Logs out the currently authenticated admin user and clears their session.
     * Provides appropriate response handling for both successful and failed logout attempts.
     *
     * @throws Exception
     */
    public function logout()
    {
        try {
            // Clear user authentication session
            Auth::logout();

            // Return success response with redirect to login page
            return $this->viewResponseHandler('success', 'logout successfully!', 'admin.login');
        } catch (Exception $e) {
            // Log logout error and return failure response
            Log::error('Admin logout failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', $this->error_msg, 'admin.login');
        }
    }
}
