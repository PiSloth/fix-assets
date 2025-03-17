<?php

namespace App\Http\Controllers\Api\Acessory;

use App\Http\Controllers\Controller;
use App\Models\AccessoriesGroup;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class Group extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return AccessoriesGroup::query()
            ->select('id', 'name')
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
