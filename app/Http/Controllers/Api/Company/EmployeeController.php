<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return Employee::query()
            ->select('id', DB::raw('concat(name,"/ ED-",stt_id) AS name'))
            ->orderBy('stt_id')
            ->when(
                $request->search,
                fn (Builder $query) => $query->where(function ($query) use ($request) {
                    $query->where('stt_id', 'like', "{$request->search}%")
                        ->orWhere('name', 'like', "%{$request->search}%");
                })
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                // fn(Builder $query) => $query->limit(10),
            )
            ->get();
    }
}
