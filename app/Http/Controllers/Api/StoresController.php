<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\StoresService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoresController extends Controller
{

    public StoresService $StoresService;

    public function __construct(StoresService $StoresService)
    {
        $this->StoresService = $StoresService;
    }

    //demo 暫用不然可以做一個message class 統一使用 還有返回代碼定義 200 之類的http code
    public array $result = [
        "code" => "fail",
        "data" => [],
        "errorMsg" => []
    ];

    /**
     * @note 商店列表
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
        ]);

        if ($validated->fails()) {
            $this->result['errorMsg'] = $validated->errors()->messages();
        } else {
            $page = $request->input('page');
            $data = $this->StoresService->getStoresListPage($page);
            if ($data->isNotEmpty()) {
                $this->result['code'] = "success";
                $this->result['data'] = $data;
            }
        }

        return response()->json($this->result);
    }


    /**
     * @note 創建商店
     * @param Request $request
     * @return JsonResponse
     * @author roger
     * @date 2023-03-10
     */
    public function store(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'store_name' => 'required|string|max:100|min:3',
            'store_phone' => 'required|string|max:25|min:10',
            'store_business_start_time' => 'date_format:H:i',
            'store_business_end_time' => 'date_format:H:i',
            'store_longitude' => 'min:0|not_in:0',
            'store_latitude' => 'min:0|not_in:0',
        ]);

        if ($validated->fails()) {
            $this->result['errorMsg'] = $validated->errors()->messages();
        } else {
            $created = $this->StoresService->createStore($request->all());

            if ($created) {
                $oneData = $this->StoresService->selectStoreById($created->id);
                $this->result['code'] = "success";
                $this->result['data'] = $oneData;
            }
        }
        return response()->json($this->result);
    }


    /**
     * @note 取得單一一筆商店資料
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
            $existed = $this->StoresService->selectStoreById($id);
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
     * @note 更新商店資料
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
            'store_name' => 'required|string|max:100|min:3',
            'store_phone' => 'required|string|max:25|min:10',
            'store_business_start_time' => 'date_format:H:i',
            'store_business_end_time' => 'date_format:H:i',
            'store_longitude' => 'min:0|not_in:0',
            'store_latitude' => 'min:0|not_in:0',
        ]);

        if ($validated->fails()) {
            $this->result['errorMsg'] = $validated->errors()->messages();
        } else {
            $existed = $this->StoresService->selectStoreById($id);
            if (!$existed) {
                $this->result['errorMsg'][] = ['id' => '資料不存在'];
            }else{
                $updated = $this->StoresService->updateDataById($id, $data);
                if ($updated) {
                    $oneData = $this->StoresService->selectStoreById($id);
                    $this->result['code'] = "success";
                    $this->result['data'] = $oneData;
                }
            }
        }
        return response()->json($this->result);
    }
}
