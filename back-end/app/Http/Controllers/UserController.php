<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show($id)
    {
        $user = $this->userService->loadUserProfile($id);
        return response()->json($user);
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $response = $this->userService->updateUserProfile($request->user()->id, $request->validated());
        return response()->json($response);
    }

    public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);

        $response = $this->userService->deleteUserAccount($id);

        // Only include debug information if app is in debug mode
        if (config('app.debug')) {
            $response['debug'] = [
                'Authenticated user ID' => Auth::id(),
                'User to delete ID' => $id
            ];
        }

        return response()->json($response);
    } catch (\Exception $e) {
        // Include debug information in the error response if app is in debug mode
        $debugInfo = config('app.debug') ? [
            'Authenticated user ID' => Auth::id(),
            'User to delete ID' => $id,
            'Error message' => $e->getMessage()
        ] : null;

        return response()->json([
            'error' => 'This action is unauthorized.',
            'debug' => $debugInfo
        ], 403);
    }
}


}
