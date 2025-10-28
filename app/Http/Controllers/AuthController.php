<?php

namespace App\Http\Controllers;

use App\Http\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Redirect to Facebook login
    public function redirectToFacebook()
    {
        // We keep stateless() and the email scope. stateless() prevents session/state validation errors.
        return Socialite::driver('facebook')
            ->stateless()
            ->scopes(['public_profile','email'])
            ->redirect();
    }

    // Handle Facebook callback
    public function handleFacebookCallback()
    {
        // Also use stateless() when handling the callback for consistency
        return $this->handleProviderCallback('facebook');
    }

    // Redirect to Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        return $this->handleProviderCallback('google');
    }

    // Generic handler for socialite callbacks
    protected function handleProviderCallback(string $provider)
    {
        try {
            // Use stateless() for Facebook callback to match the redirect request
            if ($provider === 'facebook') {
                $providerUser = Socialite::driver($provider)->stateless()->user();
            } else {
                $providerUser = Socialite::driver($provider)->user();
            }

            $email = $providerUser->getEmail();
            
            // Fallback for email is critical to ensure the email field is never null.
            if (empty($email)) {
                $email = $providerUser->getId() . '@' . $provider . '.local';
            }

            // FIX: Manually check if the user exists. This eliminates the risk of 
            // a crash inside the atomic firstOrCreate/updateOrCreate function in unstable environments.
            $user = User::where('email', $email)->first();

            if ($user) {
                // User exists, update social provider details
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'avatar' => $providerUser->getAvatar(),
                ]);
            } else {
                // User does not exist, create a new record
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $email,
                    'provider' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'avatar' => $providerUser->getAvatar(),
                    'password' => Hash::make(uniqid()), // Assign unique password hash
                    'role' => 'user', // Default role for new social user
                ]);
            }

            Auth::login($user);

            if (in_array($user->role, ['admin'])) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Socialite callback failed for {$provider}: " . $e->getMessage());
            // Added a specific redirect to the login page with the error message
            return redirect()->route('login')->with('error', ucfirst($provider) . ' login failed: ' . $e->getMessage());
        }
    }


    // Handle email/password login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if (in_array($user->role, ['admin'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    // Show user login form
    public function showUserLogin()
    {
        return view('auth.login');
    }


    // Show user registration form (for regular users)
    public function showUserRegister()
    {
        return view('auth.register');
    }

    // Handle user registration
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
