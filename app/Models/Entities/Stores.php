<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Stores | 店家
 * @package App\Models\Entities
 * @mixin Builder
 * @property mixed store_name
 * @property mixed store_phone
 * @property mixed store_business_start_time
 * @property mixed store_business_end_time
 * @property mixed store_longitude
 * @property mixed store_latitude
 * @property mixed created_at
 * @property mixed updated_at
 * @author Roger 2023-03-10
 */
class Stores extends Model
{
    use HasFactory;
    // 設定 table
    protected $table = 'stores';
    // 設定 table PK
    protected $primaryKey = 'id';
    // 設定 table 可異動 column
    protected $fillable = [
        'store_name',
        'store_phone',
        'store_business_start_time',
        'store_business_end_time',
        'store_longitude',
        'store_latitude'
    ];
}
