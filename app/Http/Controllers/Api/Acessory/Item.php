<?php

namespace App\Http\Controllers\Api\Acessory;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Item extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return Accessory::query()
            ->select('id', DB::raw("concat (code,' / ',name) as group"))
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
                fn(Builder $query) => $query->limit(10),
            )
            ->get();
    }
}
