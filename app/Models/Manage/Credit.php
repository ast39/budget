<?php

namespace App\Models\Manage;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payment\CreditPayment;

class Credit extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'credits';

    protected $primaryKey = 'credit_id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;


    /**
     * Владелец кредита
     *
     * @return HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    /**
     * Платежи по кредиту
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(CreditPayment::class, 'credit_id', 'credit_id');
    }


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
        'credit_id', 'owner_id', 'title', 'creditor', 'amount', 'percent', 'period', 'payment',
        'start_date', 'payment_date',
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
