@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Rasptells kontrollcenter</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					@if (count($user_devices) > 0)
						@for($i = 0; $i < count($user_devices); $i++)
							<input type="hidden" id="ip-address" value="{{$ip}}">
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<small>{{$user_devices[$i]->device_name}}  </small>
									<button type="submit" value="{{$user_devices[$i]->id_in_residence}}" id="<?php if($i === 0) {echo $i;} else {echo $i+1;} ?>" class="lightOn btn btn-primary">
										{{ __('PÅ') }}
									</button>
									<button type="submit" value="{{$user_devices[$i]->id_in_residence}}" id="<?php if($i === 0) {echo $i+1;} else {echo $i+2;} ?>" class="lightOff btn btn-primary">
										{{ __('AV') }}
									</button>
									<br><br>
								</div>
							</div>
						@endfor
					@else 
						<small>Du kan inte tända någon lampa. Ledsen {{Auth::user()->name}}</small>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
