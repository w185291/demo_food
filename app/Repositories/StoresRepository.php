<?php

namespace App\Repositories;

use App\Models\Entities\Stores;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

//其實可以寫一個 抽象類別再上層 把重複方法定義好 但是 DEMO...先這樣
class StoresRepository
{

    private Model $model;

    public function __construct(Stores $model)
    {
        $this->model = $model;
    }

    /**
     * @note 抓取by id
     * @param $id
     * @return Stores|Stores[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function selectById($id){
        return $this->model->find($id);
    }

    /**
     * @note 抓取Stores 分頁 (不get留給後續人拼orm)
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
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     * @author roger
     * @date 2023-03-10
     *
     */
    public function getPageData($where,$orderBy,$begin,$pageLimit)
    {
        $builder =  $this->getLimitOffsetBuilder($where,$begin,$pageLimit);
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $sort){
                $builder->orderBy($column,$sort);
            }
        }
        return $builder->get();
    }


    /**
     * @note 創建商店
     * @param $data
     * @return Stores|Model
     * @author roger
     * @date 2023-03-10
     */
    public function createData($data){
        return $this->model->create($data);
    }

    /**
     * @note 更新商店byId
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
