$(document).ready( function () {
  $('.select2').select2();
      $("#mytable").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_inspectionlot").DataTable({
        dom: 'frtip',
        // processing: true,
      //   serverSide: true,
      //   pageLength: 1,
      //   ajax: {
      //   url: "../server_produk.php",
      //   type: "POST"
      // },
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_pernr").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_produk").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_mesin").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_shift").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
        $("#mytables").DataTable({
          // "pageLength": 1,
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytabled").DataTable({
        dom: 'rt',
      });
      $("#mytable_operator1").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_operator2").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_operator3").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_operator4").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_operator5").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_operator6").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_dashboard1").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_dashboard2").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_dashboard3").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search"
        },

        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["planning_prod_header","approval_kaunit"]
             },
        },
        columns: [
            { data: null,
              render: function(data, type, row) {
                return `
                    <button class="btn-sm badge bg-warning text-dark zoom" onclick="showdetailallproses(${row.PlanningNumber},${row.Years})">#${row.PlanningNumber}</button>
                `;
            }
            },
            { data: "Years"},
            { data: "ProductID"},
            { data: "BatchNumber"},
            {
              data: null,
              render: function (data, type, row) {
                // Pastikan kalau salah satu null, tetap aman
                const name = row.EmployeeName || "";
                const createdFor = row.CreatedFor || "";
                return `${name} -  ${createdFor}`.trim();
              }
            },
            { 
              data: "CreatedOn",
              render: function(data, type, row) {
                  if (!data) return "";
                  let d = new Date(data);

                  let day    = ("0" + d.getDate()).slice(-2);
                  let month  = ("0" + (d.getMonth() + 1)).slice(-2);
                  let year   = d.getFullYear();
                  let hours  = ("0" + d.getHours()).slice(-2);
                  let minute = ("0" + d.getMinutes()).slice(-2);
                  let second = ("0" + d.getSeconds()).slice(-2);

                  return `${day}.${month}.${year} ${hours}:${minute}:${second}`;
              }
            },
            { data: null,
              render: function(data, type, row) {
                return `
                    <a href="#" class="badge bg-success zoom text-decoration-none text-white" onclick="saveapprovalproses(${row.PlanningNumber},${row.Years})"><img src="../asset/icon/accept2.png"> Setuju</a>
                    <a href="#" class="badge bg-danger zoom text-decoration-none text-white" onclick="tolakapprovalproses(${row.PlanningNumber},${row.Years})"><img src="../asset/icon/no_accept.png"> Tolak</a>
                `;
            }
            },
        ],
        dom: 'Bfrtip',
      });

      $("#mytable_dashboard4").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
      $("#mytable_dashboard5").DataTable({
        dom: 'frtip',
        language: {
        search: "🔍Search" // kosongkan label
        }
      });
    $("#dshift").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 3,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
      });
      $("#drhsuhu").DataTable({
        "nDestroy": true,
        "bInfo": false,
        "lengthChange": false,
        "pageLength": 3,
        "ordering": true,
        "info":     false,
        "bFilter": false,
        "bPaginate": false,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        // "sDom": 'T<"clear">lfrtip',
      });
      $("#drhsuhu0").DataTable({
        "nDestroy": true,
        "bInfo": false,
        "lengthChange": false,
        "pageLength": 3,
        "ordering": true,
        "info":     false,
        "bFilter": false,
        "bPaginate": false,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        // "sDom": 'T<"clear">lfrtip',
      });
      $("#dshift_range").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dcreateplanning").DataTable({
        "nDestroy": true,
        "bInfo": false,
        "lengthChange": false,
        "pageLength": 5,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        "searching": false,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        "paging": false,
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dproduct").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dproduct0").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 10,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [10, 25, 50,75, -1], [10,25, 50, 75,100, "All"] ]
      });
      $("#dmainresources0").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 10,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [10, 25, 50, -1], [10,25, 50, 75, "All"] ]
      });
      $("#dmainresources").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dmainresources2").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dmainresources3").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dmainresources4").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dmainresources5").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dmainresources6").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 4,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dsearchdata").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 5,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dsearchdata2").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 5,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dsearchdata3").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 5,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dsearchdata4").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        // "responsive": true,
        "pageLength": 5,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false,
      });
      $("#dsearchdata5").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        // "responsive": true,
        "pageLength": 5,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false,
      });
      $("#dsearchdata6").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        // "responsive": true,
        "pageLength": 5,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false,
      });
      $("#dsearchdata7").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        // "responsive": true,
        "pageLength": 10,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false,
      });
      $("#ddisplayreviewer0").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        // "autoWidth": true,
        lengthMenu: [ [5,10, 25, 50,75, -1], [5,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayreviewer1").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        // "autoWidth": true,
        lengthMenu: [ [5,10, 25, 50,75, -1], [5,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayreviewer2").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [5,10, 25, 50,75, -1], [5,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayreviewer3").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [5,10, 25, 50,75, -1], [5,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayreviewer4").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [5,10, 25, 50,75, -1], [5,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayreviewer5").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [5,10, 25, 50,75, -1], [5,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayplanning0").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [7,10, 25, 50,75, -1], [7,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayplanning1").DataTable({
        "bInfo": true,
        // "lengthChange": false,
        // "pageLength": 7,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
        lengthMenu: [ [7,10, 25, 50,75, -1], [7,10,25, 50, 75, "All"] ]
      });
      $("#ddisplayplanning").DataTable({
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 10,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
      });
      $("#ddisplayplanning3").DataTable({
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 10,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
      });
      $("#ddisplayplanning4").DataTable({
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 10,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        dom: 'Bfrtip',
        // scrollX: true,
        // scrolly: true,
      });
      $("#ddisplayplanning2").DataTable({
        scrollX: true,
        scrolly: true,
      });
      $("#droles").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 8,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
      $("#dmenu").DataTable({
        "nDestroy": true,
        "bInfo": true,
        "lengthChange": false,
        "pageLength": 10,
        "ordering": true,
        "info":     false,
        "bFilter": true,
        // "pagingType": 'full_numbers',
        // "dom": 'lrtip',
        // "paging": false
        // "sDom": '<"top"flp>rt<"bottom"i><"clear">'
        // "sDom": 'C<"clear">lfrtip',
        "sDom": 'T<"clear">lfrtip',
        "autoWidth": false
      });
});

$(document).ready(function() {
  $("#reportpengemasan").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["planning_prod_header","reportpengemasan"]
             },
        },
        columns: [
            { data: "PlanningNumber",
              render: function(data, type, row) {
                return `
                    <a href="#" class="badge bg-success href_transform" onclick="prosesselectreport(${row.PlanningNumber}, ${row.Years})">${row.PlanningNumber}</a>
                `;
            }
            },
            { data: "Years"},
            { data: "ProductID"},
            { data: "ShiftID"},
            { data: "PackingDate"},
            { data: "ResourceID"},
            { data: "BatchNumber"},
            { data: "ExpiredDate"},
            { data: "ResourceIDMix"},
            { data: "MixingDate"},
            { data: "Quantity"},
            { data: "UnitOfMeasures"},
            {data: "ProcessNumber"}
        ],
        dom: 'Bfrtip',
  });
  $("#reportpengolahan").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["planning_pengolahan_subdetail",
                  "reportpengolahan"]
             },
        },
        columns: [
            { data: "PlanningNumber",
              render: function(data, type, row) {
                return `
                    <a href="#" class="badge bg-success href_transform" onclick="selectplanningnumberreportpengolahan(${row.PlanningNumber}, ${row.Years})">${row.PlanningNumber}</a>
                `;
            }
            },
            { data: "Years"},
            { data: "ProductID"},
            { data: "ProductDescriptions"},
            { data: "BatchNumber"},
            { data: "CreatedOn"},
            // { data: "CreatedBy"}
        ],
        dom: 'Bfrtip',
  });
  $("#printlabelsample").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["insp_pengolahan_header",
                  "printlabelsample"]
             },
        },
        columns: [
            { data: "PlanningNumber",
              render: function(data, type, row) {
                return `
                    <a href="#" class="badge bg-success href_transform" onclick="selectplanningnumberreportpengolahan(${row.PlanningNumber}, ${row.Years})">${row.InspectionLot}</a>
                `;
            }
            },
            { data: "Lotyears"},
            { data: "ProductID"},
            { data: "ProductDescriptions"},
            { data: "BatchNumber"},
            { data: "PlanningNumber"},
            { data: "Years"},
            { data: "StatsY"},
            { data: "CreatedOn"},
            // { data: "CreatedBy"}
        ],
        dom: 'Bfrtip',
  });
  $("#configmenu").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["agr_menu","configmenu"]
             },
        },
        columns: [
            { data: "Menus",
              render: function(data, type, row) {
                return `
                    <a href="#" class="badge bg-danger href_transform" onclick="deletedatamenu(${row.Menus})">Delete</a>
                `;
            }
            },
            { data: "Menus"},
            { data: "Descriptions"},
        ],
        dom: 'Bfrtip',
  });
  $("#table_prepare_hopper").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["planning_prod_header","prepare_hopper"]
             },
            //  success: function (data) {
            //   alert(data)
            //  }
        },
        columns: [
            { data: null,
              render: function(data, type, row) {
                return `
                    <a href="#" class="badge bg-success href_transform" onclick="prosesselectpersiapanhoper(${row.PlanningNumber},${row.Years})">${row.PlanningNumber}</a>
                `;
            }
            },
            { data: "Years"},
            { data: "ProductID"},
            { data: "BatchNumber"},
            { data: "ShiftID"},
            { data: "PackingDate"},
            { data: "ResourceID"},
            { data: "ExpiredDate"},
            { data: "ResourceIDMix"},
            { data: "MixingDate"},
            { data: "Quantity"},
            { data: "UnitOfMeasures"},
            { data: "ProcessNumber"},
        ],
        dom: 'Bfrtip',
  });

  $("#table_manajemenstok").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["tbl_movingstock","manajemen_stok"]
             },
        },
        columns: [
            { data: "ProductID"},
            { data: "ProductDescriptions"},
            { data: "BatchNumber"},
            { data: "NoPallet"},
            { data: "NoProses"},
            { data: "Quantity"},
        ],
        dom: 'Bfrtip',
        footerCallback: function () {
          let api = this.api();
          let total = api.column(5, { page: 'current' }).data().reduce((a, b) => +a + +b, 0);
          $(api.column(5).footer()).html(total.toLocaleString()+' Kg');
        }
  });

  $("#table_manajemenstok2").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "⏳ Loading"
        },
        ajax: {
            url: "../function/serverside.php",
            type: "POST",
            cache: false,
            data: {
                "prosessimpandataproject": ["tbl_stockhouse","stock_house"]
             },
        },
        columns: [
            { data: "UnitType"},
            { data: "ProductID"},
            { data: "ProductDescriptions"},
            { data: "BatchNumber"},
            { data: "Quantity"},
        ],
        dom: 'Bfrtip',
        // footerCallback: function (row, data, start, end, display) {
        //   let api = this.api();
        //   let totalAll = api.ajax.json().totalQuantity || 0;
        //   $(api.column(4).footer()).html(`${totalAll.toLocaleString()}`);
        // }
        footerCallback: function () {
          let api = this.api();
          let total = api.column(4, { page: 'current' }).data().reduce((a, b) => +a + +b, 0);
          $(api.column(4).footer()).html(total.toLocaleString()+' Kg');
        }
  });
})

