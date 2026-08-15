<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function sendEmailVerificationNotification()
    {
        $verificationLink = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        try {
            Http::withHeaders([
                'X-API-Key' => config('services.mailer.key'),
            ])->post(config('services.mailer.url'), [
                'type'    => 'verification',
                'to'      => $this->email,
                'subject' => 'Verify Your Email Address',
                'data'    => [
                    'eyebrow'           => 'Verification',
                    'heading'           => 'Confirm your email',
                    'name'              => $this->name,
                    'message'           => 'Thanks for signing up! Please click the button below to verify your email address.',
                    'button_text'       => 'Verify Email',
                    'verification_link' => $verificationLink,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Verification Mailer Error: ' . $e->getMessage());
        }
    }
}
