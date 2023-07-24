
<?php

function format_uang ($angka){
    return number_format($angka, 0, ',', '.');
    }

function terbilang($angka){
    //$angka= abs($angka);
    $baca = array('','Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', ' Sepuluh', 'Sebelas');
    $terbilang = '';

    if ($angka<0){
        $terbilang='Kurang Bayar';}
    elseif ($angka<12){
        $terbilang=' '.$baca[$angka];}
    elseif ($angka<20){
        $terbilang=terbilang($angka-10).' Belas';}
    elseif ($angka<100){
        $terbilang=terbilang($angka/10).' Puluh'.terbilang($angka%10);}
    elseif ($angka<200){
        $terbilang=' Seratus'.terbilang($angka-100);}
    elseif ($angka<1000){
        $terbilang=terbilang($angka/100).' Ratus'.terbilang($angka%100);}
    elseif ($angka<2000){
        $terbilang=' Seribu'.terbilang($angka-1000);}
    elseif ($angka<1000000){
        $terbilang=terbilang($angka/1000).' Ribu'.terbilang($angka%1000);}
    elseif ($angka<1000000000){
        $terbilang=terbilang($angka/1000000).' Juta'.terbilang($angka%1000000);}
    return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari  = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'
    );
    $nama_bulan = array(1 =>
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    );

    $tahun   = substr($tgl, 0, 4);
    $bulan   = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text    = '';

    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0,0,0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari        = $nama_hari[$urutan_hari];
        $text       .= "$hari, $tanggal$bulan$tahun";
    } else {
        $text       .= "$tanggal$bulan$tahun";
    }
    
    return $text; 
}

function tambah_nol_didepan($value, $threshold = null)
{
    return sprintf("%0". $threshold . "s", $value);
}