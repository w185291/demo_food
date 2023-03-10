<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



/**
 * Class Foods | 食物
 * @package App\Models\Entities
 * @mixin Builder
 * @property mixed store_id
 * @property mixed food_name
 * @property mixed food_price
 * @property mixed food_remark
 * @property mixed created_at
 * @property mixed updated_at
 * @author Roger 2023-03-10
 */
class Foods extends Model
{
    use HasFactory;
    // 設定 table
    protected $table = 'foods';
    // 設定 table PK
    protected $primaryKey = 'id';
    // 設定 table 可異動 column
    protected $fillable = [
        'store_id',
        'food_name',
        'food_price',
        'food_remark'
    ];
}
