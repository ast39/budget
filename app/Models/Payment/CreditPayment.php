<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Manage\Credit as UserCredit;

class CreditPayment extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table      = 'credit_payments';

    protected $primaryKey = 'payment_id';

    protected $keyType    = 'int';

    public $incrementing  = true;

    public $timestamps    = true;


    /**
     * В рамках какого кредита платеж
     *
     * @return HasOne
     */
    public function inCredit(): HasOne
    {
        return $this->hasOne(UserCredit::class, 'credit_id', 'credit_id');
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
        'payment_id', 'credit_id', 'amount', 'status', 'created_at', 'updated_at',
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
