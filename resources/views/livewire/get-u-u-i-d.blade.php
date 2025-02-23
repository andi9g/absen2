<div>
    <label for="nisn" class="form-label">UUID</label>
    <br>
    <small id="nisnID" class="text-muted">SCAN ALAT, Jika sudah silahkan tekan tombol <b>GET UUID</b></small>
    <div class="input-group">

        <input class="form-control mb-0 bg-light border-success" readonly type="text" wire:model="value" name="uuid"
            placeholder="silahkan scan dan GET UID" aria-label="silahkan scan dan GET UID" aria-describedby="keyword">
        <div class="input-group-append">
            <button type="button" wire:click="procesScan" class="btn btn-outline-success">
                <i class="mdi mdi-search"></i> GET UUID
            </button>
        </div>
    </div>
    @if ($message == 1)
        <small id="nisnID" class="text-success">UUID Ditemukan</small>
    @elseif ($message == 2)
        <small id="nisnID" class="text-warning">UUID Telah Terdaftar</small>
    @elseif ($message == 3)
        <small id="nisnID" class="text-warning">UUID Tidak ditemukan</small>
    @endif

</div>
