<div>
    <button type="button" wire:click="getCard" class="btn btn-primary btn-lg w-100 mb-2">
        <b>
            GET CARD
        </b>
    </button>
    <div class='card product-card'>
        <div class='card-body'>
            @if ($akses == 0)
                <center>
                    <h5 class='product-title text-center'>SCAN KARTU</h5>
                    <small id="nisnID" class="text-muted">SCAN kartu, Jika sudah silahkan tekan tombol <b>GET
                            CARD</b></small>
                </center>
            @elseif ($akses == 1)
                <table class="table table-striped table-lg">
                    <tr>
                        <th>NISN</th>
                        <td>{{ $nisn }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $nama }}</td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td>{{ $tempatlahir }}</td>
                    </tr>
                    <tr>
                        <th>Rombel</th>
                        <td>{{ $rombel }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $alamat }}</td>
                    </tr>
                </table>
            @elseif ($akses == 2)
                <h5 class='product-title text-center text-danger'>KARTU TIDAK DITEMUKAN</h5>
            @elseif ($akses == 3)
                <h5 class='product-title text-center text-danger'>KARTU TIDAK DITEMUKAN</h5>
            @endif

        </div>
    </div>
</div>
