<?php

namespace App\Repositories;

use App\Models\Entities\Foods;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

//其實可以寫一個 抽象類別再上層 把重複方法定義好 但是 DEMO...先這樣
class FoodsRepository
{

    private Model $model;

    public function __construct(Foods $model)
    {
        $this->model = $model;
    }


    /**
     * @node 取得所有
     * @return Foods[]|Collection|Model[]
     */
    public function findAllByWhere($where){
        return $this->model->where($where)
             ->leftJoin('stores','stores.id','=','foods.store_id')
           ->select(["stores.store_name","foods.food_name","foods.food_price","foods.food_remark","foods.created_at"])
            ->orderBy('created_at','desc')->get();
    }

    /**
     * @note 抓取by id
     * @param $id
     * @return Foods|Foods[]|Collection|Model|null
     */
    public function selectById($id){
        return $this->model->find($id);
    }

    /**
     * @note 抓取Foods 分頁 (不get留給後續人拼orm)
     * @param $where
     * @param int $offset
     * @param int $limit
     * @return Builder
     * @author roger
     * @date 2023-03-10
     */
    public function getLimitOffsetBuilder($where,int $offset=0, int $limit=50):Builder
    {
        return $this->model
            ->where($where)
            ->offset($offset)
            ->limit($limit);
    }


    /**
     *
     * @note 取得page 分頁 資料
     * @param $where
     * @param $orderBy
     * @param $begin
     * @param $pageLimit
     * @return Builder[]|Collection
     * @author roger
     * @date 2023-03-10
     *
     */
    public function getPageData($where,$orderBy,$begin,$pageLimit)
    {
        $builder =  $this->getLimitOffsetBuilder($where,$begin,$pageLimit);
        $builder->leftJoin('stores','stores.id','=','foods.store_id');
        $builder->select(["stores.store_name","foods.food_name","foods.food_price","foods.food_remark","foods.created_at"]);
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $sort){
                $builder->orderBy($column,$sort);
            }
        }
        return $builder->get();
    }


    /**
     * @note 創建食物
     * @param $data
     * @return Foods|Model
     * @author roger
     * @date 2023-03-10
     */
    public function createData($data){
        return $this->model->create($data);
    }

    /**
     * @note 更新Foods byId
     * @param $id
     * @param $data
     * @return bool
     * @author roger
     * @date 2023-03-10
     */
    public function updateDataById($id,$data): bool
    {
        return $this->model->find($id)->update($data);
    }

}
