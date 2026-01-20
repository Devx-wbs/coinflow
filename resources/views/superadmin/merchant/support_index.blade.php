@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Heading -->
    <div class="d-flex flex-column gap-0 mb-3">
        <h4 class="mb-1">Customer Support</h4>
        <span class="text-muted mb-3">Manage customer support tickets and inquiries</span>
    </div>
    
    <!-- Search & Filter Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center gap-3">
            <input type="text" class="form-control" placeholder="Search tickets by customer , emails or subjects ....">
            <select class="form-select" style="max-width:180px;">
                <option>All Statuses</option>
            </select>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body px-0">
            <h6 class="mb-4 px-4 pt-2 font-weight-bold">Customer Support</h6>
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Ticket ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">TK-001</td>
                            <td>John Smith</td>
                            <td>john@techstore.com</td>
                            <td>Payment gateway not working</td>
                            <td><span class="badge bg-danger">Open</span></td>
                            <td>2024-01-15</td>
                            <td><span style="color: #aaa;">...</span></td>
                        </tr>
                        <tr class="bg-light">
                            <td class="fw-bold">TK-002</td>
                            <td>Sarah Johnson</td>
                            <td>sarah@fashionboutique.com</td>
                            <td>License key activation problem</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>2024-01-14</td>
                            <td><span style="color: #aaa;">...</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">TK-003</td>
                            <td>Mike Chen</td>
                            <td>mike@electronicsworld.com</td>
                            <td>Transaction fees question</td>
                            <td><span class="badge bg-success">Resolved</span></td>
                            <td>2024-01-13</td>
                            <td><span style="color: #aaa;">...</span></td>
                        </tr>
                        <tr class="bg-light">
                            <td class="fw-bold">TK-004</td>
                            <td>Sarah Johnson</td>
                            <td>sarah@fashionboutique.com</td>
                            <td>License key activation problem</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>2024-01-12</td>
                            <td><span style="color: #aaa;">...</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">TK-005</td>
                            <td>John Smith</td>
                            <td>john@techstore.com</td>
                            <td>Payment gateway not working</td>
                            <td><span class="badge bg-danger">Open</span></td>
                            <td>2024-01-11</td>
                            <td><span style="color: #aaa;">...</span></td>
                        </tr>
                        <tr class="bg-light">
                            <td class="fw-bold">TK-006</td>
                            <td>Sarah Johnson</td>
                            <td>sarah@fashionboutique.com</td>
                            <td>License key activation problem</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>2024-01-10</td>
                            <td><span style="color: #aaa;">...</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center align-items-center p-3">
            <button class="btn btn-dark btn-sm rounded-pill px-3">&lt; &gt;</button>
        </div>
    </div>
</div>
@endsection
