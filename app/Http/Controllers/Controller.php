<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller Class
 *
 * This abstract controller class serves as the foundation for all application controllers.
 * It provides common functionality including response handling, error management, and
 * standardized messaging across the application.
 *
 * Features:
 * - Unified JSON response formatting
 * - Predefined success and error messages
 * - Consistent error logging mechanism
 * - Support for both API and web view responses
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    /**
     * Global success message suffix
     * Used as a consistent ending for all success messages throughout the application
     */
    private const string SUCCESSFULLY = "Successfully.";

    // private $encryptionService; // Reserved for future encryption service integration

    /**
     * Predefined success response messages
     * These messages provide consistent feedback for common CRUD operations
     * and can be used across all child controllers to maintain uniformity
     */
    protected string $add_msg = "Added " . self::SUCCESSFULLY,        // For adding new records
        $set_msg = "Set " . self::SUCCESSFULLY,           // For setting configurations
        $create_msg = "Created " . self::SUCCESSFULLY,    // For creating new entities
        $update_msg = "Updated " . self::SUCCESSFULLY,    // For updating existing records
        $edit_msg = "Edited " . self::SUCCESSFULLY,       // For editing operations
        $modify_msg = "Modified " . self::SUCCESSFULLY,   // For modification operations
        $delete_msg = "Deleted " . self::SUCCESSFULLY,    // For deletion operations
        $remove_msg = "Removed " . self::SUCCESSFULLY,    // For removal operations
        $destroy_msg = "Destroyed " . self::SUCCESSFULLY, // For destroy operations
        $generate_msg = "Generated " . self::SUCCESSFULLY; // For generation operations

    /**
     * Predefined error response messages
     * Standard error messages used across the application for consistent user experience
     */
    protected string $error_msg = "Something went wrong! Please try again later.",           // Generic error message
        $invalid_flow_msg = "Getting some errors, Please process as per the flow."; // Flow validation error

    /**
     * Universal Response Handler
     *
     * This method provides a standardized way to format and return JSON responses
     * across all API endpoints. It ensures consistency in response structure and
     * handles various data types while maintaining proper HTTP status codes.
     *
     * Response Structure:
     * {
     *   "status": "success|fail|warning|info",
     *   "message": "string" | "messages": ["array"],
     *   "response": mixed (optional - only included if data is provided)
     * }
     *
     * @param string $status The response status (success, fail, warning, info)
     *                      - 'success': Operation completed successfully
     *                      - 'fail': Operation failed due to client error
     *                      - 'warning': Operation completed with warnings
     *                      - 'info': Informational response
     * @param array|string|Arrayable $message The response message(s)
     *                                       - string: Single message
     *                                       - array: Multiple messages
     *                                       - Arrayable: Object implementing Arrayable interface
     * @param mixed|null $data Optional response data payload
     *                        - Can be any data type (array, object, string, etc.)
     *                        - Will be included in 'response' key if provided
     * @param int $code HTTP status code (default: 200)
     *                 - 200: OK - Success
     *                 - 400: Bad Request - Client error
     *                 - 401: Unauthorized - Authentication required
     *                 - 403: Forbidden - Access denied
     *                 - 404: Not Found - Resource not found
     *                 - 422: Unprocessable Entity - Validation errors
     *                 - 500: Internal Server Error - Server error
     *
     * @return JsonResponse Formatted JSON response with proper HTTP status code
     *
     * @throws Exception When response formatting fails
     *
     * @example
     * return $this->responseHandler('success', 'User created successfully', $userData, 201);
     * return $this->responseHandler('fail', 'Validation failed', null, 422);
     * return $this->responseHandler('warning', ['Warning 1', 'Warning 2']);
     */
    public function responseHandler(string $status, array|string|Arrayable $message, mixed $data = null, int $code = 200)
    {
        try {
            // Validate and sanitize the status parameter
            // Ensures only valid status values are used, defaults to 'fail' for security
            $status = in_array($status, ['success', 'fail', 'warning', 'info']) ? $status : 'fail';

            // Build the base response structure
            // Dynamic key selection based on message type for better API consistency
            $response = [
                "status" => $status,
                // Conditional key assignment: 'messages' for arrays, 'message' for strings
                is_array($message) || $message instanceof Arrayable ? "messages" : "message" => (!empty($message) ? $message : ""),
            ];

            // Include data payload only if provided and not null
            // This keeps the response clean and avoids unnecessary null values
            if (!empty($data)) {
                $response["response"] = $data;
            }

            // Return the formatted JSON response with appropriate HTTP status code
            return response()->json($response, $code);

        } catch (Exception $e) {
            // Enhanced error logging with detailed context information
            // Provides comprehensive debugging information for developers
            $errorContext = [
                'method' => __METHOD__,
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
                'status_param' => $status,
                'message_param' => is_string($message) ? $message : gettype($message),
                'data_type' => gettype($data),
                'code_param' => $code ?? 200,
                'trace' => $e->getTraceAsString()
            ];

            $logMessage = "➤ Response Handler Exception :: " .
                "Method: {$errorContext['method']} || " .
                "Line: {$errorContext['line']} || " .
                "Error: {$errorContext['message']} || " .
                "Context: " . json_encode($errorContext, JSON_UNESCAPED_SLASHES);

            Log::error($logMessage, $errorContext);

            // Return a safe fallback response to prevent application crashes
            return response()->json([
                'status' => 'fail',
                'message' => 'Internal server error occurred while processing response'
            ], 500);
        }
    }

    /**
     * Universal Response Handler for Web Views and Mixed Requests
     *
     * This method handles responses for web applications that may serve both
     * traditional web pages and AJAX requests. It intelligently detects the
     * request type and responds appropriately with either JSON or redirect responses.
     *
     * Behavior:
     * - JSON requests: Returns JSON response (AJAX, API calls)
     * - Web requests: Redirects with flash data (traditional forms)
     * - Supports both route redirects and back() redirects
     *
     * @param string $status The response status (success, fail, warning, info)
     *                      - Validated against allowed values for security
     *                      - Invalid values default to 'fail'
     * @param string $message The response message to display to the user
     *                       - Should be user-friendly and descriptive
     *                       - Will be flashed to session for web requests
     * @param string $route Optional route name for redirection
     *                          - If provided: redirects to specified route
     *                          - If null/empty: redirects back to previous page
     *                          - Only used for non-JSON requests
     * @param mixed|null $routeData Optional data to pass to the route
     *                        - Route parameters for named routes
     *                        - Can be arrayed, string, or any route-compatible data
     *
     * @return RedirectResponse|JsonResponse JsonResponse for AJAX requests, RedirectResponse for web requests
     *
     * @example
     * return $this->viewResponseHandler('success', 'Profile updated', 'user.profile', ['id' => $userId]);
     * return $this->viewResponseHandler('fail', 'Validation failed');
     * return $this->viewResponseHandler('success', 'Data saved');
     */
    public function viewResponseHandler(string $status, string $message, string $route = "", mixed $routeData = null)
    {
        try {
            // Validate and sanitize the status parameter
            // Security measure to prevent injection of invalid status values
            $status = in_array($status, ['success', 'fail', 'warning', 'info']) ? $status : 'fail';

            // Prepare the response data structure
            // Consistent format for both JSON and flash data
            $response = ['status' => $status, 'message' => $message];

            // Intelligent request type detection and appropriate response handling
            if (request()->expectsJson()) {
                // Handle AJAX/API requests with JSON response
                // Maintains consistency with responseHandler method
                return response()->json($response);
            } else {
                // Handle traditional web form submissions with redirects
                // Flash data will be available in the next request
                return $route ?
                    redirect()->route($route, $routeData)->with($response) :  // Named route redirect
                    back()->with($response);                                   // Back to previous page
            }

        } catch (Exception $e) {
            // Comprehensive error logging with full context
            // Helps in debugging complex redirect/response issues
            $errorContext = [
                'method' => __METHOD__,
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
                'status_param' => $status,
                'message_param' => $message,
                'route_param' => $route,
                'route_data_type' => gettype($routeData),
                'request_expects_json' => request()->expectsJson(),
                'request_url' => request()->url(),
                'request_method' => request()->method(),
                'user_agent' => request()->userAgent(),
                'trace' => $e->getTraceAsString()
            ];

            $logMessage = "➤ View Response Handler Exception :: " .
                "Method: {$errorContext['method']} || " .
                "Line: {$errorContext['line']} || " .
                "Error: {$errorContext['message']} || " .
                "Request Type: " . (request()->expectsJson() ? 'JSON' : 'Web') . " || " .
                "Route: {$errorContext['route_param']} || " .
                "URL: {$errorContext['request_url']}";

            Log::error($logMessage, $errorContext);

            // Provide safe fallback responses based on request type
            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'An error occurred while processing your request'
                ], 500);
            } else {
                return back()->with([
                    'status' => 'fail',
                    'message' => 'An error occurred while processing your request'
                ]);
            }
        }
    }
}
