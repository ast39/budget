<?php

namespace App\Models\Calculate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table      = 'tmp_deposits';

    protected $primaryKey = 'deposit_id';

    protected $keyType    = 'int';

    public $incrementing  = true;

    public $timestamps    = true;


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
        'deposit_id', 'title', 'start_date', 'amount', 'percent', 'period', 'refill', 'plow_back', 'withdrawal',
        'created_at', 'updated_at',
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
