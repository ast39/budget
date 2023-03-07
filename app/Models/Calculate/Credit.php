<?php

namespace App\Models\Calculate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit extends Model {

    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table      = 'tmp_credits';

    protected $primaryKey = 'credit_id';

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
        'credit_id', 'title', 'payment_type', 'subject', 'amount', 'percent', 'period', 'payment', 'created_at', 'updated_at',
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
