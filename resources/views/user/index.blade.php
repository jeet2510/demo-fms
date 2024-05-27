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
            <a type="button" class="btn btn-primary" @click="toggle"
                style="width: 100px; float:right; margin-bottom: 8px;">Add</a>

            <!-- modal -->
            <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="overflow-y: auto;">
                <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                    <div x-show="open" x-transition x-transition.duration.300
                        class="panel border-0 p-0 rounded-lg overflow-hidden w-full my-8" style="max-width: 80%;">
                        <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                            <h5 class="font-bold text-lg">Add User</h5>
                            <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                                <svg style="max-height: 40px;"> ... </svg>
                            </button>
                        </div>
                        <div class="p-5">
                            @include('user.create')
                        </div>
                    </div>
                </div>
            </div>
            <table id="company-table" class="table">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> User Name </th>
                        <th> Email </th>
                        <th> Action </th>

                        {{-- <th> Action </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td> <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary"
                                    style="max-width: 40px">Edit</a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

</x-layout.default>
