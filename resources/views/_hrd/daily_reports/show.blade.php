@extends('layouts.app.index')

@section('title')
    Detail Daily Report
@endsection

@section('css')
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Detail Daily Report</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Detail Daily Report</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Laporan Harian</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date">Nama Karyawan</label>
                                <input type="text" class="form-control" value="{{ $daily_report->employee->user->name }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date">Tanggal Mulai</label>
                                <input type="date" class="form-control" value="{{ $daily_report->date }}" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="description" class="mb-3">Description</label>
                                {!! $daily_report->description !!}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="w-100 user-chat">
        <div class="card">
            <div class="p-4 border-bottom ">
                <div class="row">
                    <div class="col-md-4 col-9">
                        <h5 class="font-size-15 mb-1">Komentar</h5>
                    </div>
                </div>
            </div>
            <div>
                <div class="chat-conversation p-3">
                    <ul class="list-unstyled mb-0" data-simplebar style="max-height: 486px;">
                        <li>
                            <div class="chat-day-title">
                                <span class="title">{{ $daily_report->created_at->format('d F Y') }}</span>
                            </div>
                        </li>
                        @foreach ($daily_report->comment as $item)
                            @if ($item->user_id !== auth()->user()->id)
                                <li>
                                    <div class="conversation-list">
                                        <div class="ctext-wrap">
                                            <div class="conversation-name">
                                                @if ($item->user)
                                                    {{ $item->user->name }}
                                                @endif
                                            </div>
                                            <p>
                                                {{ $item->comment }}
                                            </p>
                                            <p class="chat-time mb-0"><i
                                                    class="bx bx-time-five align-middle me-1"></i>{{ $item->created_at->format('h:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="mar" style="margin-left: 650px;">
                                    <div class="conversation-list">
                                        <div class="ctext-wrap">
                                            <div class="conversation-name">
                                                @if ($item->user)
                                                    {{ $item->user->name }}
                                                @endif
                                            </div>
                                            <p>
                                                {{ $item->comment }}
                                            </p>
                                            <p class="chat-time mb-0"><i
                                                    class="bx bx-time-five align-middle me-1"></i>{{ $item->created_at->format('h:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="p-3 chat-input-section">
                    <div class="row">
                        <form action="{{ route('daily_report_comment.hrd', $daily_report) }}" method="post">
                            @csrf
                            <div class="col">
                                <div class="position-relative">
                                    <input type="text" name="comment" class="form-control chat-input"
                                        placeholder="Enter Message...">
                                </div>
                            </div>
                            <div class="col-auto mt-3">
                                <button type="submit"
                                    class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light"><span
                                        class="d-none d-sm-inline-block me-2">Send</span> <i
                                        class="mdi mdi-send"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('plugin')
@endsection
