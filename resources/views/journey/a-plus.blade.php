@extends('_layouts.app')

@section('title', 'A+ Setups - ' . $journey->name)

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border flex items-center justify-between gap-3">
                <h3 class="box-title">A+ Setups — {{ $journey->name }}</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Result</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td style="white-space: nowrap;">{{ $item->date }}</td>
                                <td style="white-space: nowrap;">
                                    <span class="{{ $item->result_r1 === 'WIN' || (is_numeric($item->result_r1) && (float) $item->result_r1 > 0) ? 'text-emerald-400' : ($item->result_r1 === 'LOSS' || (is_numeric($item->result_r1) && (float) $item->result_r1 < 0) ? 'text-rose-400' : '') }}">
                                        {{ $item->result_r1 ?: '—' }}
                                    </span>
                                    @if (is_numeric($item->result_r1)) ({{ number_format((float) $item->result_r1, 2) }}R) @endif
                                    @if ($item->result_r2 !== null && $item->result_r2 !== '' && $item->result_r2 != 0)
                                        <br><span class="{{ $item->result_r2 === 'WIN' || (is_numeric($item->result_r2) && (float) $item->result_r2 > 0) ? 'text-emerald-400' : ($item->result_r2 === 'LOSS' || (is_numeric($item->result_r2) && (float) $item->result_r2 < 0) ? 'text-rose-400' : '') }}">{{ $item->result_r2 }}</span>
                                        @if (is_numeric($item->result_r2)) ({{ number_format((float) $item->result_r2, 2) }}R) @endif
                                    @endif
                                </td>
                                <td>{!! nl2br(e($item->note ?: '—')) !!}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding: 0;">
                                    @if ($item->dimage || $item->dimage2)
                                        <div style="display: flex; flex-direction: column; gap: .75rem; padding: .75rem;">
                                            @if ($item->dimage)
                                                <a href="{{ $item->dimage }}" target="_blank" rel="noopener">
                                                    <img src="{{ $item->dimage }}" alt="รูปบันทึกการเทรด วันที่ {{ $item->date }}" style="display: block; width: 100%; height: auto; border-radius: .5rem;">
                                                </a>
                                            @endif
                                            @if ($item->dimage2)
                                                <a href="{{ $item->dimage2 }}" target="_blank" rel="noopener">
                                                    <img src="{{ $item->dimage2 }}" alt="รูปบันทึกการเทรดเพิ่มเติม วันที่ {{ $item->date }}" style="display: block; width: 100%; height: auto; border-radius: .5rem;">
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-muted" style="padding: .75rem;">ไม่มีรูปบันทึกการเทรด</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">ยังไม่มี setup เกรด A+ ใน Journey นี้</td></tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($items->total())
                    <div class="mt-4 flex items-center justify-between gap-3">
                        @if ($items->previousPageUrl())
                            <a href="{{ $items->previousPageUrl() }}" class="btn btn-default">← ก่อนหน้า</a>
                        @else
                            <span></span>
                        @endif
                        <span class="text-muted">{{ $items->firstItem() }} / {{ $items->total() }}</span>
                        @if ($items->nextPageUrl())
                            <a href="{{ $items->nextPageUrl() }}" class="btn btn-primary">ถัดไป →</a>
                        @else
                            <span></span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
