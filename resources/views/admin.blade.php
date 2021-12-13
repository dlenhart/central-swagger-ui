@extends('layouts.app')

@section('content')

<!-- A super simple crud interface -->

<div class="container mt-12">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card border-dark" style="box-shadow: rgba(0, 0, 0, 0.1) 2px 2px 10px 0px;">

                <div class="center-img compImg">
                    <img src="/images/company_0.png" width="600" height="152" alt="" />
                </div>

                <div class="card-header text-white bg-dark text-center">Add/Update/Delete Swagger JSON URLS to view
                    on the centralized document.</div>
                <br />
                <div class="col-md-6">
                    
                    <create-component></create-component>                    
                    
                </div>

                @if (\Session::has('success'))
                <br />
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{!! \Session::get('success') !!}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif

                @if (\Session::has('something_happened'))
                <br />
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{!! \Session::get('something_happened') !!}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <br />

                @if($urls->count() <= 0 ) <div class="center-img">
                    <img src="/images/oops.png" width="200" height="224" />
            </div>
            @else

                <link-component :user_id="{{ Auth::user()->id }}" user_name="{{ Auth::user()->name }}"></link-component>

            @endif
        </div>
    </div>
</div>
</div>

@endsection
