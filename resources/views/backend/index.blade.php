@extends('backend.layouts.master')
@section('title','E-SHOP || DASHBOARD')
@section('main-content')
<div class="container-fluid">
    @include('backend.layouts.notification')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Total Users -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$userStats['total_users'] ?? 0}}</div>
                <div class="text-xs text-muted">Registered users</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Active Users -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$userStats['active_users'] ?? 0}}</div>
                <div class="text-xs text-muted">Currently active</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-check fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- This Month Users -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">This Month</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$userStats['this_month_users'] ?? 0}}</div>
                <div class="text-xs text-muted">New registrations</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Admin Users -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Admin Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$userStats['admin_users'] ?? 0}}</div>
                <div class="text-xs text-muted">System administrators</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-user-shield fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Second Row for Categories, Products, Posts -->
    <div class="row">

      <!-- Category -->
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Category</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Category::countActiveCategory()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-sitemap fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products -->
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Products</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Product::countActiveProduct()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-cubes fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--Posts-->
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Post</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Post::countActivePost()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-folder fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Dashboard Overview</h6>
            
          </div>
          <!-- Card Body -->
          <div class="card-body">
             <!-- Users List -->
            <div>
              @if(isset($recentUsers) && $recentUsers->count() > 0)
                <div class="table-responsive table-hover table-bordered">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($recentUsers as $user)
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            @if($user->photo)
                              <img src="{{ $user->photo }}" class="rounded-circle mr-2" style="width: 25px; height: 25px; object-fit: cover;">
                            @else
                              <img src="{{asset('backend/img/avatar.png')}}" class="rounded-circle mr-2" style="width: 25px; height: 25px; object-fit: cover;">
                            @endif
                            <div>
                              <div class="font-weight-bold text-sm">{{ $user->name }}</div>
                              <small class="text-muted">{{ $user->email }}</small>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-{{ $user->role_id == 1 ? 'danger' : ($user->role_id == 2 ? 'warning' : 'info') }} badge-sm">
                            {{ $user->role ? $user->role->display_name : 'No Role' }}
                          </span>
                        </td>
                        <td>
                          <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'secondary' }} badge-sm">
                            {{ $user->status }}
                          </span>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="text-center mt-3">
                  <a href="{{route('users.index')}}" class="btn btn-sm btn-outline-primary">View All Users</a>
                </div>
              @else
                <div class="text-center py-3">
                  <i class="fas fa-users fa-2x text-gray-300 mb-2"></i>
                  <p class="text-muted mb-0">No users found</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    
      <!-- Pie Chart -->
      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">User Registration (7 Days)</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body" style="overflow:hidden">
            <div id="pie_chart" style="width:100%; height:200px;">
          </div>
        </div>
      </div>
    </div>

    <!-- User Statistics Row -->
    <div class="row">
      <!-- Role Distribution Chart -->
      <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Role Distribution</h6>
          </div>
          <div class="card-body">
            @if(isset($roleDistribution) && $roleDistribution->count() > 0)
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Role</th>
                      <th>Count</th>
                      <th>Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $totalUsers = $userStats['total_users'] ?? 1;
                    @endphp
                    @foreach($roleDistribution as $role)
                      <tr>
                        <td>
                          <span class="badge badge-{{ $role->role == 'Admin' ? 'danger' : ($role->role == 'Manager' ? 'warning' : 'info') }}">
                            {{ $role->role }}
                          </span>
                        </td>
                        <td>{{ $role->count }}</td>
                        <td>
                          <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-{{ $role->role == 'Admin' ? 'danger' : ($role->role == 'Manager' ? 'warning' : 'info') }}" 
                                 role="progressbar" 
                                 style="width: {{ round(($role->count / $totalUsers) * 100, 1) }}%"
                                 aria-valuenow="{{ round(($role->count / $totalUsers) * 100, 1) }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                              {{ round(($role->count / $totalUsers) * 100, 1) }}%
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="text-center py-3">
                <i class="fas fa-chart-pie fa-2x text-gray-300 mb-2"></i>
                <p class="text-muted mb-0">No role data available</p>
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- User Statistics Summary -->
      <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Statistics Summary</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6 mb-3">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="fas fa-users text-primary fa-2x"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="fw-bold">Total Users</div>
                    <div class="text-muted">{{ $userStats['total_users'] ?? 0 }}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 mb-3">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="fas fa-user-check text-success fa-2x"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="fw-bold">Active Users</div>
                    <div class="text-muted">{{ $userStats['active_users'] ?? 0 }}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 mb-3">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="fas fa-user-times text-secondary fa-2x"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="fw-bold">Inactive Users</div>
                    <div class="text-muted">{{ $userStats['inactive_users'] ?? 0 }}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 mb-3">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <i class="fas fa-chart-line text-info fa-2x"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="fw-bold">Monthly Growth</div>
                    <div class="text-muted">
                      @php
                        $growth = (($userStats['this_month_users'] ?? 0) - ($userStats['last_month_users'] ?? 0));
                        $growthPercent = ($userStats['last_month_users'] ?? 0) > 0 
                          ? round(($growth / $userStats['last_month_users']) * 100, 1) 
                          : 0;
                      @endphp
                      @if($growth >= 0)
                        <span class="text-success">+{{ $growth }} ({{ $growthPercent }}%)</span>
                      @else
                        <span class="text-danger">{{ $growth }} ({{ $growthPercent }}%)</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Content Row -->
    
  </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- pie chart --}}
<script type="text/javascript">
  var analytics = <?php echo $users; ?>

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart()
  {
      var data = google.visualization.arrayToDataTable(analytics);
      var options = {
          title : 'Last 7 Days registered user'
      };
      var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
      chart.draw(data, options);
  }
</script>
  {{-- line chart --}}
  {{-- <script type="text/javascript">
    // const url = "{{route('product.order.income')}}";
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

      // Area Chart Example
      var ctx = document.getElementById("myAreaChart");

        axios.get(url)
              .then(function (response) {
                const data_keys = Object.keys(response.data);
                const data_values = Object.values(response.data);
                var myLineChart = new Chart(ctx, {
                  type: 'line',
                  data: {
                    labels: data_keys, // ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                      label: "Earnings",
                      lineTension: 0.3,
                      backgroundColor: "rgba(78, 115, 223, 0.05)",
                      borderColor: "rgba(78, 115, 223, 1)",
                      pointRadius: 3,
                      pointBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointBorderColor: "rgba(78, 115, 223, 1)",
                      pointHoverRadius: 3,
                      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                      pointHitRadius: 10,
                      pointBorderWidth: 2,
                      data:data_values,// [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
                    }],
                  },
                  options: {
                    maintainAspectRatio: false,
                    layout: {
                      padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                      }
                    },
                    scales: {
                      xAxes: [{
                        time: {
                          unit: 'date'
                        },
                        gridLines: {
                          display: false,
                          drawBorder: false
                        },
                        ticks: {
                          maxTicksLimit: 7
                        }
                      }],
                      yAxes: [{
                        ticks: {
                          maxTicksLimit: 5,
                          padding: 10,
                          // Include a dollar sign in ticks
                          callback: function(value, index, values) {
                            return '$' + number_format(value);
                          }
                        },
                        gridLines: {
                          color: "rgb(234, 236, 244)",
                          zeroLineColor: "rgb(234, 236, 244)",
                          drawBorder: false,
                          borderDash: [2],
                          zeroLineBorderDash: [2]
                        }
                      }],
                    },
                    legend: {
                      display: false
                    },
                    tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      titleMarginBottom: 10,
                      titleFontColor: '#6e707e',
                      titleFontSize: 14,
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      intersect: false,
                      mode: 'index',
                      caretPadding: 10,
                      callbacks: {
                        label: function(tooltipItem, chart) {
                          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                          return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                        }
                      }
                    }
                  }
                });
              })
              .catch(function (error) {
              //   vm.answer = 'Error! Could not reach the API. ' + error
              console.log(error)
              });

  </script> --}}
@endpush