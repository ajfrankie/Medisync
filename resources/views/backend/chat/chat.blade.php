@extends('backend.layouts.master')

@section('title')
    AI Chat Log
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            AI Chat Log
        @endslot
        @slot('title')
            Chat Logs
        @endslot
    @endcomponent
    @include('backend.layouts.alert')
    @include('backend.doctor.filter')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Patient's Name</th>
                                    <th scope="col">Asking Question</th>
                                    <th scope="col">Replay</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chats as $chat)
                                    <tr>
                                        <td>{{ $chat->user->name ?? 'N/A' }}</td>
                                        <td>{{ $chat->query_text ?? 'N/A' }}</td>
                                        <td>{{ $chat->response_text ?? 'N/A' }}</td>
                                        <td>{{ $chat->created_at ? $chat->created_at->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $chat->created_at ? $chat->created_at->format('H:i') : 'N/A' }}</td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- end table -->
                    </div>
                    <!-- end table responsive -->
                </div>
                <!-- end card body -->
                <div class="text-end">
                    <ul class="pagination-rounded">
                        {{ $chats->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
