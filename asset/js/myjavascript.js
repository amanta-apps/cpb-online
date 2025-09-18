// ------------Public Function---------------

var linked = 'cpb-online';
var linkedip = 'http://19.0.2.244:8080/cpb-online';

function imposeMinMax(el){
  if(el.value != ""){
    if(parseInt(el.value) < parseInt(el.min)){
      el.value = el.min;
    }
    if(parseInt(el.value) > parseInt(el.max)){
      el.value = el.max;
    }
  }
}
function missingstatement() {
  Swal.fire({
    text: "Proses Belum Lengkap. Cek List Semua Uraian Pemeriksaan",
    icon: "warning",
    showConfirmButton: true,
  })
}
function missingbobottimbang() {
  Swal.fire({
    text: "Bobot timbang tidak sesuai",
    icon: "warning",
    showConfirmButton: false,
    timer: 1500
  })
}
function missingparameter() {
  Swal.fire({
    text: "Data Input Belum Lengkap",
    icon: "warning",
    showConfirmButton: true,
  })
}
function missingplanningnumber() {
  Swal.fire({
    text: "Data Planning Number Kosong",
    icon: "warning",
    showConfirmButton: true,
  })
}
function missingpcheck() {
  Swal.fire({
    text: "Data belum terpilih",
    icon: "warning",
    showConfirmButton: true,
  })
}
function missingcompare() {
  Swal.fire({
    text: "Data tidak konsisten",
    icon: "error",
    showConfirmButton: true,
  })
}
function missingkodebahan() {
  Swal.fire({
    text: "Kode bahan tidak terdaftar. Hubungi Administrator",
    icon: "error",
    showConfirmButton: false,
    timer: 1500
  })
}
function underdevelopment() {
  Swal.fire({
    title: '💻',
    text: "App is under development !",
    showConfirmButton: false,
  })
  // setTimeout(function () {
  //   location.reload()  
  // }, 2000);
}
function koneksitimbangan() {
  Swal.fire({
    title: '💻',
    text: "Timbangan belum terhubung !",
    showConfirmButton: false,
  })
}
function cekusedtimbangan() {
  Swal.fire({
    text: "Timbangan sedang digunakan !",
    icon: "warning",
    showConfirmButton: false,
    timer: 3000,
  })
}
function getkoneksi(v) {
  $.ajax({
    url: "function/getkoneksi.php",
    type: "POST",
    cache: false,
    data: {
      "prosesgetkoneksi": v
    },
    success: function (data) {
      location.reload()
    }
  });
}
function message(value) { 
  if (value == 1) {
    underdevelopment()
    return
  }
  if (value == 2) {
    Swal.fire({
      text: "Jumlah batch & resep tidak sesuai",
      icon: "warning",
      showConfirmButton: true,
    })
    return
  }
  if (value == 3) {
    Swal.fire({
      text: "Data Input Belum Lengkapi",
      icon: "warning",
      showConfirmButton: true,
    })
    return
  }
  if (value == 4) {
    Swal.fire({
      text: "Please, Maintain Master of Insp.",
      icon: "warning",
      showConfirmButton: true,
    })
    return
  }
  if (value == 5) {
    missingpcheck()
  }
  if (value == 6) {
    missingkodebahan()
  }
  if (value == 7) {
    missingcompare()
  }
  if (value == 8) {
    Swal.fire({
      text: "Kode bahan belum terdaftar",
      icon: "warning",
      showConfirmButton: true,
    })
    return
  }
}
function drawChart() {
  var data = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['Limit', 40]
  ]);
  var options = {
      width: 300,
      height: 80,
      redFrom: 40,
      redTo: 100,
      yellowFrom: 40,
      yellowTo: 45,
      greenFrom:0,
      greenTo:40,
      minorTicks: 5 
  };
  var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
  chart.draw(data, options);
}
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}


// ----------Transaksi - Login & Logout------------
function showpassword() {
    var x = document.getElementById('passworddatalogin');
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
function hidepassword() {
    var x = document.getElementById('passworddatalogin');
      x.type = "password";
  }
function validasiloginenter() {
    var input = document.getElementById('passworddatalogin')
    input.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        var userid = $('#personalnumberdatalogin').val()
        var password = $('#passworddatalogin').val()
        var clientkoneksi = $('#clientkoneksi').val()
        var Scaptcha = $('#chaptchadatalogin').val()
        var captcha = $('#getrandomcodedatalogin').val()
        var plant = $('#plantdatalogin').val()
        var unitcode = $('#unitcodedatalogin').val()
        if (userid == '' || password == '') {
          missingparameter()
          return
        }
        $.ajax({ 
          url: "function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "proseslogin": [userid,password,
              clientkoneksi,Scaptcha,captcha,
            plant,unitcode]
          },
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                icon: 'success',
                text: 'Login Sukses',
                showConfirmButton: false,
              })
              setTimeout(function () {
                location.href = "page/mainpage?p=dashboard";
              }, 1500);
            }else{
              Swal.fire({
                icon: 'warning',
                text: data,
                showConfirmButton: false,
                timer: 1500
              })
            }
          },
        });
      }
    })
  }
function validasilogin() {
    var userid = $('#personalnumberdatalogin').val()
    var password = $('#passworddatalogin').val()
    var clientkoneksi = $('#clientkoneksi').val()
    var userid = $('#personalnumberdatalogin').val()
    var password = $('#passworddatalogin').val()
    var clientkoneksi = $('#clientkoneksi').val()
    var Scaptcha = $('#chaptchadatalogin').val()
    var captcha = $('#getrandomcodedatalogin').val()
    var plant = $('#plantdatalogin').val()
    var unitcode = $('#unitcodedatalogin').val()    
    if (userid == '' || password == '') {
      missingparameter()
      return
    }
    $.ajax({ 
      url: "function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "proseslogin": [userid,password,
          clientkoneksi,Scaptcha,captcha,
        plant,unitcode]
      },
      success: function (data) {
        // alert(data)
        if (data == 1) {
          Swal.fire({
            icon: 'success',
            text: 'Login Sukses',
            showConfirmButton: false,
          })
          setTimeout(function () {
            location.href = "page/mainpage?p=dashboard";
          }, 1500);
        }else{
          Swal.fire({
            icon: 'warning',
            text: data,
            showConfirmButton: false,
            timer: 3000
          })
        }
      },
    });
  }
function logoutsystem() {
  Swal.fire({
    title: '🙁',
    text: "Tekan 'YES' untuk meninggalkan aplikasi ",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          proseslogout: ''
        },
        success: function (data) {
          if (data == 1) {
            location.href = "../index";
          }
        }
      })
    }
  })
}
function changepassword() {
  underdevelopment()
  return
}
function Accesprogram(userid) {
  $.ajax({ 
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "cekotorisasi": userid
    },
    success: function (data) {
      let a = data.roles.length
      for (let i = 0; i < a; i++) {
        // alert(data.roles[i])
        document.getElementById(data.roles[i]).hidden=false
      }
    },
  });
}
function kickuserlog(userid) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Kick user " + userid,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Kick him!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({ 
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          proseskickuserlog: userid
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "User has been kick",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()  
            }, 1500);
          }
        },
      });
    }
  })
}
function showversionaplikasi() {
  $('#versionaplikasi').modal('show')
}

// -----------Dashboard-----------------

function submitdisplayapprovalallproses() {
  var tglstart = $('#tglfromallproses').val()
  var tglend = $('#tglendallproses').val()
  location.href = linkedip+'/page/mainpage?p=dashboard&start='+tglstart+'&end='+tglend+''
}
function showdetailallproses(planningnumber,years) {
  window.open ("../page/report/form/page_laporanquality.php?n='"+planningnumber+"'&&y='"+years+"'");
}
function showdatachange(notiket,years,obj) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "prosesshowdatachange": [notiket,years,obj]
    },
    success: function (data) {
      location.href = linkedip+'/page/mainpage?p=displaychange&x='+data.notiket+'&y='+data.years+'&z='+data.obj+''
    },
  });
  
}
function approvechangepersiapanpengolahan(notiket,tiketyears,obj) {
  Swal.fire({
    text: "Setujui Perubahan Data " + obj + "?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesapprovechangepersiapanpengolahan": [notiket,tiketyears,obj]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Data tersimpan",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.href = linkedip+'/page/mainpage?p=dashboard'  
            }, 1500);
          }
        },
      });
    }
  })
}
function saveallapprovalpengemasan() {
  var selectedValues = [];
  $('input[name="selectallpengemasan[]"]:checked').each(function() {
      selectedValues.push($(this).val());
  });
  
  if (selectedValues.length == '0') {
    message(5)
    return
  }
  // var note = selectedValues.split("/")

  Swal.fire({
    text: "Approved Planning?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6', 
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        // dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosessaveallapprovalpengemasandanpengolahan": [selectedValues,selectedValues.length]
        },
        success: function (data) {
          if (data != '') {
            Swal.fire({
              text: "Planning Approved",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()  
            }, 1500);
          }
        },
      });
    }
  })
}
function prosesapprovalreviewer(prosestype,planningnumber,years,levels,pernr,stats) {
  var txt =''
  if (stats == 'Y') {
    txt = "Approved Planning " + planningnumber +"?"
  }else{
    txt = "Tolak Planning " + planningnumber +"?"
  }

  Swal.fire({
    text: txt,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php", 
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosessimpanapprovalreviewer": [prosestype,planningnumber,years,levels,pernr,stats]
        },
        success: function (data) {
          // alert(data.test)
          if (data.return == 1) {
            Swal.fire({
              text: "Planning "+ data.planningnumber +" Approved",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()  
            }, 1500);
          } else {
            Swal.fire({
              title: "Oops..",
              Text: "Data Gagal Tersimpan",
              icon: "error",
              showConfirmButton: true,
            })
          }
        },
      });
    }
  })
}
function saveallapprovalproses() {
  var selectedValues = [];
  $('input[name="selectallproses[]"]:checked').each(function() {
      selectedValues.push($(this).val());
  });
  
  if (selectedValues.length == '0') {
    message(5)
    return
  }

  Swal.fire({
    text: "Approved Planning?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosessaveallapprovalproses": [selectedValues,selectedValues.length]
        },
        success: function (data) {
          if (data != '') {
            Swal.fire({
              text: "Planning Approved",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()  
            }, 1500);
          }
        },
      });
    }
  })
}
function saveapprovalproses(planningnumber,years) {
  Swal.fire({
    text: "Approved Planning "+planningnumber+ " ?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosessaveapprovalproses": [planningnumber,years]
        },
        success: function (data) {
          if (data != '') {
            Swal.fire({
              text: "Planning "+planningnumber+ " Approved",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()  
            }, 1500);
          }
        },
      });
    }
  })
}
function saveallapprovalpengolahan() {
  var selectedValues = [];
  var planning = [];
  $('input[name="selectallpengolahan[]"]:checked').each(function() {
      selectedValues.push($(this).val());
  });
  
  if (selectedValues.length == '0') {
    message(5)
    return
  }
  var a = String(selectedValues).split(",")
  for (let index = 0; index < a.length; index++) {
    var b = String(a[index]).split("/")

    planning.push(b[0])
  }
  Swal.fire({
    text: "Approved Planning " +planning+ "? ",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosessaveallapprovalpengemasandanpengolahan": [selectedValues,selectedValues.length]
        },
        success: function (data) {
          if (data != '') {
            Swal.fire({
              text: "Planning Approved",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()  
            }, 1500);
          }
        },
      });
    }
  })
}

// ------------Master Data - Product--------------------
  function simpanproduk() {
    var produkid = $('#idprodukdataproduk').val()
    var deskripsi = $('#deskripsidataproduk').val()
    var standardroll = $('#standardrolldataproduk').val()
    var standardprimer = $('#standardberatprimerdataproduk').val()
    var standardkonversi = $('#standardrollkonversidataproduk').val()

    var standarddus = $('#standarddusdataproduk').val()
    var standardduskonversi = $('#standarduskonversidataproduk').val()
    var standardcar = $('#standardcartondataproduk').val()
    var standardcarkonversi = $('#standarcarkonversidataproduk').val()

    var totalselflife = $('#totalselflifedataproduk').val()
    var bobotrangefrom = $('#bobotrangetimbangfromdataproduk').val()
    var bobotrangeto = $('#bobotrangetimbangtodataproduk').val()
    var bobotrange = bobotrangefrom.concat('-'+bobotrangeto)
    if (produkid == '' || deskripsi == '' || standardroll == '' || 
        standardkonversi == '' || standardprimer =='' || bobotrangefrom =='' || bobotrangeto =='' ||
        standarddus == '' || standardduskonversi == '' || standardcar == '' || standardcarkonversi =='') {
      missingparameter()
      return
    }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      'prosessimpanproduk': [produkid,
      deskripsi,
      standardroll,
      standardprimer,
      standardkonversi,
      totalselflife,
      bobotrange,
      standardcar,
      standardcarkonversi,
      standarddus,
      standardduskonversi]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload()
        }, 1500);
      }else if(data == 2){
        Swal.fire({
          title: 'Product is available.',
          text: "Update data product " + produkid,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                'prosesupdateproduk': [produkid,
                deskripsi,
                standardroll,
                standardprimer,
                standardkonversi,
                totalselflife,
                bobotrange,
                standardcar,
                standardcarkonversi,
                standarddus,
                standardduskonversi]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload();
        }, 1500);
      }
    },
  });
  }
  function deleteddataproduk(prodctid) {
    Swal.fire({
      title: 'Are you sure?',
      text: "Delete product " + prodctid,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            prosesdeleteproduk: prodctid
          },
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                title: "Success",
                text: "Data Terhapus",
                icon: "success",
                showConfirmButton: true,
              })
              setTimeout(function () {
                location.reload()
              }, 1500);
            } else {
              Swal.fire({
                Text: "Data Gagal Tersimpan",
                icon: "error",
                showConfirmButton: false,
              })
              setTimeout(function () {
                location.reload()
              }, 1500);
            }
          },
        });  
      }
    })
  }
  function changedataproduk(prodctid) {
    $.ajax({
      url: "../function/getdata.php",
      dataType: "JSON",
      type: "POST",  
      cache: false,
      data: {
        proseschangeproduk: prodctid
      },
      success: function (data) {
        document.getElementById('idprodukdataproduk').disabled = true
        $('#idprodukdataproduk').val(data.productid)
        $('#deskripsidataproduk').val(data.productdescriptions)
        $('#standardrolldataproduk').val(data.standardroll)
        $('#standardrollkonversidataproduk').val(data.standardrollkonversi)
        $('#standarddusdataproduk').val(data.standarddus)
        $('#standarduskonversidataproduk').val(data.standardduskonversi)
        $('#standardcartondataproduk').val(data.standardcar)
        $('#standarcarkonversidataproduk').val(data.standardcarkonversi)
        $('#standardberatprimerdataproduk').val(data.standarberatprimer)
        $('#totalselflifedataproduk').val(data.totalselflife)
        var bobottimbangfrom = data.bobottimbang.split('-') 
        $('#bobotrangetimbangfromdataproduk').val(bobottimbangfrom[0])  
        $('#bobotrangetimbangtodataproduk').val(bobottimbangfrom[1])  
        $('#createondatabarang').val(data.createdon)
        $('#createbydataproduk').val(data.createdby)
      },
    });
  }

// -----------Master Data - Shift--------------
  function simpanshift() {
    var shiftid = $('#shiftidshift').val()
    var shiftdeskripsi = $('#shiftdescriptiondatashift').val()
    var idrangetime = $('#idrangetimedatashift').val()
    if (shiftid == '' || shiftdeskripsi == '' || idrangetime =='') {
      missingparameter()
      return
    }
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        prosessimpanshift: [shiftid, shiftdeskripsi, idrangetime]
      },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            title: "Success",
            text: "Data Tersimpan",
            icon: "success",
            showConfirmButton: true,
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload()
            }
          });
        }else if(data ==2){
          Swal.fire({
            title: 'Shift is available.',
            text: "Update data shift " + shiftid,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: "../function/getdata.php",
                type: "POST",
                cache: false,
                data: {
                  prosesupdateshift: [shiftid, shiftdeskripsi, idrangetime]
                },
                success: function (data) {
                  if (data == 1) {
                    Swal.fire({
                      title: "Success",
                      text: "Data Tersimpan",
                      icon: "success",
                      showConfirmButton: false,
                    })
                    setTimeout(function () {
                      location.reload();    
                    }, 1500);
                  }
                }
              })
            }else{
              document.getElementById('shiftidshift').value=''
              document.getElementById('shiftidshift').disabled=false
              document.getElementById('shiftdescriptiondatashift').value=''
              document.getElementById('idrangetimedatashift').value=''
            }
          })
        } else {
          Swal.fire({
            Text: "Data Gagal Tersimpan",
            icon: "error",
            showConfirmButton: true,
          })
        }
      },
    });
  }
  function deleteddatashift(shiftid) {
    Swal.fire({
      title: 'Are you sure?',
      text: "Delete shift " + shiftid,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('shiftidshift').value=''
        document.getElementById('shiftdescriptiondatashift').value=''
        document.getElementById('idrangetimedatashift').value=''
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            prosesdeleteshift: shiftid
          },
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                title: "Success",
                text: "Data Terhapus",
                icon: "success",
                showConfirmButton: true,
              })
              setTimeout(function () {
                location.reload();    
              }, 1500);
            } else {
              Swal.fire({
                Text: "Data Gagal Tersimpan",
                icon: "error",
                showConfirmButton: false,
              })
              setTimeout(function () {
                location.reload();
              }, 1500);
            }
          },
        });  
      }
    })
  }
  function changedatashift(shiftid) {
    $.ajax({
      url: "../function/getdata.php",
      dataType: "JSON",
      type: "POST",  
      cache: false,
      data: {
        proseschangeshift: shiftid
      },
      success: function (data) {
        document.getElementById('shiftidshift').disabled = true
        $('#shiftidshift').val(data.shiftid)
        $('#shiftdescriptiondatashift').val(data.shiftdescriptions)
        $('#idrangetimedatashift').val(data.rangetimeid)
        $('#createdonshift').val(data.createdon)
        $('#createdbydatashift').val(data.createdby)
      },
    });
  }

// -----------Master Data - Shift Range------------------

function simpanshiftrange() {
  var rangetime = $('#rangetimeiddatashiftrange').val()
  var deskripsi = $('#rangetimedescriptiondatashiftrange').val()
  if (rangetime == '' || deskripsi == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpanshiftrange: [rangetime, deskripsi]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: 'Shift is available.',
          text: "Update data shift range " + rangetime,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                prosesupdateshiftrange: [rangetime, deskripsi]
              },
              success: function (data) {
                if (data == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: true,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload()
                    }
                  });  
                }
              }
            })
          }else{
            location.reload()
          }
        })
      } else {
        Swal.fire({
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deleteddatashift_range(shiftidrange) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete shift range " + shiftidrange,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('rangetimeiddatashiftrange').value=''
      document.getElementById('rangetimedescriptiondatashiftrange').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeleteshiftrange: shiftidrange
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload()    
              }
            });
          } else {
            Swal.fire({
              Text: "Data Gagal Tersimpan",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedatashift_range(shiftidrange) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      proseschangeshiftrange: shiftidrange
    },
    success: function (data) {
      document.getElementById('rangetimeiddatashiftrange').disabled = true
      $('#rangetimeiddatashiftrange').val(data.rangetimeid)
      $('#rangetimedescriptiondatashiftrange').val(data.rangedescriptions)
    },
  });
}

// -------------Master Data - Main Resource-------------------
function simpanmainresource() {
  var idmain = $('#resourceidmainresource').val()
  var deskripsi1 = $('#resourcedesription1mainresource').val()
  var deskripsi2 = $('#resourcedesription2mainresource').val()
  var primary = $('#primaryresourceidmainresource').val()
  var secondary = $('#secondaryresourceidmainresource').val()
  if (idmain == '' || deskripsi1 == ''|| deskripsi2 == ''|| primary == ''|| secondary == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpanmainresource: [idmain, 
        deskripsi1,deskripsi2,primary,secondary]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){        
        Swal.fire({
          title: 'Main Resource is available.',
          text: "Update data mainresource " + idmain,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                prosesupdatemainresource: [idmain, 
                  deskripsi1,deskripsi2,primary,secondary]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deleteddatamainresource(idmain) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete main Resource " + idmain,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('resourceidmainresource').value=''
      document.getElementById('resourcedesription1mainresource').value=''
      document.getElementById('resourcedesription2mainresource').value=''
      document.getElementById('primaryresourceidmainresource').value=''
      document.getElementById('secondaryresourceidmainresource').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeletemainresource: idmain
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Tersimpan",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedatamainresource(idmain) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      proseschangemainresource: idmain
    },
    success: function (data) {
      document.getElementById('resourceidmainresource').disabled = true
      $('#resourceidmainresource').val(data.resourceid)
      $('#resourcedesription1mainresource').val(data.	resourcedescriptions1)
      $('#resourcedesription2mainresource').val(data.resourcedescriptions2)
      $('#primaryresourceidmainresource').val(data.primaryresourceid).trigger('change');
      $('#secondaryresourceidmainresource').val(data.secondaryresourceid).trigger('change');
      $('#createonmainresource').val(data.createdon)
      $('#createbymainresource').val(data.createdby)
    },
  });
}

// --------------Master Data - Primary Resource-----------------
function simpanprimaryresource() {
  var idprimary = $('#primaryresourceidprimaryresource').val()
  var deskripsi = $('#descriptionprimaryresource').val()
  var merk = $('#merkprimaryresource').val()
  var noiventaris = $('#noinventarisprimaryresource').val()
  var xtype = $('#typeprimaryresource').val()
  var status = $('#activestatusprimaryresource').val()
  if (idprimary == '' || deskripsi == ''|| merk == ''|| noiventaris == ''|| xtype == '' || status == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpanprimaryresource: [idprimary, 
        deskripsi,merk,noiventaris,xtype,status]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: idprimary +' is available.',
          text: "Update data primary resource?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                prosesupdateprimaryresource: [idprimary, 
                  deskripsi,merk,noiventaris,xtype,status]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deleteddataprimaryresource(idprimary) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete primary Resource " + idprimary,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('primaryresourceidprimaryresource').value=''
      document.getElementById('descriptionprimaryresource').value=''
      document.getElementById('merkprimaryresource').value=''
      document.getElementById('noinventarisprimaryresource').value=''
      document.getElementById('typeprimaryresource').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeleteprimaryresource: idprimary
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedataprimaryresource(idprimary) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      proseschangeprimaryresource: idprimary
    },
    success: function (data) {
      document.getElementById('primaryresourceidprimaryresource').disabled = true
      $('#primaryresourceidprimaryresource').val(data.primaryresourceid)
      $('#descriptionprimaryresource').val(data.primarydescriptions)
      $('#merkprimaryresource').val(data.merk)
      $('#noinventarisprimaryresource').val(data.noinventaris)
      $('#typeprimaryresource').val(data.types)
      $('#activestatusprimaryresource').val(data.activestatus)
      // $('#createonprimaryresource').val(data.createonprimaryresource)
      // $('#createbyprimaryresource').val(data.createbyprimaryresource)
    },
  });
}

// -------------Master Data - Secondary Resource----------------
function simpansecondaryresource() {
  var idsecondary = $('#secondaryresourceidsecondaryresource').val()
  var deskripsi = $('#descriptionsecondaryresource').val()
  var merk = $('#merksecondaryresource').val()
  var noiventaris = $('#noinventarissecondaryresource').val()
  var xtype = $('#typesecondaryresource').val()
  var status = $('#activestatussecondaryresource').val()
  if (idsecondary == '' || deskripsi == ''|| merk == ''|| noiventaris == ''|| xtype == '' || status == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpansecondaryresource: [idsecondary, 
        deskripsi,merk,noiventaris,xtype,status]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: idsecondary +' is available.',
          text: "Update data primary resource?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                prosesupdatesecondaryresource: [idsecondary, 
                  deskripsi,merk,noiventaris,xtype,status]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deleteddatasecondaryresource(idsecondary) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Secodanry Resource " + idsecondary,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('secondaryresourceidsecondaryresource').value=''
      document.getElementById('descriptionsecondaryresource').value=''
      document.getElementById('merksecondaryresource').value=''
      document.getElementById('noinventarissecondaryresource').value=''
      document.getElementById('typesecondaryresource').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeletesecondaryresource: idsecondary
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedatasecondaryresource(idsecondary) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      proseschangesecondaryresource: idsecondary
    },
    success: function (data) {
      document.getElementById('secondaryresourceidsecondaryresource').disabled = true
      $('#secondaryresourceidsecondaryresource').val(data.secondaryresourceid)
      $('#descriptionsecondaryresource').val(data.secondarydescriptions)
      $('#merksecondaryresource').val(data.merk)
      $('#noinventarissecondaryresource').val(data.noinventaris)
      $('#typesecondaryresource').val(data.types)
      $('#activestatussecondaryresource').val(data.activestatus)
    },
  });
}

// --------------Master Data - Mixing Resource------------------
function simpanmixingresource() {
  var idmixing = $('#resourceidmixingresource').val()
  var deskripsi = $('#descriptionmixingresource').val()
  var merk = $('#merkmixingresource').val()
  var noiventaris = $('#noinventarismixingresource').val()
  if (idmixing == '' || deskripsi == ''|| merk == ''|| noiventaris == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpanmixingresource: [idmixing, 
        deskripsi,merk,noiventaris]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: idmixing +' is available.',
          text: "Update data mixing resource?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                prosesupdatemixingresource: [idmixing, 
                  deskripsi,merk,noiventaris]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deleteddatamixingresource(idmixing) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Secodanry Resource " + idmixing,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('resourceidmixingresource').value=''
      document.getElementById('descriptionmixingresource').value=''
      document.getElementById('merkmixingresource').value=''
      document.getElementById('noinventarismixingresource').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeletemixingresource: idmixing
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedatamixingresource(idmixing) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      proseschangemixingresource: idmixing
    },
    success: function (data) {
      document.getElementById('resourceidmixingresource').disabled = true
      $('#resourceidmixingresource').val(data.resourceid)
      $('#descriptionmixingresource').val(data.descriptions)
      $('#merkmixingresource').val(data.merk)
      $('#noinventarismixingresource').val(data.noinventaris)
      $('#createonmixingresource').val(data.createdon)
      $('#createbymixingresource').val(data.createdby)
    },
  });
}

// --------------Master Data - Data Employee------------------
function simpanemployee() {
  var pernr = $('#personalnumberemployee').val()
  var nama = $('#employeenameemployee').val()
  var posisi = $('#positionidemployee').val()
 
  if (pernr == '' || nama == ''|| posisi == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanemployee": [pernr, 
        nama,posisi]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: pernr +' is available.',
          text: "Update data employee?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                prosesupdataemployee: [pernr, 
                  nama,posisi]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedataemployee(pernr) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Pernr " + pernr,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('personalnumberemployee').value=''
      document.getElementById('employeenameemployee').value=''
      document.getElementById('positionidemployee').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeleteemployee: pernr
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedataemployee(pernr) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "proseschangeemployee": pernr
    },
    success: function (data) {
      document.getElementById('personalnumberemployee').disabled=true
      $('#personalnumberemployee').val(data.personnelnumber)
      $('#employeenameemployee').val(data.descriptions)
      // $('#positionidemployee').val(data.positionid)
      // document.getElementById('positionidemployee').innerHTML=data.positionid
      $('#positionidemployee').val(data.positionid).trigger('change');
      $('#createbyemployee').val(data.createdby)
      $('#createonemployee').val(data.createdon)
    },
  });
}

// --------------Master Data - Mapping Timbangan--------------
function simpandaftartimbangan() {
  var ipadd = $('#ipaddressdatatimbangan').val()
  var namatimbangan = $('#namatimbangandatatimbangan').val()
  var detaillokasi = $('#detaillokasidatatimbangan').val()
  var port = $('#portdatatimbangan').val()

  if (ipadd == '' || namatimbangan == ''|| port == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpandatatimbangan": [ipadd, 
        namatimbangan,detaillokasi,port]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload()  
        }, 1500);
      }else if(data == 2){
        Swal.fire({
          text: namatimbangan + ' - ' + ipadd +' is available. Update data timbangan?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata2.php",
              type: "POST",
              cache: false,
              data: {
                "prosesupdatedatatimbangan": [ipadd, 
                  namatimbangan,detaillokasi,port]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedatatimbangan(ipadd) {
  Swal.fire({
    text: "Hapus data timbangan " + ipadd +"?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletedatatimbangan": ipadd
        },
        success: function (data) {
          if (data == 1) {
              location.reload();    
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: true,
            })
          }
        },
      });  
    }
  })
}
function changedatatimbangan(ipadd) {
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "proseschangedatatimbangan": ipadd
    },
    success: function (data) {
      if (data.ipaddress !='') {
        document.getElementById('ipaddressdatatimbangan').disabled=true
      }
      $('#ipaddressdatatimbangan').val(data.ipaddress)
      $('#namatimbangandatatimbangan').val(data.namatimbangan)
      $('#detaillokasidatatimbangan').val(data.detaillokasi)
      $('#portdatatimbangan').val(data.port)
      $('#createdbydatatimbangan').val(data.createdby)
      $('#createondatatimbangan').val(data.createdon)
    },
  });
}

// -------------Transaksi - Authorization-----------------
function simpanauth() {
  var userid = $('#useriduserotorisasi').val()
  var pernr = $('#personalnumberuserotorisasi').val()
  if (userid == '' || pernr == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanauth": [userid, 
        pernr]
    },
    success: function (data) {
      alert(data)
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: userid +' is available.',
          text: "Update data User Authorization?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                "prosesupdataauth": [userid, 
                  pernr]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedataauth(userid) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete User ID " + userid,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('useriduserotorisasi').value=''
      document.getElementById('personalnumberuserotorisasi').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeleteauth: userid
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedataauth(userid) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      proseschangeauth: userid
    },
    success: function (data) {
      $('#useriduserotorisasi').val(data.userid)
      $('#personalnumberuserotorisasi').val(data.personnelnumber).trigger('change');
      $('#createbyuserotorisasi').val(data.createdby)
      $('#createonuserotorisasi').val(data.createdon)
    },
  });
}
function getnamekaryawan(pernr) {
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",  
    cache: false,
    data: {
      prosesgetnameauth: pernr
    },
    success: function (data) {
      $('#nameuserotorisasi').val(data)
    },
  });
}

// ------------Master Data - Job Position---------------
function simpanjob() {
  var idposition = $('#positionidjobposition').val()
  var deskripsi = $('#descriptionjobposition').val()
  if (idposition == '' || deskripsi == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanjobposition": [idposition, 
        deskripsi]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        
        Swal.fire({
          title: idposition +' is available.',
          text: "Update data Job?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                "prosesupdatejob": [idposition, 
                  deskripsi]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedatajob(positionid) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete User ID " + positionid,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('positionidjobposition').value=''
      document.getElementById('descriptionjobposition').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeletejob: positionid
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedatajob(positionid) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "proseschangejob": positionid
    },
    success: function (data) {
      document.getElementById('positionidjobposition').disabled=true
      $('#positionidjobposition').val(data.positionid)
      $('#descriptionjobposition').val(data.descriptions)
    },
  });
}

// ------------Config - Assign Role------------------
function selectuseridassignrole(userid,employeename,pernr) {
  $('#useridassignrole').val(userid)
  $('#employeenameassignrole').val( pernr+" - "+employeename)
  document.getElementById('simpanassignrole').hidden=false
  $('#searchuseridassignrole').modal('hide')
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayassignrole": userid
    },
    success: function (data) {
      document.getElementById('roleuserlist').innerHTML = data
    }
  })
}
function simpanassignrole() {
  var userid = $('#useridassignrole').val()
  var checkboxes = document.getElementsByName('mySelector');
  var roleslist = []
  for (let i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked){ roleslist.push(checkboxes[i].value)
    }
  }
  if (roleslist == '') {
    Swal.fire({
      text: "User Min Have 1 Role",
      icon: "error",
      showConfirmButton: false,
      timer:1500
    })
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpanassignrole: [roleslist,userid]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Roles Has Been Update",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload()
        }, 1500);
      }
    }
  })
}

// ---------Config - Menu-----------------------
function simpanmenu() {
  var menu = $('#menudaftarmenu').val()
  var deskripsi = $('#deskripsidaftarmenu').val()
  if (menu == '' || deskripsi == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpandatamenu: [menu, 
        deskripsi]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: idposition +' is available.',
          text: "Update data Menu?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                prosesupdatemenu: [menu, 
                  deskripsi]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedatamenu(menu) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Menu " + menu,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeletemenu: menu
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}

// ---------Config - Reviewer-----------------------
function simpanreviewercpb() {
  var menu = $('#menureviewercpb').val()
  var pernr = $('#pernrreviewercpb').val()
  if (menu == '' || pernr == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessimpareviewercpb": [menu, 
        pernr]
    },
    success: function (data) {
      if (data.return == 1) {
        Swal.fire({
          text: data.msgsukses,
          icon: data.iconmsgsukses,
          showConfirmButton: false,
          timerProgressBar: true,
        })
        setTimeout(function () {
              location.reload() 
            }, data.time);
      }else{
        Swal.fire({
          text: data.msgerror,
          icon: data.iconmsgerror,
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletereviewercpb(menu,pernr) {
  Swal.fire({
    title: 'Apa kamu yakin?',
    // text: "Delete Menu Ini ",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletereviewercpb": [menu,pernr]
        },
        success: function (data) {
      if (data.return == 1) {
          Swal.fire({
          text: data.msgsukses,
          icon: data.iconmsgsukses,
          showConfirmButton: false,
          timerProgressBar: true,
        })
        setTimeout(function () {
              location.reload() 
            }, data.time);
        }else{
          Swal.fire({
            text: data.msgerror,
            icon: data.iconmsgerror,
            showConfirmButton: true,
          })
        }
        },
      });  
    }
  })
}
// -----------Config - Role----------------------
function simpanrole() {
  var koderole = $('#koderoledatarole').val()
  var roles = $('#roledatarole').val()
  var menurole = $('#menudatarole').val()
  // var roles = koderole.concat(role)
  if (koderole == '' || roles == '' || menurole == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      'prosessimpandatarole': [roles, 
        menurole]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if(data ==2){
        Swal.fire({
          title: "Oops..",
          Text: "Data Sudah Terdaftar",
          icon: "error",
          showConfirmButton: false,
          timer: 1500,
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedatarole(roles,menu) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Role " + roles,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesdeleterole: [roles,menu]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: true,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}

// ----------Transaksi - Planning Pengemasan----------------------
function submitproductcreateplanning() {
  var input = document.getElementById("productidcreateplanning");
  input.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
      var productid =  $('#productidcreateplanning').val()
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          sumbitproductmanual: productid
        },
        success: function (data) {
          if (data.statuscode == 1) {
            $('#productidcreateplanning').val(data.productid)
            $('#descriptionproductcreateplanning').val(data.descriptions)
            $('#expireddatecreateplanning').val(data.selflife)
          }else{
            $('#productidcreateplanning').val('')
            $('#descriptionproductcreateplanning').val('')
            $('#expireddatecreateplanning').val(date.now())
            Swal.fire({
              text: "Product ID not found",
              icon: "warning",
              showConfirmButton: false,
              timer: 1000
            })
          }
        }
      })
    }
  })
}
function resetproductcreateplanning() {
  $('#productidcreateplanning').val('')
  $('#descriptionproductcreateplanning').val('')
}
function selectproductcreateplanning(productid,description,totalselflife) {
  $('#productidcreateplanning').val(productid)
  
  var productid =  $('#productidcreateplanning').val()
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "sumbitproductmanual": productid
        },
        success: function (data) {
          if (data.statuscode == 1) {
            $('#productidcreateplanning').val(data.productid)
            $('#descriptionproductcreateplanning').val(data.descriptions)
            $('#expireddatecreateplanning').val(data.selflife)
            $('#searchprodukcreateplanning').modal('hide')
          }
        }
      })
}
function getkadaluarsa(parameters) {
  var product = $('#productidcreateplanning').val()
  if (product != '') {
    $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      edautomatiscreateplanning:[product,parameters] 
    },
    success: function (data) {
      $('#expireddatecreateplanning').val(data)
      // $('#expireddatecreateplanningpengolahan').val(data)
    }
    })
  } 
}
function submitshiftcreateplanning() {
  var input = document.getElementById("shiftcreateplanning");
  input.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
      var shift =  $('#shiftcreateplanning').val()
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          sumbitshiftmanual: shift
        },
        success: function (data) {
          if (data.statuscode == 1) {
            $('#shiftcreateplanning').val(data.shiftid)
            // $('#descriptionshiftcreateplanning').val(data.descriptions)
          }else{
            $('#shiftcreateplanning').val('')
            // $('#descriptionshiftcreateplanning').val('')
            Swal.fire({
              text: "Shift not found",
              icon: "warning",
              showConfirmButton: false,
              timer: 1000
            })
          }
        }
      })
    }
  })
}
function resetshiftcreateplanning() {
  $('#shiftcreateplanning').val('')
  // $('#descriptionshiftcreateplanning').val('') 
}
function selectshiftcreateplanning(shiftid) {
  $('#shiftcreateplanning').val(shiftid)
  // $('#descriptionshiftcreateplanning').val(description)
  $('#searchshiftcreateplanning').modal('hide')
}
function resetmesincreateplanning() {
  $('#kodemesincreateplanning').val('')
  $('#nohoppercreateplanning').val('')
  $('#descriptionmesincreateplanning').val('')
  $('#noruanghoppercreateplanning').val('')
  $('#namaruanghoppercreateplanning').val('')
  $('#nomesintopackcreateplanning').val('')
  $('#descriptiontopackcreateplanning').val('')
  $('#noruangtopackcreateplanning').val('')
  $('#namruangtopackcreateplanning').val('')
}
function selectmesincreateplanning(resourceid,hopper,description1,topack,description2) {
  $('#kodemesincreateplanning').val(resourceid)
  $('#nohoppercreateplanning').val(hopper)
  $('#descriptionhoppercreateplanning').val(description1)
  // $('#noruanghoppercreateplanning').val(data)
  // $('#namaruanghoppercreateplanning').val(data)
  $('#nomesintopackcreateplanning').val(topack)
  $('#descriptiontopackcreateplanning').val(description2)
  // $('#noruangtopackcreateplanning').val(data)
  // $('#namruangtopackcreateplanning').val(data)
  $('#searchmesincreateplanning').modal('hide')
}
function submitmesincreateplanning() {
  var input = document.getElementById("kodemesincreateplanning");
  input.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
      var kodemesin =  $('#kodemesincreateplanning').val()
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          sumbitkodemesinmanual: kodemesin
        },
        success: function (data) {
          if (data.statuscode == 1) {
            $('#kodemesincreateplanning').val(data.resourceid)
            $('#nohoppercreateplanning').val(data.primaryresourceid)
            $('#descriptionhoppercreateplanning').val(data.resourcedescriptions1)
            // $('#noruanghoppercreateplanning').val(data)
            // $('#namaruanghoppercreateplanning').val(data)
            $('#nomesintopackcreateplanning').val(data.secondaryresourceid)
            $('#descriptiontopackcreateplanning').val(data.resourcedescriptions2)
            // $('#noruangtopackcreateplanning').val(data)
            // $('#namruangtopackcreateplanning').val(data)
          }else{
            resetmesincreateplanning()
            Swal.fire({
              text: "Machine code not found",
              icon: "warning",
              showConfirmButton: false,
              timer: 1000
            })
          }
        }
      })
    }
  })
}
function submitmesinmixingcreateplanning() {
  var input = document.getElementById("kodemesincreateplanning");
  input.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
      var kodemesin =  $('#kodemesincreateplanning').val()
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          sumbitkodemesinmanual: kodemesin
        },
        success: function (data) {
          if (data.statuscode == 1) {
            $('#kodemesincreateplanning').val(data.resourceid)
            $('#nohoppercreateplanning').val(data.primaryresourceid)
            $('#descriptionhoppercreateplanning').val(data.resourcedescriptions1)
            // $('#noruanghoppercreateplanning').val(data)
            // $('#namaruanghoppercreateplanning').val(data)
            $('#nomesintopackcreateplanning').val(data.secondaryresourceid)
            $('#descriptiontopackcreateplanning').val(data.resourcedescriptions2)
            // $('#noruangtopackcreateplanning').val(data)
            // $('#namruangtopackcreateplanning').val(data)
          }else{
            resetmesincreateplanning()
            Swal.fire({
              text: "Machine code not found",
              icon: "warning",
              showConfirmButton: false,
              timer: 1000
            })
          }
        }
      })
    }
  })
}
function selectmesinmixingcreateplanning(resourceid,description1) {
  $('#kodemesinmixingcreateplanning').val(resourceid)
  $('#descriptionmesinmixingcreateplanning').val(description1)
  $('#searchmesinmixingcreateplanning').modal('hide')
}
function resetmesinmixingcreateplanning() {
  $('#kodemesinmixingcreateplanning').val('')
  $('#descriptionmesinmixingcreateplanning').val('')
}
function savedatareviewer() {
  var type_transaksi = $('#typetransaksidatareviewer').val()
  var pernr = $('#pernrdatareviewer').val()
  var employeename = $('#employeenamedatareviewer').val()
  var position = $('#positiondatareviewer').val()
  var level = $('#levelsdatareviewer').val()
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosessavedatareviewer": [type_transaksi, 
        pernr,employeename,position,level]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function (data) {
          location.reload()  
        }, 1500);
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function prosesselectpernrdatareviewer(pernr,name,position) {
  $('#pernrdatareviewer').val(pernr)
  $('#employeenamedatareviewer').val(name)
  $('#positiondatareviewer').val(position)
  $('#listpernrdatareviewer').modal('hide')
}
function selectlevelsdatareviewer(value) {
  if (value == '') {
    $('#levelsdatareviewer').val(1)
    return
  }
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosesselectlevelsdatareviewer": value
    },
    success: function (data) {
      $('#levelsdatareviewer').val(data)
    }
  });
}
function deletedatareviewer(type_transaksi,level,transaksi) {
  Swal.fire({
    // title: 'Autentikasi',
    text: "Delete reviewer " + transaksi + " level " + level +" ?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Batal',
    confirmButtonText: 'Ya, Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletedatareviewer": [type_transaksi,level]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              text: data,
              icon: "warning",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function simpancreateplanning() {
  var productid = $('#productidcreateplanning').val()
  var shift = $('#shiftcreateplanning').val()
  var tglkemas = $('#tglkemascreateplanning').val()
  var resourceid = $('#kodemesincreateplanning').val()
  var batch = $('#batchcreateplanning').val()
  var ed = $('#expireddatecreateplanning').val()
  var resourceidmix = $('#kodemesinmixingcreateplanning').val()
  var tglmixing = $('#tglmixingcreateplanning').val()
  var jumlahsachet = $('#jumlahsachetcreateplanning').val()
  var uom = $('#uomcreateplanning').val()
  var noproses = $('#noprosescreateplanning').val()
  var tong = $('#notongcreateplanning').val()
  var createdfor = $('#pernrcreateplanning').val()
  var reviewer_add = $('#revieweraddcreateplanning').val()
  const d = new Date();
  let years = d.getFullYear();
  // var createdfor = createdfor_e.split(" ",1)
  if (productid == '' || tglkemas == '' ||
      shift == '' || batch =='' || ed =='' || noproses == '' ||
      resourceidmix =='' || tglmixing == '' ||
      jumlahsachet == '' || uom == '' || resourceid == '') {
    missingparameter()
    return
  }

  var totalreviewer = $('#totalreviewercreateplanningpengemasan').val()
  var reviewer = []
  for (let i = 0; i < totalreviewer; i++) {
    var rev = document.getElementById('reviewerpengemasan'+i+'').checked
    if (rev === true) {
      reviewer[i] = $('#levelscreateplanningpengemasan'+i+'').val()
    }  
  }
  // alert(reviewer)

  Swal.fire({
    text: "Save Data?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#0275d8',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Save'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosessavecreateplanning": [productid,shift,tglkemas,
          resourceid,batch,ed,resourceidmix,tglmixing,
          jumlahsachet,uom,noproses,tong,createdfor,reviewer_add,reviewer]
        },
        success: function (data) {
          // alert(data)
          if (data.status == 1) {
            planningnumber = data.kodeplanning
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                "prosessavelogprint": [planningnumber,years]
              },
              success: function (data) {
                if (data === false) {
                  Swal.fire({
                    Text: "error before print",
                    icon: "error",
                    showConfirmButton: false,
                  })
                }
              },
            });
            Swal.fire({
              title: "Success",
              text: "Do you want to print?",
              icon: "success",
              showCancelButton: true,
              confirmButtonText: 'Print'
            }).then((result) => {
              if (result.isConfirmed) {
                Swal.fire({
                  title: "Success",
                  text: "Planning number was create with number " + planningnumber +"",
                  icon: "success",
                  showConfirmButton: true,
                }).then((result) => {
                  if (result.isConfirmed) {
                    submitstartprintworkorder(planningnumber,years)
                  }
                });
              }else {
                Swal.fire({
                  title: "Success",
                  text: "Planning number was create with number " + planningnumber +"",
                  icon: "success",
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload()
                  }
                });
              }
            })
          } else {
            Swal.fire({
              Text: "Data not saved",
              icon: "error",
              showConfirmButton: false,
            })
          }
        },
      });  
    }
  })
}
function selectpernrcreateplanning(pernr,nama) {
  $('#pernrcreateplanning').val(pernr + ' - ' + nama)
  $('#searchpernrcreateplanning').modal('hide')
}
function prosesselectapprovalplanning(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayapprovalplanning": [planningnumber,years] 
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberapprovalplanning').val(data.planning)
        $('#setplanningnumberapprovalplanning').val(data.planning)
        $('#productidapprovalplanning').val(': ' +data.productid)
        $('#productdescriptionapprovalplanning').val(': ' +data.productdecription)
        $('#shiftidapprovalplanning').val(': ' +data.shiftid)   
        $('#batchapprovalplanning').val(': ' +data.batchnumber)
        $('#edapprovalplanning').val(': ' +data.expireddate)
        $('#tanggalkemasapprovalplanning').val(': ' +data.packingdate)            
        $('#batchapprovalplanning').val(': ' +data.batchnumber)
        $('#nomesinapprovalplanning').val(': ' +data.resourceid)
        $('#namamesinapprovalplanning').val(': ')
        $('#mixingapprovalplanning').val(': ' +data.resourceidmix)
        $('#tglmixingapprovalplanning').val(': ' +data.mixingdate)
        $('#qtyapprovalplanning').val(': ' +data.quantity+" "+data.unitofmeasures)
        // $('#uomapprovalplanning').val(': ' +data.unitofmeasures)
        $('#prosesnumberapprovalplanning').val(': ' +data.processnumber)      
        $('#createbyapprovalplanning').val(': ' +data.createdby)
        $('#createonapprovalplanning').val(': ' +data.createdon)
        $('#changedonapprovalplanning').val(': ' +data.changedon)
        $('#changedbyapprovalplanning').val(': ' +data.changedby) 
        $('#yearsapprovalplanning').val(data.years)       
        document.getElementById('simpanapprovalplanning').hidden=false
        $('#searchplanningnumberapprovalplanning').modal('hide')
      }
    }
  })
}
function selectpernrapprovalplanning(pernr,nama) {
  $('#approvedbyapprovalplanning').val(pernr + ' - ' + nama)
  $('#searchapprovedbyapprovalplanning').modal('hide')
}
function simpanapprovalplanning(planningnumber) {
  var planningnumber = $('#setplanningnumberapprovalplanning').val()
  var years = $('#yearsapprovalplanning').val()  
  var note = $('#noteapprovalplanning').val()
  var approvalby = $('#approvedbyapprovalplanning').val()
  Swal.fire({
    // title: 'Are you sure?',
    text: "Approve planning number " + planningnumber + "?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Approved'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesapprovalplanning": [planningnumber,note,years,approvalby]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              // title: "Planning Number " + planning,
              text: "Planning Number has been Approved",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function (data) {
              location.reload()  
            }, 1500);
          }
        }
      })
    }
  })
}

// ------------Master Data - Master of Inspection Characteristic---------------
function simpanmic() {
  var mic = $('#micdatamic').val()
  var desc = $('#descdatamic').val()
  var fulldesc = $('#spesifikasidatamic').val()
  var qual = document.getElementById('typequaldatamic').checked
  var quan = document.getElementById('typequandatamic').checked
  if (qual === true) {
    qual = 'X'
    quan=''
  }
  if (quan === true) {
    quan = 'X'
    qual = ''
  }

  if (mic == '' || desc == '' || fulldesc == '') {
    message(3)
    return
  }

  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanmic": [mic,desc,fulldesc,qual,quan]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function (data) {
          location.reload()  
        }, 1500);
      } else {
        Swal.fire({
          text: data,
          icon: "error",
          showConfirmButton: false,
          timer: 1500
        })
      }
    },
  });
}
function changedatamic(mic) {
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "proseschangedatamic": mic
    },
    success: function (data) {
      document.getElementById('micdatamic').disabled=true
      $('#micdatamic').val(data.mic)
      $('#descdatamic').val(data.desc)
      $('#spesifikasidatamic').val(data.fulldesc)
      if (data.qual == 'X') {
          document.getElementById('typequaldatamic').checked = true
      }
      if (data.quan == 'X') {
        document.getElementById('typequandatamic').checked = true
      }
      $('#createondatamic').val(data.createdon)
      $('#createbydatamic').val(data.createdby)
    },
  }); 
}
function deleteddatamic(mic) {
  Swal.fire({
    text: "Delete MIC " + mic +  "?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Batal',
    confirmButtonText: 'Ya, Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeleteddatamic": mic
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function (data) {
              location.reload()  
            }, 1500);
          } else {
            Swal.fire({
              text: data,
              icon: "warning",
              showConfirmButton: false,
              timer: 1500,
            })
          }
        },
      });  
    }
  })
}

// ------------Master Data - Assign Master of Inspection Characteristic---------------
function selectproductassignmic(productid,desc) {
  location.href = linkedip+'/page/mainpage?p=assignmic&x='+productid+'&y='+desc+''
}
function simpanassignmic() {
  var productid = $('#productidassignmic').val()
  var mic = $('#micassignmic').val()

  if (mic == '' || productid == '') {
    message(3)
    return
  }

  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanassignmic": [productid, mic]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function (data) {
          location.reload()  
        }, 1500);
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deleteddataassignmic(productid,mic) {
  Swal.fire({
    text: "Delete assign MIC " + mic + " produk " + productid +" ?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Batal',
    confirmButtonText: 'Ya, Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeleteddataassignmic": [productid,mic]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function (data) {
              location.reload()  
            }, 1500);
          } else {
            Swal.fire({
              text: data,
              icon: "warning",
              showConfirmButton: false,
              timer: 1500,
            })
          }
        },
      });  
    }
  })
}

// -------------Cahnge/Display Planning Pengolahan------------------

function submitstartdisplayplanningpengolahan() {
  var productid = $('#productidstartdisplayplanningpengolahan').val()
  var bets = $('#batchstartdisplayplanningpengolahan').val()
  var maxs = $('#maxshowstartdisplayplanningpengolahan').val()
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessubmitstartdisplayplanningpengolahan": [productid,bets,maxs]
    },
    success: function (data) {
      location.href = linkedip+'/page/mainpage?p=displaydatapengolahan&x='+data.productid+'&y='+data.bets+'&z='+data.maxs+''
    }
  }) 
  // location.href = linkedip+'/page/mainpage?p=displaydatapengolahan&x='+productid+'&y='+bets+'&z='+maxs+''
}
function selectproductidstartdisplayplanningpengolahan(productid) {
  $('#productidstartdisplayplanningpengolahan').val(productid)
  $('#searchprodukstartdisplayplanningpengolahan').modal('hide')
}
function displayplanningpengolahan(planningnumber,years,items,productid,bets) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayplanningpengolahan": [planningnumber,years,items,productid,bets]
    },
    success: function (data) {
      if (data.status == 1) {
          $('#planningnumberdisplaydataplanningpengolahan').val(data.planningnumber)
          $('#yearsdisplaydataplanningpengolahan').val(data.years)
          $('#createdfordisplaydataplanningpengolahan').val(data.createdfor)
          $('#createdondisplaydataplanningpengolahan').val(data.createdon)
          $('#shiftdisplaydataplanningpengolahan').val(data.shift)
          $('#produkiddataplanningpengolahan').val(data.productid)
          $('#batchdataplanningpengolahan').val(bets)
          $('#itemsdataplanningpengolahan').val(data.items)
          $('#insplotdataplanningpengolahan').val(data.ILot)
          $('#inspyearsdataplanningpengolahan').val(data.ILyears)   
          document.getElementById('approvaldisplaydataplanningpengolahan').innerHTML=data.output
          
          $('#showmodaldisplayplanningpengolahan').modal('show')
      }
    },
  });
}
function displaydrymixdatapengolahan() {
  var planningnumber = $('#planningnumberdisplaydataplanningpengolahan').val()
  var years = $('#yearsdisplaydataplanningpengolahan').val()
  var items = $('#itemsdataplanningpengolahan').val()
  var bets = $('#batchdataplanningpengolahan').val()  
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaydrymixdatapengolahan": [planningnumber,years,items,bets]
    },
    success: function (data) {
      if (data.return == 1) {
          document.getElementById('drymixdataplanningpengolahan').innerHTML=data.output
      }
    },
  });
}
function displayqualitydatapengolahan() {
  var planningnumber = $('#planningnumberdisplaydataplanningpengolahan').val()
  var years = $('#yearsdisplaydataplanningpengolahan').val()
  var items = $('#itemsdataplanningpengolahan').val()
  var bets = $('#batchdataplanningpengolahan').val()
  var productid = $('#produkiddataplanningpengolahan').val()
  var insplot = $('#insplotdataplanningpengolahan').val()
  var inspyears = $('#inspyearsdataplanningpengolahan').val()
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayqualitydatapengolahan": [planningnumber,years,items,bets,productid,insplot,inspyears]
    },
    success: function (data) {
      if (data.return == 1) {
          document.getElementById('qualitycontroldataplanningpengolahan').innerHTML=data.output
      }
    },
  });
}
function changepreparehoperdatapengolahan(noproses,table) {
  var planningnumber = $('#planningnumberdisplaydataplanningpengolahan').val()
  var years = $('#yearsdisplaydataplanningpengolahan').val()
  var productid = $('#produkiddataplanningpengolahan').val()
  var batchnumber = $('#batchdataplanningpengolahan').val()
  var value = planningnumber.concat('*',years,'*',productid,'*',batchnumber,'*',noproses,'*',table)
    $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "proseschangepreparehoperdatapengolahan": value
    },
    success: function (data) {
      location.href = linkedip+'/page/mainpage?p=changedatapengolahan&x='+data+''
    }
  })
  
}
function changeuddatapengolahan(noproses,table,insplot,inspyears) {
  var planningnumber = $('#planningnumberdisplaydataplanningpengolahan').val()
  var years = $('#yearsdisplaydataplanningpengolahan').val()
  var productid = $('#produkiddataplanningpengolahan').val()
  var batchnumber = $('#batchdataplanningpengolahan').val()
  var value = planningnumber.concat('*',years,'*',productid,'*',batchnumber,'*',noproses,'*',table,'*',insplot,'*',inspyears)
    $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "proseschangeuddatapengolahan": value
    },
    success: function (data) {
      location.href = linkedip+'/page/mainpage?p=changedatapengolahan&x='+data+''
    }
  })
}
function changeorganoleptisdatapengolahan(noproses,table,insplot,inspyears) {
  var planningnumber = $('#planningnumberdisplaydataplanningpengolahan').val()
  var years = $('#yearsdisplaydataplanningpengolahan').val()
  var productid = $('#produkiddataplanningpengolahan').val()
  var batchnumber = $('#batchdataplanningpengolahan').val()
   var value = planningnumber.concat('*',years,'*',productid,'*',batchnumber,'*',noproses,'*',table,'*',insplot,'*',inspyears)
    $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "proseschangeorganoleptisdatapengolahan": value
    },
    success: function (data) {
      location.href = linkedip+'/page/mainpage?p=changedatapengolahan&x='+data+''
    }
  })
  // alert(noproses)
}
function updateorganoleptis() {
  var planningnumber = $('#setplanningnumberchangepersiapanpengolahan').val()
  var years = $('#yearschangepersiapanpengolahan').val()
  var bets = $('#batchnumberchangepersiapanpengolahan').val()
  var qcname = $('#qcnamechangepersiapanpengolahan').val()
  // var suhu = $('#suhu_persiapanpengolahanchangepengolahan').val()
  var noproses = $('#noproseschangepersiapanpengolahan').val()
  var productid = $('#productidchangepersiapanpengolahan').val()
  var insplot = $('#inspyearschangepersiapanpengolahan').val()
  var inspyears = $('#lotyearschangepersiapanpengolahan').val()

  var lenght = $('#lenght_updateorganoleptis').val()
  var result_1 = [];
  var result_2 = [];
  var result_3 = [];
  var mic = [];
  var keterangan = [];
  for (let i = 1; i < lenght; i++) {
    // MIC
    var mic_value = document.getElementById('MICupdateorganoleptis'+i+'').value

    // 1
    var result_awal = document.getElementById('result_awalupdateorganoleptis'+i+'')
    result_awal = result_awal.checked
    if (result_awal == false) {
      result_awal = document.getElementById('result_awalupdateorganoleptis'+i+'').value
      if (result_awal =='on') {
        result_awal = false
      } 
    }
    result_1[i] = result_awal

    // 2
    var result_tengah = document.getElementById('result_tengahupdateorganoleptis'+i+'')
    result_tengah = result_tengah.checked
    if (result_tengah == false) {
      result_tengah = document.getElementById('result_tengahupdateorganoleptis'+i+'').value
      if (result_tengah =='on') {
        result_tengah = false
      } 
    }

    // 3
    var result_akhir = document.getElementById('result_akhirupdateorganoleptis'+i+'')
    result_akhir = result_akhir.checked
    if (result_akhir == false) {
      result_akhir = document.getElementById('result_akhirupdateorganoleptis'+i+'').value
      if (result_akhir =='on') {
        result_akhir = false
      } 
    }

    // Keterangan Hasil Tolak

    var keterangan_value = document.getElementById('keteranganhasiltolakupdateorganoleptis'+i+'').value
    result_1[i] = result_awal
    result_2[i] = result_tengah
    result_3[i] = result_akhir
    mic[i] = mic_value
    keterangan[i] = keterangan_value
  }

  
  $.ajax({
    url: "../function/getdata.php",
    // dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesupdateorganoleptis": [insplot,
                                  inspyears,
                                  noproses,
                                  qcname,
                                  result_1,
                                  result_2,
                                  result_3,
                                  lenght,
                                  mic,
                                  keterangan,
                                  planningnumber,
                                  years,
                                  productid,
                                  bets]
    },
    success: function (data) {
      alert(data)
      if (data == 1) {
        Swal.fire({
          text: "Hasil analisa tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.href = linkedip+'/page/mainpage?p=displaydatapengolahan'
          }
        })
      }
    }
  })
}
function updatechangeudcodedatapengolahan(udcode) {
    $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesupdatechangeudcodedatapengolahan": udcode
    },
    success: function (data) {
      if (data != "") {
        $('#udcodedescriptiondatapengolahan').val(data)
      }
    }
  })
  }
function updatechangepersiapanpengolahan() {
  var planningnumber = $('#setplanningnumberchangepersiapanpengolahan').val()
  var operator1 = $('#operator1changepersiapanpengolahan').val()
  var operator2 = $('#operator2changepersiapanpengolahan').val()
  var operator3 = $('#operator3changepersiapanpengolahan').val()
  var pengawas = $('#pengawasproduksichangepersiapanpengolahan').val()
  var bets = $('#batchnumberchangepersiapanpengolahan').val()
  var var1 = $('#parameter1changepersiapanpengolahan').val()
  var var2 = $('#parameter2changepersiapanpengolahan').val()
  var var3 = $('#parameter3changepersiapanpengolahan').val()
  var var4 = $('#parameter4changepersiapanpengolahan').val()
  var var5 = $('#parameter5changepersiapanpengolahan').val()
  var var6 = $('#parameter6changepersiapanpengolahan').val()
  var var7 = $('#parameter7changepersiapanpengolahan').val()
  var var8 = $('#parameter8changepersiapanpengolahan').val()
  var var9 = $('#parameter9changepersiapanpengolahan').val()
  var var10 = $('#parameter10changepersiapanpengolahan').val()
  var years = $('#yearschangepersiapanpengolahan').val()
  var noproses = $('#noproseschangepersiapanpengolahan').val()
  var productid = $('#productidchangepersiapanpengolahan').val()
  if (planningnumber == '' || var2 == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesupdatepersiapanpengolahan": [planningnumber,operator1,operator2,operator3,
      var1,var2,var3,var4,var5,var6,var7,var8,var9,var10,pengawas,years,bets,noproses,productid]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Persiapan proses mixer tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.href = linkedip+'/page/mainpage?p=displaydatapengolahan'
          }
        });
      }
    }
  })
}
function updatechangeqcresultdatapengolahan() {
  var planningnumber = $('#setplanningnumberchangepersiapanpengolahan').val()
  var years = $('#yearschangepersiapanpengolahan').val()
  var bets = $('#batchnumberchangepersiapanpengolahan').val()
  var qcname = $('#qcnamechangepersiapanpengolahan').val()
  var suhu = $('#suhu_persiapanpengolahanchangepengolahan').val()
  var noproses = $('#noproseschangepersiapanpengolahan').val()
  var productid = $('#productidchangepersiapanpengolahan').val()
  if (planningnumber == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesupdatechangeqcresultdatapengolahan": [planningnumber,years,noproses,bets,qcname,suhu,productid]
    },
    success: function (data) {
      // alert(data)
      if (data == 1) {
        Swal.fire({
          text: "Data tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.href = linkedip+'/page/mainpage?p=displaydatapengolahan'
          }
        });
      }
    }
  })
}
function validasikodebahan(e) {
  if (e.which == 13) {
    var kodebahan = $('#kodebahanlistbahancreatepengolahan').val()
    
    $.ajax({
      url: "../function/getdata2.php",
      type: "POST",
      cache: false,
      data: {
        "prosesvalidasikodebahan": kodebahan
      },
      success: function (data) {
        if (data == false) {
          message(6)
          $('#kodebahanlistbahancreatepengolahan').val('')
        }
      },
    });
  }
}
function validasijmlteoritis(kodebahan) {
  var reffcode = $('#koderefflistbahancreatepengolahan').val()
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesvalidasijmlteoritis": [reffcode,kodebahan]
    },
    success: function (data) {
      if (data.return == 1) {
        document.getElementById('jmlteoritislistbahancreatepengolahan').value = data.jmlteoritis
        document.getElementById('jmlteoritislistbahancreatepengolahan').disabled = true
        document.getElementById('jmlkonsumsilistbahancreatepengolahan').value = data.jumlah
        // document.getElementById('jmlkonsumsilistbahancreatepengolahan').disabled = true
        if (data.totjumlah >= data.jmlteoritis) {
          document.getElementById('kodebahanlistbahancreatepengolahan').value='';
          document.getElementById('jmlteoritislistbahancreatepengolahan').value = 1
          document.getElementById('jmlteoritislistbahancreatepengolahan').disabled = false
          document.getElementById('jmlkonsumsilistbahancreatepengolahan').value = 1
          document.getElementById('jmlkonsumsilistbahancreatepengolahan').disabled = false
        }
      }else{
        document.getElementById('jmlteoritislistbahancreatepengolahan').value = 1
        document.getElementById('jmlteoritislistbahancreatepengolahan').disabled = false
        document.getElementById('jmlkonsumsilistbahancreatepengolahan').value = 1
        document.getElementById('jmlkonsumsilistbahancreatepengolahan').disabled = false
      }
    }
  })
}
function prosescreatepengolahan(values) {
  var reff = $('#koderefflistbahancreatepengolahan').val()
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesprosescreatepengolahan": [values,reff]
    },
    success: function (data) {
      if (data.return == 1) {
          $('#urutanproseslistbahancreatepengolahan').val(data.urutanproses)
      }
    },
  });
}
// function missingkodebahan(kodebahan) {
//   $('#kodebahanlistbahancreatepengolahan').val(kodebahan)
//   topFunction()
// }
// ---------------------------------------------------------
// Cahnge/Display Planning Pengemasan

function submitstartdisplayplanningpengemasan() {
  var productid = $('#productidstartdisplayplanningpengemasan').val()
  var bets = $('#batchstartdisplayplanningpengemasan').val()
  var maxs = $('#maxshowstartdisplayplanningpengemasan').val()
  location.href = linkedip+'/page/mainpage?p=displaydatapengemasan&x='+productid+'&y='+bets+'&z='+maxs+''
}
function selectproductidstartdisplayplanningpengemasan(productid) {
  $('#productidstartdisplayplanningpengemasan').val(productid)
  $('#searchprodukstartdisplayplanningpengemasan').modal('hide')
}
function prosesdisplayplanningpengemasan(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayplanningpengemasan": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
          $('#planningnumberdisplaydataplanningpengemasan').val(data.planningnumber)
          $('#yearsdisplaydataplanningpengemasan').val(data.years)
          $('#createdfordisplaydataplanningpengemasan').val(data.createdfor)
          $('#createdondisplaydataplanningpengemasan').val(data.createdon)
          $('#shiftdisplaydataplanningpengemasan').val(data.shift)
          $('#packingdatedisplaydataplanningpengemasan').val(data.packingdate)
          $('#mixingdatedisplaydataplanningpengemasan').val(data.mixingdate)
          document.getElementById('approvaldisplaydataplanningpengemasan').innerHTML=data.output
          $('#showmodaldisplayplanningpengemasan').modal('show')
      }
    },
  });
}
function displayhoperdatapengemasan() {
  var planningnumber = $('#planningnumberdisplaydataplanningpengemasan').val()
  var years = $('#yearsdisplaydataplanningpengemasan').val()
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayhoperdatapengemasan": [planningnumber,years]
    },
    success: function (data) {
      if (data.return == 1) {
          document.getElementById('hoperdataplanningpengemasan').innerHTML=data.output
      }
    },
  });
}
function displaytopackdatapengemasan() {
  var planningnumber = $('#planningnumberdisplaydataplanningpengemasan').val()
  var years = $('#yearsdisplaydataplanningpengemasan').val()
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaytopackdatapengemasan": [planningnumber,years]
    },
    success: function (data) {
      if (data.return == 1) {
          document.getElementById('topackdataplanningpengemasan').innerHTML=data.output
      }
    },
  });
}
function displaypillowdatapengemasan() {
  var planningnumber = $('#planningnumberdisplaydataplanningpengemasan').val()
  var years = $('#yearsdisplaydataplanningpengemasan').val()
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaypillowdatapengemasan": [planningnumber,years]
    },
    success: function (data) {
      if (data.return == 1) {
          document.getElementById('pillowdataplanningpengemasan').innerHTML=data.output
      }
    },
  });
}
function konfirmbatchauto(productid,resep) {
  if (productid == '' ) {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "proseskonfirmbatchauto": [productid,resep]
    },
    success: function (data) {
      // alert(data.test)
      if (data.return == 1) {
        $('#batchcreateplanningpengolahan').val(data.bets)
      }else{
        document.getElementById('modalproductidbetsotomatis').innerHTML= $('#descriptionproductcreateplanningpengolahan').val()
        document.getElementById('modaltotalresepsotomatis').value = $('#jumlahresepcreateplanningpengolahan').val()
        $('#konfirmasilastbatch').modal('show')
      }
    },
  });
  
}
function batchauto(productid) {
  var betsmodal = $('#modalbetsotomatis').val()
  var resep = $('#modaltotalresepsotomatis').val()
    $.ajax({
      url: "../function/getdata2.php",
      dataType: "JSON",
      type: "POST",
      cache: false,
      data: {
        "prosesbatchauto": [productid,betsmodal,resep]
      },
      success: function (data) {
        $('#modalbetsotomatis').val('')
        $('#modaltotalresepsotomatis').val('')
        $('#batchcreateplanningpengolahan').val(data.bets)
        $('#jumlahresepcreateplanningpengolahan').val(resep)
        $('#konfirmasilastbatch').modal('hide')
      },
    }); 
}


// ---------Transaksi - Start Display Planning---------------

function selectproductidstartdisplayplanning(productid,batch) {
  $('#productidstartdisplayplanning').val(productid)
  $('#batchstartdisplayplanning').val(batch)
  $('#searchprodukstartdisplayplanning').modal('hide')
}
function submitstartdisplayplanning() {
  var x1 =  $('#productidstartdisplayplanning').val()
  var x2 =  $('#batchstartdisplayplanning').val()
  var x3 =  $('#packingdatefromstartdisplayplanning').val()
  var x4 =  $('#packingdatetostartdisplayplanning').val()
  var x5 =  $('#mixingdatefromstartdisplayplanning').val()
  var x6 =  $('#mixingdatetostartdisplayplanning').val()
  var x7 =  $('#maxshowstartdisplayplanning').val()

    var x = x1.concat('*',x2,'*',x3,'*',x4,'*',x5,'*',x6,'*',x7)
  location.href = '../page/mainpage?p=displayplanning&v='+ x +''
}
function prosesdisplayplanning(prosestype,planningnumber,years) {
    $.ajax({
      url: "../function/getdata.php",
      dataType: "JSON",
      type: "POST",
      cache: false,
      data: {
        "prosesdisplayplanningnumber": [prosestype,planningnumber,years]
      },
      success: function (data) {
        if (data.status == 1 && data.prosestype == 'create_planning') {
          $('#numberdisplayplanning').val(data.planning)
          $('#yearsdisplayplanning').val(data.years)
          $('#productiddisplayplanning').val(data.productid)
          $('#batchdisplayplanning').val(data.batchnumber)
          $('#expireddatedisplayplanning').val(data.expireddate)
          $('#tglmixingdisplayplanning').val(data.mixingdate)
          $('#tglkemasdisplayplanning').val(data.packingdate)
          $('#shiftdisplayplanning').val(data.shiftid)
          $('#qtydisplayplanning').val(data.quantity)
          $('#uomdisplayplanning').val(data.unitofmeasures)
          $('#prosesnumberdisplayplanning').val(data.processnumber)
          $('#notongdisplayplanning').val(data.tong)      
          $('#kodemesindisplayplanning').val(data.resourceid)
          $('#kodemesinmixingdisplayplanning').val(data.resourceidmix)  
          $('#createbydisplayplanning').val(data.createdby)
          $('#createonisplayplanning').val(data.createdon)
          $('#changedondisplayplanning').val(data.changedon)
          $('#changedbydisplayplanning').val(data.changedby)    
          $('#statusapprovaldisplayplanning').val(data.statusapproval)
          if (data.statusapproval == 'Approved') {
            document.getElementById('savechangeplanning').hidden=true
          }else{
            document.getElementById('savechangeplanning').hidden=false
          }
          document.getElementById('approvalplanningpengemasan').innerHTML=data.output
          $('#modaldisplayplanning').modal('show')
        }else if (data.status == 1 && data.prosestype == 'planning_pengolahan') {
          $('#planningnumberdisplayplanningpengolahan').val(data.planningnumber)
          $('#yearsdisplayplanningpengolahan').val(data.years)
          $('#createdfordisplayplanningpengolahan').val(data.createdfor)
          $('#createdondisplayplanningpengolahan').val(data.createdon)
          $('#shiftdisplayplanningpengolahan').val(data.shift)
          document.getElementById('approvalplanningpengolahan').innerHTML=data.output
          document.getElementById('listbahan1').innerHTML=data.output1  
          $('#modaldisplayplanning2').modal('show')
        }
      },
    });
}
function updatejmlprosesdisplaypengolahan(indexrow,jmlproses) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesupdatejmlprosesdisplaypengolahan": [indexrow,jmlproses]
        },
      })
}
function updateproduksiplanningdisplayplanning() {
  var planning = $('#numberdisplayplanning').val()
  var years = $('#yearsdisplayplanning').val()
  var productid = $('#productiddisplayplanning').val()
  var shiftid = $('#shiftdisplayplanning').val()
  var batch = $('#batchdisplayplanning').val()
  var ed = $('#expireddatedisplayplanning').val()
  var kodemesin = $('#kodemesindisplayplanning').val()
  var tglkemas = $('#tglkemasdisplayplanning').val()
  var mixing = $('#kodemesinmixingdisplayplanning').val()
  var tglmixing = $('#tglmixingdisplayplanning').val()
  var qty = $('#qtydisplayplanning').val()
  var uom = $('#uomdisplayplanning').val()
  var prosesnumber = $('#prosesnumberdisplayplanning').val()
  Swal.fire({
    title: 'Are you sure',
    text: "Update data production planning?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Update it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          prosesupdateproduksiplanningdisplayplanning: [planning, 
            productid,shiftid,batch,ed,kodemesin,tglkemas,mixing,tglmixing,qty,uom,prosesnumber,years]
        },
        success: function (dataupdate) {
          if (dataupdate == 1) {
            Swal.fire({
              title: "Planning Number " + planning,
              text: "Data has been updated",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()  
            }, 1500);
          }
        }
      })
    }
  })
}
// function prosesapprovalplanning(planningnumber) {
//   Swal.fire({
//     // title: 'Are you sure?',
//     text: "Approve planning number " + planningnumber + "?",
//     icon: 'question',
//     showCancelButton: true,
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Approved'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       $.ajax({
//         url: "../function/getdata.php",
//         type: "POST",
//         cache: false,
//         data: {
//           prosesapprovalplanning: planningnumber
//         },
//         success: function (data) {
//           if (data == 1) {
//             Swal.fire({
//               // title: "Planning Number " + planning,
//               text: "Planning Number has been Approved",
//               icon: "success",
//               showConfirmButton: false,
//             })
//             setTimeout(function (data) {
//               location.reload()  
//             }, 1500);
//           }
//         }
//       })
//     }
//   })
// }
function submitstartdisplaydata(planningnumber) {
    var x =  $('#nomorplanningdisplaydata').val()
    var y =  $('#yeardisplaydata').val() 
    location.href = '../page/mainpage?p=showdisplaydata&v='+ x +'&&y='+y+''
}
function prosesselectdisplaydata(planningnumber,years) {
  $('#nomorplanningdisplaydata').val(planningnumber)
  $('#yeardisplaydata').val(years)
  $('#searchplanningdisplaydata').modal('hide') 
}
function submitproductdisplayplanning(productid,description) {
  $('#productiddisplayplanning').val(productid)
  $('#descriptionproductdisplayplanning').val(description)
  $('#listprodukdisplayplanning').modal('hide')
  $('#modaldisplayplanning').modal('show')
}
function submitmachinedisplayplanning(resourceid) {
  $('#kodemesindisplayplanning').val(resourceid)
  $('#listmesindisplayplanning').modal('hide')
  $('#modaldisplayplanning').modal('show')
}
function submitmixingdisplayplanning(resourceid) {
  $('#kodemesinmixingdisplayplanning').val(resourceid)
  $('#listmixingdisplayplanning').modal('hide')
  $('#modaldisplayplanning').modal('show')
}
function submitshiftdisplayplanning(shiftid) {
  $('#shiftdisplayplanning').val(shiftid)
  $('#listshiftdisplayplanning').modal('hide')
  $('#modaldisplayplanning').modal('show')
}

// --------------Transaksi - Print Work Order---------------------

function submitstartprintworkorder(planningnumber,years) {
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
  // if (act == 0) {
    window.open ("../page/production/planning/form/print_workorder.php?n='"+planningnumber+"' && y='"+years+"'");
  // }else{
  //   location.href= "../page/production/planning/form/print_workorder.php?n='"+planningnumber+"' && r='"+act+"'";
  // }
  
  location.reload()
}
function prosesselectworkorder(planningnumber,years) {
  $('#nomorplanningworkorder').val(planningnumber)
  $('#yearplanningworkorder').val(years)
  $('#searchplanningworkorder').modal('hide') 
}

// --------------Transaksi - Print Label Manual---------------------

function selectproductprintlabelbahan(productid,desc) {
  $('#produkidprintlabelbahan').val(productid)
  $('#produkdescprintlabelbahan').val(desc)
  $('#searchprodukprintlabelbahan').modal('hide')
}
function simpanprintlabelbahan() {
  var produk = $('#produkidprintlabelbahan').val()
  var kodebahan = $('#kodebahanprintlabelbahan').val()
  var betsbahan = $('#batchbahanprintlabelbahan').val()

  var validasikodebahan = document.getElementById('iconprintlabelbahan').hidden

  if (produk == '' || kodebahan == '' || betsbahan == '') {
      missingparameter()
      return
  }

  if (validasikodebahan == true) {
    message(8)
    return
  }

  $('#searchmodalreasonprint').modal('show')
  
}
function showprintlabelbahan() {
  var produk = $('#produkidprintlabelbahan').val()
  var kodebahan = $('#kodebahanprintlabelbahan').val()
  var betsbahan = $('#batchbahanprintlabelbahan').val()
  var noidentitas1 = $('#identitasbahan1printlabelbahan').val()
  var noidentitas2 = $('#identitasbahan2printlabelbahan').val()
  var nokantong = $('#nomorkantongprintlabelbahan').val()
  var totalkantong = $('#totalkantongprintlabelbahan').val()
  var reasonprint = $('#reasonprintlabelmanual').val()
  $.ajax({
    url: "../function/getdata2.php",
    // dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesshowprintlabelbahan": [kodebahan,
        noidentitas1,
        noidentitas2,
        produk,
        betsbahan,
        nokantong,
        totalkantong,
        reasonprint
      ]
    },
    success: function (data) {
      // alert(data)
      if (data == 1) {
        var x = produk.concat('*',kodebahan,'*',betsbahan,'*',noidentitas1,'*',noidentitas2,'*',nokantong,'*',totalkantong,'*',reasonprint)
        window.open ("../page/production/planning/form/print_labelbahanmanual?x="+x+"");
        $('#searchmodalreasonprint').modal('hide')
      }
    }
  })
}
function cekkodebahan(kodebahan) {
  document.getElementById('iconprintlabelbahan').hidden=true
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosesvalidasikodebahan": kodebahan
    },
    success: function (data) {
      if (data == 1) {
        document.getElementById('iconprintlabelbahan').hidden=false
      }
    }
  })
}
// --------------Transaksi - Persiapan Hoper----------------------

function prosesselectpersiapanhoper(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaypersiapanhoper": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberpersiapanhoper').val(data.planning)
        $('#setplanningnumberpersiapanhoper').val(data.planning)
        $('#productidpersiapanhoper').val(': ' +data.productid)
        $('#productdescriptionpersiapanhoper').val(': ' +data.productdecription)
        $('#shiftidpersiapanhoper').val(': ' +data.shiftid)   
        $('#batchpersiapanhoper').val(': ' +data.batchnumber)
        $('#edpersiapanhoper').val(': ' +data.expireddate)
        $('#tanggalkemaspersiapanhoper').val(': ' +data.packingdate)            
        $('#batchpersiapanhoper').val(': ' +data.batchnumber)
        $('#nomesinpersipanhoper').val(': ' +data.resourceid)
        $('#namamesinpersiapanhoper').val(': ')
        $('#mixingpersiapanhoper').val(': ' +data.resourceidmix)
        $('#tglmixingpersiapanhoper').val(': ' +data.mixingdate)
        $('#qtypersiapanhoper').val(': ' +data.quantity+" "+data.unitofmeasures)
        // $('#uompersiapanhoper').val(': ' +data.unitofmeasures)
        $('#prosesnumberpersiapanhoper').val(': ' +data.processnumber)      
        $('#createbydisplayplanning').val(': ' +data.createdby)
        $('#createonisplayplanning').val(': ' +data.createdon)
        $('#changedondisplayplanning').val(': ' +data.changedon)
        $('#changedbydisplayplanning').val(': ' +data.changedby)      
        $('#parameter2rhpersiapanhoper').val(data.rh)
        $('#parameter2suhupersiapanhoper').val(data.suhu)

        $('#parameter5_1persiapanhoper').val(data.standardroll)
        $('#parameter5_2persiapanhoper').val(data.batchnumber)
        $('#parameter5_3persiapanhoper').val(data.mixingdate)
        $('#parameter5_4persiapanhoper').val(data.expireddate)
        $('#yearspersiapanhoper').val(data.years)

        $('#searchplanningnumberpersiapanhoper').modal('hide')
      }
    }
  })
}
function submitoperatorpersiapanhoper(operatornumber,nama) {
  if (operatornumber == 'operator1') {
    $('#operator1persiapanhoper').val(nama)
    $('#searchoperator1persiapanhoper').modal('hide')
  }else if(operatornumber == 'operator2'){
    $('#operator2persiapanhoper').val(nama)
    $('#searchoperator2persiapanhoper').modal('hide')   
  }else{
    $('#pengawasproduksipersiapanhoper').val(nama)
    $('#searchpengawasproduksipersiapanhoper').modal('hide') 
  }
}
function simpanpersiapanhopper() {
  var planningnumber = $('#setplanningnumberpersiapanhoper').val()
  var operator1 = $('#operator1persiapanhoper').val()
  var operator2 = $('#operator2persiapanhoper').val()
  var pengawas = $('#pengawasproduksipersiapanhoper').val()
  var var1 = $('#parameter1persiapanhoper').val()
  var var2 = $('#parameter2rhpersiapanhoper').val()
  var var2_1 = $('#parameter2suhupersiapanhoper').val()
  var var3 = $('#parameter3persiapanhoper').val()
  var var4 = $('#parameter4persiapanhoper').val()
  var var5 = $('#parameter5persiapanhoper').val()
  // var var5_1 = $('#parameter5_1persiapanhoper').val()
  var var5_2 = $('#parameter5_2persiapanhoper').val()
  var var5_3 = $('#parameter5_3persiapanhoper').val()
  var var5_4 = $('#parameter5_4persiapanhoper').val()
  var var6 = $('#parameter6persiapanhoper').val()
  var var7 = $('#parameter7persiapanhoper').val()
  var var8 = $('#parameter8persiapanhoper').val()
  var years = $('#yearspersiapanhoper').val()
  if (planningnumber == '' || var2 =='' || var2_1 =='') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanpersiapanhoper": [planningnumber,operator1,operator2,
      var1,var2,var2_1,var3,var4,var5,var5_2,var5_3,var5_4,var6,var7,var8,pengawas,years]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Persiapan proses hoper tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  })
}

// ----------------Transaksi - Prepare Topack-------------------

function prosesselectpersiapatopack(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaypersiapantopack": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberpersiapantopack').val(data.planning)
        $('#setplanningnumberpersiapantopack').val(data.planning)
        $('#productidpersiapantopack').val(': ' +data.productid)
        $('#productdescriptionpersiapantopack').val(': ' +data.productdecription)
        $('#shiftidpersiapantopack').val(': ' +data.shiftid)   
        $('#batchpersiapantopack').val(': ' +data.batchnumber)
        $('#edpersiapantopack').val(': ' +data.expireddate)
        $('#tanggalkemaspersiapantopack').val(': ' +data.packingdate)            
        $('#batchpersiapantopack').val(': ' +data.batchnumber)
        $('#nomesinpersiapantopack').val(': ' +data.resourceid)
        $('#namamesinpersiapantopack').val(': ')
        $('#mixingpersiapantopack').val(': ' +data.resourceidmix)
        $('#tglmixingpersiapantopack').val(': ' +data.mixingdate)
        $('#qtypersiapantopack').val(': ' +data.quantity+" "+data.unitofmeasures)
        // $('#uompersiapantopack').val(': ' +data.unitofmeasures)
        $('#prosesnumberpersiapantopack').val(': ' +data.processnumber)      
        $('#createbydisplayplanning').val(': ' +data.createdby)
        $('#createonisplayplanning').val(': ' +data.createdon)
        $('#changedondisplayplanning').val(': ' +data.changedon)
        $('#changedbydisplayplanning').val(': ' +data.changedby)
        $('#parameter2rhpersiapantopack').val(data.rh)
        $('#parameter2suhupersiapantopack').val(data.suhu)
        $('#yearspersiapantopack').val(data.years)

        $('#parameter5_1persiapantopack').val(data.productid)
        $('#parameter5_2persiapantopack').val(data.batchnumber)
        $('#parameter5_3persiapantopack').val(data.mixingdate)
        $('#parameter5_4persiapantopack').val(data.expireddate)
        $('#searchplanningnumberpersiapantopack').modal('hide')
      }
    }
  })
}
function simpanpersiapantopack() {
  var planningnumber = $('#setplanningnumberpersiapantopack').val()
  var operator1 = $('#operator1persiapantopack').val()
  var operator2 = $('#operator2persiapantopack').val()
  var var1 = $('#parameter1persiapantopack').val()
  var var2 = $('#parameter2rhpersiapantopack').val()
  var var2_1 = $('#parameter2suhupersiapantopack').val()
  var var3 = $('#parameter3persiapantopack').val()
  var var4 = $('#parameter4persiapantopack').val()
  var var5 = $('#parameter5persiapantopack').val()
  var var5_1 = $('#parameter5_1persiapantopack').val()
  var var5_2 = $('#parameter5_2persiapantopack').val()
  var var5_3 = $('#parameter5_3persiapantopack').val()
  var var5_4 = $('#parameter5_4persiapantopack').val()
  var var6 = $('#parameter6persiapantopack').val()
  var var7 = $('#parameter7persiapantopack').val()
  var var8 = $('#parameter8persiapantopack').val()
  var pengawas = $('#pengawasproduksipersiapantopack').val()
  var years = $('#yearspersiapantopack').val()
  if (planningnumber == '' || var2 == '' || var2_1 =='') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanpersiapantopack": [planningnumber,operator1,operator2,
      var1,var2,var2_1,var3,var4,var5,var5_1,var5_2,var5_3,var5_4,var6,var7,var8,pengawas,years]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Persiapan proses topack tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  })
}
function submitoperatorpersiapantopack(operatornumber,nama) {
  if (operatornumber == 'operator1') {
    $('#operator1persiapantopack').val(nama)
    $('#searchoperator1persiapantopack').modal('hide')
  }else if(operatornumber == 'operator2'){
    $('#operator2persiapantopack').val(nama)
    $('#searchoperator2persiapantopack').modal('hide')   
  }else{
    $('#pengawasproduksipersiapantopack').val(nama)
    $('#searchpengawasproduksipersiapantopack').modal('hide') 
  }
}

// ------Transaksi - Prepare Pengolahan------

function submitoperatorpersiapanpengolahan(operatornumber,nama) {
  if (operatornumber == 'operator1') {
    $('#operator1persiapanpengolahan').val(nama)
    $('#searchoperator1persiapanpengolahan').modal('hide')
  }else if(operatornumber == 'operator2'){
    $('#operator2persiapanpengolahan').val(nama)
    $('#searchoperator2persiapanpengolahan').modal('hide')   
  }else if(operatornumber == 'operator3'){
    $('#operator3persiapanpengolahan').val(nama)
    $('#searchoperator3persiapanpengolahan').modal('hide')  
  }else{
    $('#pengawasproduksipersiapanpengolahan').val(nama)
    $('#searchpengawasproduksipersiapanpengolahan').modal('hide') 
  }
}
function prosesselectpersiapanpengolahan(planningnumber,years,batch,prodctid,noproses,reffcode) {
  // alert(noproses)
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaypersiapanpengolahan": [planningnumber,years,batch,prodctid,noproses]
    },
    success: function (data) {
      if (data.status == 1) {
        showdatabahanpersiapanpengolahan(planningnumber,years,batch,prodctid,noproses,reffcode)
        // document.getElementById('settingpreparemixer').innerHTML=data.output
        $('#planningnumberpersiapanpengolahan').val(data.planning)
        $('#setplanningnumberpersiapanpengolahan').val(data.planning)
        $('#productidpersiapanpengolahan').val(': ' +data.productid)
        $('#productdescriptionpersiapanpengolahan').val(': ' +data.productdecription)
        $('#shiftidpersiapanpengolahan').val(': ' +data.shiftid)   
        $('#batchpersiapanpengolahan').val(': ' +data.batchnumber)
        $('#edpersiapanpengolahan').val(': ' +data.expireddate)
        $('#tanggalkemaspersiapanpengolahan').val(': ' +data.packingdate)            
        $('#batchpersiapanpengolahan').val(': ' +data.batchnumber)
        $('#nomesinpersiapanpengolahan').val(': ' +data.resourceid)
        $('#namamesinpersiapanpengolahan').val(': ')
        $('#mixingpersiapanpengolahan').val(': ' +data.resourceidmix)
        $('#tglmixingpersiapanpengolahan').val(': ' +data.mixingdate)
        $('#qtypersiapanpengolahan').val(': ' +data.quantity)
        // $('#uompersiapanpengolahan').val(': ' +data.unitofmeasures)
        $('#prosesnumberpersiapanpengolahan').val(': ' +data.processnumber)      
        $('#createbydisplayplanning').val(': ' +data.createdby)
        $('#createonisplayplanning').val(': ' +data.createdon)
        $('#changedondisplayplanning').val(': ' +data.changedon)
        $('#changedbydisplayplanning').val(': ' +data.changedby)
        // $('#parameter2rhpersiapanpengolahan').val(data.rh)
        $('#parameter2suhupersiapanpengolahan').val(data.suhu)
        $('#yearspersiapanpengolahan').val(data.years)
        $('#reffcodepersiapanpengolahan').val(': ' +reffcode)
        

        $('#parameter5_1persiapanpengolahan').val(data.productid)
        $('#parameter5_2persiapanpengolahan').val(data.batchnumber)
        $('#parameter5_3persiapanpengolahan').val(data.mixingdate)
        $('#parameter5_4persiapanpengolahan').val(data.expireddate)
        $('#searchplanningnumberpersiapanpengolahan').modal('hide')
      }
    }
  })
}
function simpanpersiapanpengolahan() {
  var inputbahan = $('#inputbahanpreparepengolahan').val()
  var planningnumber = $('#setplanningnumberpersiapanpengolahan').val()
  var operator1 = $('#operator1persiapanpengolahan').val()
  var operator2 = $('#operator2persiapanpengolahan').val()
  var operator3 = $('#operator3persiapanpengolahan').val()
  var bets = $('#batchpersiapanpengolahan').val()
  var var1 = $('#parameter1persiapanpengolahan').val()
  var var2 = $('#parameter2suhupersiapanpengolahan').val()
  var var3 = $('#parameter3persiapanpengolahan').val()
  var var4 = $('#parameter4persiapanpengolahan').val()
  var var5 = $('#parameter5persiapanpengolahan').val()
  var var6 = $('#parameter6persiapanpengolahan').val()
  var var7 = $('#parameter7persiapanpengolahan').val()
  var var8 = $('#parameter8persiapanpengolahan').val()
  var var9 = $('#parameter8persiapanpengolahan').val()
  var var10 = $('#parameter8persiapanpengolahan').val()
  var pengawas = $('#pengawasproduksipersiapanpengolahan').val()
  var years = $('#yearspersiapanpengolahan').val()
  var noproses = $('#noprosespersiapanpengolahan').val()
  var productid = $('#productidpersiapanpengolahan').val()
  if (planningnumber == '' || var2 == '' || inputbahan == 1) {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanpersiapanpengolahan": [planningnumber,operator1,operator2,operator3,
      var1,var2,var3,var4,var5,var6,var7,var8,var9,var10,pengawas,years,bets,noproses,productid]
    },
    success: function (data) {
      // alert(data)
      if (data == 1) {
        Swal.fire({
          text: "Persiapan proses mixer tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  })
}
function scanbahanmanualpreparepengolahan() {
  var planningnumber = $('#setplanningnumberpersiapanpengolahan').val()
  var years = $('#yearspersiapanpengolahan').val()
  var productid = $('#productidpersiapanpengolahan').val().slice(2)
  var productdescriptions = $('#productdescriptionpersiapanpengolahan').val().slice(2)
  var batchnumber = $('#batchpersiapanpengolahan').val().slice(2)
  var noproses = $('#noprosespersiapanpengolahan').val()

  $('#planningnumbermanualpersiapanpengolahan').val(planningnumber)
  $('#yearsmanualpersiapanpengolahan').val(years)
  $('#productidmanualpersiapanpengolahan').val(productid)
  $('#productdescmanualpersiapanpengolahan').val(productdescriptions)
  $('#batchnumbermanualpersiapanpengolahan').val(batchnumber)
  $('#noprosesmanualpersiapanpengolahan').val(noproses)
  
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesscanbahanmanualpreparepengolahan": productid
    },
    success: function (data) {
      // alert(data.output)
      $('#kodebahanmanualpersiapanpengolahan').val(data.output)
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosesgetbatchlabelmanualpreparepengolahan": [planningnumber,years,productid,batchnumber]
        },
        success: function (data) {
          $('#batchlabelmanualpersiapanpengolahan').val(data.batchlabel)
          $('#scanbahanmanualpersiapanpengolahan').modal('show')
        }
      })  
    }
  })

  
}
function simpanmanualbahanpersiapanpengolahan() {
  var planningnumber = $('#setplanningnumberpersiapanpengolahan').val()
  var years = $('#yearspersiapanpengolahan').val()
  var productid = $('#productidpersiapanpengolahan').val().slice(2)
  var batchnumber = $('#batchpersiapanpengolahan').val().slice(2)
  var noproses = $('#noprosespersiapanpengolahan').val()
  var reffcode = $('#reffcodepersiapanpengolahan').val().slice(2)

  
  var identitas1 = $('#identitas1manualpersiapanpengolahan').val()
  var identitas2 = $('#identitas2manualpersiapanpengolahan').val()
  var batchlabel = $('#batchlabelmanualpersiapanpengolahan').val()
  var nokantong = $('#noprosespersiapanpengolahan').val()
  var totalkantong = $('#noprosespersiapanpengolahan').val()
  var kodebahan = $('#kodebahanmanualpersiapanpengolahan').val()
  
  if (planningnumber == '' || years=='' || kodebahan == '' || identitas1 == '') {
    missingparameter()
    return
  }

  $.ajax({
    url: "../function/getdata.php",
    // dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanmanualbahanpersiapanpengolahan": [planningnumber,
        years,
        productid,
        batchnumber,
        noproses,
        identitas1,
        identitas2,
        batchlabel,
        nokantong,
        totalkantong,
        reffcode,
        kodebahan]
    },
    success: function (data) {
      if (data == 1) {
        $('#scanbahanmanualpersiapanpengolahan').modal('hide')
        showdatabahanpersiapanpengolahan(planningnumber,years,batchnumber,productid,noproses,reffcode)
      }else{
        Swal.fire({
          text: data,
          icon: "info",
          showConfirmButton: true,
        })
      }
    }
  })  
}
function showdatabahanpersiapanpengolahan(planningnumber,years,batch,prodctid,noproses,reffcode) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesshowdatabahanpersiapanpengolahan": [planningnumber,years,batch,prodctid,noproses,reffcode]
    },
    success: function (data) {
      if (data.return == 1) {
        document.getElementById('settingpreparemixer').innerHTML=data.output
      }
    }
  }) 
}

// function checksettingpreparemixing(indexrow,value) {
//   if (value == true) {
//     value = '0.5'
//   }else if (value == false) {
//     value = '1'
//   }
//   $.ajax({
//     url: "../function/getdata.php",
//     type: "POST",
//     cache: false,
//     data: {
//       "proseschecksettingpreparemixing": [indexrow,value]
//     },
//   })
// }

// ------Transaksi - Proses Hopper------
function submitpengawasproses(jenisproses,nama) {
  if (jenisproses == 'hoper') {
    $('#pengawasproduksiproseshoper').val('')
    $('#pengawasproduksiproseshoper').val(nama)
    $('#searchpengawasproduksiproseshoper').modal('hide')
  }
}
function prosesselectproseshoper(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayproseshoper": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberproseshoper').val(data.planning)
        $('#setplanningnumberproseshoper').val(data.urlcodes)
        // document.getElementById('setplanningnumberproseshoper').hidden=true
        $('#productidproseshoper').val(': ' +data.productid)
        $('#productdescriptionproseshoper').val(': ' +data.productdecription)
        $('#shiftidproseshoper').val(': ' +data.shiftid)   
        $('#batchproseshoper').val(': ' +data.batchnumber)
        $('#edproseshoper').val(': ' +data.expireddate)
        $('#tanggalkemasproseshoper').val(': ' +data.packingdate)            
        $('#batchproseshoper').val(': ' +data.batchnumber)
        $('#nomesinproseshoper').val(': ' +data.resourceid)
        $('#namamesinproseshoper').val(': ')
        $('#mixingproseshoper').val(': ' +data.resourceidmix)
        $('#tglmixingproseshoper').val(': ' +data.mixingdate)
        $('#qtyproseshoper').val(': ' +data.quantity+" "+data.unitofmeasures)
        $('#jumlahprosesproseshoper').val(': ' +data.processnumber)      
        $('#createbydisplayplanning').val(': ' +data.createdby)
        $('#createonisplayplanning').val(': ' +data.createdon)
        $('#changedondisplayplanning').val(': ' +data.changedon)
        $('#changedbydisplayplanning').val(': ' +data.changedby)
        $('#yearsproseshoper').val(data.years)
        document.getElementById('scanbarcodeproseshoper').focus();
        // document.getElementById("prosesnumberproseshoper").value= data.processnumber;
        // document.getElementById("prosesnumberproseshoper").max=data.processnumber
        document.getElementById("btn_saveproseshoper").hidden=false 
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "showtableproseshoper": [(data.planning),years]
          },
          success: function (data) {
              document.getElementById('content_page').innerHTML=data
              $('#searchplanningnumberproseshoper').modal('hide')
          }
        })
      }
    }
  })
}
function submitproseshopper(e) {
      if (e.which == 13) {
        let text = document.getElementById('scanbarcodeproseshoper').value
        const myArray = text.split(",");
        var planningnumber = $('#setplanningnumberproseshoper').val()
        var years = $('#yearsproseshoper').val()
        var planingpengolahan = myArray[2];
        var yearpengolahan = myArray[3]
        var item = myArray[4]
        var product = myArray[5]
        var batch = myArray[6]
        var noproses = myArray[7]
        var container = myArray[8] 
        var qty = myArray[9]
        var insplot = myArray[10]
        var inpsyear = myArray[11]     
        
        document.getElementById('scanbarcodeproseshoper').value=''
        if (planningnumber == '' || noproses == '' || container =='' || qty =='') {
          missingparameter()
          return
        }
        $.ajax({
            url: "../function/getdata.php",
            type: "POST",
            cache: false,
            data: {
              "prosescektongproseshoper": [planningnumber,years,product,batch,noproses]
            },
            success: function (data) {
              if (data == 1) {
                $.ajax({
                  url: "../function/getdata.php",
                  type: "POST",
                  cache: false,
                  data: {
                    "prosessubmitproseshoper": [planningnumber,years,noproses,
                    container,qty,insplot,inpsyear,product,batch,item,planingpengolahan,yearpengolahan]
                  },
                  success: function (data) {
                    if (data == 1) {       
                      $.ajax({
                        url: "../function/getdata.php",
                        type: "POST",
                        cache: false,
                        data: {
                          "showtableproseshoper": [planningnumber,years]
                        },
                        success: function (data) {
                          document.getElementById('content_page').innerHTML=data
                        }
                      })
                    }else if (data == 4) {
                      Swal.fire({
                        text: "Stok Hopper Deficit!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Abaikan',
                        cancelButtonText: 'Keluar'
                      }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                              url: "../function/getdata.php",
                              type: "POST",
                              cache: false,
                              data: {
                                "prosessubmitproseshoper2": [planningnumber,years,noproses,
                                container,qty,insplot,inpsyear,product,batch,item,planingpengolahan,yearpengolahan]
                              },
                              success: function (data) {
                                if (data == 1) {       
                                  $.ajax({
                                    url: "../function/getdata.php",
                                    type: "POST",
                                    cache: false,
                                    data: {
                                      "showtableproseshoper": [planningnumber,years]
                                    },
                                    success: function (data) {
                                      document.getElementById('content_page').innerHTML=data
                                    }
                                  })
                                }
                              }
                              }) 
                        }
                      })
                    }else{
                      Swal.fire({
                        text: data,
                        icon: "info",
                        showConfirmButton: false,
                        timer: 1500
                      })
                    }
                  },
                });        
              }else if (data == 'wrong') {
                  Swal.fire({
                    text: 'Label Tidak Di Kenali',
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                  })
              }else {
                Swal.fire({
                  text: "Anda sudah mencapai batas timbang sebanyak " + data + ". Tetap lakukan simpan data ?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, simpan',
                  cancelButtonText: 'Batal'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $.ajax({
                      url: "../function/getdata.php",
                      type: "POST",
                      cache: false,
                      data: {
                        "prosessubmitproseshoper": [planningnumber,years,noproses,
                          container,qty,insplot,inpsyear,product,batch,item,planingpengolahan,yearpengolahan]
                      },
                      success: function (data) {
                        if (data == 1) {       
                          $.ajax({
                            url: "../function/getdata.php",
                            type: "POST",
                            cache: false,
                            data: {
                              "showtableproseshoper": [planningnumber,years]
                            },
                            success: function (data) {
                                document.getElementById('content_page').innerHTML=data
                            }
                          })
                        }
                      },
                    });
                  }
                })
              }
            },
          });
      }
}
function deleteproseshoper(planningnumber,prosesnumber,container,years,quantity) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Proses Hoper ",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        dataType: "JSON",
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeleteproseshoper": [planningnumber,prosesnumber,container,years,quantity]
        },
        success: function (data) {
          if (data.statuscode == 1) {
            var planningnumber = data.planningnumber
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                "showtableproseshoper": [planningnumber,years]
              },
              success: function (data) {
                  document.getElementById('content_page').innerHTML=data
              }
            })
          }
        }
      })
    } 
  }) 
}
function changevalueproseshoper(planningnumber,years,processnumber,container,types,value) {
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "proseschangevalueproseshoper": [planningnumber,years,processnumber,container,types,value]
    },
    success: function (data) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "showtableproseshoper": [planningnumber,years]
        },
        success: function (data) {
          document.getElementById('content_page').innerHTML=data
        }
      })
    }
  })
}
function changevalueenterproseshoper(e,planningnumber,years,processnumber,container,types,value) {
  if (e.which == 13) {
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "proseschangevalueenterproseshoper": [planningnumber,years,processnumber,container,types,value]
      },
      success: function (data) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "showtableproseshoper": [planningnumber,years]
          },
          success: function (data) {
            document.getElementById('content_page').innerHTML=data
          }
        })
      }
    })
  }
}
function saveproseshopper() {
  var planningnumber = $('#setplanningnumberproseshoper').val()
  var pengawas = $('#pengawasproduksiproseshoper').val()
  var years = $('#yearsproseshoper').val()
  if (planningnumber == '') {
    missingparameter()
    return
  }
  Swal.fire({
    text: "Save Proses Hoper",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosessimpanproseshoper": [planningnumber,pengawas,years]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Process hoper has been completed ",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data not saved",
              icon: "error",
              showConfirmButton: false,
            })
          }    
        }
      })
    }
  })
}

// ------Transaksi - Engine Set------

function prosesselectenginesettopack(planningnumber,jenistransaksi,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayenginesettopack": [planningnumber,jenistransaksi,years]
    },
    success: function (data) {
      $('#planningnumberenginesettopack').val(data.planning)
      $('#setplanningnumberenginesettopack').val(data.planning)
      document.getElementById('setplanningnumberenginesettopack').hidden=true
      $('#productidenginesettopack').val(': ' +data.productid)
      $('#productdescriptionenginesettopack').val(': ' +data.productdecription)
      $('#shiftidenginesettopack').val(': ' +data.shiftid)   
      $('#batchenginesettopack').val(': ' +data.batchnumber)
      $('#edenginesettopack').val(': ' +data.expireddate)
      $('#tanggalkemasenginesettopack').val(': ' +data.packingdate)            
      $('#batchenginesettopack').val(': ' +data.batchnumber)
      $('#nomesinenginesettopack').val(': ' +data.resourceid)
      $('#namamesinenginesettopack').val(': ')
      $('#mixingenginesettopack').val(': ' +data.resourceidmix)
      $('#tglmixingenginesettopack').val(': ' +data.mixingdate)
      $('#qtyenginesettopack').val(': ' +data.quantity+" "+data.unitofmeasures)
      $('#prosesnumberenginesettopack').val(': ' +data.processnumber)
      $('#yearsenginesettopack').val(data.years)      
      // $('#createbydisplayplanning').val(': ' +data.createdby)
      // $('#createonisplayplanning').val(': ' +data.createdon)
      // $('#changedondisplayplanning').val(': ' +data.changedon)
      // $('#changedbydisplayplanning').val(': ' +data.changedby)


      $('#suhuheaterenginesettopack').val(data.suhuheater)
      $('#suhustoprunenginesettopack').val(data.suhustoprun)
      $('#kecepatanmesinenginesettopack').val(data.kecepatanmesin)
      $('#searchplanningnumberenginesettopack').modal('hide')
      document.getElementById('simpanenginesettopack').hidden=false
    }
  })
}
function simpanenginesettopack(jumlah,stats) {
  var suhu = [];
  var jenispengecekan =[];
  if (document.getElementById('setplanningnumberenginesettopack').value == '') {
      missingplanningnumber()
      return
  }
  for (let i = 1; i < stats; i++) {
    if (document.getElementById('textengineset'+i).checked == false) {
      missingparameter()
      return
    }  
  }
  for (let i = 0; i < jumlah; i++) {
    suhu[i] = document.getElementById('suhu'+i).value;
    jenispengecekan[i] = document.getElementById('jenispengecekanengineset'+i).value;
  }
  var planningnumber = $('#setplanningnumberenginesettopack').val()
  var years = $('#yearsenginesettopack').val() 
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessubmitenginesettopack": [planningnumber,jenispengecekan,suhu,jumlah,years]
    },
    success: function (data) {
      if (data == 1) {       
        Swal.fire({
          text: "Data Engine Set tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    },
  }); 
}

// ----------Transaksi - Rekon Topack------------------

function prosesselectprosestopack(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayprosestopack": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberprosestopack').val(data.planning)
        $('#setplanningnumberprosestopack').val(data.urlcodes)
        document.getElementById('setplanningnumberprosestopack').hidden=false
        $('#productidprosestopack').val(': ' +data.productid)
        $('#productdescriptionprosestopack').val(': ' +data.productdecription)
        $('#shiftidprosestopack').val(': ' +data.shiftid)   
        $('#batchprosestopack').val(': ' +data.batchnumber)
        $('#edprosestopack').val(': ' +data.expireddate)
        $('#tanggalkemasprosestopack').val(': ' +data.packingdate)            
        $('#batchprosestopack').val(': ' +data.batchnumber)
        $('#nomesinprosestopack').val(': ' +data.resourceid)
        $('#namamesinprosestopack').val(': ')
        $('#mixingprosestopack').val(': ' +data.resourceidmix)
        $('#tglmixingprosestopack').val(': ' +data.mixingdate)
        $('#qtyprosestopack').val(': ' +data.quantity+" "+data.unitofmeasures)
        $('#jumlahprosesprosestopack').val(': ' +data.processnumber)
        // 
        $('#hasilteoritisrekontopack').val(data.hasilteoritis)
        $('#hasilnyatarekontopack').val(data.hasilnyata)
        $('#presentaserekontopack').val(data.persentase)
        $('#yearsprosestopack').val(data.years)
        
        document.getElementById('showiconsampling').innerHTML =  data.iconic     
        // $('#createbydisplayplanning').val(': ' +data.createdby)
        // $('#createonisplayplanning').val(': ' +data.createdon)
        // $('#changedondisplayplanning').val(': ' +data.changedon)
        // $('#changedbydisplayplanning').val(': ' +data.changedby)
        // document.getElementById("prosesnumberprosestopack").value= data.processnumber;
        // document.getElementById("prosesnumberprosestopack").max=data.processnumber
        if (data.no_iconic == 1) {
          document.getElementById("btn_saveprosestopack").hidden=false
        } 
        $('#searchplanningnumberprosestopack').modal('hide')  
      }
    }
  })
}
function Getlithoused() {
  Getreject()
  var productid = $('#productidprosestopack').val()
  productid = productid.replace(':','').replace(' ','')
  var counterprinter = $('#counterprinterprosestopack').val()
  if (productid != '') {
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        'prosesgetlithoused': [productid,counterprinter]
      },
      success: function (data) {
        $('#lithoterpakaiprosestopack').val(data)
      }
    })
  }
}
function Getreject() {
  var countermesin = $('#countermesinprosestopack').val()
  var counterprinter = $('#counterprinterprosestopack').val()
  var productid = $('#productidprosestopack').val()
  var hasilteoritis = $('#hasilteoritisrekontopack').val()
  var hasilnyata = $('#hasilnyatarekontopack').val() 
  if (countermesin !='' && productid != '') {
    $('#rusakprosestopack').val(counterprinter- countermesin)
  }
  // $('#hasilnyatarekontopack').val(counterprinter)
  hasilnyatarekontopack()
  
  var persentase = hasilnyata/hasilteoritis *100
  $('#presentaserekontopack').val(persentase.toFixed(3))
  
}
function hasilnyatarekontopack() {
  var countermesin = $('#countermesinprosestopack').val()
  $('#hasilnyatarekontopack').val(countermesin)
}
function saveprosestopack() {
  var planningnumber = $('#setplanningnumberprosestopack').val()
  var years = $('#yearsprosestopack').val()
  var jammulai = $('#jammulaiprosestopack').val()
  var jamselesai = $('#jamselesaiprosestopack').val()
  var countermesin = $('#countermesinprosestopack').val()
  var counterprinter = $('#counterprinterprosestopack').val()
  var lithoterpakai = $('#lithoterpakaiprosestopack').val()

  var samplekebocoran = $('#sampelkebocoranprosestopack').val()
  var retainedsample = $('#retainedsampleprosestopack').val()

  var hasilteoritis = $('#hasilteoritisrekontopack').val()
  var hasilnyata = $('#hasilnyatarekontopack').val()
  var persentase = $('#presentaserekontopack').val()
  var rusak = $('#rusakprosestopack').val()
  var rangehasil = $('#rangehasilrekontopack').val()
  var rangehasil_conv = rangehasil.split("-")
  var bottom_range = persentase - rangehasil_conv[0]
  var top_range = persentase - rangehasil_conv[1]
  if (planningnumber == '' || jammulai =='' || jamselesai =='' ||
   retainedsample == '' || samplekebocoran =='' || countermesin =='' || counterprinter =='') {
    missingparameter()
    return
  }
  if (bottom_range < 0 || top_range > 0) {
    Swal.fire({
      title: 'Persentase Kurang/Lebih dari batas range.',
      text: "Tetap lakukan simpan data?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Simpan'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "prosessimpanprosestopack": [planningnumber,
            jammulai,jamselesai,countermesin,counterprinter,
            lithoterpakai,rusak,
            hasilteoritis,hasilnyata,
            persentase,samplekebocoran,retainedsample,years]
          },
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                title: "Success",
                text: "process topack has been completed ",
                icon: "success",
                showConfirmButton: true,
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload()
                }
              })
            } else {
              Swal.fire({
                Text: "Data not saved",
                icon: "error",
                showConfirmButton: false,
              })
            }    
          }
        })
      }
    })
  }else {
    Swal.fire({
      text: "Save Proses Topack?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "prosessimpanprosestopack": [planningnumber,
            jammulai,jamselesai,countermesin,
            counterprinter,lithoterpakai,
            rusak,hasilteoritis,
            hasilnyata,persentase,samplekebocoran,retainedsample,years]
          },
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                title: "Success",
                text: "process topack has been completed ",
                icon: "success",
                showConfirmButton: true,
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload()
                }
              })
            } else {
              Swal.fire({
                Text: "Data not saved",
                icon: "error",
                showConfirmButton: false,
              })
            }    
          }
        })
      }
    })
  }
}
function downtimerekontopack(proses) {
  var planningnumber = $('#setplanningnumberprosestopack').val()
  var years = $('#yearsprosestopack').val()
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
    document.getElementById('titleplanningnumberrekontopack').innerHTML=planningnumber
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosesshowtabledowntimerekontopack": [planningnumber,years,proses]
      },
      success: function (data) {
        if (data != '') {    
          document.getElementById('table_rekon_topack').innerHTML = data   
          $('#searchdowntimerekontopack').modal('show')
        }
      },
    });   
  
}
function savedowntimerekontopack(proses) {
  var planningnumber = $('#setplanningnumberprosestopack').val()
  var years = $('#yearsprosestopack').val()
  var jam = $('#jamrekontopack').val()
  var permasalahan = $('#permasalahanrekontopack').val()
  var tindakan = $('#tindakanrekontopack').val()
  var hasil = $('#hasilrekontopack').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessavedowntimerekontopack": [planningnumber,
      years,jam,permasalahan,tindakan,hasil,proses]
    },
    success: function (data) {
      $('#permasalahanrekontopack').val('')
      $('#tindakanrekontopack').val('')
      $('#hasilrekontopack').val('')
      if (data == 1) {
        downtimerekontopack('topack')  
      }
    },
  });
}
function deletedowntimerekontopack(planningnumber,years,item,proses) {
  if (proses==2) {
    proses = 'topack'
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesdeletedowntimerekontopack": [planningnumber,years,item,proses]
    },
    success: function (data) {
      $('#permasalahanrekontopack').val('')
      $('#tindakanrekontopack').val('')
      $('#hasilrekontopack').val('')
      if (data == 1) {
        downtimerekontopack('topack')
      }
    },
  }); 
}

// -----------Transaksi - Prepare Pillow Pack-----------------

function submitoperatorpersiapanpillow(operatornumber,nama) {
  if (operatornumber == 'operator1') {
    $('#operator1persiapanpillow').val(nama)
    $('#searchoperator1persiapanpillow').modal('hide')
  }else if (operatornumber == 'operator2') {
    $('#operator2persiapanpillow').val(nama)
    $('#searchoperator2persiapanpillow').modal('hide')   
  }else if (operatornumber == 'operator3') {
    $('#operator3persiapanpillow').val(nama)
    $('#searchoperator3persiapanpillow').modal('hide')   
  }else if (operatornumber == 'operator4') {
    $('#operator4persiapanpillow').val(nama)
    $('#searchoperator4persiapanpillow').modal('hide')   
  }else if (operatornumber == 'operator5') {
    $('#operator5persiapanpillow').val(nama)
    $('#searchoperator5persiapanpillow').modal('hide')   
  }else if (operatornumber == 'operator6') {
    $('#operator6persiapanpillow').val(nama)
    $('#searchoperator6persiapanpillow').modal('hide')   
  }else if (operatornumber == 'produksipengawas') {
    $('#pengawasproduksipersiapanpillow').val(nama)
    $('#searchpengawasproduksipersiapanpillow').modal('hide')   
  }
}
function prosesselectpersiapanpillow(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaypersiapanpillow": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberpersiapanpillow').val(data.planning)
        $('#setplanningnumberpersiapanpillow').val(data.planning)
        $('#productidpersiapanpillow').val(': ' +data.productid)
        $('#productdescriptionpersiapanpillow').val(': ' +data.productdecription)
        $('#shiftidpersiapanpillow').val(': ' +data.shiftid)   
        $('#batchpersiapanpillow').val(': ' +data.batchnumber)
        $('#edpersiapanpillow').val(': ' +data.expireddate)
        $('#tanggalkemaspersiapanpillow').val(': ' +data.packingdate)            
        $('#batchpersiapanpillow').val(': ' +data.batchnumber)
        $('#nomesinpersipanpillow').val(': ' +data.resourceid)
        $('#namamesinpersiapanpillow').val(': ')
        $('#mixingpersiapanpillow').val(': ' +data.resourceidmix)
        $('#tglmixingpersiapanpillow').val(': ' +data.mixingdate)
        $('#qtypersiapanpillow').val(': ' +data.quantity+" "+data.unitofmeasures)
        $('#yearspersipanpillow').val(data.years)
        // $('#uompersiapanpillow').val(': ' +data.unitofmeasures)
        $('#prosesnumberpersiapanpillow').val(': ' +data.processnumber)      
        $('#searchplanningnumberpersiapanpillow').modal('hide')
        document.getElementById('simpanpersiapanpillow').hidden=false
      }
    }
  })
}
function simpanpersiapanpillow(parameters) {
  var planningnumber = $('#setplanningnumberpersiapanpillow').val()
  var operator1 = $('#operator1persiapanpillow').val()
  var operator2 = $('#operator2persiapanpillow').val()
  var operator3 = $('#operator3persiapanpillow').val()
  var operator4 = $('#operator4persiapanpillow').val()
  var operator5 = $('#operator5persiapanpillow').val()
  var operator6 = $('#operator6persiapanpillow').val()
  var satuan_1 = $('#duspersiapanpillow').val()
  var qty_1 = $('#qtyduspreparepillow').val()
  var satuan_2 = $('#brosurpersiapanpillow').val()
  var qty_2 = $('#qtybrosurpersiapanpillow').val()
  var satuan_3 = $('#hangerpersiapanpillow').val()
  var qty_3 = $('#qtyhangerpersiapanpillow').val()
  var satuan_4 = $('#stikerpersiapanpillow').val()
  var qty_4 = $('#qtystikerpersiapanpillow').val()
  var satuan_5 = $('#boxpersiapanpillow').val()
  var qty_5 = $('#qtyboxpersiapanpillow').val()
  var satuan_6 = $('#plastikpersiapanpillow').val()
  var qty_6 = $('#qtyplastikpersiapanpillow').val()
  var pp = $('#pengawasproduksipersiapanpillow').val()
  var years = $('#yearspersipanpillow').val()
  
  var values_parameter=[];
  for (let i = 1; i < parameters; i++) {
    values_parameter[i] = document.getElementById('textpillowpack'+i).checked
  }
  for (let i = 1; i < parameters; i++) {
    if (values_parameter[i] === false) {
      missingstatement()
      return
    }
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessubmitpreparepillow": [planningnumber,
        values_parameter,
        operator1,
        operator2,
        operator3,
        operator4,
        operator5,
        operator6,
      satuan_1,qty_1,
      satuan_2,qty_2,
      satuan_3,qty_3,
      satuan_4,qty_4,
      satuan_5,qty_5,
      satuan_6,qty_6,pp,years]
    },
    success: function (data) {
      if (data == 1) {       
        Swal.fire({
          text: "Data Prepare Pillow Pack tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    },
  }); 
}

// -----------Transaksi - Proses Pillow Pack-----------------

function prosesselectprosespillow(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayprosespillow": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberprosespillow').val(data.planning)
        $('#setplanningnumberprosespillow').val(data.planning)
        $('#productidprosespillow').val(': ' +data.productid)
        $('#productdescriptionprosespillow').val(': ' +data.productdecription)
        $('#shiftidprosespillow').val(': ' +data.shiftid)   
        $('#batchprosespillow').val(': ' +data.batchnumber)
        $('#edprosespillow').val(': ' +data.expireddate)
        $('#tanggalkemasprosespillow').val(': ' +data.packingdate)            
        $('#batchprosespillow').val(': ' +data.batchnumber)
        $('#nomesinprosespillow').val(': ' +data.resourceid)
        $('#namamesinprosespillow').val(': ')
        $('#mixingprosespillow').val(': ' +data.resourceidmix)
        $('#tglmixingprosespillow').val(': ' +data.mixingdate)
        $('#qtyprosespillow').val(': ' +data.quantity+" "+data.unitofmeasures)
        // $('#uomprosespillow').val(': ' +data.unitofmeasures)
        $('#prosesnumberprosespillow').val(': ' +data.processnumber)
        $('#yearsprosespillow').val(data.years) 
        $('#searchplanningnumberprosespillow').modal('hide')
        document.getElementById('simpanprosespillow').hidden=false
      }
    }
  })
}
function simpanprosespillow() {
  var planningnumber = $('#setplanningnumberprosespillow').val()
  var renteng = $('#rentengprosespillow').val()
  var parameter_1 = document.getElementById('text1prosespillowpack').checked
  var parameter_2 = document.getElementById('text2prosespillowpack').checked
  var parameter_3 = document.getElementById('text3prosespillowpack').checked
  var qtyplastik = $('#qtypastikprosespillow').val()
  var jam_mulai = $('#jammulaiprosespillow').val()
  var jam_selesai = $('#jamselesaiprosespillow').val()
  var years = $('#yearsprosespillow').val()
  if (planningnumber == '' || parameter_1 =='' || parameter_2 =='' || parameter_3 == '') {
    missingstatement()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessubmitprosespillow": [planningnumber,
        renteng,
        parameter_1,
        parameter_2,
        parameter_3,
        qtyplastik,
      jam_mulai,jam_selesai,years]
    },
    success: function (data) {
      if (data == 1) {       
        Swal.fire({
          text: "Data Pillow Pack tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    },
  }); 
}

// ------------Transaksi - Rekon Pillow Pack------------------

function prosesselectrekonpillow(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayrekonpillow": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberrekonpillow').val(data.planning)
        $('#setplanningnumberrekonpillow').val(data.planning)
        $('#productidrekonpillow').val(': ' +data.productid)
        $('#productdescriptionrekonpillow').val(': ' +data.productdecription)
        $('#shiftidrekonpillow').val(': ' +data.shiftid)   
        $('#batchrekonpillow').val(': ' +data.batchnumber)
        $('#edrekonpillow').val(': ' +data.expireddate)
        $('#tanggalkemasrekonpillow').val(': ' +data.packingdate)            
        $('#batchrekonpillow').val(': ' +data.batchnumber)
        $('#nomesinrekonpillow').val(': ' +data.resourceid)
        $('#namamesinrekonpillow').val(': ')
        $('#mixingrekonpillow').val(': ' +data.resourceidmix)
        $('#tglmixingrekonpillow').val(': ' +data.mixingdate)
        $('#qtyrekonpillow').val(': ' +data.quantity+" "+data.unitofmeasures)
        // $('#uomrekonpillow').val(': ' +data.unitofmeasures)
        $('#prosesnumberrekonpillow').val(': ' +data.processnumber)  
        $('#yearsrekonpillow').val(data.years)
        // $('#hasilteoritisrekonpillow').val(data.quantity)  
        $('#hasilnyatarekonpillow').val(0)
        $('#presentaserekonpillow').val('')
        hasilrekonpillow()
        $('#searchplanningnumberrekonpillow').modal('hide')
        document.getElementById('saverekonpillow').hidden=false
      }
    }
  })
}
function autohasilnyata() {
  var planningnumber = $('#setplanningnumberrekonpillow').val()
  var hasilpengemasan = $('#hasilpengemasanrekonsiliasipillow').val()
  var years = $('#yearsrekonpillow').val()
  if (planningnumber == '') {
    missingplanningnumber()
    return
  } 
  if (hasilpengemasan == '') {
    $('#hasilnyatarekonpillow').val(0)
  }
  $.ajax({
    url: "../function/getdata.php",
    // dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesautohasilnyata": [planningnumber,years,hasilpengemasan]
    },
    success: function (data) {
      if (data != 0 && hasilpengemasan !=0) {  
        $('#hasilnyatarekonpillow').val(data)     
        hasilrekonpillow()        
      }
    },
  }); 
}
function hasilrekonpillow() {
  var planningnumber = $('#setplanningnumberrekonpillow').val()
  var hasilnyata = $('#hasilnyatarekonpillow').val()
  var years = $('#yearsrekonpillow').val()
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesambildatasampleprosespillow": [planningnumber,hasilnyata,years]
    },
    success: function (data) {
      if (data.return == 1) {       
        if (planningnumber != '') { 
            var presentase = hasilnyata/data.teoritis * 100
            $('#hasilteoritisrekonpillow').val(data.teoritis)
            $('#presentaserekonpillow').val(presentase)            
        }else{
          $('#hasilnyatarekonpillow').val(0)
          missingplanningnumber()
          return
        }
      }
    },
  }); 
}
function saverekonpillow() {
  var planningnumber = $('#setplanningnumberrekonpillow').val()
  var hasilpengemasan = $('#hasilpengemasanrekonsiliasipillow').val()
  var countermesin = $('#countermesinrekonsiliasipillow').val()
  var dus = $('#qtydusrekonpillow').val()
  var brosur = $('#qtybrosurrekonpillow').val()
  var hanger = $('#qtyhangerrekonpillow').val()
  var stiker = $('#qtystikerrekonpillow').val()
  var box = $('#qtyboxrekonpillow').val()
  var plastik = $('#qtyplastikrekonpillow').val()

  var hasilteoritis = $('#hasilteoritisrekonpillow').val()
  var hasilnyata = $('#hasilnyatarekonpillow').val()
  var persentase = $('#presentaserekonpillow').val()
  var rangehasil = $('#rangehasilrekonpillow').val()
  var years = $('#yearsrekonpillow').val()
  var rangehasil_conv = rangehasil.split("-")
  var bottom_range = persentase - rangehasil_conv[0]
  var top_range = persentase - rangehasil_conv[1]
  if (planningnumber == '' || hasilpengemasan =='' || 
    countermesin =='') {
    missingparameter()
    return
  }
  if (bottom_range < 0 || top_range > 0) {
    Swal.fire({
      title: 'Persentase Kurang/Lebih dari batas range.',
      text: "Tetap lakukan simpan data?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Simpan'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "prosessimpanrekonpillow": [planningnumber,
            hasilpengemasan,countermesin,dus,brosur,hanger,stiker,box,plastik,
            hasilteoritis,hasilnyata,persentase,years]
          },
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                title: "Success",
                text: "Process pillow pack has been completed ",
                icon: "success",
                showConfirmButton: true,
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload()
                }
              })
            } else {
              Swal.fire({
                Text: "Data not saved",
                icon: "error",
                showConfirmButton: false,
              })
            }    
          }
        })
      }
    })
  }else {
    Swal.fire({
      text: "Save Proses Pillow Pack?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "prosessimpanrekonpillow": [planningnumber,
              hasilpengemasan,countermesin,dus,brosur,hanger,stiker,box,plastik,
              hasilteoritis,hasilnyata,persentase,years]
          },
          success: function (data) {
            if (data == 1) {
              Swal.fire({
                title: "Success",
                text: "process pillow pack has been completed ",
                icon: "success",
                showConfirmButton: true,
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload()
                }
              })
            } else {
              Swal.fire({
                Text: "Data not saved",
                icon: "error",
                showConfirmButton: false,
              })
            }    
          }
        })
      }
    })
  }
}
function showinoutreject() {
  var planningnumber = $('#setplanningnumberrekonpillow').val()
  var years = $('#yearsrekonpillow').val()
  if (planningnumber != '') {
    document.getElementById('titleplanningnumberrekonsiliasipillow').innerHTML=planningnumber
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosesshowtablerekonsiliasipillow": [planningnumber,years]
      },
      success: function (data) {
        if (data != '') {    
          document.getElementById('table_reject_pillowpack').innerHTML = data   
          $('#searchrejectrekonsiliasipillow').modal('show')
        }
      },
    });   
  }else{
    missingplanningnumber()
    return
  }
}
function saverejectrekonpillow() {
  var planningnumber = $('#setplanningnumberrekonpillow').val()
  var years = $('#yearsrekonpillow').val()
  var jumlah = $('#Jumlahrekonsiliasipillow').val()
  var nocontainer = $('#nocontainerrekonsiliasipillow').val()
  var keterangan = $('#keteranganrekonsiliasipillow').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessaverejectrekonsiliasipillow": [planningnumber,
      jumlah,nocontainer,keterangan,years]
    },
    success: function (data) {
      $('#Jumlahrekonsiliasipillow').val(0)
      $('#nocontainerrekonsiliasipillow').val(0)
      $('#keteranganrekonsiliasipillow').val('')
      if (data == 1) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "prosesshowtablerekonsiliasipillow": [planningnumber,years]
          },
          success: function (data) {
            if (data != '') {    
              document.getElementById('table_reject_pillowpack').innerHTML = data  
              $('#searchrejectrekonsiliasipillow').modal('show') 
            }
          },
        });   
      }
    },
  }); 
}
function deletereject(planningnumber,item,years) {
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesdeleterejectrekonsiliasipillow": [planningnumber,item,years]
    },
    success: function (data) {
      $('#Jumlahrekonsiliasipillow').val(0)
      $('#nocontainerrekonsiliasipillow').val(0)
      $('#keteranganrekonsiliasipillow').val('')
      if (data == 1) {
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "prosesshowtablerekonsiliasipillow": [planningnumber,years]
          },
          success: function (data) {
            if (data != '') {    
              document.getElementById('table_reject_pillowpack').innerHTML = data  
              $('#searchrejectrekonsiliasipillow').modal('show') 
            }
          },
        });   
      }
    },
  }); 
}
function downtimerekonpillow(params) {
  var planningnumber = $('#setplanningnumberrekonpillow').val()
  var years = $('#yearsrekonpillow').val()
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
    document.getElementById('titleplanningnumberrekonpillow').innerHTML=planningnumber
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosesshowtabledowntime": [planningnumber,years,params]
      },
      success: function (data) {
        if (data != '') {    
          document.getElementById('table_rekon_pillow').innerHTML = data   
          $('#searchdowntimerekonpillow').modal('show')
        }
      },
    });
}
function savedowntimerekonpillow(proses) {
  var planningnumber = $('#setplanningnumberrekonpillow').val()
  var years = $('#yearsrekonpillow').val()
  var jam = $('#jamrekonpillow').val()
  var permasalahan = $('#permasalahanrekonpillow').val()
  var tindakan = $('#tindakanrekonpillow').val()
  var hasil = $('#hasilrekonpillow').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessavedowntime": [planningnumber,
      years,jam,permasalahan,tindakan,hasil,proses]
    },
    success: function (data) {
      $('#permasalahanrekonpillow').val('')
      $('#tindakanrekonpillow').val('')
      $('#hasilrekonpillow').val('')
      if (data == 1) {
        downtimerekonpillow('pillowpack')  
      }
    },
  });
}
function deletedowntime(planningnumber,years,item,proses) {
  if (proses == 1) {
    proses = 'pillowpack'
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesdeletedowntime": [planningnumber,years,item,proses]
    },
    success: function (data) {
      $('#permasalahanrekonpillow').val('')
      $('#tindakanrekonpillow').val('')
      $('#hasilrekonpillow').val('')
      if (data == 1) {
        downtimerekonpillow('pillowpack')
      }
    },
  }); 
}

// ----------Transksi - Sampling Topack Produksi------------------

function prosesselectsamplingtopackproduksi(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplaysamplingtopackproduksi": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumbersamplingtopackproduksi').val(data.planning)
        $('#setplanningnumbersamplingtopackproduksi').val(data.urlcodes)
        document.getElementById('setplanningnumbersamplingtopackproduksi').hidden=false
        $('#productidsamplingtopackproduksi').val(': ' +data.productid)
        $('#productdescriptionsamplingtopackproduksi').val(': ' +data.productdecription)
        $('#shiftidsamplingtopackproduksi').val(': ' +data.shiftid)   
        $('#batchsamplingtopackproduksi').val(': ' +data.batchnumber)
        $('#edsamplingtopackproduksi').val(': ' +data.expireddate)
        $('#tanggalkemassamplingtopackproduksi').val(': ' +data.packingdate)            
        $('#batchsamplingtopackproduksi').val(': ' +data.batchnumber)
        $('#nomesinsamplingtopackproduksi').val(': ' +data.resourceid)
        $('#namamesinsamplingtopackproduksi').val(': ')
        $('#mixingsamplingtopackproduksi').val(': ' +data.resourceidmix)
        $('#tglmixingsamplingtopackproduksi').val(': ' +data.mixingdate)
        $('#qtysamplingtopackproduksi').val(': ' +data.quantity+" "+data.unitofmeasures)
        $('#jumlahprosessamplingtopackproduksi').val(': ' +data.processnumber)
        $('#productsamplingtopackproduksi').val(data.productid)
        $('#itemsamplingtopackproduksi').val(data.item)
        $('#bobotrangetopackproduksi').val(data.bobottimbang)
        $('#bobotrangepokoktopackproduksi').val(data.bobottimbang)   
        $('#yearssamplingtopackproduksi').val(data.years)
        // konversi
        $('#uomsamplingtopackproduksi').val('Sch')
        $('#schkonversitopackproduksi').val(1)
        document.getElementById('schkonversitopackproduksi').hidden=true
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "showtablesamplingtopackproduksi": [$('#setplanningnumbersamplingtopackproduksi').val(),years]
          },
          success: function (data) {
              document.getElementById('content_samplingtopack').innerHTML=data
              $('#searchplanningnumbersamplingtopackproduksi').modal('hide')
          }
        })  
      }
    }
  })
}
function submitsamplingtopackproduksi() {
  var planningnumber = $('#setplanningnumbersamplingtopackproduksi').val()
  var item = $('#itemsamplingtopackproduksi').val()
  var qty = $('#quantitysamplingtopackproduksi').val()
  var uom = $('#uomsamplingtopackproduksi').val()
  var bobotrange = $('#bobotrangetopackproduksi').val()
  var bobottimbang = $('#bobottimbangtopackproduksi').val()
  var years = $('#yearssamplingtopackproduksi').val()
  var bobotrange_split = bobotrange.split("-")
  var bobotrange_from = bobotrange_split[0]
  var bobotrange_split2 = bobotrange_split[1].split(" ")
  var bobotrange_to = bobotrange_split2[0]
  if (Number(bobottimbang) < Number(bobotrange_from) || Number(bobottimbang) > Number(bobotrange_to)) {
    missingbobottimbang()
    return
  }
  if (planningnumber == '' || qty =='' || uom =='' || bobottimbang =='') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessubmitsamplingtopackproduksi": [planningnumber,item,qty,
      uom,bobottimbang,years]
    },
    success: function (data) {
      if (data.return == 1) {   
        $('#itemsamplingtopackproduksi').val(data.item)
        $.ajax({
          url: "../function/getdata.php",
          type: "POST",
          cache: false,
          data: {
            "showtablesamplingtopackproduksi": [planningnumber,years]
          },
          success: function (data) {
              document.getElementById('content_samplingtopack').innerHTML=data
          }
        })
      }
    },
  });
}
function deletesamplingtopackproduksi(planningnumber,years) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Proses Sampling ",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url: "../function/getdata.php",
        // dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletesamplingtopackproduksi": [planningnumber,years]
        },
        success: function (data) {
          if (data == 1) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                "showtablesamplingtopackproduksi2": [planningnumber,years]
              },
              success: function (data) {
                // if (data.return == true) {
                  document.getElementById('content_samplingtopack').innerHTML=data
                // }    
              }
            })
          }
        }
      })
    } 
  })
}
function viewrenteng(parameters) {
  var planningnumber = $('#planningnumbersamplingtopackproduksi').val()
  var uom = $('#uomsamplingtopackproduksi').val()
  $('#schkonversitopackproduksi').val('1')
  if (planningnumber != '' & uom != 'Sch') {
    document.getElementById('labelkonversitopackproduksi').innerHTML = 'Konversi ' +parameters +' ke Sch'
    document.getElementById('schkonversitopackproduksi').hidden=false
  }else{
    document.getElementById('labelkonversitopackproduksi').innerHTML = ''
    document.getElementById('schkonversitopackproduksi').hidden=true
  }
}
function bobotrangeother(parameters) {
  $schkonversi = $('#schkonversitopackproduksi').val()
  if ($schkonversi != 0) {
    var bobotrange = $('#bobotrangepokoktopackproduksi').val()
    var bobotrange_split = bobotrange.split("-")
    var bobotrange_from = bobotrange_split[0]
    var bobotrange_split2 = bobotrange_split[1].split(" ")
    var bobotrange_to = bobotrange_split2[0]
    var uom = bobotrange_split2[1]


    var value_from = parameters * bobotrange_from
    var value_to = parameters * bobotrange_to
    $('#bobotrangetopackproduksi').val('')
    $('#bobotrangetopackproduksi').val(value_from +'-'+value_to +' '+ uom)
  }
  bobotrangepokoktopackproduksi

}

// --------------Transaksi - QC Result--------------------

function selectpernrcekrhsuhu(pernr,nama) {
  $('#pernrcekrhsuhu').val(pernr + ' - ' + nama)
  $('#searchpernrcekrhsuhu').modal('hide') 
}
function prosesselectqcresult(planningnumber,years,jenis,batchnumber,noproses) {
  // alert(batchnumber)
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesselectqcresult": [planningnumber,years,jenis,batchnumber,noproses]
    },
    success: function (data) {
      // alert(data.suhu)
      $('#productpersiapanhoperqc').val(data.productid)
      $('#batchpersiapanhoperqc').val(data.batch)
      $('#deskripsipersiapanhoperqc').val(data.deskripsi)
      $('#yearpersiapanhoperqc').val(data.years)
      $('#planningnumberqcresulthoper').val(data.planningnumber)
      $('#noprosespersiapanhoperqc').val(data.noproses)
      $('#parameter1persiapanhoperqc').val('')
      $('#parameter2persiapanhoperqc').val('')
      $('#parameter1persiapanhoperqc').val(data.rh)
      $('#parameter2persiapanhoperqc').val(data.suhu)
      if (data.qc_name != undefined) {
        $('#pernrcekrhsuhu').val(data.qc_name)
      }
      
      // if (data.rh != undefined || data.suhu != undefined) {
        document.getElementById('simpanqcresulthoper').hidden=false
      // }  
      document.getElementById('rhqualityrhsuhu').hidden=false
      document.getElementById('tnoprosespersiapanhoperqc').hidden=true
      if (data.jenis== 'Pengolahan') {
        document.getElementById('rhqualityrhsuhu').hidden=true
        document.getElementById('tnoprosespersiapanhoperqc').hidden=false
      }
      $('#searchplanningnumberpersiapanhoperqc1').modal('hide')
      $('#searchplanningnumberpersiapanhoperqc2').modal('hide')
      $('#searchplanningnumberpersiapanhoperqc3').modal('hide')
    }
  })
}
function simpanqcresult() {
  var planningnumber = $('#planningnumberqcresulthoper').val()
  var years = $('#yearpersiapanhoperqc').val()
  var batch = $('#batchpersiapanhoperqc').val()
  var noproses = $('#noprosespersiapanhoperqc').val()
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
  var hoper = document.getElementById('inlineRadio1');
  var topack = document.getElementById('inlineRadio2');
  var pengolahan = document.getElementById('inlineRadio3');
  var jenis =''
  if (hoper.checked==true) {
    jenis = 'Hoper'
  }else if (topack.checked == true) {
    jenis = 'Topack'
  }else if (pengolahan.checked == true) {
    jenis = 'Pengolahan'
  }
  var planningnumber = $('#planningnumberqcresulthoper').val()
  var rh =  $('#parameter1persiapanhoperqc').val()
  var suhu = $('#parameter2persiapanhoperqc').val()
  var namaqc = $('#pernrcekrhsuhu').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanqcresult": [planningnumber,rh,suhu,jenis,namaqc,years,batch,noproses]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  })    
}
function searchplanningqcresult() {
  var hoper = document.getElementById('inlineRadio1');
  var topack = document.getElementById('inlineRadio2');
  var pengolahan = document.getElementById('inlineRadio3');
  if (hoper.checked==true) {
    $('#searchplanningnumberpersiapanhoperqc1').modal('show')
  }else if (topack.checked==true){
    $('#searchplanningnumberpersiapanhoperqc2').modal('show')
  }else if (pengolahan.checked==true){
    $('#searchplanningnumberpersiapanhoperqc3').modal('show')
  }
}
function qcresultransaksi(values) {
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    dataType: "JSON",
    cache: false,
    data: {
      "jenistransaksiqcresult": values
    },
    success: function (data) {
      $('#planningnumberqcresulthoper').val('')
      $('#productpersiapanhoperqc').val('')
      $('#batchpersiapanhoperqc').val('')
      $('#deskripsipersiapanhoperqc').val('')
      $('#yearpersiapanhoperqc').val('')
      $('#pernrcekrhsuhu').val(data.qc_name)
      $('#parameter1persiapanhoperqc').val('0')
      $('#parameter2persiapanhoperqc').val('0')
      $('#suhu_persiapanhoperqc').val(data.suhu)
      $('#rh_persiapanhoperqc').val(data.rh)
      document.getElementById('rhqualityrhsuhu').hidden=false
      document.getElementById('tnoprosespersiapanhoperqc').hidden=true
      
      if (data.rh== 'none') {
        document.getElementById('rhqualityrhsuhu').hidden=true
        document.getElementById('tnoprosespersiapanhoperqc').hidden=false
      }
    }
  }) 
}
function cekstatusqc() {
  var input = document.getElementById('scanbarcodecekstatusqc')
    input.addEventListener("keypress", function(event) {
      if (event.key == "Enter") {
        var barcode = $('#scanbarcodecekstatusqc').val()
        $.ajax({ 
          url: "../function/getdata2.php",
          type: "POST",
          cache: false,
          data: {
            "prosescekstatusqc": barcode
          },
          success: function (data) {
            document.getElementById('statusqccekstatusqc').innerHTML=data
            document.getElementById('scanbarcodecekstatusqc').value=''
            document.getElementById('showhasilanalisacekstatusqc').hidden=false
          },
        });
        // alert('a')
      }
    })
}

// ----------Transaksi - Review Quality Assurance---------------------
function prosesselectreviewquality(planningnumber,years,steps) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesselectreviewquality": [planningnumber,years,steps]
    },
    success: function (data) {
      if (steps == 1) {
        $('#planningnumberreviewquality').val(data.planningnumber)
        $('#productreviewquality').val(data.productid)
        $('#batchreviewquality').val(data.batch)
        $('#deskripsireviewquality').val(data.deskripsi)
        $('#ukuranbetsreviewquality').val(data.hasilnyata)
        $('#tglpackingreviewquality').val(data.tglpacking)
        $('#jumlahreviewquality').val(data.hasilpengemasan +" Carton")
        $('#uomreviewquality').val(data.uom)
        $('#yearsreviewquality').val(data.years)
        document.getElementById('simpanreviewquality').hidden=false
        $('#searchplanningnumberreviewquality').modal('hide')
      }else{   
        $('#yearsreviewquality2').val(data.years)
        $('#planningnumber_result_reviewquality').val(data.planningnumber)
        $('#searchplanningnumber2reviewquality').modal('hide')
      }    
    }
  })
}
function simpanreviewquality() {
  var planningnumber = document.getElementById('planningnumberreviewquality').value
  var var_1 = document.getElementById('kodifikasireviewquality').checked
  var var_2 = document.getElementById('rekonsiliasibahankemasreviewquality').checked
  var var_3 = document.getElementById('rekonsiliasiprodukjadireviewquality').checked
  var var_4 = document.getElementById('kebenarankemasanreviewquality').checked
  var var_5 = document.getElementById('jalurpengemasanreviewquality').checked
  var var_6 = document.getElementById('kemasanprimerreviewquality').checked
  var var_7 = document.getElementById('kemasansekunderreviewquality').checked
  var var_8 = document.getElementById('insertbrosurreviewquality').checked
  var years = $('#yearsreviewquality').val()
  var decision = 'Lulus'
  var lulus = document.getElementById('lulusreviewquality').checked
  if (lulus == false) {
    decision = 'Tidak Lulus'
  }
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanreviewquality": [planningnumber,
                                    var_1,
                                  var_2,
                                var_3,
                              var_4,
                            var_5,
                          var_6,
                        var_7,
                      var_8,
                    decision,
                  years]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else{
        Swal.fire({
          text: "Data gagal tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    }
  })
}
function showreportqualityassurance() {
  var planningnumber = document.getElementById('planningnumber_result_reviewquality').value
  var years = document.getElementById('yearsreviewquality2').value
  var preparehoper = document.getElementById('cetakpreparehoperreviewquality').checked
  var proseshoper = document.getElementById('cetakproseshoperreviewquality').checked
  var preparetopack = document.getElementById('cetakpreparetopackreviewquality').checked
  var prosestopack = document.getElementById('cetakprosestopackreviewquality').checked
  var preparepillow = document.getElementById('cetakpreparepillowreviewquality').checked
  var prosespillow = document.getElementById('cetakprosespillowreviewquality').checked
  var reviewquality = document.getElementById('cetakreviewqualityreviewquality').checked
  var workorder = document.getElementById('cetakworkorderreviewquality').checked
  var pengemasansekunder = document.getElementById('cetakpengemasansekunderreviewquality').checked
  var analisarhsuhu = document.getElementById('cetakanalisarhsuhureviewquality').checked

  window.open ("../page/report/form/page_laporanquality.php?n='"+planningnumber+"'&&y='"+years+"'");
}

// ------------Transaksi - Engine Set Approval-----------------

function prosesselectenginesetapproval(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesselectenginesetapproval": [planningnumber,years]
    },
    success: function (data) {
      $('#productenginesetapproval').val(data.productid)
      $('#batchenginesetapproval').val(data.batch)
      $('#deskripsipersiapanhoperqc').val(data.deskripsi)
      $('#yearsenginesetapproval').val(data.years)
      $('#planningnumberenginesetapproval').val(data.planningnumber)
      $('#stats1enginesetapproval').val(data.stats1)
      $('#stats2enginesetapproval').val(data.stats2)
      $('#stats3enginesetapproval').val(data.stats3)
      $('#stats4enginesetapproval').val(data.stats4)
        document.getElementById('simpanqenginesetapproval').hidden=false
      $('#searchplanningnumberenginesetapproval').modal('hide')
    }
  })
}
function simpanqenginesetapproval() {
  var planningnumber = $('#planningnumberenginesetapproval').val()
  var stats1 =  $('#stats1enginesetapproval').val()
  var stats2 = $('#stats2enginesetapproval').val()
  var stats3 = $('#stats3enginesetapproval').val()
  var stats4 = $('#stats4enginesetapproval').val()
  var years = $('#yearsenginesetapproval').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanenginesetapproval": [planningnumber,
        stats1,
        stats2,
        stats3,
        stats4,
        years
      ]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  }) 
}

// ------------Transaksi - Analisa Pengemasan Primer-----------------

function selectpengemasanprimer(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesselectpengemasanprimer": [planningnumber,years]
    },
    success: function (data) {
      // Header
      if (data.button==1) {
        $('#tingkatinspeksidatepengemasanprimer').val(data.tingkatinspeksi)
        $('#jmlcontohfrekuensipengemasanprimer').val(data.jmlcontohfrek)
        $('#sachetsetiappengemasanprimer').val(data.schsetiap)
        $('#pemasokpengemasanprimer').val(data.catatanpemasok)
        
        // $('#kesimpulanpengemasanprimer').val(data.kesimpulan)
      }else{
        $('#tingkatinspeksidatepengemasanprimer').val('I')
        $('#jmlcontohfrekuensipengemasanprimer').val(0)
        $('#sachetsetiappengemasanprimer').val(15)
        $('#pemasokpengemasanprimer').val('DNPI')
      }
      // End
      $('#planningnumberpengemasanprimer').val(data.planningnumber)
      $('#yearspengemasanprimer').val(data.years)
      $('#productpengemasanprimer').val(data.prod)
      $('#mixingdatepengemasanprimer').val(data.mixingdate)
      $('#nomesindatepengemasanprimer').val(data.mesintopack)
      $('#tanggalpengemasanprimer').val(data.mixingdate)
      $('#nomesindmpengemasanprimer').val(data.nomesin)

      $('#assqcpengemasanprimer').val(data.assqc)
      $('#koipcpengemasanprimer').val(data.koorqc)
      $('#shiftpengemasanprimer').val(data.shiftid)
      document.getElementById('rangebobotpengemasanprimer').innerHTML=data.rangebobot
      document.getElementById('nodmpengemasanprimer').value=1
      document.getElementById('nodmpengemasanprimer').max=data.noproses
      selectsachetsetiap($('#sachetsetiappengemasanprimer').val())
      selecttingkatinspeksi($('#tingkatinspeksidatepengemasanprimer').val())
      
      $('#searchplanningnumberpengemasanprimer').modal('hide')
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "showtableanalisakemasanprimer": [planningnumber,years]
        },
        success: function (data) {
          if (data.buttonselesai==true) {
            document.getElementById('buttonselesaipengemasanprimer').hidden=false
          }else{
            document.getElementById('buttonselesaipengemasanprimer').hidden=true
          }
            document.getElementById('showdata_analisapengemasanprimer').innerHTML=data.output1
            document.getElementById('showdata_analisapengemasanprimer2').innerHTML=data.output2 
            document.getElementById('showdata_analisapengemasanprimer3').innerHTML=data.output3
            changepemasokpengemasanprimer($('#pemasokpengemasanprimer').val())
        }
      })
    }
  })
  $('#searchplanningnumberpengemasanprimer').modal('hide')
}
function selecttingkatinspeksi(values) {
  var planningnumber = $('#planningnumberpengemasanprimer').val()
  if (planningnumber == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesselecttingkatinspeksi": values
    },
    success: function (data) {
      $('#jumlahcontohpengemasanprimer').val(data.jumlahcontoh)
      $('#terimakualitaspengemasanprimer').val(data.tingkatterima)
      $('#lulustolakpengemasanprimer').val(data.lulustolak)
    }
  })
}
function selectsachetsetiap(values) {
  var planningnumber = $('#planningnumberpengemasanprimer').val()
  if (planningnumber == '') {
    missingparameter()
    return
  }
  $return = 2;
  if (values == 15) {
    $return=1
  }
  $('#mesindaripengemasanprimer').val($return)
}
function changepemasokpengemasanprimer(value) {
  $('#kemasanpertamapengemasanprimer').val(value)
}
function setstrippengemasanprimer(value) {
  if (value == true) {
    $('#schtidakrapipengemasanprimer').val('-')
    $('#misregisterpengemasanprimer').val('-')
    $('#tdkadaeyecutpengemasanprimer').val('-')
    $('#posisisalaheyecutpengemasanprimer').val('-')
    $('#tdkadakodeprodukpengemasanprimer').val('-')
    $('#posisisalahkodeprodukpengemasanprimer').val('-')
    $('#salahkodeprodukpengemasanprimer').val('-')
    $('#misprintkodeprodukpengemasanprimer').val('-')
    $('#tdkadaembospengemasanprimer').val('-')
    $('#posisisalahembospengemasanprimer').val('-')
    $('#tdkjelasembospengemasanprimer').val('-')
    $('#kurangkekembunganpengemasanprimer').val('-')
    $('#lebihkekembunganpengemasanprimer').val('-')
    $('#tidakngesealkondisisealpengemasanprimer').val('-')
    $('#haluskondisisealpengemasanprimer').val('-')
    $('#pisaupotongpengemasanprimer').val('-')
    $('#bobotpengemasanprimer').val('-')
  }else{
    $('#schtidakrapipengemasanprimer').val('')
    $('#misregisterpengemasanprimer').val('')
    $('#tdkadaeyecutpengemasanprimer').val('')
    $('#posisisalaheyecutpengemasanprimer').val('')
    $('#tdkadakodeprodukpengemasanprimer').val('')
    $('#posisisalahkodeprodukpengemasanprimer').val('')
    $('#salahkodeprodukpengemasanprimer').val('')
    $('#misprintkodeprodukpengemasanprimer').val('')
    $('#tdkadaembospengemasanprimer').val('')
    $('#posisisalahembospengemasanprimer').val('')
    $('#tdkjelasembospengemasanprimer').val('') 
    $('#kurangkekembunganpengemasanprimer').val('')
    $('#lebihkekembunganpengemasanprimer').val('')
    $('#tidakngesealkondisisealpengemasanprimer').val('')
    $('#haluskondisisealpengemasanprimer').val('')
    $('#pisaupotongpengemasanprimer').val('')
    $('#bobotpengemasanprimer').val('')
  }
}
function submitanalisapengemasanprimer_one() {
  // Header
  var planningnumber = $('#planningnumberpengemasanprimer').val()
  var years = $('#yearspengemasanprimer').val() 
  var tingkatinspeksi = $('#tingkatinspeksidatepengemasanprimer').val()
  var jmlhcontohperfrekuensi = $('#jmlcontohfrekuensipengemasanprimer').val()
  var schsetiap = $('#sachetsetiappengemasanprimer').val()
  // Detail
  var jam = $('#jam1pengemasanprimer').val()
  var tglmixing = $('#tanggalpengemasanprimer').val()
  var nomesindm = $('#nomesindmpengemasanprimer').val()
  var nodm = $('#nodmpengemasanprimer').val()
  var pemasok = $('#pemasokpengemasanprimer').val()

  var schtidakrapi = $('#schtidakrapipengemasanprimer').val()
  var misregister = $('#misregisterpengemasanprimer').val()
  var tdkadaeyecut = $('#tdkadaeyecutpengemasanprimer').val()
  var posisisalaheyecut = $('#posisisalaheyecutpengemasanprimer').val()
  var tdkadakodeproduk = $('#tdkadakodeprodukpengemasanprimer').val()

  var posisisalahkodeproduk = $('#posisisalahkodeprodukpengemasanprimer').val()
  var salahkodeproduk = $('#salahkodeprodukpengemasanprimer').val()
  var misprintkodeproduk = $('#misprintkodeprodukpengemasanprimer').val()
  var tdkadaembos = $('#tdkadaembospengemasanprimer').val()
  var posisisalahembos = $('#posisisalahembospengemasanprimer').val()

  var tdkjelasembos = $('#tdkjelasembospengemasanprimer').val()
  var kurangkekembungan = $('#kurangkekembunganpengemasanprimer').val()
  var lebihkekembungan = $('#lebihkekembunganpengemasanprimer').val()
  var tidakngesealkondisiseal = $('#tidakngesealkondisisealpengemasanprimer').val()
  var haluskondisiseal = $('#haluskondisisealpengemasanprimer').val()

  var pisaupotong = $('#pisaupotongpengemasanprimer').val()
  var bobot = $('#bobotpengemasanprimer').val()
  var catatan = $('#catatan1pengemasanprimer').val()

  var jumlahcontoh = $('#jumlahcontohbawahpengemasanprimer').val()
  var catatanpemasok = $('#kemasanpertamapengemasanprimer').val()
  var kesimpulan = $('#kesimpulanpengemasanprimer').val()

  var assqc = $('#assqcpengemasanprimer').val()
  var koorqc = $('#koipcpengemasanprimer').val()
  var shift = $('#shiftpengemasanprimer').val()
  
  if (planningnumber == '' || years == '') {
    missingplanningnumber()
    return
  }
  alert(planningnumber)
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessubmitanalisapengemasanprimer_one": [ 
        planningnumber,
        years,
        tingkatinspeksi,
        jmlhcontohperfrekuensi,
        schsetiap,
        jam,
        tglmixing,
        nomesindm,
        nodm,
        pemasok,  
        schtidakrapi,
        misregister,
        tdkadaeyecut,
        posisisalaheyecut,
        tdkadakodeproduk,
        posisisalahkodeproduk,
        salahkodeproduk,
        misprintkodeproduk,
        tdkadaembos,
        posisisalahembos,
        tdkjelasembos,
        kurangkekembungan,
        lebihkekembungan,
        tidakngesealkondisiseal,
        haluskondisiseal,
        pisaupotong,
        bobot,
        catatan,
        jumlahcontoh,
        catatanpemasok,
        kesimpulan,
        assqc,
        koorqc,
        shift
  ]
    },
    success: function (data) {
      alert(data)
      if (data == 1) {
        $.ajax({
          url: "../function/getdata.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
            "showtableanalisakemasanprimer": [planningnumber,years]
          },
          success: function (data) {
            if (data.buttonselesai==true) {
              document.getElementById('buttonselesaipengemasanprimer').disabled=false
            }else{
              document.getElementById('buttonselesaipengemasanprimer').disabled=true
            }
              document.getElementById('showdata_analisapengemasanprimer').innerHTML=data.output1
              document.getElementById('showdata_analisapengemasanprimer2').innerHTML=data.output2
              document.getElementById('showdata_analisapengemasanprimer3').innerHTML=data.output3
              changepemasokpengemasanprimer($('#pemasokpengemasanprimer').val())
              document.getElementById('setdefault1pengemasanprimer').checked=false
              setstrippengemasanprimer(false)
              document.getElementById('setdefault2pengemasanprimer').checked=false
              setstrip2pengemasanprimer(false)

              // Auto Move
              document.getElementById('pills-1').classList.remove('active')
              document.getElementById('pills-2').classList.add('active')
              document.getElementById('pills-1-tab').classList.remove('active')
              document.getElementById('pills-2-tab').classList.add('active')
          }
        })
      }
    }
  }) 
}
function deleteanalisapengemasanprimer_one(planningnumber,years,indexrow) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdeleteanalisapengemasanprimer_one": [planningnumber,years,indexrow]
    },
    success: function (data) {
      if (data == 1) {
        $.ajax({
          url: "../function/getdata.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
            "showtableanalisakemasanprimer": [planningnumber,years]
          },
          success: function (data) {
            if (data.buttonselesai==true) {
              document.getElementById('buttonselesaipengemasanprimer').disabled=false
            }else{
              document.getElementById('buttonselesaipengemasanprimer').disabled=true
            }
              document.getElementById('showdata_analisapengemasanprimer').innerHTML=data.output1
              document.getElementById('showdata_analisapengemasanprimer2').innerHTML=data.output2
              document.getElementById('showdata_analisapengemasanprimer3').innerHTML=data.output3
              changepemasokpengemasanprimer($('#pemasokpengemasanprimer').val())
              document.getElementById('showtableid').scrollIntoView({
                behavior: 'smooth'
              });
          }
        })
      }
    },
  });
}
function deleteanalisapengemasanprimer_two(planningnumber,years,indexrow) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdeleteanalisapengemasanprimer_two": [planningnumber,years,indexrow]
    },
    success: function (data) {
      if (data == 1) {
        $.ajax({
          url: "../function/getdata.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
            "showtableanalisakemasanprimer": [planningnumber,years]
          },
          success: function (data) {
            if (data.buttonselesai==true) {
              document.getElementById('buttonselesaipengemasanprimer').disabled=false
            }else{
              document.getElementById('buttonselesaipengemasanprimer').disabled=true
            }
              document.getElementById('showdata_analisapengemasanprimer').innerHTML=data.output1
              document.getElementById('showdata_analisapengemasanprimer2').innerHTML=data.output2
              document.getElementById('showdata_analisapengemasanprimer3').innerHTML=data.output3
              changepemasokpengemasanprimer($('#pemasokpengemasanprimer').val())
              document.getElementById('showtableid2').scrollIntoView({
                behavior: 'smooth'
              });
          }
        })
      }
    },
  });
}
function deleteanalisapengemasanprimer_three(planningnumber,years,indexrow) {
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosesdeleteanalisapengemasanprimer_three": [planningnumber,years,indexrow]
    },
    success: function (data) {
      if (data == 1) {
        $.ajax({
          url: "../function/getdata.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
            "showtableanalisakemasanprimer": [planningnumber,years]
          },
          success: function (data) {
            if (data.buttonselesai==true) {
              document.getElementById('buttonselesaipengemasanprimer').disabled=false
            }else{
              document.getElementById('buttonselesaipengemasanprimer').disabled=true
            }
              document.getElementById('showdata_analisapengemasanprimer').innerHTML=data.output1
              document.getElementById('showdata_analisapengemasanprimer2').innerHTML=data.output2
              document.getElementById('showdata_analisapengemasanprimer3').innerHTML=data.output3
              changepemasokpengemasanprimer($('#pemasokpengemasanprimer').val())
              document.getElementById('showdata_analisapengemasanprimer3').scrollIntoView({
                behavior: 'smooth'
              });
          }
        })
      }
    },
  });
}
function setstrip2pengemasanprimer(value) {
  if (value == true) {
    $('#toppengemasanprimer').val('-')
    $('#vert1pengemasanprimer').val('-')
    $('#vert2pengemasanprimer').val('-')
    $('#horipengemasanprimer').val('-')
    $('#centrepengemasanprimer').val('-')
    $('#ljpengemasanprimer').val('-')
    $('#adakontaminanpengemasanprimer').val('-')
    $('#tidakadakontaminanpengemasanprimer').val('-')
  }else{
    $('#toppengemasanprimer').val('')
    $('#vert1pengemasanprimer').val('')
    $('#vert2pengemasanprimer').val('')
    $('#horipengemasanprimer').val('')
    $('#centrepengemasanprimer').val('')
    $('#ljpengemasanprimer').val('')
    $('#adakontaminanpengemasanprimer').val('')
    $('#tidakadakontaminanpengemasanprimer').val('')
  }
}
function submit2analisapengemasanprimer_two() {
  var planningnumber = $('#planningnumberpengemasanprimer').val()
  var years = $('#yearspengemasanprimer').val()
  var jam = $('#jam2pengemasanprimer').val()
  var top = $('#toppengemasanprimer').val()
  var vert1 = $('#vert1pengemasanprimer').val()
  var vert2 = $('#vert2pengemasanprimer').val()
  var hori = $('#horipengemasanprimer').val()
  var centre = $('#centrepengemasanprimer').val()
  var lj = $('#ljpengemasanprimer').val()
  var adakontaminasi = $('#adakontaminanpengemasanprimer').val()
  var tidakadakontaminasi = $('#tidakadakontaminanpengemasanprimer').val()
  var catatan = $('#catatan2pengemasanprimer').val()

  var jumlahcontoh = $('#jumlahcontoh2bawahpengemasanprimer').val()
  var kesimpulan = $('#kesimpulan2pengemasanprimer').val()
  if (planningnumber == '' || years == '') {
    missingplanningnumber()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessubmit2analisapengemasanprimer_two": [ 
        planningnumber,
        years,
        jam,
        top,
        vert1,
        vert2,
        hori,
        centre,
        lj,
        adakontaminasi,
        tidakadakontaminasi,
        catatan,
        jumlahcontoh,
        kesimpulan     
  ]
    },
    success: function (data) {
      alert()
      if (data == 1) {
        $.ajax({
          url: "../function/getdata.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
            "showtableanalisakemasanprimer": [planningnumber,years]
          },
          success: function (data) {
            if (data.buttonselesai==true) {
              document.getElementById('buttonselesaipengemasanprimer').disabled=false
            }else{
              document.getElementById('buttonselesaipengemasanprimer').disabled=true
            }
              document.getElementById('showdata_analisapengemasanprimer').innerHTML=data.output1
              document.getElementById('showdata_analisapengemasanprimer2').innerHTML=data.output2
              document.getElementById('showdata_analisapengemasanprimer3').innerHTML=data.output3
              changepemasokpengemasanprimer($('#pemasokpengemasanprimer').val())
              document.getElementById('setdefault1pengemasanprimer').checked=false
              setstrippengemasanprimer(false)
              document.getElementById('setdefault2pengemasanprimer').checked=false
              setstrip2pengemasanprimer(false)

              document.getElementById('pills-2').classList.remove('active')
              document.getElementById('pills-3').classList.add('active')
              document.getElementById('pills-2-tab').classList.remove('active')
              document.getElementById('pills-3-tab').classList.add('active')

              $('#keteranganpengemasanprimer').val('')
              $('#gambarpengemasanprimer').val('')
          }
        })
      }
    }
  })
}
function submit3analisapengemasanprimer_three() {
  var planningnumber = $('#planningnumberpengemasanprimer').val()
  var years = $("#yearspengemasanprimer").val()
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
    const fileupload = $("#gambarpengemasanprimer").prop("files")[0];
    let formData = new FormData();
    formData.append("fileupload", fileupload);
    formData.append("planningnumber", $("#planningnumberpengemasanprimer").val());
    formData.append("years", $("#yearspengemasanprimer").val());
    formData.append("typess", 'analisapengemasanprimer');
    formData.append("jam", $("#jam3pengemasanprimer").val());
    formData.append("keterangan", $("#keteranganpengemasanprimer").val());
      $.ajax({
        type: "POST",
        url: "../function/uploaddata.php",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function (data) {
          if (data == 1) {
            $.ajax({
              url: "../function/getdata.php",
              dataType: "JSON",
              type: "POST",
              cache: false,
              data: {
                "showtableanalisakemasanprimer": [planningnumber,years]
              },
              success: function (data) {
                if (data.buttonselesai==true) {
                  document.getElementById('buttonselesaipengemasanprimer').disabled=false
                }else{
                  document.getElementById('buttonselesaipengemasanprimer').disabled=true
                }
                  document.getElementById('showdata_analisapengemasanprimer').innerHTML=data.output1
                  document.getElementById('showdata_analisapengemasanprimer2').innerHTML=data.output2
                  document.getElementById('showdata_analisapengemasanprimer3').innerHTML=data.output3
                  changepemasokpengemasanprimer($('#pemasokpengemasanprimer').val())
                  document.getElementById('setdefault1pengemasanprimer').checked=false
                  setstrippengemasanprimer(false)
                  document.getElementById('setdefault2pengemasanprimer').checked=false
                  setstrip2pengemasanprimer(false)
    
                  document.getElementById('pills-2').classList.remove('active')
                  document.getElementById('pills-3').classList.add('active')
                  document.getElementById('pills-2-tab').classList.remove('active')
                  document.getElementById('pills-3-tab').classList.add('active')

                  $('#keteranganpengemasanprimer').val('')
                  $('#gambarpengemasanprimer').val('')
              }
            })
          }
        },
      });
}
function simpandataanalisapengemasanprimer() {
  Swal.fire({
    // title: 'Are you sure?',
    text: "Simpan data analisa pengemasan primer ",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, simpan'
  }).then((result) => {
    if (result.isConfirmed) {
      var planningnumber = $('#planningnumberpengemasanprimer').val()
      var years = $('#yearspengemasanprimer').val()
      if (planningnumber == '' || years == '') {
        missingplanningnumber()
        return
      }
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosessimpandataanalisapengemasanprimer": [ 
            planningnumber,
            years   
      ]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Data Tersimpan",
              icon: "success",
              showConfirmButton: true,
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload()
              }
            });
          }
        }
      })
    }
  })
}

// ------------Config - General Setting------------------

function simpangeneralsettingweb() {
  var dashboardtitle =$('#titledashboarddatasetting').val()
  var dashboardcontent = $('#contentdashboarddatasetting').val()
  var userid = $('#useriddatasetting').val()
  var rolecode = $('#rolecodedatasetting').val()
  var passcode = $('#passdatasetting').val()
  var shiftcode = $('#shiftcodedatasetting').val()
  var mainresource = $('#mainresourcedatasetting').val()
  var primaryresource = $('#primaryresourcedatasetting').val()
  var secondaryresource = $('#secondaryresourcedatasetting').val()
  var mixingresource = $('#mixingresourcedatasetting').val()
  var kodesupplier = $('#supplierdatasetting').val()

  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpangeneralsetting": [dashboardtitle,
      dashboardcontent,
      userid,
      rolecode,
      passcode,
      shiftcode,
      mainresource,
      primaryresource,
      secondaryresource,
      mixingresource,
      kodesupplier
  ]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Diperbarui",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload()
        }, 1500);
      }
    }
  }) 
}
function savechangepassword() {
  var current_password = $('#currentpasswordchangepassword').val()
  var new_password = $('#newpasswordchangepassword').val()
  var renew_password = $('#renewpasswordchangepassword').val()
  if (current_password == '' || new_password =='' || renew_password =='') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      proseschangepassword: [current_password,new_password,renew_password]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Terupdate",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }else if (data == 2) {
        Swal.fire({
          text: "User / Password Salah",
          icon: "error",
          showConfirmButton: true,
        })
      }else if (data == 3) {
        Swal.fire({
          text: "New Password harus sama dengan re-entry password",
          icon: "warning",
          showConfirmButton: true,
        })
      }
    }
  }) 
}
// ---------------------------------------------------------
// Transaksi - Approval Proses
// ---------------------------------------------------------
function submitstartapprovalproses() {
  var x1 =  $('#jenisprosesstartapprovalproses').val()
  var x2 =  $('#statusstartapprovalproses').val()
  var x3 =  $('#createonfromstartapprovalproses').val()
  var x4 =  $('#createontostartapprovalproses').val()

    var x = x1.concat('*',x2,'*',x3,'*',x4)
  location.href = '../page/mainpage?p=displayapprovalproses&v='+ x +''
}
function prosesdisplayapprovalproses(planningnumber,jenisproses,years) {
  var jenisproses = jenisproses
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayapprovalproses": [planningnumber,years]
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberapprovalproses').val(data.planning)
        $('#productidapprovalproses').val(data.productid)
        $('#descriptionproductapprovalproses').val(data.productdecription)
        $('#batchapprovalproses').val(data.batchnumber)
        $('#expireddateapprovalproses').val(data.expireddate)
        $('#tglmixingapprovalproses').val(data.mixingdate)
        $('#tglkemasapprovalproses').val(data.packingdate)
        $('#shiftapprovalproses').val(data.shiftid)
        // $('#qtydisplayplanning').val(data.quantity)
        // $('#uomdisplayplanning').val(data.unitofmeasures)
        // $('#prosesnumberdisplayplanning').val(data.processnumber)
        // $('#notongdisplayplanning').val(data.tong)      
        $('#kodemesinapprovalproses').val(data.resourceid)
        $('#kodemesinmixingapprovalproses').val(data.resourceidmix)  
        $('#createbyapprovalproses').val(data.createdby)
        $('#createonapprovalproses').val(data.createdon)
        $('#changedonapprovalproses').val(data.changedon)
        $('#changedbyapprovalproses').val(data.changedby)    
        $('#statusapprovalapprovalproses').val(data.statusapproval)
        document.getElementById('savechangeplanning').hidden=false
        if (data.statusapproval == 'Approved') {
          document.getElementById('savechangeplanning').hidden=true
        }
        document.getElementById('titleapprovalproses').innerHTML=jenisproses       
        $('#modaldisplayapprovalproses').modal('show')
      }
    },
  }); 
}
function approvedapprovalproses() {
  underdevelopment()
  return
  var jenisproses = document.getElementById('titleapprovalproses').innerHTML
  var planningnumber = $('#planningnumberapprovalproses').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosesapprovedapprovalproses: [planningnumber,jenisproses]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Approved Completed",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  }) 
}

// ----------Report - Pengolahan & Pengemasan------------------

function jenistransaksi(values) {
  document.getElementById('subcekhoper').hidden=true
  document.getElementById('subcektopack').hidden=true
  // document.getElementById('subcekpillow').hidden=true
  if (values == '1') {
    document.getElementsByName('jenistransaksitopack').checked=false
    document.getElementsByName('jenistransaksipillow').checked=false
    document.getElementById('subcekhoper').hidden=false
    document.getElementById('subjenistransaksipreparehoper').checked=true
  }else if (values == '2') {
    document.getElementsByName('jenistransaksihopper').checked=false
    document.getElementsByName('jenistransaksipillow').checked=false
    document.getElementById('subcektopack').hidden=false
    document.getElementById('subjenistransaksipreparetopack').checked=true
  }
  else if (values == '3') {
    document.getElementsByName('jenistransaksitopack').checked=false
    document.getElementsByName('jenistransaksihopper').checked=false
    // document.getElementById('subcekpillow').hidden=false
    // document.getElementById('subjenistransaksipreparepillow').checked=true
  }
  else if (values == '4') {
    document.getElementsByName('jenistransaksitopack').checked=false
    document.getElementsByName('jenistransaksihopper').checked=false
    document.getElementsByName('jenistransaksipillow').checked=false
    // document.getElementById('subcekpillow').hidden=false
    // document.getElementById('subjenistransaksipreparepillow').checked=true
  }
}
function prosesselectreport(planningnumber,years) {
  // alert(planningnumber)
  $('#nomorplanningreport').val(planningnumber)
  $('#yearreportpengemasan').val(years)
  $('#searchplanningreport').modal('hide')
}
function showreportcpb() {
  var planningnumber = $('#nomorplanningreport').val()
  var years = $('#yearreportpengemasan').val()
  var jenistransaksi = ''
  var jenistransaksi_hoper = document.getElementById('jenistransaksihoper').checked;
  var subjenistransaksi_preparehoper = document.getElementById('subjenistransaksipreparehoper').checked;
  var subjenistransaksi_proseshoper = document.getElementById('subjenistransaksiproseshoper').checked;
  // 
  var jenistransaksi_topack = document.getElementById('jenistransaksitopack').checked;
  var subjenistransaksi_preparetopack = document.getElementById('subjenistransaksipreparetopack').checked;
  var subjenistransaksi_prosestopack = document.getElementById('subjenistransaksiprosestopack').checked;
  // var subjenistransaksi_rekontopack = document.getElementById('subjenistransaksirekontopack').checked;
  // 
  var jenistransaksi_pillow = document.getElementById('jenistransaksipillow').checked;
  var jenistransaksi_tinjauan = document.getElementById('jenistransaksitinjauanqa').checked;
  // var subjenistransaksi_preparepillow = document.getElementById('subjenistransaksipreparepillow').checked;
  // var subjenistransaksi_prosespillow = document.getElementById('subjenistransaksiprosespillow').checked;
  // var subjenistransaksi_rekonpillow = document.getElementById('subjenistransaksirekonpillow').checked;
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
  if (jenistransaksi_hoper === true) {
    if (subjenistransaksi_preparehoper === true) {
      jenistransaksi = 'preparehoper'
    }else if (subjenistransaksi_proseshoper === true) {
      jenistransaksi = 'proseshoper'
    }
  }else if (jenistransaksi_topack === true) {
    if (subjenistransaksi_preparetopack === true) {
      jenistransaksi = 'preparetopack'
    }else if (subjenistransaksi_prosestopack === true) {
      jenistransaksi = 'prosestopack'
    }
    // else if (subjenistransaksi_rekontopack === true) {
    //   jenistransaksi = 'rekontopack'
    // }
  }else if (jenistransaksi_pillow === true) {
    // if (subjenistransaksi_preparepillow === true) {
      jenistransaksi = 'preparepillow'
    // }else if (subjenistransaksi_prosespillow === true) {
    //   jenistransaksi = 'prosespillow'
    // }else if (subjenistransaksi_rekonpillow === true) {
    //   jenistransaksi = 'rekonpillow'
    // }
  }else if (jenistransaksi_tinjauan === true) {
    // if (subjenistransaksi_preparepillow === true) {
      jenistransaksi = 'tinjauanqa'
    // }else if (subjenistransaksi_prosespillow === true) {
    //   jenistransaksi = 'prosespillow'
    // }else if (subjenistransaksi_rekonpillow === true) {
    //   jenistransaksi = 'rekonpillow'
    // }
  }
  window.open ("../page/report/form/page_laporan.php?v='"+ jenistransaksi +"'&& n='"+planningnumber+"'&& y='"+years+"'");
}
function showreportpengolahan() {
  var jenistransaksi = ''
  var rencanakerjapencampuran = document.getElementById('rencanakerjapencampuran').checked
  var hasiltimbang = document.getElementById('hasiltimbang').checked
  var lampiran = document.getElementById('lampiranpengolahan').checked
  var planningnumber = document.getElementById('nomorplanningreportpengolahan').value
  var years = document.getElementById('yearreportpengolahan').value
  var nomix = document.getElementById('selectnomesinreportpengolahan').value

  if (rencanakerjapencampuran=== true) {
    jenistransaksi = 'rencanakerjapencampuran'
  }else if (hasiltimbang === true) {
    jenistransaksi = 'hasiltimbang'
  }else if (lampiran === true) {
    jenistransaksi = 'lampiranpengolahan'
  }
  if (planningnumber =='') {
    missingplanningnumber()
    return
  }
  
     window.open ("../page/report/form/page_laporanpengolahan.php?v='"+ jenistransaksi +"'&& n='"+planningnumber+"'&& y='"+years+"'&& z='"+nomix+"'");
}
function pilihanpengolahan(value) {
  var hasiltimbang = document.getElementById('hasiltimbang').checked
  var planningnumber = document.getElementById('nomorplanningreportpengolahan').value;
  if (hasiltimbang === true) {
    if (planningnumber !='') {
      document.getElementById('nomesinreportpengolahan').hidden=false
      var planningnumber = $('#nomorplanningreportpengolahan').val()
      var years =  $('#yearreportpengolahan').val()
      $.ajax({
        url: "../function/getdata2.php",
        method  : "POST",
        cache: false,
        data: {
          "prosespilihanpengolahan": [planningnumber,years]
        },
        success: function (data) {
            $('#selectnomesinreportpengolahan').html(data)
        }
      }) 
    }else{
      document.getElementById('rencanakerjapencampuran').checked=true;
      document.getElementById('hasiltimbang').checked=false
    }
  }else{
    document.getElementById('nomesinreportpengolahan').hidden=true    
  }  
}
function selectplanningnumberreportpengolahan(planningnumber,years) {
  $('#nomorplanningreportpengolahan').val(planningnumber)
  $('#yearreportpengolahan').val(years)
  document.getElementById('rencanakerjapencampuran').checked=true
  pilihanpengolahan()
  $('#searchplanningreportpengolahan').modal('hide')
}

// -------------User Log--------------------

function checkdischeck(values) {
  if (values === true) {
    for (let i = 0; i < 99; i++) {
      document.getElementById('userlog_checked'+i).checked = true;   
      if (i <=99) {
        Swal.fire({
          title: 'Kick all user?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'Yes',
          denyButtonText: 'No',
        }).then((result) => {
          if (result.isConfirmed) {
            
$.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      proseskickuserall: 'Kick'
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Eksekusi berhasil",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  })


          }
        })
      }  
    }
    
  }else{
    for (let i = 0; i < 99; i++) {
      document.getElementById('userlog_checked'+i).checked = false;     
    }
  }
}

// -------------Config - User Managemen------------------
-
function simpanmessagemaintenance() {
  unit = $('#unitsistemmanagemen').val()
  time_from = $('#timefromsistemmanagemen').val()
  time_to = $('#timetosistemmanagemen').val()
  keterangan = $('#keterangansistemmanagemen').val()
  
  if (unit == '') {
    missingparameter()
    return
  }

  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpanmessagemaintenance: [unit,
        time_from,
        time_to,
      keterangan]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Pesan Terkirim",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  }) 
}
function simpanusermanagemen() {
  unit = $('#unitsistemmanagemen2').val()
  lock_user = document.getElementById('locksistemmanagemen').checked
  unlock_user = document.getElementById('unlocksistemmanagemen').checked
  var type_transaksi = ''
  if (lock_user == true) {
    type_transaksi = 'lock'
  }else if (unlock_user == true) {
   type_transaksi = 'unlock' 
  }
  if (unit == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      prosessimpanusermanagemen: [unit,type_transaksi]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Eksekusi berhasil",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  })
}

// -----------Transaksi - Analisa Pengemasan Sekunder----------------

function showtablepengemasansekunder(planningnumber,years,b=0) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "showtableanalisakemasansekunder": [planningnumber,years]
    },
    success: function (data) {
      if (data.isi == 1) {
        document.getElementById('udanalisapengemasansekunder').style.pointerEvents='auto'
        document.getElementById('udanalisapengemasansekunder').style.opacity='100%';
        document.getElementById('simpananalisapengemasansekunder').hidden=false
      }else{
        document.getElementById('udanalisapengemasansekunder').style.pointerEvents='none'
        document.getElementById('udanalisapengemasansekunder').style.opacity='50%';
        document.getElementById('simpananalisapengemasansekunder').hidden=true
      }   
        document.getElementById('showdata_analisapengemasansekunder').innerHTML=data.output
        document.getElementById('setdefault1pengemasansekunder').checked=false
        document.getElementById('setdefault2pengemasansekunder').checked=false

        // Roll
        $('#rollkodesachetalisapengemasansekunder').val('')
        $('#rolljmlsachetalisapengemasansekunder').val('')
        $('#rollsachetbocoralisapengemasansekunder').val('')
        $('#rollbocoralisapengemasansekunder').val('')
        $('#rollrapialisapengemasansekunder').val('')
        $('#rollbrosuralisapengemasansekunder').val('')
        // Box
        $('#boxnumberalisapengemasansekunder').val('')
        $('#boxjmlsampelalisapengemasansekunder').val('')
        $('#boxjmloralisapengemasansekunder').val('')
        $('#boxketprodukalisapengemasansekunder').val('')
        $('#boxkodeproduksialisapengemasansekunder').val('')
        $('#boxedalisapengemasansekunder').val('')
        $('#boxopralisapengemasansekunder').val('')
        $('#boxmelekatalisapengemasansekunder').val('')
        $('#boxsampingatasalisapengemasansekunder').val('')
        $('#boxsampingbawahalisapengemasansekunder').val('')
        $('#boxketalisapengemasansekunder').val('')
        
        $('#shiftpengemasansekunder').val(data.shiftid)
        $('#koipcpengemasansekunder').val(data.koor)     
        $('#roll_inspengemasansekunder').val(data.roll_ins)
        $('#box_inspengemasansekunder').val(data.box_ins)
        $('#roll_tpkpengemasansekunder').val(data.roll_tpk)
        $('#box_tpkpengemasansekunder').val(data.box_tpk)
        $('#roll_cthpengemasansekunder').val(data.roll_cth)
        $('#box_cthpengemasansekunder').val(data.box_cth)
        $('#roll_msnpengemasansekunder').val(data.roll_msn)
        $('#box_msnpengemasansekunder').val(data.box_msn)
        $('#roll_ltpengemasansekunder').val(data.roll_lt)
        $('#box_ltpengemasansekunder').val(data.box_lt)

        $('#rolljmlsampelfrekuensianalisapengemasansekunder').val(data.roll_jmlfrek)
        $('#rollmenitfrekuensianalisapengemasansekunder').val(data.roll_mntfrek)
        $('#boxjmlsampelfrekuensianalisapengemasansekunder').val(data.box_jmlfrek)
        $('#boxmenitfrekuensianalisapengemasansekunder').val(data.box_mntfrek)
        // document.getElementById('roll_lulus_analisapengemasansekunder').value = data.roll_ud
        // document.getElementById('box_lulus_analisapengemasansekunder').value = data.box_ud
        $('#roll_lulus_analisapengemasansekunder').val(data.roll_ud)
        $('#box_lulus_analisapengemasansekunder').val(data.box_ud)
    }
  })
}
function prosesselectprosesanalisakemasansekunder(planningnumber,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdisplayanalisakemasansekunder": [planningnumber,years] 
    },
    success: function (data) {
      if (data.status == 1) {
        $('#planningnumberanalisapengemasansekunder').val(data.planning)
        $('#yearspengemasansekunder').val(data.years)
        $('#productpengemasansekunder').val(data.prod)
        $('#nomesindatepengemasansekunder').val(data.nomesin)
        $('#shiftpengemasansekunder').val(data.shiftid)
        $('#koipcpengemasansekunder').val(data.koor)
        
        $('#roll_inspengemasansekunder').val(data.roll_ins)
        $('#box_inspengemasansekunder').val(data.box_ins)
        $('#roll_tpkpengemasansekunder').val(data.roll_tpk)
        $('#box_tpkpengemasansekunder').val(data.box_tpk)
        $('#roll_cthpengemasansekunder').val(data.roll_cth)
        $('#box_cthpengemasansekunder').val(data.box_cth)
        $('#roll_msnpengemasansekunder').val(data.roll_msn)
        $('#box_msnpengemasansekunder').val(data.box_msn)
        $('#roll_ltpengemasansekunder').val(data.roll_lt)
        $('#box_ltpengemasansekunder').val(data.box_lt)

        $('#rolljmlsampelfrekuensianalisapengemasansekunder').val(data.roll_jmlfrek)
        $('#rollmenitfrekuensianalisapengemasansekunder').val(data.roll_mntfrek)
        $('#boxjmlsampelfrekuensianalisapengemasansekunder').val(data.box_jmlfrek)
        $('#boxmenitfrekuensianalisapengemasansekunder').val(data.box_mntfrek)
        // document.getElementById('roll_lulus_analisapengemasansekunder').value = data.roll_ud
        // document.getElementById('box_lulus_analisapengemasansekunder').value = data.box_ud
        $('#roll_lulus_analisapengemasansekunder').val(data.roll_ud)
        $('#box_lulus_analisapengemasansekunder').val(data.box_ud)
        // if (data.isi == 1) {
        //   document.getElementById('udanalisapengemasansekunder').style.pointerEvents='auto'
        //   document.getElementById('udanalisapengemasansekunder').style.opacity='100%';
        //   document.getElementById('simpananalisapengemasansekunder').hidden=false
        // }else{
        //   document.getElementById('udanalisapengemasansekunder').style.pointerEvents='none'
        //   document.getElementById('udanalisapengemasansekunder').style.opacity='50%';
        //   document.getElementById('simpananalisapengemasansekunder').hidden=true
        // }   
        $('#searchplanningnumberanalisapengemasansekunder').modal('hide')
        // $.ajax({
        //   url: "../function/getdata.php",
        //   type: "POST",
        //   cache: false,
        //   data: {
        //     "showtableanalisakemasansekunder": [planningnumber,years]
        //   },
        //   success: function (data) {
        //       document.getElementById('showdata_analisapengemasansekunder').innerHTML=data
        //       document.getElementById('setdefault1pengemasansekunder').checked=false
        //       document.getElementById('setdefault2pengemasansekunder').checked=false
        //   }
        // })
        showtablepengemasansekunder(planningnumber,years)
      }
    }
  })
}
function get_valuefromcheckbox(idcheckbox,idtextbox) {
  var x = false;
  if (document.getElementById(idcheckbox).checked == true) {
    x = document.getElementById(idtextbox).value
  }else{
    x = '-'
    // document.getElementById(idtextbox).value =''
  }
  return x
}
function simpanrollalisapengemasansekunder() {
  var planningnumber = $('#planningnumberanalisapengemasansekunder').val()
  var jam = $('#rolljamanalisapengemasansekunder').val()
  var kodesachet =  $('#rollkodesachetalisapengemasansekunder').val()
  var jmlsachet =  $('#rolljmlsachetalisapengemasansekunder').val()
  var sachetbocor =  $('#rollsachetbocoralisapengemasansekunder').val()
  var bocor =  $('#rollbocoralisapengemasansekunder').val()
  var rapi =  $('#rollrapialisapengemasansekunder').val()
  var brosur =  $('#rollbrosuralisapengemasansekunder').val()
  var item = $('#rollitemanalisapengemasansekunder').val()
  var years = $('#yearspengemasansekunder').val()
  var shiftid = $('#shiftpengemasansekunder').val()
  var koor = $('#koipcpengemasansekunder').val()
  var nomesin = $('#nomesindatepengemasansekunder').val()

  var roll_ins = $('#roll_inspengemasansekunder').val()
  var box_ins = $('#box_inspengemasansekunder').val()
  var roll_tpk = $('#roll_tpkpengemasansekunder').val()
  var box_tpk = $('#box_tpkpengemasansekunder').val()
  var roll_cth = $('#roll_cthpengemasansekunder').val()
  var box_cth = $('#box_cthpengemasansekunder').val()
  var roll_msn = $('#roll_msnpengemasansekunder').val()
  var box_msn = $('#box_msnpengemasansekunder').val()
  var roll_lt = $('#roll_ltpengemasansekunder').val()
  var box_lt = $('#box_ltpengemasansekunder').val()


  if (planningnumber == '' || item == '' || kodesachet == '') {
    missingplanningnumber()
    return
  }
  if (kodesachet == '') {
    missingparameter()
    return
  }

  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanrollanalisapengemasansekunder": [planningnumber,
        jam,
        kodesachet,
        jmlsachet,
        sachetbocor,
        bocor,
        rapi,
        brosur,
        item,
        years,
        shiftid,
        koor,
        nomesin,
        roll_ins,
        box_ins,
        roll_tpk,
        box_tpk,
        roll_cth,
        box_cth,
        roll_msn,
        box_msn,
        roll_lt,
        box_lt
      ]
    },
    success: function (data) {
      if (data.return == 1) {
        $('#boxitemanalisapengemasansekunder').attr('max',data.item)
        $('#rollitemanalisapengemasansekunder').attr('max',data.item)
        $('#boxitemanalisapengemasansekunder').val(data.item)
        $('#rollitemanalisapengemasansekunder').val(data.item)
        document.getElementById('simpananalisapengemasansekunder').hidden=false
        // $.ajax({
        //   url: "../function/getdata.php",
        //   type: "POST",
        //   cache: false,
        //   data: {
        //     "showtableanalisakemasansekunder": [planningnumber,years]
        //   },
        //   success: function (data) {
        //     document.getElementById('udanalisapengemasansekunder').style.pointerEvents='auto'
        //       document.getElementById('showdata_analisapengemasansekunder').innerHTML=data
        //       // var jam = $('#rolljamanalisapengemasansekunder').val()
        //       $('#rollkodesachetalisapengemasansekunder').val('')
        //       $('#rolljmlsachetalisapengemasansekunder').val('')
        //       $('#rollsachetbocoralisapengemasansekunder').val('')
        //       $('#rollbocoralisapengemasansekunder').val('')
        //       $('#rollrapialisapengemasansekunder').val('')
        //       $('#rollbrosuralisapengemasansekunder').val('')
        //   }
        // })
        showtablepengemasansekunder(planningnumber,years)
      }
    }
  }) 
}
function simpanboxalisapengemasansekunder() {
  var planningnumber = $('#planningnumberanalisapengemasansekunder').val()
  var jml_or = $('#boxjmloralisapengemasansekunder').val()
  var jam = $('#boxjamalisapengemasansekunder').val()
  var nobox = $('#boxnumberalisapengemasansekunder').val()
  var jmlsampel = $('#boxjmlsampelalisapengemasansekunder').val()
  var item = $('#boxitemanalisapengemasansekunder').val()
  var years = $('#yearspengemasansekunder').val()

  var ket_produksi = $('#boxketprodukalisapengemasansekunder').val()
  var kodeproduksi = $('#boxkodeproduksialisapengemasansekunder').val()
  var edbc = $('#boxedalisapengemasansekunder').val()
  var opr = $('#boxopralisapengemasansekunder').val()
  var melekat = $('#boxmelekatalisapengemasansekunder').val()
  var sampingatas = $('#boxsampingatasalisapengemasansekunder').val()
  var sampingbawah = $('#boxsampingbawahalisapengemasansekunder').val()
  var ket = $('#boxketalisapengemasansekunder').val()

  var shiftid = $('#shiftpengemasansekunder').val()
  var koor = $('#koipcpengemasansekunder').val()
  var nomesin = $('#nomesindatepengemasansekunder').val()

  var roll_ins = $('#roll_inspengemasansekunder').val()
  var box_ins = $('#box_inspengemasansekunder').val()
  var roll_tpk = $('#roll_tpkpengemasansekunder').val()
  var box_tpk = $('#box_tpkpengemasansekunder').val()
  var roll_cth = $('#roll_cthpengemasansekunder').val()
  var box_cth = $('#box_cthpengemasansekunder').val()
  var roll_msn = $('#roll_msnpengemasansekunder').val()
  var box_msn = $('#box_msnpengemasansekunder').val()
  var roll_lt = $('#roll_ltpengemasansekunder').val()
  var box_lt = $('#box_ltpengemasansekunder').val()
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
  if (jmlsampel == '' || jam == '' || nobox =='') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessimpananboxanalisapengemasansekunder": [planningnumber,
        jml_or,
        ket_produksi,
        kodeproduksi,
        edbc,
        opr,
        jam,
        nobox,
        jmlsampel,
        melekat,
        sampingatas,
        sampingbawah,
        ket,
        item,
        years,
        shiftid,
        koor,
        nomesin,
        roll_ins,
        box_ins,
        roll_tpk,
        box_tpk,
        roll_cth,
        box_cth,
        roll_msn,
        box_msn,
        roll_lt,
        box_lt
      ]
    },
    success: function (data) {
      if (data.return == 1) {
        $('#boxitemanalisapengemasansekunder').attr('max',data.item)
        $('#rollitemanalisapengemasansekunder').attr('max',data.item)
        $('#boxitemanalisapengemasansekunder').val(data.item)
        $('#rollitemanalisapengemasansekunder').val(data.item)
        document.getElementById('simpananalisapengemasansekunder').hidden=false
        // $.ajax({
        //   url: "../function/getdata.php",
        //   type: "POST",
        //   cache: false,
        //   data: {
        //     "showtableanalisakemasansekunder": [planningnumber,years]
        //   },
        //   success: function (data) {
        //       document.getElementById('showdata_analisapengemasansekunder').innerHTML=data
        //       $('#boxnumberalisapengemasansekunder').val('')
        //       $('#boxjmlsampelalisapengemasansekunder').val('')
        //       $('#boxjmloralisapengemasansekunder').val('')
        //       $('#boxketprodukalisapengemasansekunder').val('')
        //       $('#boxkodeproduksialisapengemasansekunder').val('')
        //       $('#boxedalisapengemasansekunder').val('')
        //       $('#boxopralisapengemasansekunder').val('')
        //       $('#boxmelekatalisapengemasansekunder').val('')
        //       $('#boxsampingatasalisapengemasansekunder').val('')
        //       $('#boxsampingbawahalisapengemasansekunder').val('')
        //       $('#boxketalisapengemasansekunder').val('')
              
        //   }
        // })
        showtablepengemasansekunder(planningnumber,years)
      }else{
        Swal.fire({
          text: "Proses Input N/W Outeroll Belum Tersedia",
          icon: "error",
          showConfirmButton: true,
        })
      }
    }
  }) 
}
function deleteprosesanalisapengemasansekunder(planningnumber,item,years) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesdeleteanalisapengemasansekunder": [planningnumber,item,years]
    },
    success: function (data) {
      if (data.return == 1) {
        $('#boxitemanalisapengemasansekunder').attr('max',data.item)
        $('#rollitemanalisapengemasansekunder').val(data.item)
        if (data.isi == 1) {
          document.getElementById('simpananalisapengemasansekunder').hidden=false
        }   else{
          document.getElementById('simpananalisapengemasansekunder').hidden=true
        }
        // $.ajax({
        //   url: "../function/getdata.php",
        //   type: "POST",
        //   cache: false,
        //   data: {
        //     "showtableanalisakemasansekunder": [planningnumber,years]
        //   },
        //   success: function (data) {
        //       document.getElementById('showdata_analisapengemasansekunder').innerHTML=data
        //       $('#rollkodesachetalisapengemasansekunder').val('')
        //       $('#rolljmlsachetalisapengemasansekunder').val('')
        //       $('#rollsachetbocoralisapengemasansekunder').val('')
        //       $('#rollbocoralisapengemasansekunder').val('')
        //       $('#rollrapialisapengemasansekunder').val('')
        //       $('#rollbrosuralisapengemasansekunder').val('')
        //   }
        // })
        // setTimeout(function() {
        //   window.location.hash = "udanalisapengemasansekunder"
        // }, 10);
        showtablepengemasansekunder(planningnumber,years,b=1)
      }
    },
  });  
}
function simpananalisapengemasansekunder() { 
  var planningnumber = $('#planningnumberanalisapengemasansekunder').val()
  var box = document.getElementById('box_lulus_analisapengemasansekunder').value
  var roll = document.getElementById('roll_lulus_analisapengemasansekunder').value
  var rollmenitfrek = document.getElementById('rollmenitfrekuensianalisapengemasansekunder').value
  var rolljmlfrek = document.getElementById('rolljmlsampelfrekuensianalisapengemasansekunder').value
  var boxmenitfrek = document.getElementById('boxmenitfrekuensianalisapengemasansekunder').value
  var boxjmlfrek = document.getElementById('boxjmlsampelfrekuensianalisapengemasansekunder').value
  var years = $('#yearspengemasansekunder').val()

  var shiftid = $('#shiftpengemasansekunder').val()
  var koor = $('#koipcpengemasansekunder').val()
  var nomesin = $('#nomesindatepengemasansekunder').val()

  var roll_ins = $('#roll_inspengemasansekunder').val()
  var box_ins = $('#box_inspengemasansekunder').val()
  var roll_tpk = $('#roll_tpkpengemasansekunder').val()
  var box_tpk = $('#box_tpkpengemasansekunder').val()
  var roll_cth = $('#roll_cthpengemasansekunder').val()
  var box_cth = $('#box_cthpengemasansekunder').val()
  var roll_msn = $('#roll_msnpengemasansekunder').val()
  var box_msn = $('#box_msnpengemasansekunder').val()
  var roll_lt = $('#roll_ltpengemasansekunder').val()
  var box_lt = $('#box_ltpengemasansekunder').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanananalisapengemasansekunder": [planningnumber,
                                                    box,
                                                    roll,
                                                    years,
                                                    rolljmlfrek,
                                                    rollmenitfrek,
                                                    boxjmlfrek,
                                                    boxmenitfrek,
                                                    shiftid,
                                                    koor,
                                                    nomesin,
                                                    roll_ins,
                                                    box_ins,
                                                    roll_tpk,
                                                    box_tpk,
                                                    roll_cth,
                                                    box_cth,
                                                    roll_msn,
                                                    box_msn,
                                                    roll_lt,
                                                    box_lt]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        });
      }
    }
  }) 
}
function setstrip1pengemasansekunder(values) {
  if (values == true) {
    $('#rollkodesachetalisapengemasansekunder').val('-')
    $('#rolljmlsachetalisapengemasansekunder').val('-')
    $('#rollsachetbocoralisapengemasansekunder').val('-')
    $('#rollbocoralisapengemasansekunder').val('-')
    $('#rollrapialisapengemasansekunder').val('-')
    $('#rollbrosuralisapengemasansekunder').val('-')
  }else{
    $('#rollkodesachetalisapengemasansekunder').val('')
    $('#rolljmlsachetalisapengemasansekunder').val('')
    $('#rollsachetbocoralisapengemasansekunder').val('')
    $('#rollbocoralisapengemasansekunder').val('')
    $('#rollrapialisapengemasansekunder').val('')
    $('#rollbrosuralisapengemasansekunder').val('')
  }
}
function setstrip2pengemasansekunder(values) {
  if (values == true) {
    $('#boxnumberalisapengemasansekunder').val('-')
    $('#boxjmlsampelalisapengemasansekunder').val('-')
    $('#boxketprodukalisapengemasansekunder').val('-')
    $('#boxkodeproduksialisapengemasansekunder').val('-')
    $('#boxedalisapengemasansekunder').val('-')
    $('#boxopralisapengemasansekunder').val('-')
    $('#boxsampingatasalisapengemasansekunder').val('-')
    $('#boxsampingbawahalisapengemasansekunder').val('-')
    $('#boxmelekatalisapengemasansekunder').val('-')
    $('#boxjmloralisapengemasansekunder').val('-')
    $('#boxketalisapengemasansekunder').val('-')
  }else{
    $('#boxnumberalisapengemasansekunder').val('')
    $('#boxjmlsampelalisapengemasansekunder').val('')
    $('#boxketprodukalisapengemasansekunder').val('')
    $('#boxkodeproduksialisapengemasansekunder').val('')
    $('#boxedalisapengemasansekunder').val('')
    $('#boxopralisapengemasansekunder').val('')
    $('#boxsampingatasalisapengemasansekunder').val('')
    $('#boxsampingbawahalisapengemasansekunder').val('')
    $('#boxmelekatalisapengemasansekunder').val('')
    $('#boxjmloralisapengemasansekunder').val('')
    $('#boxketalisapengemasansekunder').val('')
  }
}

// -------------Transaksi - Proses Timbang------------------

function prosesselectlisttimbangan(addressof) {
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    dataType: "JSON",
    cache: false,
    data: {
      "prosesdisplaydatatimbangan": addressof
    },
    success: function (data) {
      if (data.return == 1) {
        $('#ipaddressdatatimbangan').val(data.ipaddress)
        $('#portdatatimbangan').val(data.port)
        $('#namatimbangandatatimbangan').val(data.namatimbangan)
        document.getElementById('autoprintdatatimbangan').checked =false
        if (data.autoprint == 'X') {
          document.getElementById('autoprintdatatimbangan').checked =true
          document.getElementById('autoprintdatatimbangan').disabled=false
        }
        document.getElementById('autotimbangmodaltimbangbahan').checked =false
        document.getElementById('ambildatatimbangan').hidden=false
        if (data.autotimbang == 'X') {
          document.getElementById('autotimbangmodaltimbangbahan').checked =true
          // document.getElementById('autotimbangmodaltimbangbahan').disabled=false
          document.getElementById('ambildatatimbangan').hidden=true
        }
        document.getElementById('autosavedatatimbangan').checked =false
        document.getElementById('simpandatatimbang').hidden =false
        document.getElementById('stopdatatimbangan').checked =false
        document.getElementById('stopdatatimbangan').removeAttribute('disabled')
        if (data.stoped == 'X') {
          document.getElementById('stopdatatimbangan').checked =true
          document.getElementById('textcountdowndatatimbang').innerHTML= 'Stoped'
        }
        if (data.autosave == 'X') {
          document.getElementById('autosavedatatimbangan').checked =true
          document.getElementById('simpandatatimbang').hidden =true
        }
        if (data.getweight == 'Gross') {
          document.getElementById('grossgetweightdatatimbangan').checked=true
          document.getElementById('taregetweightdatatimbangan').checked=false
          document.getElementById('netgetweightdatatimbangan').checked=false
        }
        if (data.getweight == 'Tare') {
          document.getElementById('grossgetweightdatatimbangan').checked=false
          document.getElementById('taregetweightdatatimbangan').checked=true
          document.getElementById('netgetweightdatatimbangan').checked=false
        }
        if (data.getweight == 'Net') {
          document.getElementById('grossgetweightdatatimbangan').checked=false
          document.getElementById('taregetweightdatatimbangan').checked=false
          document.getElementById('netgetweightdatatimbangan').checked=true
        }
        $('#searchnamatimbangandatatimbanganbahan').modal('hide') 
      }else{
        $('#searchnamatimbangandatatimbanganbahan').modal('hide')
        Swal.fire({
          text: "Timbangan sedang digunakan !",
          icon: "warning",
          showConfirmButton: false,
          timer: 3000,
        })
      }          
    }
  })
}
function prosesunlocklisttimbangan(addressof) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
        "prosesunlocktimbangan": addressof
    },
    success: function(data) {
        if (data.return == 1) {
            location.reload()
        }else if(data.return == 2){
          Swal.fire({
            text: 'Timbangan ready',
            icon: "warning",
            showConfirmButton: false,
            timer: 1500
          })
        }else{
          Swal.fire({
            text: data.return,
            icon: "warning",
            showConfirmButton: true,
          })
        }
    }
})
}
function cekkoneksitimbangan() {
  var namatimbangan = $('#namatimbangandatatimbangan').val()
  var addressof = $('#ipaddressdatatimbangan').val()
  var port = $('#portdatatimbangan').val()
  if (namatimbangan == '' || addressof == '' || port == '') {
    $('#searchnamatimbangandatatimbanganbahan').modal('show')
    return
  }
  var cekkoneksi = document.getElementById('koneksitimbangbahan').innerHTML
  if (cekkoneksi == 'Connect') {
    $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
            "prosescekkoneksitimbangan": [namatimbangan,addressof,port,'connect']
        },
        success: function(data) {
            if (data.return == 1) {
                document.getElementById('koneksitimbangbahan').innerHTML = 'Disconnect'
                Swal.fire({
                  text: "Terhubung dengan timbangan !",
                  icon: "success",
                  showConfirmButton: false,
                })
                setTimeout(function () {
                  location.reload()
                }, 1500);
            } else if(data.return == 2) {
                document.getElementById('koneksitimbangbahan').innerHTML = 'Connect'
                Swal.fire({
                  text: "Gagal terhubung dengan Modbus !",
                  icon: "warning",
                  showConfirmButton: false,
                  timer: 1500,
                })
            }else{
              document.getElementById('koneksitimbangbahan').innerHTML = 'Connect'
              setTimeout(function () {
                location.reload()
              }, 1500);
            }
        }
    })
  }else{
    Swal.fire({
      title: 'Yakin',
      text: "Putuskan dari timbangan ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Iya'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../function/getdata.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
              "prosescekkoneksitimbangan": [namatimbangan,addressof,port,'disconnect']
          },
          success: function(data) {
              if (data.return == 1) {
                  location.reload()
              }
          }
        })
      }
    })
  }
}
function getdatatimbangan() {
  var addressof = $('#ipaddressdatatimbangan').val()
  var port = $('#portdatatimbangan').val()
  var autosave = document.getElementById('autosavedatatimbangan').checked
  var cekkoneksi = document.getElementById('koneksitimbangbahan').innerHTML
  var stop = document.getElementById('stopdatatimbangan').checked
  if (cekkoneksi != 'Disconnect') {
    koneksitimbangan()
    return
  }
  // if (stop === true) {
  //   return
  // }
  var weight = ''
  $('#showdatatimbangan').val('')
  var gross = document.getElementById('grossgetweightdatatimbangan')
  var net = document.getElementById('netgetweightdatatimbangan')
  var tare = document.getElementById('taregetweightdatatimbangan')

  if (gross.checked === true) {
      weight = 'gross'
  }
  if (net.checked === true) {
      weight = 'net'
  }
  if (tare.checked === true) {
      weight = 'tare'
  }

  $.ajax({
      url: "../function/getdata.php",
      dataType: "JSON", 
      type: "POST",
      cache: false,
      data: {
          "prosesgetdatatimbangan": [addressof,
          port,weight]
      },
      success: function(data) {
        // alert(data.cb)
        if (data.return == 2) {
          document.getElementById('koneksitimbangbahan').innerHTML = 'Connect'
          Swal.fire({
            text: "Gagal terhubung dengan Modbus !",
            icon: "warning",
            showConfirmButton: false,
            timer: 2000,
          })
        }else if(data.return==1 && data.weight !='' && data.weight !== null){
            $('#bebandatatimbangan').val(data.weight_qty + data.weight_uom)
            setTimeout(function() {
              if (autosave === true) {
                simpandatatimbangan()
              }
            }, 500);
        }else if (data.return==1 && data.weight=='') {
          Swal.fire({
            text: "Kabel serial RS232 tidak terhubung",
            icon: "warning",
            showConfirmButton: false,
            timer: 2000,
          })
        }else if (data.return==1 && data.weight=== null) {
          Swal.fire({
            text: "Tidak bisa mengambil berat " + data.weight + ". Restart Scale / Set config pengambilan berat (Net/Gross/Tare)",
            icon: "warning",
            showConfirmButton: false,
            timer: 2000,
          })
        }else if (data.return=3) {
          Swal.fire({
            text: "Tidak dapat mengambil data dari timbangan",
            icon: "warning",
            showConfirmButton: false,
            timer: 2000,
          })
        }
      }
  })
}
function getadditionaldata() {
  var cekkoneksi = document.getElementById('koneksitimbangbahan').innerHTML
  if (cekkoneksi == 'Connect') {
    koneksitimbangan()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    method  : "POST",
    cache: false,
    data: {
      "prosesadditionaldatatimbangan": true
    },
    success: function (data) {
      if (data.return == 1) {
        $('#timbangandatatimbangan').val(data.namatimbangan)
        $('#ipdatatimbangan').val(data.ip)
        $('#portdatatimbangan').val(data.port)
        $('#searchadditionaldatadatatimbanganbahan').modal('show')
      }
    }
  }) 
}
function submitproducttimbangbahan(productid,prod_desc) {
  $('#productiddatatimbangan').val(productid)
  $('#productdescdatatimbangan').val(prod_desc)
  $('#listproduktimbangbahan').modal('hide')
  $('#searchadditionaldatadatatimbanganbahan').modal('show')
}
function deleteprosestimbang(planningnumber,years,item,productid,batch,usedby,addressof) {
  Swal.fire({
    // title: 'Apa anda yakin?',
    text: "Menghapus data set timbang akan menghapus seluruh data yang sudah terlanjur ditimbang. Tetap lakukan Hapus data set timbang?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeleteprosestimbang": [planningnumber,years,item,productid,batch,usedby,addressof]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
            $('#searchadditionaldatadatatimbanganbahan').modal('show')
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
          }
        },
      });  
    }
  })
}
//   $('#operatordatatimbangan').val(pernr)
//   $('#searchoperatordatatimbangan').modal('hide')
//   $('#searchadditionaldatadatatimbanganbahan').modal('show')
// }
// function activemanualinput_drymixed(productid, batch, swab) {
//   if (swab == 'on') {
//     Swal.fire({
//       title: 'Yakin',
//       text: "Gunakan data timbang produk " + productid +" dan batch "+ batch +"?",
//       icon: 'warning',
//       showCancelButton: true,
//       confirmButtonColor: '#3085d6',
//       cancelButtonColor: '#d33',
//       confirmButtonText: 'Iya'
//     }).then((result) => {
//       if (result.isConfirmed) {
//         $.ajax({
//           url: "../function/getdata.php",
//           method  : "POST",
//           cache: false,
//           data: {
//             "prosesactivemanualinput_drymixed": [productid,batch,swab]
//           },
//           success: function (data) {
//             if (data == 1) {
//               Swal.fire({
//                 text: "Data label sudah terpasang. Silahkan lakukan penimbangan bahan !",
//                 icon: "success",
//                 showConfirmButton: true,
//               }).then((result) => {
//                 if (result.isConfirmed) {
//                   location.reload()
//                 }
//               });
//             }else{
//               Swal.fire({
//                 text: data,
//                 icon: "info",
//                 showConfirmButton: false,
//                 timer: 3000,
//               })
//               setTimeout(function () {
//                 location.reload()
//               }, 1500);
//             }
//           }
//         }) 
//       }else{
//         location.reload()
//       }
//     })
//   }else{
//     $.ajax({
//       url: "../function/getdata.php",
//       method  : "POST",
//       cache: false,
//       data: {
//         "prosesactivemanualinput_drymixed": [productid,batch,swab]
//       },
//       success: function (data) {
//         if (data == 1) {
//           Swal.fire({
//             text: "Pasang data label terlebih dahulu sebelum proses penimbangan",
//             icon: "info",
//             showConfirmButton: true,
//           }).then((result) => {
//             if (result.isConfirmed) {
//               location.reload()
//             }
//           });
//         }
//       }
//     }) 
//   }
// }
// 
function cekkoneksidatatimbang() {
  var namtim = $('#namatimbangandatatimbangan').val()
  var ip = $('#ipaddressdatatimbangan').val()
  var port = $('#portdatatimbangan').val()
  if (namtim != '' && ip != '' && port != '') {
      $.ajax({
          url: "../function/getdata.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
              "prosescekkoneksitimbangan": [namtim, ip, port, 'cekconnect']
          },
          success: function(data) {
              if (data.return == 1) {
                  document.getElementById('koneksitimbangbahan').innerHTML = 'Disconnect'
                  $('#ipaddressdatatimbangan').val(data.ipaddress)
                  $('#portdatatimbangan').val(data.port)
                  $('#namatimbangandatatimbangan').val(data.namatimbangan)
                  document.getElementById('ambildatatimbangan').hidden=false
                  if (data.autotimbang == 'X') {
                    document.getElementById('autotimbangmodaltimbangbahan').checked =true
                    // document.getElementById('autotimbangmodaltimbangbahan').disabled=false
                    document.getElementById('ambildatatimbangan').hidden=true
                  }
                  document.getElementById('stopdatatimbangan').checked =false
                  document.getElementById('stopdatatimbangan').removeAttribute('disabled')
                  if (data.stoped == 'X') {
                    document.getElementById('stopdatatimbangan').checked =true
                    document.getElementById('textcountdowndatatimbang').innerHTML= 'Stoped'
                  }
                  document.getElementById('autoprintdatatimbangan').checked = false
                  if (data.autoprint == 'X') {
                      document.getElementById('autoprintdatatimbangan').checked = true
                  }
                  document.getElementById('autosavedatatimbangan').checked = false
                  document.getElementById('simpandatatimbang').hidden = false
                  if (data.autosave == 'X') {
                      document.getElementById('autosavedatatimbangan').checked = true
                      document.getElementById('simpandatatimbang').hidden = true
                  }
                  if (data.getweight == 'Gross') {
                      document.getElementById('getweightdatatimbangangross').hidden = false
                      document.getElementById('grossgetweightdatatimbangan').hidden = false
                      document.getElementById('grossgetweightdatatimbangan').checked = true
                      document.getElementById('taregetweightdatatimbangan').checked = false
                      document.getElementById('netgetweightdatatimbangan').checked = false
                  }
                  if (data.getweight == 'Tare') {
                      document.getElementById('getweightdatatimbangantare').hidden = false
                      document.getElementById('taregetweightdatatimbangan').hidden = false
                      document.getElementById('grossgetweightdatatimbangan').checked = false
                      document.getElementById('taregetweightdatatimbangan').checked = true
                      document.getElementById('netgetweightdatatimbangan').checked = false
                  }
                  if (data.getweight == 'Net') {
                      document.getElementById('getweightdatatimbangannet').hidden = false
                      document.getElementById('netgetweightdatatimbangan').hidden = false
                      document.getElementById('grossgetweightdatatimbangan').checked = false
                      document.getElementById('taregetweightdatatimbangan').checked = false
                      document.getElementById('netgetweightdatatimbangan').checked = true
                  }
                  document.getElementById('configtimbangbahan').disabled = false
              }
          }
      });
  }
}
function simpandatatimbangan() {
  var addressof = $('#ipaddressdatatimbangan').val()
  var port = $('#portdatatimbangan').val()
  var cekkoneksi = document.getElementById('koneksitimbangbahan').innerHTML
  var autoprint = document.getElementById('autoprintdatatimbangan').checked
  if (cekkoneksi == 'Connect') {
    koneksitimbangan()
    return
  }
  var Sberat = $('#bebandatatimbangan').val()
  var berat = Sberat.replace("kg"," ")
  if (berat == '0Kg') {
    missingbobottimbang()
    return
  }
  
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanhasiltimbang": [berat,addressof,port]
    },
    success: function (data) {
      if (data.return == 1) {
        if (autoprint === true) {
          printdatatimbang(data.planningnumber,data.years,data.item,data.productid,data.bets,data.noproses,data.notong,berat)
        }
        setTimeout(function () {
          location.reload()
        }, 500);    
      }else{
        Swal.fire({
          text: data.return,
          icon: "warning",
          showConfirmButton: true,
        })
      }
    }
  }) 
}
function stopedtimbanganchange(values) {
  var addressof = $('#ipaddressdatatimbangan').val()
  var port = $('#portdatatimbangan').val()
  var cekkoneksi = document.getElementById('koneksitimbangbahan').innerHTML
  $.ajax({
    url: "../function/getdata.php",
    // dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesstopedtimbanganchange": [addressof,port,cekkoneksi,values]
    },
    success: function (data) {
      if (data == 1) {
        location.reload()
      }
    }
  })
}
function printdatatimbang(planningnumber,years,item,product,batch,noproses,notong,qty) {
  var x = planningnumber.concat('*',years,'*',item,'*',product,'*',batch,'*',noproses,'*',notong,'*',qty)
  window.open ("../page/production/planning/form/print_datatimbang?x="+x+"");
}
function previewdatatimbang(planningnumber,years,item,product,batch,noproses,notong,qty) {
  var x = planningnumber.concat('*',years,'*',item,'*',product,'*',batch,'*',noproses,'*',notong,'*',qty)
   window.open ("../page/production/planning/form/printpre_datatimbang?x="+x+"");
}
function printDocument(documentId) {
  var doc = document.getElementById(documentId);
  //Wait until PDF is ready to print    
  if (typeof doc.print === 'undefined') {    
      setTimeout(function(){printDocument(documentId);}, 1000);
  } else {
      doc.print();
  }
}
function deletedatatimbang(planningnumber,years,item,productid,batch,noproses,notong) {
  clearInterval(getdatatimbangmanual)
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosesdeletehasiltimbang": [
        planningnumber,years,item,productid,batch,noproses,notong
      ]
    },
    success: function (data) {
      if (data == 1) {
        location.reload()
      }
    }
  }) 
}
function setconfigdatatimbangan() {
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    method  : "POST",
    cache: false,
    data: {
      "prosessetconfigdatatimbangan": "default"
    },
    success: function (data) {
      if (data.return == 1) {
        document.getElementById('grossmodaltimbangbahan').checked=false
        document.getElementById('netmodaltimbangbahan').checked=false
        document.getElementById('taremodaltimbangbahan').checked=false
        document.getElementById('autoprintmodaltimbangbahan').checked=false
        document.getElementById('autosavemodaltimbangbahan').checked=false
        if (data.autoprint == 'X') {
          document.getElementById('autoprintmodaltimbangbahan').checked=true
        }
        if (data.autosave == 'X') {
          document.getElementById('autosavemodaltimbangbahan').checked=true
        }
        
        if (data.getweight == 'Gross') {
          document.getElementById('grossmodaltimbangbahan').checked=true
        }else if (data.getweight == 'Net') {
          document.getElementById('netmodaltimbangbahan').checked=true
        }else if (data.getweight == 'Tare') {
          document.getElementById('taremodaltimbangbahan').checked=true
        }
        $('#searchconfigdatatimbanganbahan').modal('show')
      }
    }
  }) 
}
function simpanmodaltimbangbahan() {
  var autoprint = document.getElementById('autoprintmodaltimbangbahan').checked
  var autosave = document.getElementById('autosavemodaltimbangbahan').checked
  var autotimbang = document.getElementById('autotimbangmodaltimbangbahan').checked
  var gross = document.getElementById('grossmodaltimbangbahan').checked
  var net = document.getElementById('netmodaltimbangbahan').checked
  var tare = document.getElementById('taremodaltimbangbahan').checked
  var getweight = ''
  if (autoprint === true) {
    autoprint = 'X'
  }
  if (autosave === true) {
    autosave = 'X'
  }
  if (autotimbang === true) {
    autotimbang = 'X'
  }
  if (gross === true) {
    getweight = 'Gross'
  }
  if (net === true) {
    getweight = 'Net'
  }
  if (tare === true) {
    getweight = 'Tare'
  }
  $.ajax({
    url: "../function/getdata2.php",
    method  : "POST",
    cache: false,
    data: {
      "prosessimpanmodaltimbangbahan": [autoprint,autosave,getweight,autotimbang]
    },
    success: function (data) {
      $('#searchconfigdatatimbanganbahan').modal('hide')
      if (data == 1) {
        Swal.fire({
          text: "Data tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload()
        }, 1500);
      }
    }
  }) 
}
function selectgetproductid(planningnumber,productid,years,item) {
  $('#planningnumbertimbangbahan').val(planningnumber)
  $('#productiddatatimbang').val(productid)
  $('#yearsdatatimbang').val(years)
  $('#itemdatatimbangan').val(item)
  $.ajax({
    url: "../function/getdata2.php",
    method  : "POST",
    cache: false,
    data: {
      "prosesselectgetproductid": [planningnumber,productid,years,item]
    },
    success: function (data) {
        $('#batchdatatimbangan').html(data)
        var batch = $('#batchdatatimbangan').val()
        getdetailbatchdatatimbang(batch)

    }
  }) 
}
function getdetailbatchdatatimbang(batch) {
  var planningnumber = $('#planningnumbertimbangbahan').val()
  var productid =  $('#productiddatatimbang').val()
  var years =  $('#yearsdatatimbang').val()
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    method  : "POST",
    cache: false,
    data: {
      "prosesgetdetailbatchdatatimbang": [planningnumber,
        productid,years,batch]
    },
    success: function (data) {
        $('#tglmixingatatimbangan').val(data.tglmixing)
        $('#nomesindatatimbangan').val(data.nomesin)
        $('#nowadahdatatimbangan').val(data.nowadah)
        $('#noprosesdatatimbangan').val(data.noproses)
        $('#expdatedattimbangan').val(data.ed)
    }
  }) 
}
function submitdatatimbangan() {
  var planningnumber = $('#planningnumbertimbangbahan').val()
  var years = $('#yearsdatatimbang').val()
  var productid = $('#productiddatatimbang').val()
  var batch = $('#batchdatatimbangan').val()
  // var noproses = $('#noprosesdatatimbangan').val()
  var operator1 = $('#operator1datatimbangan').val()
  var operator2 = $('#operator2datatimbangan').val()
  var item = $('#itemdatatimbangan').val()
  var ip = $('#ipdatatimbangan').val()
  $.ajax({
    url: "../function/getdata2.php",
    method  : "POST",
    cache: false,
    data: {
      "prosessubmitdatatimbangan": [planningnumber,
      years,productid,batch,operator1,operator2,
    item,ip]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload();    
        }, 1500);
      }else{
        Swal.fire({
          text: data,
          icon: "warning",
          showConfirmButton: false,
          timer:1500
        })
      }
    }
  }) 
}
function stopprosestimbang(planningnumber,years,item,productid,batchnumber,usedby) {
  Swal.fire({
    text: "Stop proses timbang?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Oke'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesstopprosestimbang": [
            planningnumber,years,item,productid,batchnumber,usedby
          ]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Data tersimpan",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          }else{
            Swal.fire({
              text: data,
              icon: "warning",
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      })
  } 
})
}

// -------------History Timbang - Pengolahan-----------------

function prosesselecthistorytimbang(planning,years,productid,batch) {
  location.href = linkedip+'/page/mainpage?p=historytimbang&v='+planning+'&w='+years+'&x='+productid+'&y='+batch+'&z=1'
}
function changevalueprosesnumberhistorytimbang(planning,years,productid,batch,noproses) {
  location.href = linkedip+'/page/mainpage?p=historytimbang&v='+planning+'&w='+years+'&x='+productid+'&y='+batch+'&z='+noproses+''
}
function previewlabelpalet() {
  var planningnumber = $('#planningnumberhistorytimbang').val()
  var years = $('#inspyearsanalisaorganoleptis').val()
  var product = $('#productanalisaorganoleptis').val()
  var batch = $('#batchanalisaorganoleptis').val()
  var noproses = $('#prosesnumberalisaorganoleptis').val()

  var x = planningnumber.concat('*',years,'*',product,'*',batch,'*',noproses)
   location.href= ("../page/mainpage?p=labelpalet&x="+x+"");
}
function prosesselectlabelpalet(planningnumber,years,product,batch,desc) {
  $('#planningnumberlabelpalet').val(planningnumber)
  $('#yearsanalisaorganoleptis').val(years)
  $('#productlabelpalet').val(product)
  $('#batchlabelpalet').val(batch)
  $('#deskripsilabelpalet').val(desc)
  $('#searchplanningnumberlabelpalet').modal('hide')
}
function prosesviewlabelpalet() {
  var planningnumber = $('#planningnumberlabelpalet').val()
  var years = $('#yearsanalisaorganoleptis').val()
  var product = $('#productlabelpalet').val()
  var batch = $('#batchlabelpalet').val()
  var noproses = $('#prosesnumberlabelpalet').val()
  var x = planningnumber.concat('*',years,'*',product,'*',batch,'*',noproses)
  window.open ("../page/production/timbang/form/page_labelpalet?x="+x+"");
}
function submitkirimbahan(e) {
  if (e.key === "Enter") {
    var barcode = $('#scanbarcodekirimbahan').val()
    // alert(barcode)
    $.ajax({
      url: "../function/getdata2.php",
      method  : "POST",
      dataType: "JSON",
      cache: false,
      data: {
        "prosessubmitkirimbahan": barcode
      },
      success: function (data) {
        if (data.return == 1) {
          // alert(data.output_1)
          document.getElementById('infokirimbahan').innerHTML=''
          if (data.kirim == true) {
            document.getElementById('infokirimbahan').innerHTML=data.info
            document.getElementById('tombolkirimbahan').hidden=false
            document.getElementById('infobarcodekirimbahan').hidden=true
          }else{
            document.getElementById('infobarcodekirimbahan').value=data.info
            document.getElementById('tombolkirimbahan').hidden=true
            document.getElementById('infobarcodekirimbahan').hidden=false
          }
          
          // Basic Data
          $('#plantkirimbahan').val(data.plant)
          $('#unitcodekirimbahan').val(data.unitcode + ' - ' + data.unitdesc)
          $('#productidkirimbahan').val(data.productid)
          $('#proddesckirimbahan').val(data.productdesc)
          $('#batchkirimbahan').val(data.batchnumber)
          $('#expdatekirimbahan').val(data.expdate)
          $('#planningnumberkirimbahan').val(data.planningnumber)
          $('#planningyearskirimbahan').val(data.years)
          $('#noproseskirimbahan').val(data.noproses1)
          // Pallet
          $('#nopalletkirimbahan').val(data.nopallet)
          $('#totalberatkirimbahan').val(data.berat)
          $('#satuankirimbahan').val(data.satuan)
          document.getElementById('informasiberat1kirimbahan').innerHTML=data.output_1
          // document.getElementById('informasiberat2kirimbahan').innerHTML=data.output_2
          // Status QC
          $('#inspetionlotkirimbahan').val(data.insplot)
          $('#inspyearskirimbahan').val(data.inspyears)
          $('#udcode1kirimbahan').val(data.udcode1)
          $('#uddesc1kirimbahan').val(data.uddesc1)
          $('#uddate1kirimbahan').val(data.uddate1)
          $('#udbykirimbahan').val(data.udby)
          $('#noproses1kirimbahan').val(data.noproses1)
          // $('#udcode2kirimbahan').val(data.udcode2)
          // $('#uddesc2kirimbahan').val(data.uddesc2)
          // $('#uddate2kirimbahan').val(data.uddate2)
          // $('#noproses2kirimbahan').val(data.noproses2)
          // DATA LABEL
          $('#printlabelkirimbahan').val(data.printlabel)
          $('#diprintolehkirimbahan').val(data.diprintoleh)
          $('#scanbarcodekirimbahan').val('')
        }else{
          Swal.fire({
            text: data.info,
            icon: "warning",
            showConfirmButton: false,
            timer: 1500
          })
          $('#scanbarcodekirimbahan').val('')
        }
      }
    }) 
  // $('#scanbarcodekirimbahan').val('')
  }
  
}
function simpankirimbahan() {
  var planningnumber = $('#planningnumberkirimbahan').val()
  var years = $('#planningyearskirimbahan').val()
  var productid = $('#productidkirimbahan').val()
  var batchnumber = $('#batchkirimbahan').val()
  var nopallet = $('#nopalletkirimbahan').val()
  var qty = $('#totalberatkirimbahan').val()
  var noproses = $('#noproseskirimbahan').val()
  var satuan = $('#satuankirimbahan').val()

  Swal.fire({
    text: "Kirim bahan sekarang?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        method  : "POST",
        // dataType: "JSON",
        cache: false,
        data: {
          "prosessimpankirimbahan": [
            planningnumber,
            years,
            productid,
            batchnumber,
            nopallet,
            qty,
            noproses,
            satuan
          ]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: 'Data tersimpan',
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()
            }, 1500);
          }
        }
      })
    }
  })
}
function submitterimabahan(e) {
  if (e.which == 13) {
    var barcode = $('#scanbarcodeterimabahan').val()
    // alert(barcode)
    $.ajax({
      url: "../function/getdata2.php",
      method  : "POST",
      dataType: "JSON",
      cache: false,
      data: {
        "prosessubmitterimabahan": barcode
      },
      success: function (data) {
        if (data.return == 1) {
          $('#scanbarcodeterimabahan').val('')
          // alert(data.unitdesc)
          // alert(data.plant)
          document.getElementById('infoterimabahan').innerHTML=''
          if (data.terima == true) {
            document.getElementById('infoterimabahan').innerHTML=data.info
            document.getElementById('tombolterimabahan').hidden=false
            document.getElementById('infobarcodeterimabahan').hidden=true
          }else{
            document.getElementById('infobarcodeterimabahan').value=data.info
            document.getElementById('tombolterimabahan').hidden=true
            document.getElementById('infobarcodeterimabahan').hidden=false
          }
          
          // Basic Data
          $('#plantterimabahan').val(data.plant)
          $('#unitcodeterimabahan').val(data.unitcode + ' - ' + data.unitdesc)
          $('#productidterimabahan').val(data.productid)
          $('#proddescterimabahan').val(data.productdesc)
          $('#batchterimabahan').val(data.batchnumber)
          $('#expdateterimabahan').val(data.expdate)
          $('#planningnumberterimabahan').val(data.planningnumber)
          $('#planningyearsterimabahan').val(data.years)
          $('#prosesterimabahan').val(data.noproses1)
          // Pallet
          $('#nopalletterimabahan').val(data.nopallet)
          $('#totalberatterimabahan').val(data.berat)
          $('#satuanterimabahan').val(data.satuan)
          document.getElementById('informasiberat1terimabahan').innerHTML=data.output_1
          // document.getElementById('informasiberat2terimabahan').innerHTML=data.output_2
          // Status QC
          $('#inspetionlotterimabahan').val(data.insplot)
          $('#inspyearsterimabahan').val(data.inspyears)
          $('#udcode1terimabahan').val(data.udcode1)
          $('#uddesc1terimabahan').val(data.uddesc1)
          $('#uddate1terimabahan').val(data.uddate1)
          $('#udbyterimabahan').val(data.udby)
          $('#noproses1terimabahan').val(data.noproses1)
          // $('#udcode2terimabahan').val(data.udcode2)
          // $('#uddesc2terimabahan').val(data.uddesc2)
          // $('#uddate2terimabahan').val(data.uddate2)
          // $('#noproses2terimabahan').val(data.noproses2)

          // Info Kirim
          $('#jamkirimterimabahan').val(data.jamkirim)
          $('#pengirimterimabahan').val(data.pengirim + ' - ' + data.namapengirim)
          // $('#namapengirimterimabahan').val()
          $('#tglkirimterimabahan').val(data.tglkirim)
            $('#scanbarcodeterimabahan').val('')
        }else{
          Swal.fire({
            text: data.info,
            icon: "warning",
            showConfirmButton: false,
            timer: 1500
          })
          $('#scanbarcodeterimabahan').val('')
        }
      }
    })
    // $('#scanbarcodeterimabahan').val('') 
  }
  
}
function simpanterimabahan() {
  var planningnumber = $('#planningnumberterimabahan').val()
  var years = $('#planningyearsterimabahan').val()
  var productid = $('#productidterimabahan').val()
  var batchnumber = $('#batchterimabahan').val()
  var nopallet = $('#nopalletterimabahan').val()
  var qty = $('#totalberatterimabahan').val()
  var noproses = $('#prosesterimabahan').val()
  var satuan = $('#satuanterimabahan').val()

  Swal.fire({
    text: "Terima bahan ?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        method  : "POST",
        // dataType: "JSON",
        cache: false,
        data: {
          "prosessimpanterimabahan": [
            planningnumber,
            years,
            productid,
            batchnumber,
            nopallet,
            qty,
            noproses,
            satuan
          ]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: 'Data tersimpan',
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload()
            }, 1500);
          }
        }
      })
    }
  })
}
// ------------Manajemen stok------------------
function submitprodumanajemenstok(productid) {
  $('#searchprodukdataproduk').modal('hide')
    $.ajax({
      url: "../function/getdata2.php",
      dataType: "JSON",
      method  : "POST",
      cache: false,
      data: {
        "prosessubmitprodumanajemenstok": productid
      },
      success: function (data) {
        if (data.return == 1) {
          location.href= ("../page/mainpage?p=manajemenstok&v="+data.productid+"");
        }
      }
    })
}
// ------------Config - Correction Data------------------

function submitcorectiondata() {
  var finnaly = ""
  document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Sedang diproses.."
  document.getElementById('spinnercorecctionconfiguration').hidden=false
  document.getElementById('submitcorecctionconfiguration').disabled=true
  $('#submitcorecctionconfiguration').attr('href_transform','')
  var approval_planning = document.getElementById('approvalplanninggconfiguration').checked
  var reject_lulus_rekon_pillow = document.getElementById('rejectlulusrekonsiliasipillowgconfiguration').checked
  var qc_rhsuhu = document.getElementById('qcrhsuhuconfiguration').checked
  var prepare_hopertopack = document.getElementById('preparehoppertopackconfiguration').checked
  var proses_hoper = document.getElementById('proseshoperconfiguration').checked
  var engine_set = document.getElementById('enginesetconfiguration').checked
  var sampling_topack = document.getElementById('samplingtopackconfiguration').checked
  var rekon_topack = document.getElementById('rekontopackconfiguration').checked
  var prepare_pillow = document.getElementById('preparepillowconfiguration').checked
  var proses_pillow = document.getElementById('prosespillowconfiguration').checked
  var rekon_pillow = document.getElementById('rekonpillowconfiguration').checked
  var engine_set_approval = document.getElementById('enginesetapprovalconfiguration').checked
  var review_qa = document.getElementById('reviewqualityconfiguration').checked
  var print_work_order = document.getElementById('printworkdorderconfiguration').checked
  var approval_proses = document.getElementById('approvalprosesconfiguration').checked
  var analisa_pengemasan_sekunder = document.getElementById('analisapengemasansekunderconfiguration').checked
  // Approval Planning
  if (approval_planning === true) {
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "approval_planning"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    }) 
  }
  // Reject lulus rekon pillow
  if (reject_lulus_rekon_pillow === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "reject_lulus_rekonsiliasipillow"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (qc_rhsuhu === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "qc_result"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (prepare_hopertopack === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "proses_prepare"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (proses_hoper === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "transaksi_hoper"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (engine_set === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "machine_engine"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (sampling_topack === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "sampling_transaksi_topack"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (rekon_topack === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "transaksi_topack"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (prepare_pillow === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "proses_prepare_pillow"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (proses_pillow === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "transaksi_pillow"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (rekon_pillow === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "transaksi_rekon_pillow"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (engine_set_approval === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "qc_machine_engine"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (review_qa === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "proses_review_quality"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (print_work_order === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "log_print"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (approval_proses === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "approval_step_processing"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  if (analisa_pengemasan_sekunder === true){
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosessimpancorrectiondata": "qc_pengemasansekunder"
      },
      success: function (data) {
       if (data == 1) {
          setTimeout(function(){
          document.getElementById('spinnercorecctionconfiguration').hidden=true
          document.getElementById('textsubmitcorecctionconfiguration').innerHTML= "Data tersimpan. Mohon ditunggu.."
        },3000)
        Swal.fire({
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
        })
       }
      }
    })
  }
  

  setTimeout(function(){
  location.reload()
  },6000)
  
}
function simpanconfigplanningdataconfiguration(value) {
  if (value == 1) {
    var dashboard_createplanning = document.getElementById('dashboardcreateplanningconfiguration').checked
    
    $.ajax({
      url: "../function/getdata2.php",
      method  : "POST",
      cache: false,
      data: {
        "prosessimpanconfigdataconfiguration": [value,dashboard_createplanning,
          usedstokhoper]
      },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            text: "Data tersimpan",
            icon: "success",
            showConfirmButton: false,
          })
          setTimeout(function () {
            location.reload()
          }, 1500);
        }
      }
    })
  }else if (value == 2) {
    var used_reviewercreateplanning = document.getElementById('usereviewercreateplanningconfiguration').checked
    var show_reviewercreateplanning = document.getElementById('reviewercreateplanningconfiguration').checked
    var add_reviewercreateplanning = document.getElementById('additionalreviewercreateplanningconfiguration').checked
    $.ajax({
      url: "../function/getdata2.php",
      method  : "POST",
      cache: false,
      data: {
        "prosessimpanconfigdataconfiguration": [value,
                                                used_reviewercreateplanning,
                                                show_reviewercreateplanning,
                                                add_reviewercreateplanning]
      },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            text: "Data tersimpan",
            icon: "success",
            showConfirmButton: false,
          })
          setTimeout(function () {
            location.reload()
          }, 1500);
        }
      }
    })
  }else if (value == 3) {
    var usedstokhoper = document.getElementById('usedstockhopperconfiguration').checked
    $.ajax({
      url: "../function/getdata2.php",
      method  : "POST",
      cache: false,
      data: {
        "prosessimpanconfigdataconfiguration": [value,usedstokhoper,1]
      },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            text: "Data tersimpan",
            icon: "success",
            showConfirmButton: false,
          })
          setTimeout(function () {
            location.reload()
          }, 1500);
        }
      }
    })
  }
}

// -------- Create Planning - Pengolahan --------------

function selectproductcreateplanningpengolahan(productid,description,totalselflife) {
  $('#productidcreateplanningpengolahan').val(productid)
  
  var productid =  $('#productidcreateplanningpengolahan').val()
      $.ajax({
        url: "../function/getdata.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "sumbitproductmanual": productid
        },
        success: function (data) {
          if (data.statuscode == 1) {
            $('#productidcreateplanningpengolahan').val(data.productid)
            $('#descriptionproductcreateplanningpengolahan').val(data.descriptions)
            $('#expireddatecreateplanningpengolahan').val(data.selflife)
            $('#searchprodukcreateplanningpengolahan').modal('hide')
          }
        }
      })
}
function simpancreateplanningpengolahan() { // <---- Submit Sub Planning
  var productid = $('#productidcreateplanningpengolahan').val()
  var shift = $('#shiftcreateplanningpengolahan').val()
  var ed = $('#expireddatecreateplanningpengolahan').val()
  var batch = $('#batchcreateplanningpengolahan').val()
  var mesin_mix = $('#kodemesinmixingcreateplanningpengolahan').val()
  var tglmixing = $('#tglmixingcreateplanningpengolahan').val()
  var jumlahresep = $('#jumlahresepcreateplanningpengolahan').val()
  var createdfor = $('#pernrcreateplanningpengolahan').val()
  var reviewer_add = $('#revieweraddcreateplanningpengolahan').val()
  // var reviewer_add = $('#revieweraddcreateplanningpengolahan').val()
  var reffcode = $('#koderefflistbahancreatepengolahan').val()
  

  if (productid == '' || shift == '' || batch =='' || 
      ed =='' || mesin_mix =='' || tglmixing == '' ||
      jumlahresep == '') {
    missingparameter()
    return
  }
  var obj = JSON.parse(batch)
  var batch_real ='';
  for (let index = 0; index < obj.length; index++) {
    if (index == 0) {
      batch_real = batch_real.concat(obj[index]['value'])
    }else{
      batch_real = batch_real.concat(',' +obj[index]['value'])
    }
  }
  // ---- Validasi resep & batch
  var total_batch = obj.length
  var total_must_batch = Math.ceil(jumlahresep/2) 
  if (total_batch != total_must_batch) {
    message(2)
    return
  }
  // -----End

  Swal.fire({
    text: "Save Data?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#0275d8',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Save'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        // dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosessavecreateplanningpengolahan": [productid,shift,ed,
         batch_real,mesin_mix,tglmixing,
          jumlahresep,createdfor,reviewer_add,reffcode]
        },
        success: function (data) {
          alert(data)
          if (data == 1) {
            location.reload()
          }else{
            Swal.fire({
              text: data,
              icon: "info",
              showConfirmButton: false,
              timer:5000,
            })
          }
        },
      });  
    }
  })
}
function deletedatacreateplanningpengolahan(item,productid,createdby,years,reffcode) {
  Swal.fire({
    title: 'Apa anda yakin?',
    text: "Hapus data planning produk " + productid,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletecreateplanningpengolahan": [item,productid,createdby,years,reffcode]
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
          }
        },
      });  
    }
  })
}
function selesaicreateplanningpengolahan() { // <----- Selesai Planning
  var shift = $('#shiftcreateplanningpengolahan').val()
  var createdfor = $('#pernrcreateplanningpengolahan').val()
  var reviewer_add = $('#revieweraddcreateplanningpengolahan').val()

  var totalreviewer = $('#totalreviewercreateplanningpengolahan').val()
  var reviewer = []
  for (let i = 0; i < totalreviewer; i++) {
    var rev = document.getElementById('reviewer'+i+'').checked
    if (rev === true) {
      reviewer[i] = $('#levelscreateplanningpengolahan'+i+'').val()
    }  
  }

  Swal.fire({
    text: "Simpan data planning ?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Simpan'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosessimpancreateplanningpengolahan": [shift,
            createdfor,
            reviewer_add,
            reviewer]
        },
        success: function (data) {
          if (data.status == 1) {
            Swal.fire({
              title: "Success",
              text: "Planning number was create with number " + data.planningnumber,
              icon: "success",
              showConfirmButton: true,
            }).then((result) => {
              if (result.isConfirmed) {
                Swal.fire({
                  text: "Cetak label pengambilan sample?",
                  icon: "success",
                  showCancelButton: true,
                  confirmButtonText: 'Print'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.open ("../page/production/planning/form/print_labelsample.php?w="+data.planningnumber+" &&x="+data.years+" &&y="+0+" && z="+0+"");
                  }
                  location.reload()
                })
              }
            })
          } else {
            Swal.fire({
              Text: "Data Tidak Tersimpan",
              icon: "error",
              showConfirmButton: false,
            })
          }
        },
      });  
    }
  })
}
function viewaddreproses(productid,createdby,years) {
  $('#productidreprosescreateplanningpengolahan').val(productid)
  $('#searchaddreprosescreateplanningpengolahan').modal('show')
}
function viewlistbahan(reffcode) {
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesviewlistbahan": reffcode
    },
    success: function (data) {
      if (data.status == 1) {
        document.getElementById('listbahan1modalcreateplanningpengolahan').innerHTML=data.output1
        document.getElementById('listbahan2modalcreateplanningpengolahan').innerHTML=data.output2
        document.getElementById('listbahanmodalcreateplanningpengolahan').innerHTML=data.output3
        $('#modalproductidplanningpengolahan').val(data.productid)
        $('#modalreffcodeplanningpengolahan').val(data.reffcode)
        $('#modalcreateonplanningpengolahan').val(data.createdon)
        $('#modalcreatebyplanningpengolahan').val(data.createdby)
        $('#viewlistbahancreateplanningpengolahan').modal('show')
      }
    },
  });
}
function viewlistbahan2(reffcode,plan,years,bets,productid) {
  var prod = $('#productidcreateplanningpengolahan').val()
  if (productid == '' || reffcode == '' || prod == '') {
    missingparameter()
    return
  }
  if (prod != productid) {
    message(7)
    return
  }
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesviewlistbahan": reffcode
    },
    success: function (data) {
      if (data.status == 1) {
        document.getElementById('tablerefflistbahan').hidden=true
        document.getElementById('refflistbahan').hidden=false
        document.getElementById('refflistbahan1modalcreateplanningpengolahan').innerHTML=data.output1
        document.getElementById('refflistbahan2modalcreateplanningpengolahan').innerHTML=data.output2
        document.getElementById('refflistbahanmodalcreateplanningpengolahan').innerHTML=data.output3
        $('#modalplanningnumberlistbahanplanningpengolahan').val(plan)
        $('#modalyearslistbahanplanningpengolahan').val(years)  
        $('#modalbetslistbahanplanningpengolahan').val(bets)   
        $('#modalproductidlistbahanplanningpengolahan').val(data.productid)
        $('#modalreffcodelistbahanplanningpengolahan').val(data.reffcode)
        $('#modalcreateonreffplanningpengolahan').val(data.createdon)
        $('#modalcreatebyreffplanningpengolahan').val(data.createdby)
      }
    },
  });
}
function kembalirefflistbahancreateplanningpengolahan() {
  document.getElementById('tablerefflistbahan').hidden=false
  // document.getElementById('refflistbahan').innerHTML=''
  document.getElementById('refflistbahan').hidden=true
}
function tambahkodebahancreatepengolahan() {
  var kodeproduk = $('#productidcreateplanningpengolahan').val()
  var reff = $('#koderefflistbahancreatepengolahan').val()
  var kodebahan = $('#kodebahanlistbahancreatepengolahan').val()
  var jmlteoritis = $('#jmlteoritislistbahancreatepengolahan').val()
  var proses = $('#proseslistbahancreatepengolahan').val()
  var urutanproses = $('#urutanproseslistbahancreatepengolahan').val()
  var jmlkonsumsi = $('#jmlkonsumsilistbahancreatepengolahan').val()
  var jmltuang = $('#jmltuanglistbahancreatepengolahan').val()

  if (kodeproduk == '' || jmlteoritis == '' || kodebahan == '' || jmltuang == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosesvalidasikodebahan": kodebahan
    },
    success: function (data) {
      if (data == false) {
        message(6)
        $('#kodebahanlistbahancreatepengolahan').val('')
      }else{
        $.ajax({
          url: "../function/getdata2.php",
          dataType: "JSON",
          type: "POST",
          cache: false,
          data: {
            "prosestambahkodebahancreatepengolahan": [kodeproduk,reff,kodebahan,jmlteoritis,proses,urutanproses,jmlkonsumsi]
          },
          success: function (data) {
            if (data.return == 1) {
                $('#urutanproseslistbahancreatepengolahan').val(data.urutanproses)
                document.getElementById('listbahan1createplanningpengolahan').innerHTML=data.output1
                document.getElementById('listbahan2createplanningpengolahan').innerHTML=data.output2
                document.getElementById('listbahancreateplanningpengolahan').innerHTML=data.output3
      
                $('#kodebahanlistbahancreatepengolahan').val('')
                $('#jmlteoritislistbahancreatepengolahan').val(1)
                $('#proseslistbahancreatepengolahan').val(1)
                $('#jmlkonsumsilistbahancreatepengolahan').val(1) 

                document.getElementById('jmlteoritislistbahancreatepengolahan').disabled = false
                document.getElementById('jmlkonsumsilistbahancreatepengolahan').disabled = false
            }else{
              Swal.fire({
                text: data.return,
                icon: "warning",
                showConfirmButton: true,
              })
            }
          },
        });
      }
    },
  });
}
function salinrefflistbahancreateplanningpengolahan() {
  var planning = $('#modalplanningnumberlistbahanplanningpengolahan').val()
  var years = $('#modalyearslistbahanplanningpengolahan').val()
  Swal.fire({
    text: "Salin data list bahan planning " + planning + " - " +years,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Tidak',
    confirmButtonText: 'Ya'
  }).then((result) => {
    if (result.isConfirmed) {
      var reffcode = $('#koderefflistbahancreatepengolahan').val()
      var reffcode_copy = $('#modalreffcodelistbahanplanningpengolahan').val()
      var productid = $('#productidcreateplanningpengolahan').val()
      
      $.ajax({
        url: "../function/getdata2.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosescopycreateplanningpengolahan": [productid,reffcode,reffcode_copy]
        },
        success: function (data) {
          if (data.return == 1) {
              $('#urutanproseslistbahancreatepengolahan').val(data.urutanproses)
              document.getElementById('listbahan1createplanningpengolahan').innerHTML=data.output1
              document.getElementById('listbahan2createplanningpengolahan').innerHTML=data.output2
              document.getElementById('listbahancreateplanningpengolahan').innerHTML=data.output3
    
              $('#kodebahanlistbahancreatepengolahan').val('')
              $('#jmlteoritislistbahancreatepengolahan').val(1)
              $('#proseslistbahancreatepengolahan').val(1)
              $('#jmlkonsumsilistbahancreatepengolahan').val(1) 

              document.getElementById('jmlteoritislistbahancreatepengolahan').disabled = false
              document.getElementById('jmlkonsumsilistbahancreatepengolahan').disabled = false
              kembalirefflistbahancreateplanningpengolahan()
              $('#searchlistbahancreateplanningpengolahan').modal('hide')
          }
        },
      });

    }
  })
}
function deletedatareprosescreateplanningpengolahan(productid,batchasal,batchreproses,createdby) {
  Swal.fire({
    text: "Hapus data bahan reproses " + productid,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletedatareprosescreateplanningpengolahan": [productid,batchasal,batchreproses,createdby]
        },
        success: function (data) {
          if (data == 1) {
            location.reload()
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
          }
        },
      });  
    }
  })
}
function simpanreprosescreateplanningpengolahan() {
  productid = $('#productidreprosescreateplanningpengolahan').val()
  asal = $('#asalreprosescreateplanningpengolahan').val()
  edbc = $('#edbcreprosescreateplanningpengolahan').val()
  betsproses = $('#betsreprosesreprosescreateplanningpengolahan').val()
  berat = $('#beratreprosescreateplanningpengolahan').val()
  bulk = $('#bulkreprosescreateplanningpengolahan').val()
  berat2 = $('#berat2reprosescreateplanningpengolahan').val()
  sisa = $('#sisareprosescreateplanningpengolahan').val()

  if (productid == '' || asal == '' || edbc == '' || betsproses=='' || berat =='' || bulk == '' || berat2=='') {
    missingparameter()
    return
  }

  Swal.fire({
    text: "Simpan data bahan reproses ?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Simpan'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata2.php",
        dataType: "JSON",
        type: "POST",
        cache: false,
        data: {
          "prosessimpanreprosescreateplanningpengolahan": [productid,asal,edbc,betsproses,berat,bulk,berat2,sisa]
        },
        success: function (data) {
          if (data == 1) {
            location.reload()
            $( document ).ready(function() {
              $('#searchaddreprosescreateplanningpengolahan').modal('show')
          });
          } else {
            Swal.fire({
              Text: data,
              icon: "error",
              showConfirmButton: false,
            })
          }
        },
      });  
    }
  })
}
function getkadaluarsapengolahan(parameters) {
  var product = $('#productidcreateplanningpengolahan').val()
  if (product != '') {
    $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      edautomatiscreateplanning:[product,parameters] 
    },
    success: function (data) {
      // $('#expireddatecreateplanning').val(data)
      $('#expireddatecreateplanningpengolahan').val(data)
    }
    })
  }
}

// ----------Analisa Organoleptis - QC-------------------

function selectinspanalisaorganoleptis(prueflos,years,noproses) {
    location.href = linkedip+'/page/mainpage?p=organoleptis&x='+prueflos+'&y='+years+'&z='+noproses+''
}
function cektype(values){    
  var type = $(values).attr('type');
  // if(type == "text")
  //  console.log("input text" + $(elementID).val().size());
  return type
 }
function simpanqcorganoleptis() {
  var prueflos = $('#inspectionlotanalisaorganoleptis').val()
  var years = $('#inspyearsanalisaorganoleptis').val()
  var noproses = $('#prosesnumberalisaorganoleptis').val()
  var ud = $('#usagedecisionanalisaorganoleptis').val()
  var lenght = $('#lenght_updateorganoleptis').val()
  var result_1 = [];
  var result_2 = [];
  var result_3 = [];
  var mic = [];
  var keterangan = [];
  for (let i = 1; i < lenght; i++) {
    // MIC
    var mic_value = document.getElementById('MICorganoleptis'+i+'').value

    // 1
    var result_awal = document.getElementById('result_awalorganoleptis'+i+'')
    result_awal = result_awal.checked
    if (result_awal == false) {
      result_awal = document.getElementById('result_awalorganoleptis'+i+'').value
      if (result_awal =='on') {
        result_awal = false
      } 
    }
    result_1[i] = result_awal

    // 2
    var result_tengah = document.getElementById('result_tengahorganoleptis'+i+'')
    result_tengah = result_tengah.checked
    if (result_tengah == false) {
      result_tengah = document.getElementById('result_tengahorganoleptis'+i+'').value
      if (result_tengah =='on') {
        result_tengah = false
      } 
    }

    // 3
    var result_akhir = document.getElementById('result_akhirorganoleptis'+i+'')
    result_akhir = result_akhir.checked
    if (result_akhir == false) {
      result_akhir = document.getElementById('result_akhirorganoleptis'+i+'').value
      if (result_akhir =='on') {
        result_akhir = false
      } 
    }

    // Keterangan Hasil Tolak

    var keterangan_value = document.getElementById('keteranganhasiltolakorganoleptis'+i+'').value
    result_1[i] = result_awal
    result_2[i] = result_tengah
    result_3[i] = result_akhir
    mic[i] = mic_value
    keterangan[i] = keterangan_value
  }
  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosessimpanqcorganoleptis": [prueflos,
                                    years,
                                    noproses,
                                    ud,
                                    result_1,
                                    result_2,
                                    result_3,
                                    lenght,
                                    mic,
                                    keterangan]
    },
    success: function (data) {
      if (data.return == 1) {
        Swal.fire({
          text: "Hasil analisa tersimpan",
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.href = linkedip+'/page/mainpage?p=organoleptis'
          }
        })
      }
    }
  })
}
function showinspanalisaorganoleptis(prueflos,years,productid,noproses) {
  $('#searchinspectionlotanalisaorganoleptis').modal('hide')
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosesshowinspanalisaorganoleptis": [prueflos,years,productid,noproses]
    },
    success: function (data) {
      $('#insplotchangeilanalisaorganoleptis').val(prueflos)
      $('#inspyearschangeilanalisaorganoleptis').val(years)
      $('#materialchangeilanalisaorganoleptis').val(productid)
      if (data != '') {
        document.getElementById('table_changeinspanalisaorganoleptis').innerHTML=data
        $('#searchchangeinspectionlotanalisaorganoleptis').modal('show')
        document.getElementById('assignmicanalisaorganoleptis').hidden=false
        document.getElementById('itemokeanalisaorganoleptis').hidden=false
        $.ajax({
          url: "../function/getdata2.php",
          type: "POST",
          cache: false,
          data: {
            "prosesgetdescmaterial": productid
          },
          success: function (data) {
            $('#deskripsichangeilanalisaorganoleptis').val(data)
          }
        })
      }else{
        message(4)
      }
    },
  });
}
function assignmicanalisaorganoleptis() {
  var oke = document.getElementById('okeanalisaorganoleptis').checked
  if (oke != true) {
    missingparameter()
    return
  }
    var prueflos = $('#insplotchangeilanalisaorganoleptis').val()
    var years = $('#inspyearschangeilanalisaorganoleptis').val()
    var productid =  $('#materialchangeilanalisaorganoleptis').val()
  $.ajax({
    url: "../function/getdata2.php",
    type: "POST",
    cache: false,
    data: {
      "prosesassignmicanalisaorganoleptis": [prueflos,years,productid]
    },
    success: function (data) {
      if (data == 1) {
        location.href = linkedip+'/page/mainpage?p=organoleptis&x='+prueflos+'&y='+years+''
      }
    }
  })
}
// ---------------------------------------------------------
// Print Label Ambil Sample - QC
// ---------------------------------------------------------
function showlabelambilsample(planning,years,ilot,iyears) {
  window.open ("../page/production/planning/form/print_labelsample.php?w="+planning+" &&x="+years+" &&y="+ilot+" && z="+iyears+"");
}

// -------------Karantina-------------------

function showkarantina() {
  var prod = $('#productIDkarantina').val()
  var bet = $('#betskarantina').val()
  var stt = $('#sttskarantina').val()
  var prs = $('#proseskarantina').val()
  
  location.href = linkedip+'/page/mainpage?p=karantina&prod='+prod+'&bet='+bet+'&stt='+stt+'&prs='+prs+''
}
function showdetailkarantina(jenisproses,planningnumber,years,productid,batchnumber) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesshowdetailkarantina": [jenisproses,
                                    planningnumber,
                                    years,
                                    productid,
                                    batchnumber]
    },
    success: function (data) {
      if (data.statuscode == 1) {
        $('#planningnumbermodaldetailkarantina').val(data.planningnumber)
        $('#yearsmodaldetailkarantina').val(data.years)
        $('#productidmodaldetailkarantina').val(data.productid)
        $('#productdescmodaldetailkarantina').val(data.productdesc)
        $('#betsmodaldetailkarantina').val(data.bets)
        $('#expdatemodaldetailkarantina').val(data.expdate)
        $('#netxinspmodaldetailkarantina').val(data.nextinsp)
        
        document.getElementById('titlemodaldetailkarantina').innerHTML = jenisproses.charAt(0).toUpperCase() + jenisproses.substr(1)
        $('#modalshowdetailkarantina').modal('show')
      }
    }
  })
}
function submitkarantina(prs,stts) {
  var planningnumber = $('#planningnumbermodaldetailkarantina').val()
  var years = $('#yearsmodaldetailkarantina').val()
  var productid = $('#productidmodaldetailkarantina').val()
  var bets = $('#betsmodaldetailkarantina').val()
  var krtndate = $('#tglkarantinamodaldetailkarantina').val()
  var pic = $('#qcmodaldetailkarantina').val()
  var masalah = $('#keteranganmodaldetailkarantina').val()
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessubmitkarantina": [planningnumber,
                                years,
                                productid,
                                bets,
                                prs,
                                stts,
                                krtndate,
                                pic,
                                masalah]
    },
    success: function (data) {
        Swal.fire({
          text: data,
          icon: "success",
          showConfirmButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        })
    }
  })
}
function showtrackingkarantina(KodeKarantina,Qyears) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesshowtrackingkarantina": [KodeKarantina,Qyears]
    },
    success: function (data) {
      if (data.statuscode == 1) {
        $('#kodekarantinamodaltrackingkarantina').val(data.kodekarantina)
        $('#planningnumbermodaltrackingkarantina').val(data.planningnumber)
        $('#yearsmodaltrackingkarantina').val(data.years)
        $('#Qyearsmodaltrackingkarantina').val(data.qyears)  
        $('#productidmodaltrackingkarantina').val(data.productid)
        $('#tglkarantinamodaltrackingkarantina').val(data.tglkarantina)
        $('#createdonmodaltrackingkarantina').val(data.createdon)
        $('#createdbymodaltrackingkarantina').val(data.createdby)
        $('#productdescmodaltrackingkarantina').val(data.productdesc)
        $('#betsmodaltrackingkarantina').val(data.bets)
        $('#Qcmodaltrackingkarantina').val(data.qc)
        $('#expdatemodaltrackingkarantina').val(data.expdate)
        $('#extendexpmodaltrackingkarantina').attr('max',data.maxextend)
        $('#extendexpmodaltrackingkarantina').val(data.extendexp)
        $('#netxinspmodaltrackingkarantina').val(data.nextinsp)
        $('#keteranganmodaltrackingkarantina').val(data.keterangan)
        $('#statusmodaltrackingkarantina').val(data.status)
        document.getElementById('kodereffmodaltrackingkarantina').innerHTML=data.kodereff
        $('#showtrackingkarantina').modal('show')
      }
    }
  })
  $('#showtrackingkarantina').modal('show')
}
function showextendexpkarantina(extendexp) {
  var planningnumber = $('#planningnumbermodaltrackingkarantina').val()
  var years = $('#yearsmodaltrackingkarantina').val()
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",
    cache: false,
    data: {
      "prosesshowextendexpkarantina": [planningnumber,years,extendexp]
    },
    success: function (data) {
      if (data.statuscode == 1) {
        $('#kodekarantinamodaltrackingkarantina').val(data.kodekarantina)
        $('#planningnumbermodaltrackingkarantina').val(data.planningnumber)
        $('#yearsmodaltrackingkarantina').val(data.years)
        $('#Qyearsmodaltrackingkarantina').val(data.qyears)  
        $('#productidmodaltrackingkarantina').val(data.productid)
        $('#tglkarantinamodaltrackingkarantina').val(data.tglkarantina)
        $('#createdonmodaltrackingkarantina').val(data.createdon)
        $('#createdbymodaltrackingkarantina').val(data.createdby)
        $('#productdescmodaltrackingkarantina').val(data.productdesc)
        $('#betsmodaltrackingkarantina').val(data.bets)
        $('#Qcmodaltrackingkarantina').val(data.qc)
        $('#expdatemodaltrackingkarantina').val(data.expdate)
        $('#statusmodaltrackingkarantina').val(data.status)
        $('#extendexpmodaltrackingkarantina').attr('max',data.maxextend)
        $('#extendexpmodaltrackingkarantina').val(data.extendexp)
        $('#netxinspmodaltrackingkarantina').val(data.nextinsp)
        $('#keteranganmodaltrackingkarantina').val(data.keterangan)
        if (data.statsX != 'REL') {
          document.getElementById('endkarantinamodaltrackingkarantina').hidden=true
        }else{
          document.getElementById('endkarantinamodaltrackingkarantina').hidden=false
        }    
        document.getElementById('kodereffmodaltrackingkarantina').innerHTML=data.kodereff
      }
    }
  })
}
function endkarantina(prs) {
  var karantina = $('#kodekarantinamodaltrackingkarantina').val()
  var qyears = $('#Qyearsmodaltrackingkarantina').val()
  Swal.fire({
    title: 'Apa anda yakin?',
    text: "Akhiri Proses Karantina",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesendkarantina": [karantina,
                                    qyears,
                                  prs]
        },
        success: function (data) {
          alert(data)
          if (data == 1) {
            Swal.fire({
              text: 'Karantina selesai',
              icon: "success",
              showConfirmButton: true,
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload()
              }
            })
          }     
        }
      })
    }
  })
  
}

//----------------------Lacak Batch---------------------

function submitstartlacakplanning() {
  var productid = $('#productidlacakplanning').val()
  var bets = $('#betslacakplanning').val()

  $.ajax({
    url: "../function/getdata2.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "prosessubmitstartlacakplanning": [productid,bets]
    },
    success: function (data) {
      document.getElementById('showlacakbets').innerHTML=data.output
    },
  });
}

//------------------Nomor Lot-----------------------------
function simpandatanomorlot() {
  var nomorlot = $('#nomorlotuploadnomorlot').val()
  var kodesupplier = $('#kodesuppliernomorlot').val()
  var namasupplier = $('#namasuppliernomorlot').val()
  var keterangan = $('#keterangannomorlot').val()
  var join = $('#joinnomorlot').val()

  if (nomorlot == '' || kodesupplier == '' || namasupplier == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpandatanomorlot": [nomorlot,kodesupplier, 
        namasupplier,keterangan,join]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload()  
        }, 1500);
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedatanomorlot(nomorlot) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Nomor Lot " + nomorlot,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('nomorlotuploadnomorlot').value=''
      document.getElementById('kodesuppliernomorlot').value=''
      document.getElementById('namasuppliernomorlot').value=''
      document.getElementById('keterangannomorlot').value=''
      document.getElementById('joinnomorlot').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletedatanomorlot": nomorlot
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedatanomorlot(nomorlot) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "proseschangedatanomorlot": nomorlot
    },
    success: function (data) {
      $('#nomorlotuploadnomorlot').val(data.nomorlot)
      $('#kodesuppliernomorlot').val(data.kodesupplier)
      $('#namasuppliernomorlot').val(data.namasupplier)
      $('#keterangannomorlot').val(data.keterangan)
      $('#joinnomorlot').val(data.join)
      document.getElementById('nomorlotuploadnomorlot').disabled = true
    },
  });
}
function selectsuppliernomorlot(kodesupplier,namasupplier,keterangan) {
  $('#kodesuppliernomorlot').val(kodesupplier)
  $('#namasuppliernomorlot').val(namasupplier)
  $('#keterangannomorlot').val(keterangan)
  document.getElementById('hiddenketerangannomorlot').hidden=false
  document.getElementById('namasuppliernomorlot').setAttribute('readonly',true)
  $('#searchkodesuppliernomorlot').modal('hide')
}
function execnomorlot() {
  var planningnumber = $('#setplanningnumberprosestopack').val()
  var years = $('#yearsprosestopack').val()
  if (planningnumber == '') {
    missingplanningnumber()
    return
  }
    document.getElementById('titleplanningnumberexecnomorlot').innerHTML=planningnumber
    $.ajax({
      url: "../function/getdata.php",
      type: "POST",
      cache: false,
      data: {
        "prosesshowtableexecnomorlot": [planningnumber,years]
      },
      success: function (data) {
        if (data != '') {    
          document.getElementById('table_exec_nomorlot').innerHTML = data   
          $('#searchexecnomorlot').modal('show')
        }
      },
    });  
}
function saveexecnomorlot() {
  var planningnumber = $('#setplanningnumberprosestopack').val()
  var years = $('#yearsprosestopack').val()
  var nomorlot = $('#nomorlotrekontopack').val()
  var kodesupplier = $('#kodesupplierrekontopack').val()
  var statsX = $('#statsX').val()

  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessaveexecnomorlot": [planningnumber,
      years,nomorlot,kodesupplier,statsX]
    },
    success: function (data) {
      $('#nomorlotrekontopack').val('')
      $('#kodesupplierrekontopack').val('')
      $('#namasupplierrekontopack').val('')
      $('#joinrekontopack').val('')
      if (data == 1) {
        execnomorlot()  
      }
    },
  });
}
function selectexecnomorlot(nomorlot,kodesupplier,namasupplier,join) {
  $('#nomorlotrekontopack').val(nomorlot)
  $('#kodesupplierrekontopack').val(kodesupplier)
  $('#namasupplierrekontopack').val(namasupplier)
  $('#joinrekontopack').val(join)
  $('#searchnomorlotrekontopack').modal('hide')
}
function deleteexecnomorlot(planningnumber,years,nomorlot) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Nomor Lot " + nomorlot + " di Planning " + planningnumber +" Tahun " + years,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeleteexecnomorlot": [planningnumber,years,nomorlot]
        },
        success: function (data) {
          if (data == 1) {
            execnomorlot()
          }
        },
      });  
    }
  })
}

//----------------Data Supplier---------------------------
function simpandatasupplier() {
  var kodesupplier = $('#kodesupplierdatasupplier').val()
  var namasupplier = $('#namasupplierdatasupplier').val()
  var keterangan = $('#keterangandatasupplier').val()

  if (kodesupplier == '' || namasupplier == ''|| keterangan == '') {
    missingparameter()
    return
  }
  $.ajax({
    url: "../function/getdata.php",
    type: "POST",
    cache: false,
    data: {
      "prosessimpandatasupplier": [kodesupplier, 
        namasupplier,keterangan]
    },
    success: function (data) {
      if (data == 1) {
        Swal.fire({
          title: "Success",
          text: "Data Tersimpan",
          icon: "success",
          showConfirmButton: false,
        })
        setTimeout(function () {
          location.reload()  
        }, 1500);
      }else if(data ==2){
        Swal.fire({
          title: kodesupplier +' is available.',
          text: "Update data supplier?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../function/getdata.php",
              type: "POST",
              cache: false,
              data: {
                "prosesupdatedatasupplier": [kodesupplier, 
                  namasupplier,keterangan]
              },
              success: function (dataupdate) {
                if (dataupdate == 1) {
                  Swal.fire({
                    title: "Success",
                    text: "Data Tersimpan",
                    icon: "success",
                    showConfirmButton: false,
                  })
                  setTimeout(function () {
                    location.reload()  
                  }, 1500);
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          title: "Oops..",
          Text: "Data Gagal Tersimpan",
          icon: "error",
          showConfirmButton: true,
        })
      }
    },
  });
}
function deletedatasupplier(kodesupplier) {
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete Supplier " + kodesupplier,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('kodesupplierdatasupplier').value=''
      document.getElementById('namasupplierdatasupplier').value=''
      document.getElementById('keterangandatasupplier').value=''
      $.ajax({
        url: "../function/getdata.php",
        type: "POST",
        cache: false,
        data: {
          "prosesdeletedatasupplier": kodesupplier
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire({
              title: "Success",
              text: "Data Terhapus",
              icon: "success",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();    
            }, 1500);
          } else {
            Swal.fire({
              Text: "Data Gagal Terhapus",
              icon: "error",
              showConfirmButton: false,
            })
            setTimeout(function () {
              location.reload();
            }, 1500);
          }
        },
      });  
    }
  })
}
function changedatasupplier(kodesupplier) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "proseschangedatasupplier": kodesupplier
    },
    success: function (data) {
      document.getElementById('kodesupplierdatasupplier').value=data.kodesupplier
      document.getElementById('namasupplierdatasupplier').value=data.namasupplier
      document.getElementById('keterangandatasupplier').value=data.keterangan
      document.getElementById('kodesupplierdatasupplier').disabled = true
    },
  });
}

// -------------- Display Material & Batch ----------------------
function displaymaterial(productid) {
  $.ajax({
    url: "../function/getdata.php",
    // dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "prosesdisplaymaterial": productid
    },
    success: function (data) {
      location.href = linkedip+'/page/mainpage?p=displaymaterial&m='+data+''
    },
  });
}
function displaybatch(productid,bets) {
  $.ajax({
    url: "../function/getdata.php",
    dataType: "JSON",
    type: "POST",  
    cache: false,
    data: {
      "prosesdisplaybatch": [productid,bets]
    },
    success: function (data) {
      location.href = linkedip+'/page/mainpage?p=displaybatch&q='+data.productid+'&r='+data.bets+''
    },
  });
}

