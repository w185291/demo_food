<?php

namespace App\Service;

use App\Models\Entities\Stores;
use App\Repositories\StoresRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;


class StoresService
{

    private StoresRepository $StoresRepository;

    public function __construct(StoresRepository $StoresRepository)
    {
        $this->StoresRepository = $StoresRepository;
    }


    /**
     * @note 取得商店分頁
     * @param $page
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     * @author roger
     * @date 2023-03-10
     */
    public function getStoresListPage($page)
    {
        $defaultPageLimit = config('app.defaultPageLimit');
        $offset = ($page - 1) * $defaultPageLimit;
        //cache 可以優化 拉出來做
        $cacheKey = "storesList_" . $page;
        $result = Cache::get($cacheKey);
        if ($result == null) {
            $result = $this->StoresRepository->getPageData([], ['created_at' => 'desc'], $offset, $defaultPageLimit);
            Cache::put($cacheKey, $result, now()->addMinutes(30));
        }
        return $result;
    }

    /**
     * @note 創建商店
     * @param $data
     * @return Stores|Model
     */
    public function createStore($data)
    {
        //創建需刪除list file cache
        $prefix = 'storesList_';
        $keys = Cache::getStore()->getPrefix() . $prefix . '*';
        File::delete(File::glob($keys));
        return $this->StoresRepository->createData($data);
    }


    /**
     * @note 使用ID 取得一筆商店資料
     * @param $id
     * @return Stores|Stores[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function selectStoreById($id)
    {
        $cacheKey = "storesOneRow_" . $id;
        $result = Cache::get($cacheKey);
        if ($result === null) {
            $result = $this->StoresRepository->selectById($id);
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
        $cacheKey = "storesOneRow_" . $id;
        Cache::forget($cacheKey);
        return $this->StoresRepository->updateDataById($id, $data);
    }
}
