$.ajax({
    url: getTransactionURL,
    type: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
        outlet_id: $('#filter_outlet_id').val(),
        tra_number: $('#filter_tra_number').val()
    },
    success: function (response) {
        let columns = [
            { data: 'id', title: '#' },
            { data: 'tra_number', title: 'TRA #' },
            { data: 'transaction_date', title: 'DATE' },
            { data: 'product_name', title: 'PRODUCT NAME' }
        ];

        for (let i = 1; i <= response.uniqueTraNumbers; i++) {
            columns.push({ data: `resibo_${i}`, title: `RESIBO ${i}` });
        }

        columns.push({ data: 'total_qty', title: 'TOTAL QTY' });
        columns.push({ data: 'on_hand', title: 'ON HAND' });
        columns.push({ data: 'sold', title: 'SOLD' });
        columns.push({ data: 'unit_price', title: 'UNIT PRICE', render: $.fn.DataTable.render.number(',', '.', 2, '₱') });
        columns.push({ data: 'amount', title: 'AMOUNT', render: $.fn.DataTable.render.number(',', '.', 2, '₱') });
        columns.push({
            data: null,
            title: 'ACTION',
            defaultContent: `<td class="text-right py-0 align-middle">
            <div class="btn-group btn-group-sm">
            <a class="btn btn-info" id="btnEdit" title="Edit stock"><i class="fas fa-edit" style="color: white;"></i></a>
            <a class="btn btn-danger" id="btnDelete" title="Delete stock"><i class="fas fa-trash" style="color: white;"></i></a>
            </div>
            </td>`
        });

        $("#dataTableSubmitted").DataTable({
            processing: true,
            serverSide: true,
            data: response.data,
            columns: columns,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            order: [[0, 'desc']],
            info: true,
            autoWidth: true,
            lengthMenu: [30, 40, 50, 60, 100],
            scrollX: true,
            drawCallback: function () {
                let api = this.api();
                let total_amount = api.column(12, { page: 'current' }).data().reduce(function (a, b) {
                    return a + parseFloat(b);
                }, 0);
                $('#table_sub_total_price').val('Subtotal: ' + total_amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
        });
    }
});
