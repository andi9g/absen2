<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <style>
        @page {
            margin: 10px 20px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: rgb(31, 31, 31);
        }

        .mp0 {
            margin: 0px;
            padding: 0px;
        }

        .mp10 {
            margin: 10px;
            padding: 10px;
        }

        .mp20 {
            margin: 20px;
            padding: 20px;
        }

        .mt10 {
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
        }

        table tr td {
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body>
    <table width="100%" border="0" style="border-bottom: 3px double;">
        <tr valign="top">

            <td width="15%" align="center">
                <img src="{{ public_path('logo/logo_kepri.png') }}" width="90%" style="margin-bottom: 5px;"
                    alt="">
            </td>
            <td width="80%">
                <table width="100%" class="mt10">
                    <tr>
                        <td align="center" class="mp0">
                            <h3 class="mp0">PEMERINTAH PROVINSI KEPULAUAN RIAU</h3>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="mp0">
                            <h3 class="mp0">DINAS PENDIDIKAN</h3>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="mp0">
                            <h3 class="mp0">{{ $instansi->namainstansi }}</h3>
                        </td>
                    </tr>
                    <tr class="mp0">
                        <td align="center" class="mp0">
                            <small style="font-size: 8pt" class="mp0">Jl. Poros Pulau Pucung –
                                Lome,
                                Km 48 Desa
                                Malang Rapat
                                Kecamatan Gunung Kijang Kode
                                Pos 29153</small>
                        </td>
                    </tr>
                    <tr class="mp0">
                        <td align="center" class="mp0" style="line-height: 11px">
                            <small style="font-size: 8pt" class="mp0">Webside:www.smkn1gunungkijang.sch.id
                                &nbsp;|&nbsp;
                                Email :
                                smkn1gukibintan@gmail.com</small>
                        </td>
                    </tr>
                </table>
            </td>

            <td width="15%" align="center">
                <img src="{{ public_path('logo/logo.png') }}" width="83%" style="margin-bottom: 5px;" alt="">
            </td>
        </tr>
    </table>

    <br>
    <table width="100%">
        <tr>
            <td align="center">
                <h4 class="mp0">LAPORAN KEHADIRAN SISWA</h4>
            </td>
        </tr>
    </table>
    <br>
    <table style="font-size: 10pt">
        <tr>
            <td><b>Kelas</b></td>
            <td>&nbsp;:&nbsp;</td>
            <td>
                XII TKJ
            </td>
        </tr>
        <tr>
            <td><b>Tanggal</b></td>
            <td>&nbsp;:&nbsp;</td>
            <td>
                ( {{ \Carbon\Carbon::parse($tanggalawal)->isoFormat('DD MMMM YY') }} )
                -
                ( {{ \Carbon\Carbon::parse($tanggalakhir)->isoFormat('DD MMMM YY') }} )
            </td>
        </tr>


    </table>
    <table border="1" width="100%" style="margin-top: 5px">
        <thead>
            <tr>
                <th rowspan="2" widht="2px">No</th>
                <th rowspan="2">Nama Siswa</th>
                <th colspan="5">Keterangan</th>
            </tr>
            <tr>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
                <th>Terlmbat</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($dataAbsen as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $item['namasiswa'] }}</td>
                    @foreach ($item['ket'] as $ket)
                        <td align="center">{{ $ket['H'] }}</td>
                        <td align="center">{{ $ket['I'] }}</td>
                        <td align="center">{{ $ket['S'] }}</td>
                        <td align="center">{{ $ket['A'] }}</td>
                        <td align="center">{{ $ket['T'] }}</td>
                    @endforeach

                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
