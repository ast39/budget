<?php

namespace App\Models\Manage;

use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payment\WalletPayment;

class Wallet extends Model {

    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $connection = 'mysql';

    protected $table      = 'wallets';

    protected $primaryKey = 'wallet_id';

    protected $keyType    = 'int';

    public $incrementing  = true;

    public $timestamps    = true;


    /**
     * Владелец сейфа
     *
     * @return HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    /**
     * Транзакции сейфа
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(WalletPayment::class, 'wallet_id', 'wallet_id');
    }

    /**
     * Сразу же просчитаем сальдо по всем транзакциям
     *
     * @return float
     */
    public function getBalanceAttribute(): float
    {
        return $this->amount + WalletPayment::where('wallet_id', $this->wallet_id)
                ->get()
                ->pluck('amount')
                ->sum() ?: 0;
    }

    /**
     * Сразу же просчитаем кол-во транзакций
     *
     * @return int
     */
    public function getTransactionsAttribute(): int
    {
        return WalletPayment::where('wallet_id', $this->wallet_id)
            ->get()
            ->count() ?: 0;
    }


    /**
     * @var string[]
     */
    protected $appends = [
        'balance',
        'transactions'
    ];

    /**
     * Поля дат в БД
     *
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Date Time format
     *
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_id', 'owner_id', 'title', 'note', 'amount',
        'created_at', 'updated_at', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

}
