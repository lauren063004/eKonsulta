<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PasswordResetCodeNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    private const CODE_EXPIRATION_MINUTES = 10;

    private const MAX_CODE_ATTEMPTS = 5;

    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);
        $email = $validated['email'];
        $code = (string) random_int(100000, 999999);
        $user = User::where('email', $email)->first();

        session()->put('password_reset_email', $email);
        session()->forget(['password_reset_verified_email', 'password_reset_verified_at']);
        RateLimiter::clear($this->attemptsKey($email));
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        if ($user) {
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => Hash::make($code),
                'created_at' => now(),
            ]);

            $user->notify(new PasswordResetCodeNotification($code));
        }

        return redirect()
            ->route('password.otp')
            ->with(
                'status',
                'If an account exists for that email address, a six-digit verification code has been sent.'
            );
    }

    public function showOtpForm(): View|RedirectResponse
    {
        if (!session()->has('password_reset_email')) {
            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Enter your email address to request a password reset code.']);
        }

        return view('auth.verify-password-reset');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $email = session('password_reset_email');

        if (!is_string($email) || $email === '') {
            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Your reset request has expired. Please request a new code.']);
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $attemptsKey = $this->attemptsKey($email);

        if (RateLimiter::tooManyAttempts($attemptsKey, self::MAX_CODE_ATTEMPTS)) {
            return back()->withErrors([
                'otp' => 'Too many incorrect attempts. Request a new code and try again.',
            ]);
        }

        $resetCode = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (
            !$resetCode
            || !$resetCode->created_at
            || now()->greaterThan(
                \Illuminate\Support\Carbon::parse($resetCode->created_at)
                    ->addMinutes(self::CODE_EXPIRATION_MINUTES)
            )
            || !Hash::check($request->string('otp')->toString(), $resetCode->token)
        ) {
            RateLimiter::hit($attemptsKey, self::CODE_EXPIRATION_MINUTES * 60);

            return back()
                ->withErrors(['otp' => 'The verification code is incorrect or has expired.'])
                ->withInput();
        }

        RateLimiter::clear($attemptsKey);
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->put('password_reset_verified_email', $email);
        session()->put('password_reset_verified_at', now()->timestamp);
        session()->regenerate();

        return redirect()->route('password.reset');
    }

    public function showResetForm(): View|RedirectResponse
    {
        if (!$this->hasVerifiedResetSession()) {
            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Your verification has expired. Please request a new code.']);
        }

        return view('auth.reset-password', [
            'email' => session('password_reset_verified_email'),
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        if (!$this->hasVerifiedResetSession()) {
            session()->forget(['password_reset_verified_email', 'password_reset_verified_at']);

            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Your verification has expired. Please request a new code.']);
        }

        $email = session('password_reset_verified_email');

        $validated = $request->validate([
            'email' => ['required', 'email', Rule::in([$email])],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers(),
            ],
        ]);

        $user = User::where('email', $email)->first();

        if (!$user) {
            session()->forget(['password_reset_email', 'password_reset_verified_email', 'password_reset_verified_at']);

            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Your reset request is no longer valid. Please request a new code.']);
        }

        if (Hash::check($validated['password'], $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => 'Choose a new password that is different from your current password.']);
        }

        $user->forceFill([
            'password' => $validated['password'],
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
        session()->forget([
            'password_reset_email',
            'password_reset_verified_email',
            'password_reset_verified_at',
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Your password has been reset. You can now sign in.');
    }

    private function hasVerifiedResetSession(): bool
    {
        $email = session('password_reset_verified_email');
        $verifiedAt = session('password_reset_verified_at');

        return is_string($email)
            && $email !== ''
            && is_int($verifiedAt)
            && now()->timestamp <= $verifiedAt + (self::CODE_EXPIRATION_MINUTES * 60);
    }

    private function attemptsKey(string $email): string
    {
        return 'password-reset-otp:'.hash('sha256', Str::lower($email));
    }
}
