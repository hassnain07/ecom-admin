<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>DataTables practice</title>
        <!-- Load Bootstrap CSS -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        />
        <!-- Load DataTables CSS -->
        <link rel="stylesheet" href="{{ asset('datatables.min.css') }}" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>Laravel DataTables</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="datatable" class="display table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-sortable="true">Name</th>
                                <th data-sortable="false">Email</th>
                                <th data-sortable="false">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Load jQuery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <!-- Load Popper.js and Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
        <!-- Load DataTables JS -->
        <script src="{{ asset('datatables.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                $("#datatable").DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, "desc"]],
                    ajax: "{{ url('users-data') }}",
                    columns: [
                        { data: "id" },
                        { data: "name" },
                        { data: "email" },
                        { data: "created_at" }
                    ],
                });
            });
        </script>
    </body>
</html>
