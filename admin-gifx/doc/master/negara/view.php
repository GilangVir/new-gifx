    
    <!-- tables -->

            <div class="card">
                <h5 class="card-header" style="padding: 10px;">List Negara</h5>
                 <div class="card-body">
                    <table class="table" id="countriesTable">
                        <thead>
                            <tr>
                            <th scope="col">COUNTRY NAME</th>
                            <th scope="col">CURRENCY</th>
                            <th scope="col">CODE</th>
                            <th scope="col">PHONE CODE</th>
                            <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

         
    <!-- tables -->

    
<script type="text/javascript">
    let table;
    $(document).ready(function() {
        table = $('#countriesTable').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/master/negara/view",
                contentType: "application/json",
                type: "GET",
            },
            columns: [
                { data: 'COUNTRY_NAME' },
                { data: 'COUNTRY_CURR' },
                { data: 'COUNTRY_CODE' },
                { data: 'COUNTRY_PHONE_CODE' },
                { data: 'action', orderable: false, searchable: false } // Kolom action
            ],
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ]
        });
    });
</script>
</body>
</html>


 <!-- <script type="text/javascript">
    let table;
    $(document).ready(function() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            ajax: {
                url: "/ajax/datatable/admin/master/negara/view.php",
                type: "GET"
            },
            columns: [
                { data: 'COUNTRY_NAME' },
                { data: 'COUNTRY_CURR' },
                { data: 'COUNTRY_CODE' },
                { data: 'COUNTRY_PHONE_CODE' },
                { data: 'action', orderable: false, searchable: false } // Kolom action
            ],
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ]
        });
    });
    </script> -->