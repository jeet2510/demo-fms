<x-layout.default>

    <link rel="stylesheet"
        href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.css" />
    <link rel="stylesheet" href="Editor-2.2.2/css/editor.dataTables.css">

    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.js"></script>
    <script src="Editor-2.2.2/js/dataTables.editor.js"></script>

    <script>
        $(document).ready(function() {
            $('#company-table').DataTable();
        });
    </script>
    <!-- forms grid -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        .container_table {
            width: 100%;
            overflow-x: auto;
            white-space: nowrap;
        }

        .alert-danger {
            color: red;
        }

        .alert-success {
            color: #5CB85C;
        }
    </style>

    <div class="container_table">
        <div x-data="modal">
            <!-- button -->
            <button type="button" class="btn btn-primary" @click="toggle"
                style="width: 100px; float:right; margin-bottom: 8px;">Add</button>

            <!-- modal -->
            <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="overflow-y: auto;">
                <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                    <div x-show="open" x-transition x-transition.duration.300
                        class="panel border-0 p-0 rounded-lg overflow-hidden w-full my-8" style="max-width: 80%;">
                        <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                            <h5 class="font-bold text-lg">Add Transactions</h5>
                            <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                                <svg style="max-height: 40px;"> ... </svg>
                            </button>
                        </div>
                        <div class="p-5">
                            @include('transactions.create')
                        </div>
                    </div>
                </div>
            </div>
            <table id="company-table" class="table">
                <thead>
                    <tr>
                        <th> Transaction ID </th>
                        <th> Transaction Date </th>
                        <th> Booking ID </th>
                        <th> Amount </th>
                        <th> Payment Mode </th>
                        {{-- <th> Action </th> --}}
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through transactions and display each one --}}
                    @foreach ($transactions as $transaction)
                        <tr class="border-b">
                            <td class="p-2">{{ $transaction->transaction_id }}</td>
                            <td class="p-2">{{ $transaction->transaction_date }}</td>
                            <td class="p-2">{{ $transaction->booking->booking_id }}</td>
                            <td class="p-2">
                                @php
                                    $amountArray = explode(',', $transaction->amount);
                                    $sum = array_sum($amountArray);
                                @endphp
                                {{ $sum }}
                            </td>

                            <td class="p-2">{{ $transaction->payment_mode }}</td>
                            {{-- <td>
                            <a href="#" class="btn btn-primary">Edit</a>
                            <!-- Add delete functionality if needed -->
                        </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

</x-layout.default>
