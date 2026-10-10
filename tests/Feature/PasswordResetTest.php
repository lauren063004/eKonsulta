<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_links_to_the_password_reset_request_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('password.request'));

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Forgot your password?')
            ->assertSee(route('password.email'));
    }

    public function test_reset_request_sends_a_reset_notification_for_an_existing_user(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect()
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_request_does_not_disclose_unknown_email_addresses(): void
    {
        Notification::fake();
        $existingUser = User::factory()->create();

        $existingResponse = $this->post(route('password.email'), [
            'email' => $existingUser->email,
        ]);
        $unknownResponse = $this->post(route('password.email'), [
            'email' => 'not-registered@example.com',
        ]);

        $existingResponse->assertSessionHas('status');
        $unknownResponse->assertSessionHas('status', $existingResponse->getSession()->get('status'));
        Notification::assertSentTo($existingUser, ResetPassword::class);
    }

    public function test_user_can_reset_password_with_a_valid_token_and_password(): void
    {
        Notification::fake();
        $user = User::factory()->create(['password' => 'OldPassword1']);
        $token = Password::createToken($user);

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee('Reset your password')
            ->assertSee($token);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewStrongPass1',
            'password_confirmation' => 'NewStrongPass1',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertTrue(password_verify('NewStrongPass1', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }

    public function test_password_reset_enforces_password_policy_and_confirmation(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);
        $payload = [
            'token' => $token,
            'email' => $user->email,
            'password_confirmation' => 'weakpassword1',
        ];

        $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->post(route('password.update'), [...$payload, 'password' => 'weakpassword1'])
            ->assertSessionHasErrors('password');

        $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->post(route('password.update'), [
                ...$payload,
                'password' => 'StrongPass1',
                'password_confirmation' => 'DifferentPass2',
            ])
            ->assertSessionHasErrors('password');
    }

    public function test_password_reset_rejects_an_invalid_token(): void
    {
        $user = User::factory()->create();

        $this->from(route('password.reset', ['token' => 'invalid-token', 'email' => $user->email]))
            ->post(route('password.update'), [
                'token' => 'invalid-token',
                'email' => $user->email,
                'password' => 'NewStrongPass1',
                'password_confirmation' => 'NewStrongPass1',
            ])
            ->assertSessionHasErrors('email');

        $this->assertTrue(password_verify('password', $user->fresh()->password));
    }
}
