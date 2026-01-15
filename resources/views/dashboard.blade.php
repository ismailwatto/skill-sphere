@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-5">
    <!-- Total Sales -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-primary-soft me-3">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Total Sales</h6>
                    <h4 class="mb-0 fw-bold">$24,500</h4>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-success fw-bold"><i class="bi bi-caret-up-fill"></i> 12%</span>
                <span class="text-muted ms-1">vs last month</span>
            </div>
        </div>
    </div>

    <!-- Active Customers -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-success-soft me-3">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Customers</h6>
                    <h4 class="mb-0 fw-bold">1,240</h4>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-success fw-bold"><i class="bi bi-caret-up-fill"></i> 5.4%</span>
                <span class="text-muted ms-1">vs last month</span>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-warning-soft me-3">
                    <i class="bi bi-bag"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Orders</h6>
                    <h4 class="mb-0 fw-bold">482</h4>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-danger fw-bold"><i class="bi bi-caret-down-fill"></i> 2.1%</span>
                <span class="text-muted ms-1">vs last week</span>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-stats p-3">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-info-soft me-3">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Revenue</h6>
                    <h4 class="mb-0 fw-bold">$12,840</h4>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-success fw-bold"><i class="bi bi-caret-up-fill"></i> 8%</span>
                <span class="text-muted ms-1">vs last month</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold">Revenue Analytics</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle" style="width: 10px; height: 10px; margin-top: 6px;"></div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0 small fw-bold">New order received</p>
                            <p class="mb-0 text-muted extra-small">2 minutes ago by Ismail</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle" style="width: 10px; height: 10px; margin-top: 6px;"></div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0 small fw-bold">Customer registered</p>
                            <p class="mb-0 text-muted extra-small">45 minutes ago</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-warning rounded-circle" style="width: 10px; height: 10px; margin-top: 6px;"></div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0 small fw-bold">Payment failed</p>
                            <p class="mb-0 text-muted extra-small">1 hour ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders Table -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Recent Transactions</h5>
                <button class="btn btn-sm btn-light rounded-pill px-3">View Report</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-bold">#SK-1204</td>
                                <td>Ismail Wattoo</td>
                                <td><span class="badge rounded-pill bg-success-soft text-success badge-soft">Completed</span></td>
                                <td>$450.00</td>
                                <td class="text-muted small">Jan 15, 2024</td>
                                <td class="pe-4 text-end"><i class="bi bi-three-dots-vertical"></i></td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold">#SK-1205</td>
                                <td>John Doe</td>
                                <td><span class="badge rounded-pill bg-warning-soft text-warning badge-soft">Pending</span></td>
                                <td>$120.00</td>
                                <td class="text-muted small">Jan 15, 2024</td>
                                <td class="pe-4 text-end"><i class="bi bi-three-dots-vertical"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue 2024',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4e73df',
                    pointHoverRadius: 6
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2], color: 'rgba(0,0,0,0.05)' },
                        ticks: { color: '#b7b9cc', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#b7b9cc', font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>

<style>
.extra-small { font-size: 0.75rem; }
.timeline { position: relative; }
</style>
@endsection
