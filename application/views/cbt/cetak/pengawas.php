<?php
function date_sort($a, $b)
{
    return strtotime($a) - strtotime($b);
}

$allowedDates = [];
?>
<div class="content-wrapper bg-white">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul ?></h1>
                </div>
                <div class="col-6">
                    <a href="<?= base_url('cbtcetak') ?>" type="button" class="btn btn-sm btn-danger float-right">
                        <i class="fas fa-arrow-circle-left"></i><span
                                class="d-none d-sm-inline-block ml-1">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default my-shadow mb-4">
                <div class="card-header">
                    <h3 class="card-title"><b><?= $subjudul ?></b></h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip"
                                    title="Print" onclick="print()">
                                <i class="fas fa-print"></i> <span class="d-none d-sm-inline-block ml-1"> Print/PDF</span></button>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip"
                                    title="Export As Word" onclick="exportWord()">
                                <i class="fa fa-file-word"></i> <span class="d-none d-sm-inline-block ml-1"> Word</span></button>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="tooltip"
                                    title="Export As Excel" onclick="exportExcel()">
                                <i class="fa fa-file-excel"></i> <span class="d-none d-sm-inline-block ml-1"> Excel</span></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-default-info shadow align-content-center" role="alert">
                        <strong>Catatan!</strong>
                        <ol>
                            <li>
                                Mengatur berapa menit jadwal ujian akan aktif setelah sesi dimulai
                            </li>
                            <li>
                                Contoh <b>Menit ke</b> 90, maka jadwal mapel akan aktif 90 menit setelah Mapel pertama dimulai
                            </li>
                            <li>
                                Jika semua <b>Menit ke</b> diatur ke 0 maka semua jadwal akan bisa dikerjakan oleh siswa
                            </li>
                            <li>
                                halaman ini berlaku jika semua jadwal telah diaktifkan
                            </li>
                            <li>
                                Jika halaman ini tidak diatur/tidak disimpan, maka jadwal ujian mengikuti aturan di MENU <b>JADWAL</b>
                            </li>
                        </ol>
                    </div>
                    <br>

                    <div class="row mb-3">
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <?php
                                echo form_dropdown('jenis', $jenis, $jenis_selected, 'id="jenis" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="col-md-2 col-4">
                            <div class="form-group">
                                <label for="filter">Filter</label>
                                <?php
                                echo form_dropdown('filter', $filter, $filter_selected, 'id="filter" class="form-control"'); ?>
                            </div>
                        </div>
                        <?php
                        $dnone = $filter_selected == '0' ? 'd-none' : ''?>
                        <div class='col-md-2 col-4 <?=$dnone?>' id="tgl-dari">
                            <div class="form-group">
                                <label for="dari">Dari</label>
                                <input type='text' id="dari" name='dari' value="<?= $dari_selected ?>"
                                       class='tgl form-control' autocomplete='off'/>
                            </div>
                        </div>
                        <div class='col-md-2 col-4 <?=$dnone?>' id="tgl-sampai">
                            <div class="form-group">
                                <label for="sampai">Sampai</label>
                                <input type='text' id="sampai" name='sampai'
                                       class='tgl form-control' value="<?= $sampai_selected ?>"
                                       autocomplete='off'/>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                    //echo '<pre>';
                    //var_dump($setting);
                    //echo '<br>';
                    //var_dump($levels);
                    //echo '<br>';
                    //var_dump($pengawas);
                    //var_dump($jadwals);
                    //echo '<br>';
                    //var_dump($all_jadwal);
                    //echo '</pre>';
                    $none = count($jadwals)>0 ? '' : 'd-none';
                    if (count($jadwals)>0):
                    ?>
                        <table id="table-header-print"
                               style="width: 100%; border: 0;">
                            <tr>
                                <td style="width:15%;">
                                    <img alt="logo kiri" id="prev-logo-kanan-print" src="<?= isset($setting->logo_kiri) ? base_url().$setting->logo_kiri : '' ?>" style="width:85px; height:85px; margin: 6px;">
                                </td>
                                <td style="width:70%; text-align: center;">
                                    <div style="line-height: 1.1; font-family: 'Times New Roman'; font-size: 14pt"><?= $setting->sekolah ?></div>
                                    <div style="line-height: 1.1; font-family: 'Times New Roman'; font-size: 16pt"><b>DAFTAR PENGAWAS</b></div>
                                    <div style="line-height: 1.2; font-family: 'Times New Roman'; font-size: 13pt"><?= strtoupper($jenis_ujian->nama_jenis .' ('. $jenis_ujian->kode_jenis.')') ?></div>
                                    <div style="line-height: 1.2; font-family: 'Times New Roman'; font-size: 12pt">Tahun Pelajaran: <?= $tp_active->tahun ?></div>
                                </td>
                                <td style="width:15%;">
                                    <img alt="logo kanan" id="prev-logo-kiri-print" src="<?= isset($setting->logo_kanan) ? base_url().$setting->logo_kanan : ''?>"
                                         style="width:85px; height:85px; margin: 6px; border-style: none">
                                </td>
                            </tr>
                        </table>
                        <hr style="border: 1px solid; margin-bottom: 6px">
                        <table class="table table-sm table-bordered mt-4" id="tbl-pengawas">
                        <thead>
                        <tr>
                            <th class="text-center align-middle">Hari & Tanggal</th>
                            <th class="text-center align-middle">Ruang</th>
                            <th class="text-center align-middle">Sesi</th>
                            <th class="text-center align-middle">Jam ke</th>
                            <th class="text-center align-middle">Mata Pelajaran</th>
                            <th class="text-center align-middle">Pengawas</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($jadwals as $jadwal) :
                            ?>
                            <tr>
                                <td class="text-center align-middle"><?= str_replace(',', '<br>', buat_tanggal(date('D,d M Y', strtotime($jadwal->tanggal)))) ?></td>
                                <td class="text-center align-middle"><?=$jadwal->ruang?></td>
                                <td class="text-center align-middle"><?=$jadwal->sesi?></td>
                                <td class="text-center align-middle"><?=$jadwal->waktu?></td>
                                <td class="align-middle"><?=$jadwal->mapel?></td>
                                <td class="align-middle"><?=$jadwal->pengawas?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                    <div id="konten-copy" class="d-none"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?= base_url() ?>/assets/app/js/print-area.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/app/js/html-docx.js"></script>
<script src="<?= base_url() ?>/assets/app/js/convert-area.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/app/js/FileSaver.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/app/js/jquery.wordexport.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/app/js/tableToExcel.js"></script>
<script src="<?= base_url() ?>/assets/app/js/jquery.rowspanizer.js"></script>
<script>
    var docTitle = '<?=$judul?>' + ' <?=$jenis[$jenis_selected]?>';

    $(document).ready(function () {
        ajaxcsrf();

        $("#tbl-pengawas").rowspanizer({columns: [0,1,2]});

        var allowed = JSON.parse('<?=json_encode($allowedDates)?>');
        console.log(allowed);
        $('.tgl').datetimepicker({
            icons:
                {
                    next: 'fa fa-angle-right',
                    previous: 'fa fa-angle-left'
                },
            timepicker: false,
            format: 'Y-m-d',
            disabledWeekDays: [0],
            //allowDates: allowed,
            formatDate: 'Y-m-d',
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            }
        });

        var opsiJenis = $("#jenis");
        var opsiFilter = $("#filter");
        var opsiDari = $("#dari");
        var opsiSampai = $("#sampai");

        opsiFilter.change(function () {
            if ($(this).val() == '0') {
                $('#tgl-dari').addClass('d-none');
                $('#tgl-sampai').addClass('d-none');
                var jenis = opsiJenis.val();
                var url =  base_url + 'cbtcetak/pengawas?jenis=' + jenis + '&filter=0';
                if (jenis != "") {
                    window.location.href = url;
                }
            } else {
                $('#tgl-dari').removeClass('d-none');
                $('#tgl-sampai').removeClass('d-none');
            }
        });

        var old = "<?=$jenis_selected?>";
        opsiJenis.change(function () {
            //var jj = $(this).val();
            //if (jj != "" && jj !== old) {
                getAllJadwal();
                //window.location.href = base_url + 'cbtalokasi?jenis=' + jj + '&level=' + opsiLevel.val();
            //}
        });

        var dariold = "<?=$dari_selected?>";
        opsiDari.change(function () {
            var dari = $(this).val();
            if (dari != "" && dari !== dariold) {
                getAllJadwal();
            }
        });

        var sampaiold = "<?=$sampai_selected?>";
        opsiSampai.change(function () {
            var sampai = $(this).val();
            if (sampai != "" && sampai !== sampaiold) {
                getAllJadwal();
            }
        });

        function getAllJadwal() {
            var jenis = opsiJenis.val();
            var dari = opsiDari.val();
            var sampai = opsiSampai.val();
            var fil = opsiFilter.val();

            var tglKosong = fil == '1' && (dari == "" || sampai == "");
            var url = base_url + 'cbtcetak/pengawas?jenis=' + jenis + '&filter=' + opsiFilter.val() + '&dari=' + dari + '&sampai=' + sampai;
            console.log(url);
            if (jenis != "" && !tglKosong) {
                window.location.href = url;
            }
        }

        $('#simpanalokasi').on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();
            e.stopImmediatePropagation();

            const $rows1 = $('#tbl').find('tr'), headers1 = $rows1.splice(0, 1);
            var jsonObj = [];
            $rows1.each((i, row) => {
                const jam_ke = $(row).find('.jam-ke').text().trim();
                const jarak = $(row).find('input.jarak').val();
                const id_jadwal = $(row).find('.jadwal').val();

                let item = {};
                item ["id_jadwal"] = id_jadwal;
                item ["jam_ke"] = jam_ke;
                item ["jarak"] = jarak;

                jsonObj.push(item);
            });


            var dataPost = $(this).serialize() + "&alokasi=" + JSON.stringify(jsonObj);
            console.log(dataPost);

            $.ajax({
                url: base_url + "cbtalokasi/savealokasi",
                type: "POST",
                dataType: "JSON",
                data: dataPost,
                success: function (data) {
                    console.log("response:", data);
                    if (data.status) {
                        swal.fire({
                            title: "Sukses",
                            html: "Alokasi waktu ujian berhasil disimpan",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "OK"
                        }).then(result => {
                            if (result.value) {
                                window.location.reload();
                            }
                        });
                    } else {
                        showDangerToast('gagal disimpan')
                    }
                }, error: function (xhr, status, error) {
                    console.log("response:", xhr.responseText);
                    showDangerToast('gagal disimpan')
                }
            });

        });

        $('#selector button').click(function () {
            $(this).addClass('active').siblings().addClass('btn-outline-primary').removeClass('active btn-primary');

            if (!$('#by-kelas').is(':hidden')) {
                $('#by-kelas').addClass('d-none');
                $('#by-ruang').removeClass('d-none');
            } else {
                $('#by-kelas').removeClass('d-none');
                $('#by-ruang').addClass('d-none');
            }
        });
    });

    function print() {
        var title = document.title;
        document.title = docTitle;
        $('#tbl-pengawas').print(docTitle);
        document.title = title;
    }

    function exportWord() {
        var contentDocument = $('#tbl-pengawas').convertToHtmlFile(docTitle, '');
        var content = '<!DOCTYPE html>' + contentDocument.documentElement.outerHTML;
        //console.log('css', content);
        var converted = htmlDocx.asBlob(content, {orientation: 'landscape', size: 'A4', margins:{top:700, bottom:700, left:1000, right:1000}});

        saveAs(converted, docTitle + '.docx');
    }

    function exportExcel() {
        /*
        var title = $('#jdl').html();
        var trsAtas = $('table#atas tbody').html();
        var trsHead = $('table#log-nilai thead').html();
        var trsBody = $('table#log-nilai tbody').html();
        var copy = '<table id="excel" style="font-size: 11pt;" data-cols-width="'+colWidth+'"><tbody>' +
            '<tr>' +
            '<td colspan="'+ (numCol+9) +'" data-a-v="middle" data-a-h="center" data-f-bold="true">' + title + '</td>' +
            '</tr>' +
            trsAtas +
            trsHead +
            trsBody +
            '<tr>' +
            '<td colspan="'+ (numCol+9) +'" data-a-v="middle"">' + catatan + '</td>' +
            '</tr>' +
            '</tbody>';
            */
        $('#konten-copy').html(copy);


        var table = document.querySelector("#excel");
        TableToExcel.convert(table, {
            name: docTitle + '.xlsx',
            sheet: {
                name: "Sheet 1"
            }
        });
    }

</script>
