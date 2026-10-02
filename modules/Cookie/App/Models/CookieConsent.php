<?php

namespace Modules\Cookie\App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Accounts\App\Models\Account;

class CookieConsent extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'account_id',
        'session_id',
        'ip_address',
        'accepted_all',
        'accepted_at',
    ];

    protected $casts = [
        'accepted_all' => 'boolean',
        'accepted_at' => 'datetime',
    ];


    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
