@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="center-img compImg">
            
            <img src="/images/company_0.png" width="600" height="152" alt="" />

            <h2 class="mt-4">Centralized Swagger Documentation</h2>
            <br />
            <div class="justify-content-center">
                <a href="/documentation" class="btn btn-outline-primary btn-lg">Swagger</a>
                <a href="/admin" class="btn btn-outline-primary btn-lg">Administration</a>
                <br /><br />
                <hr />
                <h2 class="mt-4">Quick Links:</h2>
                <br />
                <div class="text-left">
                    <ul>
                        @foreach ($lists as $list)

                            <li>
                                <h4><a href="/documentation?urls.primaryName={{ $list->name }}">{{ $list->name }}</a></h4>
                            </li>

                        @endforeach
                    </ul>
                </div>
                <br />
                <hr />
            </div>
        </div>
    </div>
</div>
@endsection
