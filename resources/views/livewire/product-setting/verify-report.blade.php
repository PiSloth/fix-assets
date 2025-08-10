<div class="p-4">
    <h2 class="mb-2 text-xl font-bold">Assembly Verification Report</h2>
    <div class="mb-4">
        <span class="font-semibold">Verified Assemblies:</span> {{ $verifiedCount }}<br>
        <span class="font-semibold">Not Verified Assemblies:</span> {{ $notVerifiedCount }}
    </div>

    <div class="flex items-end gap-4 mb-4">
        <div>
            <label class="block text-sm font-semibold">Start Date</label>
            <input type="date" wire:model="startDate" class="px-2 py-1 border rounded" />
        </div>
        <div>
            <label class="block text-sm font-semibold">End Date</label>
            <input type="date" wire:model="endDate" class="px-2 py-1 border rounded" />
        </div>
        <div>
            <label class="block text-sm font-semibold">Requester</label>
            <select wire:model="selectedRequesterId" class="px-2 py-1 border rounded">
                <option value="">All</option>
                @foreach ($requesterPerformance as $perf)
                    <option value="{{ $perf->requestby_id }}">{{ $perf->requestby->name ?? $perf->requestby_id }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="p-4 mb-4 bg-white rounded-lg shadow">
        <h3 class="mb-2 font-semibold">Requests in Interval</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-separate border-gray-300 rounded-lg border-spacing-0">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-center border-b border-gray-300">ID</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Requester</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Status</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Requested At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->id }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">
                                {{ $req->requestby->name ?? '-' }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->status }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-2 text-center text-gray-500">No requests in this interval.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-4 mb-4 bg-white rounded-lg shadow">
        <h3 class="mb-2 font-semibold">Canceled Requests for This Requester (in Interval)</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-separate border-gray-300 rounded-lg border-spacing-0">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-center border-b border-gray-300">ID</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Requester</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Remark</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Canceled At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($canceledRequests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->id }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">
                                {{ $req->requestby->name ?? '-' }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->remark }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-2 text-center text-gray-500">No canceled requests in this
                                interval/requester.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="mb-2 font-semibold">Requester Performance (Total Requests)</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-separate border-gray-300 rounded-lg border-spacing-0">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Requester</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">User ID</th>
                        <th class="px-3 py-2 text-center border-b border-gray-300">Total Requests</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requesterPerformance as $perf)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center border-b border-gray-200">
                                {{ $perf->requestby->name ?? '-' }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $perf->requestby_id }}</td>
                            <td class="px-3 py-2 text-center border-b border-gray-200">{{ $perf->total_requests }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-2 text-center text-gray-500">No data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="mb-2 font-semibold">Requests Grouped by Requester (in Interval)</h3>
        @forelse($groupedRequests as $requesterId => $requests)
            <div class="p-4 mb-6 bg-white rounded-lg shadow">
                <div class="mb-2 font-semibold">
                    Requester: {{ $requests->first()->requestby->name ?? $requesterId }} (User ID:
                    {{ $requesterId }})
                </div>
                <div class="overflow-x-auto">
                    <table
                        class="min-w-full mb-2 text-sm border border-separate border-gray-300 rounded-lg border-spacing-0">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-center border-b border-gray-300">Request ID</th>
                                <th class="px-3 py-2 text-center border-b border-gray-300">Status</th>
                                <th class="px-3 py-2 text-center border-b border-gray-300">Remark</th>
                                <th class="px-3 py-2 text-center border-b border-gray-300">Requested At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $req)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->id }}</td>
                                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->status }}</td>
                                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->remark }}</td>
                                    <td class="px-3 py-2 text-center border-b border-gray-200">{{ $req->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500">No grouped requests in this interval.</div>
        @endforelse
    </div>
</div>
