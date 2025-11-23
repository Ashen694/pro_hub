<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Employee;

class AzureAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('azure')
            ->with(['prompt' => 'select_account'])  
            ->redirect();
    }

    public function callback()
    {
        try {
            $azureUser = Socialite::driver('azure')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to login with Microsoft. Please try again.',
            ]);
        }

        $raw   = method_exists($azureUser, 'user') ? $azureUser->user : (array) $azureUser;
        $email = strtolower($azureUser->getEmail() ?? ($raw['mail'] ?? $raw['userPrincipalName'] ?? $raw['upn'] ?? ''));

        if (! $email) {
            return redirect()->route('login')->withErrors([
                'email' => 'No email returned by Microsoft. Ask the Administrator to enable the email claim.',
            ]);
        }

        $oid = $azureUser->getId();
        
        $realName = $azureUser->getName(); 

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is not registered. Please contact the Administrator.',
            ]);
        }

        if (! $user->is_active) {
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is inactive. Please contact the Administrator.',
            ]);
        }

        if (empty($user->azure_id)) {
            $user->azure_id = $oid;
            $user->save();
        } elseif ($user->azure_id !== $oid) {
            return redirect()->route('login')->withErrors([
                'email' => 'This email is linked to another Microsoft account. Contact the Administrator.',
            ]);
        }

        if (!empty($realName)) {
            
            if ($user->name !== $realName) {
                $user->name = $realName;
                $user->save();
            }

            $employee = Employee::where('Emp_Email', $email)->first();
            
            if ($employee) {
                if ($employee->Emp_Name !== $realName) {
                    $employee->Emp_Name = $realName;
                    $employee->save();
                }
            }
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}