<?php

namespace App\Service;

use App\Models\Entities\Foods;
use App\Repositories\FoodsRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;


class FoodsService
{

    private FoodsRepository $FoodsRepository;

    public function __construct(FoodsRepository $FoodsRepository)
    {
        $this->FoodsRepository = $FoodsRepository;
    }


    /**
     * @note 取得food分頁
     * @param $page
     * @param int $store_id
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     * @author roger
     * @date 2023-03-10
     */
    public function getFoodsListPage($page, int $store_id = 0)
    {
        $defaultPageLimit = config('app.defaultPageLimit');
        $offset = ($page - 1) * $defaultPageLimit;
        //cache 可以優化 拉出來做
        $cacheKey = "foodsList_" . $page . "_" . $store_id;
        $result = Cache::get($cacheKey);
        if ($result == null) {
            $where = [];
            if ($store_id != 0) {
                $where = ['store_id' => $store_id];
            }
            //可搜全部或 限制50筆 <- 前端因題目沒有需求 所以前端沒做分頁 不然可以帶page 一次拿50
            if($page!=-1){
                $result = $this->FoodsRepository->getPageData($where, ['created_at' => 'desc'], $offset, $defaultPageLimit);
            }else{
                $result = $this->FoodsRepository->findAllByWhere($where);
            }
            Cache::put($cacheKey, $result, now()->addMinutes(30));
        }
        return $result;
    }

    /**
     * @note 創建商店
     * @param $data
     * @return Foods|Model
     */
    public function createStore($data)
    {
        //創建需刪除list file cache
        $prefix = 'foodsList_';
        $keys = Cache::getStore()->getPrefix() . $prefix . '*';
        File::delete(File::glob($keys));
        return $this->FoodsRepository->createData($data);
    }


    /**
     * @note 使用ID 取得一筆商店資料
     * @param $id
     * @return Foods|Foods[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function selectStoreById($id)
    {
        $cacheKey = "foodsOneRow_" . $id;
        $result = Cache::get($cacheKey);
        if ($result === null) {
            $result = $this->FoodsRepository->selectById($id);
            Cache::put($cacheKey, $result, now()->addMinutes(30));
        }
        return $result;
    }


    /**
     * @note 更新by ID
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateDataById($id, $data): bool
    {
        //更新需重製cache
        $cacheKey = "foodsOneRow_" . $id;
        Cache::forget($cacheKey);
        return $this->FoodsRepository->updateDataById($id, $data);
    }

}
