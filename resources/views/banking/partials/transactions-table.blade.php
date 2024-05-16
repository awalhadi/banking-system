<div class="w-full p-4">
    <table class="w-full bg-white">
        <thead class="bg-gray-100 items-center">
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Amount</th>
                <th class="py-2 px-4 border-b">Type</th>
                <th class="py-2 px-4 border-b">Fee</th>
                <th class="py-2 px-4 border-b">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr class="hover:bg-gray-100 items-center justify-center">
                <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->amount }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->type }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->fee }}</td>
                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
