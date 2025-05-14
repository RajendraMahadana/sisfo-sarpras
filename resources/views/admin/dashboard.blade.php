@extends('layout.main_layout')
@section('header-title', 'Dashboard')
@section('content')

@include('admin.component.sidebar')

<main class="main" id="main">
<div class="mx-4">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
        <div class="rounded-xl p-6 bg-gradient-to-r from-purple-400 to-indigo-500 shadow-lg flex items-center space-x-4">
            <div class="bg-purple-600 bg-opacity-30 rounded-full h-[44px] w-[44px] flex items-center justify-center">
                <i class="ri-user-line text-white text-2xl"></i>
            </div>
            <div>
            <p class="text-white font-semibold text-lg" style="font-family: 'Inter', sans-serif;">{{ $userCount }}</p>
            <p class="text-purple-200 text-xs font-normal" style="font-family: 'Inter', sans-serif;">User Count</p>
            </div>
        </div>

      <div class="rounded-xl p-6 bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg flex items-center space-x-4">
        <div class="bg-blue-700 bg-opacity-30 rounded-full  h-[44px] w-[44px] flex items-center justify-center">
            <i class="ri-database-line text-white text-2xl"></i>
        </div>
        <div>
          <p class="text-white font-semibold text-lg" style="font-family: 'Inter', sans-serif;">{{ $itemCount }}</p>
          <p class="text-blue-200 text-xs font-normal" style="font-family: 'Inter', sans-serif;">Item Count</p>
        </div>
      </div>

      <div class="rounded-xl p-6 bg-gradient-to-r from-red-400 to-red-500 shadow-lg flex items-center space-x-4">
        <div class="bg-red-600 bg-opacity-30 rounded-full  h-[44px] w-[44px] flex items-center justify-center">
            <i class="ri-stack-line text-white text-2xl"></i>
        </div>
        <div>
          <p class="text-white font-semibold text-lg" style="font-family: 'Inter', sans-serif;">{{ $categoryCount }}</p>
          <p class="text-red-200 text-xs font-normal" style="font-family: 'Inter', sans-serif;">category Count</p>
        </div>
      </div>

      <div class="rounded-xl p-6 bg-gradient-to-r from-orange-400 to-orange-500 shadow-lg flex items-center space-x-4">
        <div class="bg-orange-600 bg-opacity-30 rounded-full  h-[44px] w-[44px] flex items-center justify-center">
            <i class="ri-hand-coin-line text-white text-2xl"></i>
        </div>
        <div>
          <p class="text-white font-semibold text-lg" style="font-family: 'Inter', sans-serif;">{{ $loanCount }}</p>
          <p class="text-orange-200 text-xs font-normal" style="font-family: 'Inter', sans-serif;">loan successful</p>
        </div>
      </div>
    </div>
  </div>

  <div class="flex m-4 gap-4">

    <div class="flex w-4/5 shadow-md p-5 items-center justify-between rounded-xl">
        <div class="flex flex-col gap-y-8">
            <div class="flex flex-col">
                <h1 class="font-semibold text-lg leading-tight">Bar Chart</h1>
                <span class="text-xs">Loan data overview</span>
            </div>

          <div class="flex flex-col gap-5">
            <div class="flex gap-x-4 items-center">
              <span class="bg-orange-300 bg-opacity-45 border border-orange-400 rounded-full size-10 flex items-center justify-center">
                <i class="ri-hourglass-line text-md font-semibold text-orange-400"></i>
              </span>
              
              <div>
                <p class="text-base font-bold">{{ $itemsPendingApproval }}</p>
                <p class="text-xs">Pending approval</p>
              </div>
            </div>

            <div class="flex gap-x-4 items-center">
              <span class="bg-teal-300 bg-opacity-45 border border-teal-400 rounded-full size-10 flex items-center justify-center">
                <i class="ri-checkbox-circle-line text-md font-semibold text-teal-400"></i>
              </span>

              <div>
                <p class="text-base font-bold">{{ $itemsOnLoan }}</p>
                <p class="text-xs">Items on loan</p>
              </div>
            </div>

            <div class="flex gap-x-4 items-center">
              <span class="bg-indigo-300 bg-opacity-45 border border-indigo-400 rounded-full size-10 flex items-center justify-center">
                <i class="ri-scales-2-line text-md font-semibold text-indigo-700"></i>
              </span>

              <div>
                <p class="text-base font-bold">{{ $totalQuantity }}</p>
                <p class="text-xs">Total Quantity item</p>
              </div>
            </div>
          </div>

            <div class="flex">
                <a class="bg-purple-700 px-5 py-2 text-xs rounded-xl cursor-pointer text-white">see loan details</a>
            </div>
        </div>

        <div class=" w-9/12 flex flex-col items-center">
            <ul class="flex gap-4">
                <li><button id="btn-daily" onclick="switchChart('daily')" class="chart-btn">Daily</button></li>
                <li><button id="btn-weekly" onclick="switchChart('weekly')" class="chart-btn">Weekly</button></li>
                <li><button id="btn-monthly" onclick="switchChart('monthly')" class="chart-btn active">Monthly</button></li>
                <li><button id="btn-yearly" onclick="switchChart('yearly')" class="chart-btn">Yearly</button></li>
            </ul>
            
            <canvas id="loanChart"></canvas>
            <script>
                const dailyData = @json($dailyData);
                const weeklyData = @json($weeklyData);
                const monthlyData = @json($monthlyData);
                const yearlyData = @json($yearlyData);
            </script>
        </div>
    </div>

  <div class="shadow-md rounded-xl p-5 w-2/5">
    <div class="flex justify-between items-center mb-6">
      <h1 class="font-semibold text-lg leading-tight">User</h1>
      <a class="text-gray-400 text-sm font-normal transition-all hover:text-first" href="#">See all</a>
    </div>
    <ol class="space-y-5">
      @foreach ($users as $index => $user)
      <li class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <span class="leading-tight text-sm">
            {{ $index + 1 }}.
          </span>
          <img
            src="{{ $user->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
            alt="{{ $user->name }}"
            class="w-10 h-10 rounded-full object-cover"
          />
          <div>
            <p class="font-semibold text-sm leading-tight">
              {{ $user->name }}
            </p>
            <p class="text-gray-400 text-xs leading-tight">
              {{ $user->email }}
            </p>
          </div>
        </div>
        <div class="flex space-x-2">
          <a href="{{ route('users.edit', $user->id) }}"
             class="bg-purple-700 text-white text-xs font-semibold px-4 py-1 rounded-full">
            Edit
          </a>
          <form method="POST" action="{{ route('users.destroy', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit"
              onclick="return confirm('Yakin ingin menghapus user ini?')"
              class="bg-pink-600 text-white text-xs font-semibold px-4 py-1 rounded-full">
              Hapus
            </button>
          </form>
        </div>
      </li>
      @endforeach
    </ol>
  </div>
</div>

<div class="flex m-4 gap-4">

  <div class="w-2/3 p-5 shadow-md rounded-xl ">
    @livewire('loan-requests')
  </div>
  <div class="w-1/2 p-5 shadow-md rounded-xl">
    @livewire('return-request')
  </div>
</div>





</main>

<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    let chart;

    function createChart(labels, data, label = 'Total Peminjaman') {
        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: 'rgba(9, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    function switchChart(type) {
    let labels = [], data = [];

    if (type === 'daily') {
        labels = dailyData.map(row => row.date);
        data = dailyData.map(row => row.total);
    } else if (type === 'weekly') {
        labels = weeklyData.map(row => 'Week ' + row.week);
        data = weeklyData.map(row => row.total);
    } else if (type === 'monthly') {
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        labels = monthlyData.map(row => monthNames[row.month - 1]);
        data = monthlyData.map(row => row.total);
    } else if (type === 'yearly') {
        labels = yearlyData.map(row => row.year);
        data = yearlyData.map(row => row.total);
    }

    createChart(labels, data, 'Total Peminjaman (' + type.charAt(0).toUpperCase() + type.slice(1) + ')');

    // Set tombol aktif
    document.querySelectorAll('.chart-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById('btn-' + type).classList.add('active');
}

    // Inisialisasi pertama (bulanan)
    switchChart('monthly');
</script>

@endsection