@extends('layouts.app.index')

@section('title')
    Send Email Submission
@endsection

@section('css')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Send Email Submission</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                        <li class="breadcrumb-item active">Submission</li>
                        <li class="breadcrumb-item active">Send Email</li>
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


                    <form action="{{ route('submission.send_submission.employee', $submission->id) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Penerima</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cc">CC</label>
                                    <select class="select2 form-control select2-multiple @error('cc') is-invalid @enderror"
                                        name="cc[]" multiple="multiple" data-placeholder="Masukan Email ...">
                                    </select>
                                    {{-- <input type="email" multiple class="form-control @error('cc') is-invalid @enderror"
                                        name="cc"> --}}
                                    @error('cc')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body"
                            style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;"
                            width="100%" bgcolor="#f6f6f6">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                    &nbsp;</td>
                                <td class="container"
                                    style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;"
                                    width="580" valign="top">
                                    <div class="content"
                                        style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">

                                        <!-- START CENTERED WHITE CONTAINER -->
                                        <table role="presentation" class="main"
                                            style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;"
                                            width="100%">

                                            <!-- START MAIN CONTENT AREA -->
                                            <tr>
                                                <td class="wrapper"
                                                    style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;"
                                                    valign="top">
                                                    <table role="presentation" border="0" cellpadding="0"
                                                        cellspacing="0"
                                                        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                                                        width="100%">
                                                        <tr>
                                                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                                                valign="top">
                                                                <p>Judul : {!! $submission->title !!}</p>
                                                                <p>Nominal : {!! $submission->nominal !!}</p>
                                                                <p>Catatan : {!! $submission->note !!}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <!-- END MAIN CONTENT AREA -->
                                        </table>
                                        <!-- END CENTERED WHITE CONTAINER -->

                                    </div>
                                </td>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                    &nbsp;</td>
                            </tr>
                        </table>

                        <div>
                            <button class="btn btn-primary float-end" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('plugin')
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                tags: true,
            });
        });
    </script>
@endsection
