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

    <div x-data="finance">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Home</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6 text-white">
                <!-- Users Visit -->
                <div class="panel bg-gradient-to-r from-cyan-500 to-cyan-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Total Bookings Of Today</div>

                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3">{{ $total_bookings_today }} </div>

                    </div>
                    <div class="flex items-center font-semibold mt-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path opacity="0.5"
                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                            <path
                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                        </svg>

                    </div>
                </div>
                <div class="panel bg-gradient-to-r from-violet-500 to-violet-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Total Bookings Of This Month</div>

                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3">{{ $total_bookings_this_month }} </div>
                    </div>
                    <div class="flex items-center font-semibold mt-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path opacity="0.5"
                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                            <path
                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                        </svg>

                    </div>
                </div>
                <div class="panel bg-gradient-to-r from-fuchsia-500 to-fuchsia-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Total Invoice Done In This Month</div>

                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3">{{ $total_invoices_this_month }} </div>
                    </div>
                    <div class="flex items-center font-semibold mt-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path opacity="0.5"
                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                            <path
                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel h-full w-full">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Current Booking</h5>
            <div class="float-right">
                <button type="button" class="btn btn-primary" style="width: 125px; float:right; margin-bottom: 8px;">
                    <a href="/bookings/create" id="bookingCreateLink">Create Booking</a>
                </button>
            </div>
        </div>

        <div class="table-responsive">
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
                        <th>Balance </th>
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
                            <div class="flex">
                                @if (!$booking->invoice)
                                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary"
                                        style="width: 50px; display: inline-block; margin-right: 10px;"><svg
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4001 18.1612L11.4001 18.1612L18.796 10.7653C17.7894 10.3464 16.5972 9.6582 15.4697 8.53068C14.342 7.40298 13.6537 6.21058 13.2348 5.2039L5.83882 12.5999L5.83879 12.5999C5.26166 13.1771 4.97307 13.4657 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L7.47918 20.5844C8.25351 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5343 19.0269 10.823 18.7383 11.4001 18.1612Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178L14.3999 4.03882C14.4121 4.0755 14.4246 4.11268 14.4377 4.15035C14.7628 5.0875 15.3763 6.31601 16.5303 7.47002C17.6843 8.62403 18.9128 9.23749 19.85 9.56262C19.8875 9.57563 19.9245 9.58817 19.961 9.60026L20.8482 8.71306Z"
                                                fill="currentColor"></path>
                                        </svg></a>
                                @else
                                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary"
                                        style="width: 50px; display: inline-block; margin-right: 10px;"
                                        onclick="return false;" disabled><svg width="24" height="24"
                                            viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4001 18.1612L11.4001 18.1612L18.796 10.7653C17.7894 10.3464 16.5972 9.6582 15.4697 8.53068C14.342 7.40298 13.6537 6.21058 13.2348 5.2039L5.83882 12.5999L5.83879 12.5999C5.26166 13.1771 4.97307 13.4657 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L7.47918 20.5844C8.25351 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5343 19.0269 10.823 18.7383 11.4001 18.1612Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178L14.3999 4.03882C14.4121 4.0755 14.4246 4.11268 14.4377 4.15035C14.7628 5.0875 15.3763 6.31601 16.5303 7.47002C17.6843 8.62403 18.9128 9.23749 19.85 9.56262C19.8875 9.57563 19.9245 9.58817 19.961 9.60026L20.8482 8.71306Z"
                                                fill="currentColor"></path>
                                        </svg></a>
                                @endif

                                @if (!$booking->invoice)
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="post"
                                        class="inline" style="display: inline-block; margin-right: 10px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="width: 50px;">
                                            <div
                                                class="grid place-content-center w-14 h-6 border border-white-dark/20 dark:border-[#191e3a] rounded-md">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5"
                                                        d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M3 6.38597C3 5.90152 3.34538 5.50879 3.77143 5.50879L6.43567 5.50832C6.96502 5.49306 7.43202 5.11033 7.61214 4.54412C7.61688 4.52923 7.62232 4.51087 7.64185 4.44424L7.75665 4.05256C7.8269 3.81241 7.8881 3.60318 7.97375 3.41617C8.31209 2.67736 8.93808 2.16432 9.66147 2.03297C9.84457 1.99972 10.0385 1.99986 10.2611 2.00002H13.7391C13.9617 1.99986 14.1556 1.99972 14.3387 2.03297C15.0621 2.16432 15.6881 2.67736 16.0264 3.41617C16.1121 3.60318 16.1733 3.81241 16.2435 4.05256L16.3583 4.44424C16.3778 4.51087 16.3833 4.52923 16.388 4.54412C16.5682 5.11033 17.1278 5.49353 17.6571 5.50879H20.2286C20.6546 5.50879 21 5.90152 21 6.38597C21 6.87043 20.6546 7.26316 20.2286 7.26316H3.77143C3.34538 7.26316 3 6.87043 3 6.38597Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </div>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="post"
                                        class="inline" style="display: inline-block; margin-right: 10px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="width: 50px;"
                                            disabled>
                                            <div
                                                class="grid place-content-center w-14 h-6 border border-white-dark/20 dark:border-[#191e3a] rounded-md">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5"
                                                        d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M3 6.38597C3 5.90152 3.34538 5.50879 3.77143 5.50879L6.43567 5.50832C6.96502 5.49306 7.43202 5.11033 7.61214 4.54412C7.61688 4.52923 7.62232 4.51087 7.64185 4.44424L7.75665 4.05256C7.8269 3.81241 7.8881 3.60318 7.97375 3.41617C8.31209 2.67736 8.93808 2.16432 9.66147 2.03297C9.84457 1.99972 10.0385 1.99986 10.2611 2.00002H13.7391C13.9617 1.99986 14.1556 1.99972 14.3387 2.03297C15.0621 2.16432 15.6881 2.67736 16.0264 3.41617C16.1121 3.60318 16.1733 3.81241 16.2435 4.05256L16.3583 4.44424C16.3778 4.51087 16.3833 4.52923 16.388 4.54412C16.5682 5.11033 17.1278 5.49353 17.6571 5.50879H20.2286C20.6546 5.50879 21 5.90152 21 6.38597C21 6.87043 20.6546 7.26316 20.2286 7.26316H3.77143C3.34538 7.26316 3 6.87043 3 6.38597Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </div>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-primary"
                                    style="width: 50px; display: inline-block; margin-right: 10px;"><svg
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 16C21 18.8284 21 20.2426 20.1213 21.1213C19.2426 22 17.8284 22 15 22H9C6.17157 22 4.75736 22 3.87868 21.1213C3 20.2426 3 18.8284 3 16V8C3 5.17157 3 3.75736 3.87868 2.87868C4.75736 2 6.17157 2 9 2H15C17.8284 2 19.2426 2 20.1213 2.87868C21 3.75736 21 5.17157 21 8V12"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                        </path>
                                        <path d="M8 2V6M8 22V10" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M2 12H4" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M2 16H4" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M2 8H4" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M11.5 6.5H16.5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                        <path d="M11.5 10H16.5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round"></path>
                                    </svg></a>
                            </div>
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

                                        <a href="{{ asset('public/'.$booking->booking_document) }}" class="btn btn-info"
                                            download="{{ $downloadFileName }}"
                                            style="margin-bottom:18px; width: 80px">
                                            <svg width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8 22.0002H16C18.8284 22.0002 20.2426 22.0002 21.1213 21.1215C22 20.2429 22 18.8286 22 16.0002V15.0002C22 12.1718 22 10.7576 21.1213 9.8789C20.3529 9.11051 19.175 9.01406 17 9.00195M7 9.00195C4.82497 9.01406 3.64706 9.11051 2.87868 9.87889C2 10.7576 2 12.1718 2 15.0002L2 16.0002C2 18.8286 2 20.2429 2.87868 21.1215C3.17848 21.4213 3.54062 21.6188 4 21.749"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round"></path>
                                                <path d="M12 2L12 15M12 15L9 11.5M12 15L15 11.5"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-primary" @click="toggle"
                                            style="width: 80px; margin-bottom: 18px;"><svg width="20"
                                                height="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3 15C3 17.8284 3 19.2426 3.87868 20.1213C4.75736 21 6.17157 21 9 21H15C17.8284 21 19.2426 21 20.1213 20.1213C21 19.2426 21 17.8284 21 15"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M12 16V3M12 3L16 7.375M12 3L8 7.375" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg></button>
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
                            style="width: 72px; display: inline-block; text-align:center;">View</a>
                    @else
                        <a href="{{ route('invoices.edit', $booking->id) }}" class="btn btn-secondary"
                            style="width: 71px; display: inline-block;"><svg width="20px" height="20px"
                                viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#BDC3C7"
                                    d="M97.55 85.718L45.407 33.574c-4.588-4.587 3.054-15.538-5.729-24.32L23.664 0l-3.381 3.38 8.832 8.831c3.381 3.38.849 10.983-2.545 14.377-3.367 3.367-10.977 5.906-14.357 2.525l-8.833-8.83L0 23.664l9.254 16.014c8.734 8.735 19.87 1.277 24.321 5.729l52.143 52.144A8.367 8.367 0 0 0 97.55 85.718zm-3.381 8.451a3.585 3.585 0 1 1-5.07-5.07 3.585 3.585 0 0 1 5.07 5.07z" />
                                <path fill="#95A5A6"
                                    d="M33.682 12.334L22.512 1.151 20.283 3.38l8.832 8.831c3.381 3.38.849 10.983-2.545 14.377-3.367 3.367-10.977 5.906-14.357 2.525l-8.833-8.83-1.975 1.975 11.177 11.19c1.524 1.525 3.914 2.332 6.911 2.332 4.492 0 9.453-1.824 12.063-4.437 4.417-4.42 6.311-14.822 2.126-19.009zm62.064 75.615L45.775 37.972c-1.042-1.042-2.426-1.615-3.898-1.615s-2.857.574-3.898 1.615a5.522 5.522 0 0 0 0 7.798L87.95 95.746c1.041 1.042 2.426 1.615 3.898 1.615s2.857-.573 3.898-1.615a5.52 5.52 0 0 0 0-7.797zm-1.577 6.22a3.585 3.585 0 1 1-5.07-5.07 3.585 3.585 0 0 1 5.07 5.07z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#ECF0F1"
                                    d="M80 14L93 4l7 7-10 13h-5L55 54l-5-5 30-30v-5z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#BDC3C7"
                                    d="M52.5 51.5L55 54l30-30h5l10-13-3.5-3.5z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#D35400"
                                    d="M42.51 46.095l.854.845L5.768 84.161a5.931 5.931 0 0 0 0 8.447l5.119 5.068c2.356 2.332 5.17 3.326 7.526.994l38.603-38.216.853.845c.942.933 2.471.933 3.413 0s.942-2.446 0-3.379L45.923 42.716c-.942-.933-2.471-.933-3.413 0s-.943 2.446 0 3.379z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#E66612"
                                    d="M50.25 53.75L8.594 95.406l2.293 2.271c2.356 2.332 5.17 3.326 7.526.994l38.573-38.186-6.736-6.735z" />
                            </svg></a>
                    @endif
                </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<div id="id_card_model" class="hidden fixed z-10 inset-0 overflow-y-auto flex items-center justify-center">
    <div class="fixed right-0 transition-opacity" style="padding-right: 50%;" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full"
        style="margin-top: 12rem; margin-left: 18rem;">
        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Tracking Information
                        </h2>
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
                                <tbody
                                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
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
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-gray-900 dark:text-white">Add Tracking Info</h3>
                    <form action="{{ route('bookings.storeTracking') }}" method="post" class="mt-4">
                        @csrf
                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                            <div class="sm:col-span-1">
                                <label for="booking_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking
                                    ID</label>
                                <input type="text" name="booking_id" id="booking_id"
                                    class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                    readonly>
                            </div>
                            <div class="sm:col-span-1">
                                <label for="tracking_status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                    Status</label>
                                <input type="text" name="tracking_status" id="tracking_status"
                                    class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            </div>
                            <div class="sm:col-span-1">
                                <label for="tracking_title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                    Title</label>
                                <input type="text" name="tracking_title" id="tracking_title"
                                    class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="tracking_remark"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                    Remark</label>
                                <textarea name="tracking_remark" id="tracking_remark" rows="3"
                                    class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"></textarea>
                            </div>
                            <div class="sm:col-span-1">
                                <label for="tracking_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tracking
                                    Date</label>
                                <input type="date" name="tracking_date" id="tracking_date"
                                    class="mt-1 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="button" id="id_card_cancel"
                                class="mr-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</button>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
