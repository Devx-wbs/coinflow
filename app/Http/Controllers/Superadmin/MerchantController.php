<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\LicenseActivation;
use App\Models\License;
use Carbon\Carbon;

class MerchantController extends Controller
{
    public function index()
    {
        $users = User::where('role', 0)
            ->with(['license.activations'])
            ->paginate();

        return view('superadmin.merchant.index', compact('users'));
    }


    public function subscribe_store_index(Request $request)
    {
        $query = License::with(['user', 'activations', 'planInfo']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('store_name', 'like', "%$search%");
            })->orWhereHas('activations', function ($q) use ($search) {
                $q->where('store_url', 'like', "%$search%");
            });
        }

        $allSubscribes = (clone $query)->get();

        $totalStores   = $allSubscribes->count();
        $activeStores  = $allSubscribes->where('status', 'active')->count();
        $paidPlans     = $allSubscribes->whereIn('status', ['expired', 'revoked'])->count();

        $totalAmount = $allSubscribes->sum(function ($item) {
            return optional($item->planInfo)->price ?? 0;
        });

        $subscribes = $query->paginate();

        return view('superadmin.merchant.subscribe_store_index', compact(
            'subscribes',
            'totalStores',
            'activeStores',
            'paidPlans',
            'totalAmount'
        ));
    }


    public function license_managment_index(Request $request)
    {
        $query = License::with('user');

        // Search by license key
        if ($request->filled('search_license_key')) {
            $query->where('license_key', 'like', '%' . $request->search_license_key . '%');
        }

        // Search by assigned store name
        if ($request->filled('search_store_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('store_name', 'like', '%' . $request->search_store_name . '%');
            });
        }

        // Search by status
        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }


        $licenses = $query->get();
        $licensesPerPage = $query
            ->orderBy('created_at', 'desc')
            ->paginate();

        // Pass everything to the view
        return view('superadmin.merchant.license_managment_index', compact(
            'licenses',
            'licensesPerPage'
        ));
    }




    public function global_stats_index()
    {
        return view('superadmin.merchant.global_star');
    }



    // public function store_earning_index()
    // {

    //     return view('superadmin.merchant.store_earning_index');
    // }


    public function logs_error_index()
    {

        return view('superadmin.merchant.logs_error_index');
    }


    public function update_tracker_index()
    {

        return view('superadmin.merchant.update_tracker_index');
    }


    public function support_index()
    {

        return view('superadmin.merchant.support_index');
    }


    public function viewStores($licenseId)
    {
        $license = License::with(['user', 'planInfo'])->findOrFail($licenseId);

        $activations = LicenseActivation::where('license_id', $license->id)
            ->orderBy('activated_at', 'desc')
            ->paginate(10);

        return view('superadmin.merchant.view_stores', compact(
            'license',
            'activations'
        ));
    }
}
