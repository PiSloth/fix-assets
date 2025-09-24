<?php

namespace App\Livewire\ProductSetting;

use Livewire\Component;

use App\Models\Verify;
use App\Models\Assembly;
use Carbon\Carbon;


use Illuminate\Support\Facades\Validator;

class VerifyReport extends Component
{
    public $verifiedCount;
    public $notVerifiedCount;
    public $requests;
    public $requesterPerformance;
    public $startDate;
    public $endDate;
    public $selectedRequesterId;
    public $canceledRequests;
    public $groupedRequests;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfWeek()->toDateString();
        $this->endDate = Carbon::now()->endOfWeek()->toDateString();
        $this->selectedRequesterId = null;
        $this->loadData();
    }

    public function updatedStartDate()
    {
        $this->loadData();
    }

    public function updatedEndDate()
    {
        $this->loadData();
    }

    public function updatedSelectedRequesterId()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Count assemblies with at least one verify (verified) and without (not verified)
        $this->verifiedCount = Assembly::has('verify')->count();
        $this->notVerifiedCount = Assembly::doesntHave('verify')->count();

        // Get verifies in selected date interval
        $query = Verify::with('requestby')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        if ($this->selectedRequesterId) {
            $query->where('requestby_id', $this->selectedRequesterId);
        }
        $this->requests = $query->get();

        // Group requests by requester for the interval
        $this->groupedRequests = $this->requests->groupBy('requestby_id');

        // Count requests per requester (by requestby_id)
        $this->requesterPerformance = Verify::select('requestby_id')
            ->selectRaw('count(*) as total_requests')
            ->groupBy('requestby_id')
            ->with('requestby')
            ->orderByDesc('total_requests')
            ->get();

        // Get canceled requests for selected requester in interval
        $canceledQuery = Verify::with('requestby')
            ->where('status', 'canceled')
            ->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        if ($this->selectedRequesterId) {
            $canceledQuery->where('requestby_id', $this->selectedRequesterId);
        }
        $this->canceledRequests = $canceledQuery->get();
    }

    public function render()
    {
        return view('livewire.product-setting.verify-report', [
            'verifiedCount' => $this->verifiedCount,
            'notVerifiedCount' => $this->notVerifiedCount,
            'requests' => $this->requests,
            'requesterPerformance' => $this->requesterPerformance,
            'canceledRequests' => $this->canceledRequests,
            'groupedRequests' => $this->groupedRequests,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'selectedRequesterId' => $this->selectedRequesterId,
        ]);
    }
}
