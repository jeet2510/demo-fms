<x-layout.default>

    <link rel="stylesheet"
        href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#company-table').DataTable();
        });
    </script>

    <script>
        window.modal = {
            selectedBookingId: null,
        };
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

        #upload_document {
            display: none;
        }

        /* Style your modal here */
    </style>

    <div class="float-right">
        <button type="button" class="btn btn-primary" style="width: 125px; float:right; margin-bottom: 8px;">
            <a href="/bookings/create" id="bookingCreateLink">Create Booking</a>
        </button>
    </div>

    <div id="id_card_model" class="hidden fixed inset-0 overflow-hidden flex items-center justify-center z-50">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-3xl sm:w-full sm:w-full overflow-y-auto border border-gray-700"
            style="max-height: 90vh;">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Tracking Information</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Booking Id</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tracking Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tracking Title</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tracking Remark</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tracking Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
                                    @foreach ($trackings as $tracking)
                                        <tr class="tracking-row booking-id-{{ $tracking->booking_id }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $tracking->booking_id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $tracking->tracking_status }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $tracking->tracking_title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $tracking->tracking_remark }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $tracking->tracking_date }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900 dark:text-white">Add Tracking Info</h3>
                        <form action="{{ route('bookings.storeTracking') }}" method="post" class="mt-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="booking_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking
                                        ID</label>
                                    <input type="text" name="booking_id" id="booking_id"
                                        class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                        readonly>
                                </div>
                                <div>
                                    <label for="tracking_status"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                        Status</label>
                                    <input type="text" name="tracking_status" id="tracking_status"
                                        class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="margin-top: 1rem;">
                                <div>
                                    <label for="tracking_title"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                        Title</label>
                                    <input type="text" name="tracking_title" id="tracking_title"
                                        class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                </div>
                                <div>
                                    <label for="tracking_date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                        Date</label>
                                    <input type="date" name="tracking_date" id="tracking_date"
                                        class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4" style="margin-top: 1rem;">
                                <div>
                                    <label for="tracking_remark"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                        Remark</label>
                                    <textarea name="tracking_remark" id="tracking_remark" rows="3"
                                        class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"></textarea>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="button" id="id_card_cancel"
                                        class="mr-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</button>
                                    <button type="submit"
                                        class="mr-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container_table">
        <table id="company-table" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Transporter</th>
                    <th>Booking Id</th>
                    <th>Date</th>
                    <th>Route Name</th>
                    <th>No of Drivers</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Balance Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Tracking</th>
                    <th>Booking Upload</th>
                    <th>Invoice Create</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $index => $booking)
                    <tr>
                        <td class="p-2">{{ $index + 1 }}</td>
                        <td>{{ optional($booking->customer)->company_name }}</td>
                        <td class="p-2">{{ optional($booking->transporter)->transporter_name }}</td>
                        <td class="p-2">{{ $booking->booking_id }}</td>
                        <td class="p-2">{{ $booking->date }}</td>
                        <td class="p-2">{{ optional($booking->route)->route }}</td>
                        <td class="p-2">{!! $booking->getDriverCount() !!}</td>
                        <td class="p-2">
                            @if ($booking->invoice)
                                {{ $booking->invoice->total_booking_amount }}
                            @else
                                {{ $booking->total_booking_amount }}
                            @endif
                        </td>

                        <td class="p-2">
                            @php
                                $totalAmount = 0;
                                $latestTransaction = $booking->transactions->last();
                            @endphp
                            @if ($latestTransaction)
                                @php

                                    $amounts = explode(',', $latestTransaction->paid_amount);

                                    $amounts = array_map(function ($amount) {
                                        if (strpos($amount, '.') !== false) {
                                            return (float) $amount;
                                        } else {
                                            return (float) $amount;
                                        }
                                    }, $amounts);

                                    $totalAmount = array_sum($amounts);
                                @endphp
                                {{ $totalAmount }}
                            @else
                                0
                            @endif
                        </td>

                        <td class="p-2">
                            @if ($booking->invoice)
                                {{ $booking->invoice->total_booking_amount - ($totalAmount ?? 0) }}
                            @else
                                {{ $booking->total_booking_amount - ($totalAmount ?? 0) }}
                            @endif
                        </td>
                        <th class="p-2">
                            @foreach ($trackings->where('booking_id', $booking->booking_id)->sortByDesc('created_at') as $tracking)
                                {{ $tracking->tracking_status }}
                            @break
                        @endforeach
                    </th>
                    <td class="p-2">
                        @if (!$booking->invoice)
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary"
                                style="width: 50px; display: inline-block;">Edit</a>
                        @else
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary"
                                style="width: 50px; display: inline-block;" onclick="return false;"
                                disabled>Edit</a>
                        @endif



                        @if (!$booking->invoice)
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="post"
                                class="inline" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    style="width: 50px;">Delete</button>
                            </form>
                        @else
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="post"
                                class="inline" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 50px;"
                                    disabled>Delete</button>
                            </form>
                        @endif
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-primary"
                            style="width: 50px; display: inline-block;">Show booking</a>
                    </td>
                    <td class="p-2">
                        <button class="idcard_upload-button btn btn-primary" style="width: 70px; display:"
                            data-booking-id="{{ $booking->booking_id }}">Tracking</button>
                    </td>
                    <td class="p-2">
                        <div class="container mt-5">
                            <div x-data="modal">
                                @if ($booking->booking_document)
                                    @php
                                        $extension = pathinfo($booking->booking_document, PATHINFO_EXTENSION);
                                        $downloadFileName = 'document.' . $extension;
                                    @endphp

                                    <a href="{{ asset('/public/' . $booking->booking_document) }}"
                                        class="btn btn-info" download="{{ $downloadFileName }}">
                                        Download
                                    </a>
                                @else
                                    <button type="button" class="btn btn-primary" @click="toggle"
                                        style="width: 100px; float:right; margin-bottom: 8px;">Upload</button>
                                    <div class="fixed inset-0 bg-[black]/60 z-[999]  hidden"
                                        :class="open && '!block'">
                                        <div class="flex items-start justify-center min-h-screen px-4"
                                            @click.self="open = false">
                                            <div x-show="open" x-transition x-transition.duration.300
                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                <div
                                                    class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                    <button data-booking-id="{{ $booking->booking_id }}"
                                                        type="button" class="text-white-dark hover:text-dark"
                                                        @click="toggle">
                                                        <svg style="max-height: 40px;"> ... </svg>
                                                    </button>
                                                </div>
                                                <div class="p-5">
                                                    @include('bookings.bookingDocument', [
                                                        'booking' => $booking,
                                                    ])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
            @endif

            </td>
            <td class="p-2">
                @if ($booking->invoice)
                    <a href="{{ route('invoices.show', $booking->booking_id) }}" class="btn btn-warning"
                        style="width: 130px; display: inline-block;">Show Invoice</a>
                @else
                    <a href="{{ route('invoices.edit', $booking->id) }}" class="btn btn-secondary"
                        style="width: 130px; display: inline-block;">Generate Invoice</a>
                @endif
            </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.idcard_upload-button', function() {
            var bookingId = $(this).data('booking-id');
            $('#booking_id').val(bookingId);
            $('#id_card_model').removeClass('hidden');

            $('.tracking-row').hide();
            $('.booking-id-' + bookingId).show();

            if ($('.booking-id-' + bookingId + ':visible').length === 0) {
                $('.no-data-found').remove();
                var noDataRow =
                    '<tr class="no-data-found"><td colspan="5" class="px-6 py-4 whitespace-nowrap">No data found</td></tr>';
                $('tbody').append(noDataRow);
            } else {
                $('.no-data-found').remove();
            }
        });

        $('#id_card_cancel').click(function() {
            $('#id_card_model').addClass('hidden');
        });

        $('#uploadForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $('#id_card_model').addClass('hidden');
        });
    });
</script>

<script>
    $(document).on('click', '.password_upload-button', function() {
        $('#uploadModal').removeClass('hidden');
    });

    $('#cancelButton').click(function() {
        $('#uploadModal').addClass('hidden');
    });

    $('#uploadButton').click(function() {
        $('#uploadModal').addClass('hidden');
    });
</script>

</x-layout.default>
