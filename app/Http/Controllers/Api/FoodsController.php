<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\StoresService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Service\FoodsService;

class FoodsController extends Controller
{

    public FoodsService $FoodsService;
    public StoresService $StoresService;

    public function __construct(FoodsService $FoodsService, StoresService $StoresService)
    {
        $this->FoodsService = $FoodsService;
        $this->StoresService = $StoresService;
    }

    //demo 暫用不然可以做一個message class 統一使用 還有返回代碼定義 200 之類的http code
    public array $result = [
        "code" => "fail",
        "data" => [],
        "errorMsg" => []
    ];

    /**
     * @note 食物列表
     * @param Request $request
     * @return JsonResponse
     * @author roger
     * @date 2023-03-10
     */
    public function list(Request $request): JsonResponse
    {

        //demo 簡易版本 正常需要再開一個StoresListRequest 把驗證寫裡面
        $validated = Validator::make($request->all(), [
            'page' => 'required|int',
            'store_id' => 'int',
        ]);

        if ($validated->fails()) {
            $this->result['errorMsg'] = $validated->errors()->messages();
        } else {
            $page = $request->input('page');
            $store_id = $request->input('store_id');
            $data = $this->FoodsService->getFoodsListPage($page,$store_id);
            if ($data->isNotEmpty()) {
                $this->result['code'] = "success";
                $this->result['data'] = $data;
            }
        }

        return response()->json($this->result);
    }


    /**
     * @note 創建食物
     * @param Request $request
     * @return JsonResponse
     * @author roger
     * @date 2023-03-10
     */
    public function store(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'store_id' => 'required|int',
            'food_name' => 'required|string|max:255|min:5',
            'food_price' => 'required|int|min:0|not_in:0',
            'food_remark' => 'string'
        ]);

        if ($validated->fails()) {
            $this->result['errorMsg'] = $validated->errors()->messages();
        } else {
            $store_id = $request->input('store_id');
            $oneData = $this->StoresService->selectStoreById($store_id);
            if (!$oneData) {
                $this->result['errorMsg'][] = ['store_id' => "商店不存在"];
            } else {
                $created = $this->FoodsService->createStore($request->all());
                if ($created) {
                    $oneData = $this->FoodsService->selectStoreById($created->id);
                    $this->result['code'] = "success";
                    $this->result['data'] = $oneData;
                }
            }
        }
        return response()->json($this->result);
    }


    /**
     * @note 取得單一一筆食物資料
     * @param $id
     * @return JsonResponse
     * @author roger
     * @date 2023-03-10
     */
    public function show($id): JsonResponse
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|int',
        ]);

        if ($validated->fails()) {
            $this->result['errorMsg'] = $validated->errors()->messages();
        } else {
            $existed = $this->FoodsService->selectStoreById($id);
            if (!$existed) {
                $this->result['errorMsg'][] = ['id' => '資料不存在'];
            } else {
                $this->result['code'] = "success";
                $this->result['data'] = $existed;
            }
        }
        return response()->json($this->result);
    }

    /**
     * @note 更新食物資料
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @author roger
     * @date 2023-03-10
     */
    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->input();
        $data['id'] = $id;
        $validated = Validator::make($data, [
            'id' => 'required|int',
            'store_id' => 'required|int',
            'food_name' => 'required|string|max:255|min:5',
            'food_price' => 'required|int|min:0|not_in:0',
            'food_remark' => 'string'
        ]);

        if ($validated->fails()) {
            $this->result['errorMsg'] = $validated->errors()->messages();
        } else {
            $store_id = $request->input('store_id');
            $oneData = $this->StoresService->selectStoreById($store_id);
            $existed = $this->FoodsService->selectStoreById($id);
            if (!$oneData || !$existed) {
                $this->result['errorMsg'][] = ['store_id' => "資料或商店不存在"];
            }else{
                $updated = $this->FoodsService->updateDataById($id, $data);
                if ($updated) {
                    $oneData = $this->FoodsService->selectStoreById($id);
                    $this->result['code'] = "success";
                    $this->result['data'] = $oneData;
                }
            }
        }
        return response()->json($this->result);
    }

}
