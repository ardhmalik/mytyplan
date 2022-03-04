<main id="main" class="main">
    <div class="pagetitle">
        <h1><?= $title ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('admin_dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row">
                    <!-- Users Card -->
                    <div class="col-sm-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Users <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ri-user-line"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= count($users) ?></h6>
                                        <span class="text-success small pt-1 fw-bold"><?= round(count($new_users)/count($users)*100, 2) ?> %</span> <span class="text-muted small pt-2 ps-1">increase</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Users Card -->

                    <!-- Plans Card -->
                    <div class="col-sm-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Plans <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bx-notepad"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= count($plans) ?></h6>
                                        <span class="text-success small pt-1 fw-bold"><?= round(count($new_plans)/count($plans)*100, 2) ?> %</span> <span class="text-muted small pt-2 ps-1">increase</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Plans Card -->

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Plans Reports <span>/Total</span></h5>
                                <!-- Line Chart -->
                                <div id="reportsChart"></div>
                                <!-- End Line Chart -->
                            </div>
                        </div>
                    </div>
                    <!-- End Reports -->
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Plans Status -->
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Plans Status <span>| Total</span></h5>
                        <div id="plansChart" style="min-height: 400px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative;" class="echart" _echarts_instance_="ec_1646280766100">
                            <div style="position: relative; width: 281px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="562" height="800" style="position: absolute; left: 0px; top: 0px; width: 281px; height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div>
                            <div class="" style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; transition: opacity 0.2s cubic-bezier(0.23, 1, 0.32, 1) 0s, visibility 0.2s cubic-bezier(0.23, 1, 0.32, 1) 0s, transform 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgb(255, 255, 255); border-width: 1px; border-radius: 4px; color: rgb(102, 102, 102); font: 14px / 21px sans-serif; padding: 10px; top: 0px; left: 0px; transform: translate3d(138px, 236px, 0px); border-color: rgb(84, 112, 198); pointer-events: none; visibility: hidden; opacity: 0;">
                                <div style="margin: 0px 0 0;line-height:1;">
                                    <div style="font-size:14px;color:#666;font-weight:400;line-height:1;">Number of</div>
                                    <div style="margin: 10px 0 0;line-height:1;">
                                        <div style="margin: 0px 0 0;line-height:1;"><span style="display:inline-block;margin-right:4px;border-radius:10px;width:10px;height:10px;background-color:#5470c6;"></span><span style="font-size:14px;color:#666;font-weight:400;margin-left:2px">Search Engine</span><span style="float:right;margin-left:20px;font-size:14px;color:#666;font-weight:900">1,048</span>
                                            <div style="clear:both"></div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Plans Status -->
            </div>
        </div>
    </section>
</main>

<script>
    // Line Chart
    document.addEventListener("DOMContentLoaded", () => {
        new ApexCharts(document.querySelector("#reportsChart"), {
            series: [{
                name: 'Plans',
                data: [31, 40, 28, 51, 42, 82, 56],
            }, {
                name: 'Users',
                data: [11, 32, 45, 32, 34, 52, 41]
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1', '#2eca6a', '#ff771d'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'datetime',
                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            }
        }).render();
    });

    // Donut Chart
    document.addEventListener("DOMContentLoaded", () => {
        echarts.init(document.querySelector("#plansChart")).setOption({
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [{
                name: 'Number of',
                type: 'pie',
                radius: ['40%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: [{
                        value: <?= count($fail_plans) ?>,
                        name: 'Failed'
                    },
                    {
                        value: <?= count($success_plans) ?>,
                        name: 'Passed'
                    },
                    {
                        value: <?= count($unfulfilled_plans) ?>,
                        name: 'Unfulfilled'
                    }
                ]
            }]
        });
    });
</script>