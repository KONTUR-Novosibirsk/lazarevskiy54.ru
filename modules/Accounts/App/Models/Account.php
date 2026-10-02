<?php

    namespace Modules\Accounts\App\Models;

    use App\Models\BaseModel;
    use Illuminate\Auth\Passwords\CanResetPassword;
    use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\{Cookie, Hash, Session};
    use Laravel\Sanctum\HasApiTokens;
    use Modules\Cookie\App\Models\CookieConsent;
    use Modules\Shop\App\Models\ShopOrder;
    use Modules\Accounts\App\Mail\PasswordReset;

    class Account extends BaseModel implements CanResetPasswordContract
    {
        use HasApiTokens, CanResetPassword, Notifiable;

        protected $fillable = [
            'email',
            'password',
            'login',
            'full_name',
            'phone',
            'is_confirmed',
        ];

        protected $hidden = [
            'password',
        ];

        protected $casts = [
            'password' => 'hashed',
            'is_confirmed' => 'boolean',
        ];

        public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
        {
            return $this->hasMany(ShopOrder::class, 'account_id', 'id');
        }

        public function toggleConfirmed(): self
        {
            return tap($this, fn($model) => $model->update(['is_confirmed' => !$model->is_confirmed]));
        }

        public function checkPassword(string $password): bool
        {
            return Hash::check($password, $this->password);
        }

        public function login(bool $remember = false): self
        {
            $this->tokens()->delete();
            $token = $this->createToken('auth')->plainTextToken;
            Session::put('auth', $token);

            if ($remember) {
                Cookie::queue('remember_token', $token, 60 * 24 * 30, null, null, true, true, 'Strict');
            }

            return $this;
        }

        public function logout(): void
        {
            $this->tokens()->delete();

            Session::forget('auth');

            Cookie::queue(Cookie::forget('remember_token'));
        }

        public function scopeConfirmed(Builder $query): Builder
        {
            return $query->where('is_confirmed', true);
        }

        public function sendPasswordResetNotification($token): void
        {
            $this->notify(new PasswordReset($token));
        }

        public function scopeFilter($query, array $filters)
        {
            $query->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('full_name', 'like', '%' . $search . '%')
                        ->orWhere('login', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })->when(isset($filters['active']) && in_array($filters['active'], [0, 1]), function ($query) use ($filters) {
                return $query->where('is_active', $filters['active']);
            });
        }

        public function cookieConsent()
        {
            return $this->hasMany(CookieConsent::class, 'account_id', 'id');
        }

        public function scopeCookieAccepted($query)
        {
            return $query->whereHas('cookieConsent', function ($q) {
                $q->where('accepted_all', true);
            });

        }
    }
