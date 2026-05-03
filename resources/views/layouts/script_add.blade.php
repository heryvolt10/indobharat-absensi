<script>
    // UNTUK SELECT TABLE HIGHLIGHT
    $(document).ready(function() {
        $('.table tr').click(function() {
            // Remove 'table-active' class from all rows
            $(this).siblings().removeClass('table-active');

            // Add 'table-active' class to the clicked row
            $(this).addClass('table-active');
        });
    });

    $(document).ready(function() {
        $('.mask_onlynumber').inputmask({
            regex: '^[0-9][0-9]*$',
            allowMinus: false,
            placeholder: "0",
            rightAlign: true,
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1);
        });


        $(".mask_decimal").inputmask({
            alias: "decimal",
            allowMinus: false,
            digits: 2,
            groupSeparator: ",",
            autoGroup: true,
            digitsOptional: false,
            placeholder: "0",
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1);
        });

        $('.mask_number').inputmask({
            alias: 'decimal',
            allowMinus: false,
            digits: 0,
            groupSeparator: ',',
            autoGroup: true,
            digitsOptional: false,
            placeholder: "0",
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_decimal3').inputmask({
            alias: 'decimal',
            allowMinus: false,
            digits: 3,
            groupSeparator: ',',
            autoGroup: true,
            digitsOptional: false,
            placeholder: "0",
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });


        $('.mask_decimalminus').inputmask({
            alias: 'decimal',
            allowMinus: true,
            digits: 2,
            groupSeparator: ',',
            autoGroup: true,
            digitsOptional: false,
            placeholder: "0",
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_decimalmin').inputmask({
            alias: 'decimal',
            allowMinus: false,
            digits: 0,
            groupSeparator: ',',
            autoGroup: true,
            digitsOptional: false,
            placeholder: "0",
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_integer').inputmask({
            regex: '^[1-9][0-9]*$',
            allowMinus: false,
            digits: 0,
            placeholder: "0",
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_year').inputmask({
            regex: '^[2-9][0-9][0-9][0-9]',
            allowMinus: false,
            digits: 4,
            placeholder: "0",
            clearMaskOnLostFocus: !1,
            rightAlign: true,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_hour24').inputmask({
            alias: 'datetime',
            inputFormat: "HH:MM",
            placeholder: "00:00:00",
            max: 24,
            clearMaskOnLostFocus: false,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_hourminute').inputmask({
            regex: '^([0-1][0-9]|2[0-3]):([0-5][0-9]):00',
            allowMinus: false,
            placeholder: "00:00:00",
            clearMaskOnLostFocus: false,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_hms').inputmask({
            regex: '[0-9]{2}:[0-5][0-9]',
            allowMinus: false,
            placeholder: "00:00",
            clearMaskOnLostFocus: false,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_hour').inputmask({
            regex: '^([1-9][0-9]{0,2})$:[0-5][0-9]',
            allowMinus: false,
            placeholder: "0",
            clearMaskOnLostFocus: false,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $('.mask_day').inputmask({
            regex: "^([1-9]|[12][0-9]|31)$",
            allowMinus: false,
            digits: 0,
            groupSeparator: ',',
            autoGroup: true,
            digitsOptional: false,
            placeholder: "1",
            clearMaskOnLostFocus: !1,
        }).on("focus", function() {
            var that = $(this);
            setTimeout(function() {
                that.select();
            }, 1)
        });

        $(".dFilterStart").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            startDate: '<?= date('Y-01-01') ?>',
            minYear: 1980,
            maxYear: '<?= date('Y') ?>',
            maxDate: '<?= date('Y-12-31') ?>',
        });

        $(".dFilterEnd").focusin(function(e) {
            $dFilterStart = $(".dFilterStart").val();
            $dFilterEnd = $(this).val();

            $dFilterStartTemp = new Date($dFilterStart);
            $dFilterEndTemp = new Date($dFilterEnd);
            $iYearStart = $dFilterStartTemp.getFullYear();

            $(".dFilterEnd").daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                setDate: $iYearStart + '-12-' + '31',
                minDate: $dFilterStart,
                minYear: $iYearStart,
                maxYear: $iYearStart,
                maxDate: $iYearStart + '-12-' + '31',
            });

        });

        $(".dFilterStart").change(function() {
            $dFilterStart = $(this).val();
            $dFilterEnd = $(".dFilterEnd").val();


            $dFilterStartTemp = new Date($dFilterStart);
            $dFilterEndTemp = new Date($dFilterEnd);
            $iYearStart = $dFilterStartTemp.getFullYear();
            $iYearEnd = $dFilterEndTemp.getFullYear();


            if ($dFilterStartTemp > $dFilterEndTemp) {
                $(".dFilterEnd").val($iYearStart + '-12-' + '31');
            }

            if ($iYearStart != $iYearEnd) {
                $(".dFilterEnd").val($iYearStart + '-12-' + '31');
            }

            $TableId = $(this).data('tbid');
            $("#" + $TableId).DataTable().ajax.reload();
        });

        $(".dFilterEnd").change(function(e) {
            // $valDate = $(this).val();
            $TableId = $(this).data('tbid');

            $("#" + $TableId).DataTable().ajax.reload();
        });

        $(document).on("focusin", ".dDate", function(e) {
            $thisVal = $(this).val();
            if ($thisVal == "") {
                $thisValTemp = '<?= date('Y-m-d') ?>';
            } else {
                $thisValTemp = $thisVal;
            }

            $(this).daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                autoclose: true,
                minYear: 1900,
                maxYear: '<?= date('Y') ?>',
                setDate: $thisVal,
                maxDate: '<?= date('Y-m-d') ?>',
            })
        })

        $(document).on("focusin", ".dDateAll", function(e) {
            $thisVal = $(this).val();
            if ($thisVal == "") {
                $thisValTemp = "{{ date('Y-m-d') }}";
            } else {
                $thisValTemp = $thisVal;
            }

            $(this).daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                autoclose: true,
                setDate: $thisVal,
                minYear: 1900,
                maxDate: '<?= date(date('Y') + 10 . '-12-31') ?>',
            })
        })

        $(".dReportStart").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            startDate: '<?= date('Y-01-01') ?>',
            minYear: "{{ help_setapp('app_year') }}",
            maxYear: '<?= date('Y') ?>',
            maxDate: '<?= date('Y-12-31') ?>',
        });

        $(".dReportEnd").focusin(function(e) {
            $dReportStart = $(".dReportStart").val();
            $dReportEnd = $(this).val();

            $dReportStartTemp = new Date($dReportStart);
            $dReportEndTemp = new Date($dReportEnd);
            $iYear = $dReportEndTemp.getFullYear();

            $(".dReportEnd").daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                setDate: $iYear + '-12-' + '31',
                minDate: $dReportStart,
                minYear: $iYear,
                maxYear: (($iYear) + 1),
                maxDate: (($iYear) + 1) + '-12-' + '31',
            });

        });

        $(".dReportStart").change(function() {
            $dReportStart = $(this).val();
            $dReportEnd = $(".dReportEnd").val();


            $dReportStartTemp = new Date($dReportStart);
            $dReportEndTemp = new Date($dReportEnd);
            $iYearStart = $dReportStartTemp.getFullYear();
            $iYearEnd = $dReportEndTemp.getFullYear();


            if ($dReportStartTemp > $dReportEndTemp) {
                $(".dReportEnd").val($iYearStart + '-12-' + '31');
            }

            if ($iYearStart != $iYearEnd) {
                $(".dReportEnd").val($iYearStart + '-12-' + '31');
            }
        });

    });

    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener('hide.bs.modal', function(event) {
            if (document.activeElement) {
                document.activeElement.blur();
            }
        });
    });

    function empty_selected($idfield) {
        $("#" + $idfield).val("");
        $("#" + $idfield + "_tag").val("");
    }


    function formatdecimal($val) {
        $datavalue = parseFloat($val).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return $datavalue;
    }

    // formatdecimal
    function formatdecimal3($val) {
        $datavalue = parseFloat($val).toFixed(3).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return $datavalue;
    }

    function formatinteger($val) {
        $datavalue = parseFloat($val).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return $datavalue;
    }

    // UNTUK BUTTON TABLE INDEX
    function button_table_add_back_render() {
        $(document).ready(function() {
            $(".div_back_to_master").empty();
            $(".div_back_to_master").append(
                `<a wire:navigate href="/{{ help_submenu(10)->url }}" type="button" id="btn_add_data" class="btn btn-primary rounded-1" data-toggle="tooltip" data-placement="bottom"
                        title="Kembali Ke List Master Data"><i class="fas fa-arrow-left"></i></a>`
            );
        });
    }
    // UNTUK PERUBAHAN FILTER STATUS TABLE
    function changeStyleFilterStatus($idStatus) {
        if ($idStatus == "" || $idStatus == undefined) {
            $idStatus = 0;
        }

        $(document).ready(function() {
            $(".btn_tb_li_filter_status").removeClass("selected");
            $(".btn_tb_li_filter_status[data-id=" + $idStatus + "]").addClass("selected");
        });
    }

    // UNTUK BUTTON TABLE INDEX
    function setSubMenuMasterData() {
        $(document).ready(function() {
            $(".setMasterDataList").each(function() {
                $(this).addClass('active');
            })
            $(".setMasterDataList_menu").addClass('selected');
            $(".setMasterDataList_submenu").addClass('in');
        });
    }
</script>
