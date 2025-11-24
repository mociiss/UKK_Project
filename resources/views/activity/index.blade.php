@extends('layouts.app')
@section('title', 'Activity Log')

@section('content')

<h2 style="margin-bottom: 20px;">Activity Log</h2>

<style>
    .table-log {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0 8px;
    }
    .table-log thead {
        background: #545DB0;
        color: white;
    }
    .table-log th {
        padding: 12px;
        text-align: left;
        font-size: 14px;
    }
    .table-log tbody tr {
        background: white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        border-radius: 8px;
    }
    .table-log td {
        padding: 12px;
        font-size: 14px;
        vertical-align: top;
    }
    .changes-box {
        background: #f6f7ff;
        padding: 10px;
        border-radius: 6px;
        font-size: 13px;
        border-left: 4px solid #545DB0;
    }
    .changes-box strong {
        color: #333;
    }
</style>

<table class="table-log">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>User</th>
            <th>Event</th>
            <th>Model</th>
            <th>Perubahan</th>
            <th>IP</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($logs as $i => $log)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
            <td>{{ $log->causer?->nama_petugas ?? 'System' }}</td>
            <td>{{ ucfirst($log->event) }}</td>
            <td>{{ class_basename($log->subject_type) }}</td>

            <td>
                <div class="changes-box">
                    @php
                        // Ambil properti yang diubah
                        $attr = $log->properties['attributes'] ?? [];
                        $old = $log->properties['old'] ?? [];
                    @endphp

                    @forelse ($attr as $key => $value)
                        <strong>{{ $key }}</strong> :  

                        @if(isset($old[$key]))
                            <span style="color:red;">{{ $old[$key] }}</span>
                            ➝
                            <span style="color:green;">{{ $value }}</span>
                        @else
                            <span style="color:green;">{{ $value }}</span>
                        @endif
                        <br>
                    @empty
                        <em>Tidak ada perubahan</em>
                    @endforelse
                </div>
            </td>

            <td>{{ $log->getExtraProperty('ip') ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
