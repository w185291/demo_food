<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>food demo</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <style>
        html,
        body,
        .intro {
            height: 100%;
        }



        thead th,
        tbody th {
            color: #fff;
        }

        tbody td {
            font-weight: 500;
            color: rgba(255, 255, 255, .65);
        }

        .card {
            border-radius: .5rem;
        }
    </style>
</head>
<body class="antialiased">
<section class="intro">
    <div class="bg-image h-100"
         style="background-image: url('https://mdbootstrap.com/img/Photos/new-templates/tables/img2.jpg');">

                    <div class="col-12">
                        <div class="card bg-dark shadow-2-strong">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-dark table-borderless mb-0">
                                        <thead>
                                        <tr class="store-header">

                                            <th scope="col">商店名稱</th>
                                            <th scope="col">商店電話</th>
                                            <th scope="col">營業時間</th>
                                            <th scope="col">座標</th>
                                            <th scope="col">
                                                食物列表
                                            </th>
                                        </tr>
                                        <tr class="food-header" style="display: none">
                                            <th scope="col">商店名稱</th>
                                            <th scope="col">食物名稱</th>
                                            <th scope="col">食物價格</th>
                                            <th scope="col">食物備註</th>
                                            <th scope="col">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="getStoreList('+value.id+')">商店列表</button>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="data-loader">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

    </div>
</section>

<script>

    getStoreList();

    function getFoodList(store_id) {
        $.ajax({
            url: "{{route('api.foods.list')}}",
            type: "GET",
            data: {
                //可搜全部或 限制50筆  前端因題目沒有需求 所以前端沒做分頁 不然可以帶page 一次拿50
                page: -1,
                store_id : store_id
            },
            dataType: "json",
            success: function (response) {
                if (response.code === "success") {
                    let html = renderFoodsTable(response.data);
                    $(".store-header").hide();
                    $(".food-header").show();
                    $(".data-loader").html(html);
                }else{
                    alert('無資料');
                }
            },
            error: function (xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    function getStoreList() {
        $.ajax({
            url: "{{route('api.stores.list')}}",
            type: "GET",
            data: {
                page: 1
            },
            dataType: "json",
            success: function (response) {
                if (response.code === "success") {
                    let html = renderStoresTable(response.data);
                    $(".store-header").show();
                    $(".food-header").hide();
                    $(".data-loader").html(html);
                }
            },
            error: function (xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    function renderStoresTable(data) {
        let html = "";
        if (data.length > 0) {
            $.each(data, function (index, value) {
                html += "<tr>";
                html += "<td>" + value.store_name + "</td>";
                html += "<td>" + value.store_phone + "</td>";
                html += "<td>" + value.store_business_start_time + " - " + value.store_business_end_time + "</td>";
                html += "<td>" + value.store_longitude + " - " + value.store_latitude + "</td>";
                html += '<td><button type="button" class="btn btn-primary btn-sm" onclick="getFoodList('+value.id+')">取得食物列表</button></td>';
                html += "</tr>";
            })
        }
        return html;
    }

    function renderFoodsTable(data) {
        let html = "";
        if (data.length > 0) {
            $.each(data, function (index, value) {
                html += "<tr>";
                html += "<td>" + index + "." +  value.store_name + "</td>";
                html += "<td>" + value.food_name + "</td>";
                html += "<td>" + value.food_price + "</td>";
                html += "<td>" + value.food_remark + "</td>";
                html += "</tr>";
            })
        }
        return html;
    }
</script>
</body>
</html>
