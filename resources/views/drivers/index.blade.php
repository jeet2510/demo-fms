<x-layout.default>
    <div class="p-6 animate__animated">
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



        <div class="container mt-5">
            <!-- DataTables Container -->
            <!-- Modal -->
            <div x-data="modal">
                <button type="button" class="btn btn-primary" @click="toggle"
                    style="width: 100px; float:right; margin-bottom: 8px;">Add</button>
                <div class="fixed inset-0 bg-[black]/60 z-[999]  hidden" :class="open && '!block'">
                    <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                        <div x-show="open" x-transition x-transition.duration.300
                            class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                <h5 class="font-bold text-lg">Add Driver</h5>
                                <button type="button" class="text-white-dark hover:text-dark" @click="toggle"><svg
                                        style="max-height: 40px;"> ... </svg></button>
                            </div>
                            <div class="p-5">
                                @include('drivers.create')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container_table">
            <table id="company-table" class="table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Driver Name</th>
                        <th>Truck Type</th>
                        <th>Phone</th>
                        <th>Whatsapp No.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $index => $driver)
                        <tr>
                            <td class="p-2">{{ $index + 1 }}</td>
                            <td class="p-2">{{ $driver->driver_name }}</td>
                            <td class="p-2">{{ optional($driver->truck_type)->truck_type }}</td>
                            <td class="p-2">{{ $driver->phone_number }}</td>
                            <td class="p-2">{{ $driver->whatsapp_number }}</td>
                            <td class="p-2">
                                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-primary"
                                    style="width: 50px; display: inline-block;">Edit</a>
                                {{-- <form action="{{ route('drivers.destroy', $driver->id) }}"method="post"
                                class="inline" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 50px;">Delete</button>
                            </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layout.default>
