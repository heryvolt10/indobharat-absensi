@push('scripts')
    <script>
        function show_tbview($tableid, $fromInputPost, $tipe_action, $remove_action, $withButtonAdd, $withButtonStatus,
            $defaultStatusFilter, $Export_Title, $freezeLeft, $freezeRight) {
            var columns_id = [];
            var data_id = [];
            var format_decimal = [];
            var format_integer = [];
            var format_right = [];
            var format_link = [];
            var input_chk = [];
            var colhide = [];
            var data_status = [];

            $iAdd = {{ $accessSubMenu->iadd }};
            $iEdit = {{ $accessSubMenu->iedit }};
            $iDelete = {{ $accessSubMenu->idelete }};

            $.ajax({
                url: "{{ route('show_tbview') }}",
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $fromInputPost[0],
                beforeSend: function() {

                },
                success: function(result) {

                    $.each(result.columns, function(i, val) {
                        if (val.className.includes('dtDecimal')) {
                            format_decimal.push(i);
                        }
                        if (val.className.includes('dtInteger')) {
                            format_integer.push(i);
                        }
                        if (val.className.includes('dtRight')) {
                            format_right.push(i);
                        }
                        if (val.className.includes('dtLink')) {
                            format_link.push(i);
                        }
                        if (val.className.includes('input_chk')) {
                            input_chk.push(i);
                        }
                        if (val.className.includes('tbcol-hide')) {
                            colhide.push(i);
                        }
                        columns_id.push({
                            data: val.data,
                            title: val.title,
                            className: val.className,
                            width: val.width,
                        });
                    });

                    $.each(result.list_status, function(i, val) {
                        data_status.push({
                            text: val.nama,
                            className: 'fl_status fl_status_' + val.id,
                            action: function(e, dt, node, config) {
                                $('#' + $tableid).DataTable().column(".status").search(val
                                    .nama).draw();
                            },
                            attr: {
                                "onclick": "stylefilterstatus(" + val.id + ")",
                                "data-flstatus": val.nama,
                                "data-idstatus": val.id,
                            },
                        });
                    });

                    $('#' + $tableid).dataTable({
                        dom: "<'row mb-3'<'col-md-5'B><'col-md-7'f>>" +
                            "<'row'<'col-md-12'tr>>" +
                            "<'row mt-2'<'col-md-5'li><'col-md-7'p>>",
                        lengthMenu: [
                            [10, 20, 50, 100],
                            [10, 20, 50, 100]
                        ],
                        destroy: true,
                        processing: true,
                        language: {
                            searchPlaceholder: "Cari Data",
                            sSearch: "",
                            loadingRecords: 'Please wait - loading...',
                        },
                        data: result.data,
                        columns: columns_id,
                        columnDefs: [{
                                targets: -1,
                                searchable: false,
                                orderable: false,
                                visible: $remove_action == 1 ? false : true,
                                render: function(data, type, row) {
                                    $iStatusTemp = row.f_status;
                                    if ($iEdit == '1' && $iStatusTemp <= 2) {
                                        $btnEdit =
                                            `<button type="button" class="btn btn-info rounded-1 btn_editdet_` +
                                            $tableid + `" data-id="` + row['id'] +
                                            `" data-tableid="` + $tableid +
                                            `" wire:click="store(` + row['id'] +
                                            `)"><i class="ti ti-edit fs-2"></i></button>`;
                                    } else {
                                        $btnEdit = "";
                                    }

                                    if ($iDelete == '1' && $iStatusTemp == '2') {
                                        $btnDelete =
                                            `<button type="button" class="btn btn-danger rounded-1 btn_tbview_delete" data-id="` +
                                            row['id'] + `" data-tableid="` + $tableid +
                                            `" data-url="delete_` + $tableid +
                                            `"><i class="ti ti-trash fs-2"></i></button>`;
                                    } else {
                                        $btnDelete = "";
                                    }

                                    if ($tipe_action == "1") {
                                        $buttonTable =
                                            `<div class="btn-group btn-group-sm d-flex justify-content-center btn_index gap-1" id="baction">` +
                                            $btnEdit + $btnDelete + `</div>`;
                                    }

                                    if ($tipe_action == "2") {
                                        $buttonTable =
                                            `<div class="btn-group btn-group-sm d-flex justify-content-center btn_index gap-1" id="baction">` +
                                            $btnEdit + `</div>`;
                                    }

                                    if ($tipe_action == "3") {
                                        $buttonTable =
                                            `<div class="btn-group btn-group-sm d-flex justify-content-center btn_index gap-1" id="baction"></div>`;
                                    }
                                    return $buttonTable;
                                }
                            },
                            {
                                targets: 0,
                                searchable: false,
                                orderable: true,
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }

                            },
                            {
                                targets: format_decimal,
                                className: "text-end",
                                render: function(data, type, row, meta) {
                                    return formatdecimal(data);
                                }
                            },
                            {
                                targets: format_integer,
                                className: "text-end",
                                render: function(data, type, row, meta) {
                                    return formatinteger(data);
                                }
                            },
                            {
                                targets: format_right,
                                className: "text-end",
                                render: function(data, type, row, meta) {
                                    return (data);
                                }
                            },
                            {
                                targets: input_chk,
                                className: "text-center",
                                render: function(data, type, row, meta) {
                                    $setClass = meta.settings.aoColumns[meta.col].mData;

                                    if (row[$setClass] == "1") {
                                        return `<input class="form-check-input ` + "chk_" +
                                            $setClass + `" type="checkbox" checked>`;
                                    } else {
                                        return `<input class="form-check-input ` + "chk_" +
                                            $setClass + `" type="checkbox">`;
                                    }


                                }
                            },
                            {
                                targets: colhide,
                                searchable: false,
                                orderable: false,
                                visible: false,
                            },
                        ],
                        buttons: [{
                                text: '<i class="ti ti-plus"></i>',
                                className: 'btn rounded-1 fs-3  btn_index_add',
                                titleAttr: 'Add Data',
                                attr: {
                                    "wire:click": "store()",
                                },
                            },
                            {
                                extend: 'collection',
                                text: '<i class="ti ti-filter"></i>',
                                className: 'btn rounded-1 fs-3  btn_index_status',
                                titleAttr: 'StatusFilter',
                                buttons: [
                                    data_status,
                                    {
                                        text: 'Semua',
                                        className: 'fl_status fl_status_0',
                                        action: function(e, dt, node, config) {
                                            $('#' + $tableid).DataTable().column(".status")
                                                .search('').draw();
                                        },
                                        attr: {
                                            "onclick": "stylefilterstatus(0)",
                                            "data-status": "Semua",
                                        },
                                    },
                                ],
                                fade: true
                            },
                            {
                                extend: 'collection',
                                text: '<i class="ti ti-download"></i>',
                                className: 'btn rounded-1 fs-3 ',
                                titleAttr: 'Export Data',
                                buttons: [{
                                        extend: 'copyHtml5',
                                        text: 'Copy',
                                        titleAttr: 'Copy',
                                        title: $Export_Title,
                                        exportOptions: {
                                            modifier: {
                                                search: 'applied',
                                                order: 'applied'
                                            },
                                            columns: ['.print'],
                                            format: {
                                                body: function(data, row, column, node) {
                                                    $NumNew = 0;
                                                    $('#' + $tableid).find(
                                                            'thead tr:first-child th.print')
                                                        .each(function() {
                                                            $NumNew = $NumNew + 1;
                                                            if ($(this).hasClass(
                                                                    "dtIntext")) {
                                                                if (column == ($NumNew -
                                                                        1)) {
                                                                    data = '\0' + data;
                                                                    return data;
                                                                }
                                                            }
                                                        })
                                                    return data;
                                                }
                                            },
                                        },
                                    },
                                    {
                                        extend: 'excelHtml5',
                                        text: 'Excel',
                                        titleAttr: 'Excel',
                                        autoFilter: true,
                                        title: $Export_Title,
                                        exportOptions: {
                                            modifier: {
                                                search: 'applied',
                                                order: 'applied'
                                            },
                                            columns: ['.print'],
                                            format: {
                                                body: function(data, row, column, node) {
                                                    $NumNew = 0;
                                                    $('#' + $tableid).find(
                                                            'thead tr:first-child th.print')
                                                        .each(function() {
                                                            $NumNew = $NumNew + 1;
                                                            if ($(this).hasClass(
                                                                    "dtIntext")) {
                                                                if (column == ($NumNew -
                                                                        1)) {
                                                                    data = '\0' + data;
                                                                    return data;
                                                                }
                                                            }
                                                        })
                                                    return data;
                                                }
                                            },
                                        },


                                    },
                                    {
                                        extend: 'csvHtml5',
                                        text: 'CSV',
                                        titleAttr: 'CSV',
                                        title: $Export_Title,
                                        exportOptions: {
                                            modifier: {
                                                search: 'applied',
                                                order: 'applied'
                                            },
                                            columns: ['.print'],
                                            format: {
                                                body: function(data, row, column, node) {
                                                    $NumNew = 0;
                                                    $('#' + $tableid).find(
                                                            'thead tr:first-child th.print')
                                                        .each(function() {
                                                            $NumNew = $NumNew + 1;
                                                            if ($(this).hasClass(
                                                                    "dtIntext")) {
                                                                if (column == ($NumNew -
                                                                        1)) {
                                                                    data = '\0' + data;
                                                                    return data;
                                                                }
                                                            }
                                                        })
                                                    return data;
                                                }
                                            },
                                        },
                                    },
                                ],
                                fade: false
                            },
                        ],
                        fixedColumns: {
                            start: $freezeLeft,
                            end: $freezeRight,
                        },
                        scrollCollapse: true,
                        scrollX: true,
                        initComplete: function(settings, json) {

                            if (($withButtonAdd == "0") || ($iAdd == "0")) {
                                $('#' + $tableid + "_wrapper .btn_index_add").remove();
                            }

                            if (($withButtonStatus == "0")) {
                                $('#' + $tableid + "_wrapper .btn_index_status").remove();
                            } else {
                                if ($defaultStatusFilter != "") {
                                    $('#' + $tableid).DataTable().column(".status").search(
                                        $defaultStatusFilter).draw();

                                }
                            }

                        },
                    });
                },
            })
        }

        function reload_tbview($tableid) {
            let functionName = "table_view_" + $tableid;
            eval(functionName + '()');
        }

        function stylefilterstatus($statusid) {
            $(".fl_status *").removeClass('fw-bolder selected');
            $(".fl_status").parent().find('*').removeClass('selected');
            $(".fl_status_" + $statusid).addClass('selected');
            $(".fl_status_" + $statusid + " .dropdown-item").addClass('fw-bolder selected');
        }
    </script>
@endpush

@script
    <script>
        $(document).on("click", ".btn_tbview_delete", function(e) {
            $iddet = $(this).data("id");
            $tableid = $(this).data('tableid');
            Swal.fire({
                title: 'Yakin Menghapus Data?',
                text: "data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA'
            }).then((result) => {
                if (result.value) {
                    $wire.delete($iddet);

                    $(window).on('sweet-alert', function(e) {
                        const flashtype = e.detail.icon;
                        if (flashtype == 'success') {
                            setTimeout(function() {
                                reload_tbview($tableid);
                            }, 1500);
                        }
                    });
                }
            })
        });


        $(document).on("click", "#btn_save", function(e) {
            $(window).on('sweet-alert', function(e) {
                const flashtype = e.detail.icon;
                if (flashtype == 'success') {
                    setTimeout(function() {
                        reload_tbview($tableid);
                    }, 1500);
                }
            });
        });
    </script>
@endscript
