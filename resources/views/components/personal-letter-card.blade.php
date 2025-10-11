<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $letter->template_type ?? '-' }}</h5>
        <p class="card-text">{{ $letter->subject ?? $letter->tentang ?? '-' }}</p>
        <p class="text-muted small">Tanggal: {{ $letter->letter_date ?? '-' }}</p>
        <a href="{{ route('transaction.personal.show', $letter->id) }}" class="btn btn-sm btn-primary">Detail</a>
    </div>
</div>
