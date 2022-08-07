<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>View page</title>
    </head>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <body>
        <h1>View</h1>
        <h2>中身説明</h2>
        @foreach($move_type_number as $type=>$num)
            <div>
                <p>{{ $type }}の移動を{{ $num }}回実施し、合計は{{ $move_total_distance[$type] }}kmだった。</p>
            </div>
        @endforeach
        <h2>グラフ表示</h2>
        <!--Canvasのサイズを調整するときは外側のdivタグで指定-->
        <div style="width:450px;height:300px;">
            <canvas id="chart_id_num"></canvas>
        </div>
        <div style="width:450px;height:300px;">
            <canvas id="chart_id_type"></canvas>
        </div>

        <h3>CO2換算</h3>
        <p>移動の種類と対応CO2排出量のテーブル</p>
        <label for="vehicle">自動車</label>
        <input type="number" id="vehval" value=131> g-CO2/人km
        <button type="button" id="vehbut">Update</button>
        <br>
        <label for="train">電車　</label>
        <input type="number" id="traval" value=28> g-CO2/人km
        <button type="button" id="trabut">Update</button>
        <br>
        <label for="flying">飛行機</label>
        <input type="number" id="flyval" value=133> g-CO2/人km
        <button type="button" id="flybut">Update</button>
        <br>
        <button id="co2btn">グラフ表示</button>

        <div style="width:450px;height:300px;">
            <canvas id="chart_id_co2"></canvas>
        </div>
        
    </body>

    <script>
        const move_type_number = @json($move_type_number);
        const move_total_distance = @json($move_total_distance);
        let dist = [];
        let type = [];
        let nums = [];
        console.log(move_total_distance);
        for (key in move_total_distance) {
            type.push(key);
            nums.push(move_type_number[key]);
            dist.push(move_total_distance[key]);
        }
        console.log(dist);

        let ctx_num = document.getElementById('chart_id_num'); // id='chart_id'
        let myBarChart_num = new Chart(ctx_num, {
            type: 'bar',
            data: {
                labels: type,
                datasets: [
                    {
                        label: '移動回数',
                        data: nums,
                        backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    },
                ],
            },
            options: {
                scales: { // 軸設定
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: '移動回数'
                        }
                    }
                },
            },
        });


        let ctx_type = document.getElementById('chart_id_type'); // id='chart_id'
        let myBarChart_type = new Chart(ctx_type, {
            type: 'bar',
            data: {
                labels: type,
                datasets: [
                    {
                        label: '移動距離',
                        data: dist,
                        backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    },
                ],
            },
            options: {
                scales: { // 軸設定
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: '移動距離 [km]'
                        }
                    }
                },
            },
        })

        // 移動の定義づけ

        // https://locationhistoryformat.com/reference/semantic/#/$defs/activityType/
        const moveTypeDefinition = {
            BOATING: "others",
            CATCHING_POKEMON: "others",
            CYCLING: "myself",
            FLYING: "flying",
            HIKING: "myself",
            HORSEBACK_RIDING: "others",
            IN_BUS: "vehicle",
            IN_CABLECAR: "others",
            IN_FERRY: "others",
            IN_FUNICULAR: "others",
            IN_GONDOLA_LIFT: "others",
            IN_PASSENGER_VEHICLE: "vehicle",
            IN_SUBWAY: "train",
            IN_TAXI: "vehicle",
            IN_TRAIN: "train",
            IN_TRAM: "train",
            IN_VEHICLE: "vehicle",
            IN_WHEELCHAIR: "others",
            KAYAKING: "others",
            KITESURFING: "others",
            MOTORCYCLING: "vehicle",
            PARAGLIDING: "others",
            ROWING: "others",
            RUNNING: "myself",
            SAILING: "others",
            SKATEBOARDING: "others",
            SKATING: "myself",
            SKIING: "myself",
            SLEDDING: "others",
            SNOWBOARDING: "myself",
            SNOWMOBILE: "others",
            SNOWSHOEING: "myself",
            STILL: "myself",
            SURFING: "myself",
            SWIMMING: "myself",
            UNKNOWN_ACTIVITY_TYPE: "others",
            WALKING: "myself",
            WALKING_NORDIC: "myself"
        }

        // https://www.mlit.go.jp/sogoseisaku/environment/sosei_environment_tk_000007.html
        const moveTypeList = ["myself", "vehicle", "train", "flying", "others"];
        let moveTypeCost = {
            myself: 0,
            vehicle: 131,
            train: 28,
            flying: 133,
            others: 1 //適当に1にした。
        }
        let co2Volume = [0,0,0,0,0] // moveTypeListの長さだけ0がある。
        let temp = "myself"
        console.log(moveTypeCost[temp], "AAA")

        // 原単位Update
        vehbut.onclick = function(e) {
            let vehval = $('#vehval').val();
            moveTypeCost.vehicle = Number(vehval);
            console.log(moveTypeCost);
        }

        trabut.onclick = function(e) {
            let traval = $('#traval').val();
            moveTypeCost.train = Number(traval);
            console.log(moveTypeCost);
        }

        flybut.onclick = function(e) {
            let flyval = $('#flyval').val();
            moveTypeCost.flying = Number(flyval);
            console.log(moveTypeCost);
        }


        // CO2のグラフを表示
        const co2btn = document.querySelector("#co2btn")
        let ctx_co2 = document.getElementById('chart_id_co2'); // id='chart_id'
        let myBarChart_co2 = null;
        co2btn.onclick = function(e) {
            // CO2 volumeをリセット
            co2Volume = [0,0,0,0,0]
            for (key in move_total_distance) {
                console.log(key);
                console.log(moveTypeDefinition[key]);
                for (let i = 0; i < moveTypeList.length; i++) {
                    if (moveTypeList[i] === moveTypeDefinition[key]) {
                        // kgに変換するために1000で割る。
                        co2Volume[i] += move_total_distance[key] * moveTypeCost[moveTypeList[i]] / 1000;
                        console.log(key, moveTypeCost[moveTypeList[i]]);
                    }
                }
            }
            console.log(co2Volume);
            // 2回目以降の場合はDestoryする必要あり。
            if (myBarChart_co2){
                console.log("null hantei")
                myBarChart_co2.destroy();
            }
            // グラフ描写
            myBarChart_co2 = new Chart(ctx_co2, {
                type: 'bar',
                data: {
                    labels: moveTypeList,
                    datasets: [
                        {
                            label: 'CO2 emission',
                            data: co2Volume,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(201, 203, 207)'
                            ],
                            borderWidth: 1
                        },
                    ],
                },
                options: {
                    scales: { // 軸設定
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'CO2排出量 [kg]'
                            }
                        }
                    },
                },
            });
        }
    </script>

</html>