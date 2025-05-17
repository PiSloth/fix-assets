<?php

namespace App\Http\Controllers\Api\Accessory;

use App\Http\Controllers\Controller;
use App\Models\Assembly;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssemblyController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return Assembly::query()
            ->select('id', DB::raw('concat(name,"/",code) AS name'))
            ->orderBy('code')
            ->when(
                $request->search,
                fn(Builder $query) => $query->where(function ($query) use ($request) {
                    $query->where('code', 'like', "{$request->search}%")
                        ->orWhere('name', 'like', "%{$request->search}%");
                })
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                // fn(Builder $query) => $query->limit(10),
            )
            ->get();
    }
}
