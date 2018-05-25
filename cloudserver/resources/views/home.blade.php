@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ändra enheterna</div>
                <div class="card-body">
					
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					@php ($i=0)
					@if  (isset($raspberry_message))
						@if ($raspberry_message === "New")
							<big>Ny raspberry registrerad med IP-adressen {{$ip}}</big> 
							<br>
						@elseif ($raspberry_message === "Same")
							<big>Du har redan en raspberry med IP-adressen {{$ip}}</big> 
							<br>
						@endif
					@endif
					@if ($flag === 1 || $flag === 4)
						@if (count($user_devices) > 0)
							<p>Du hanterar nu raspberryn med IP-adressen {{$ip}}</p>
							@foreach($user_devices as $user_device)
								<input type="hidden" id="ip-address" value="{{$ip}}">
								<div class="form-group row mb-0">
									<div class="col-md-6 offset-md-4">
										<small>{{$user_device->device_name}}  </small>
										<button type="submit" value="{{$user_device->id_in_residence}}" id="<?php if($i === 0) {echo $i;} else {echo $i+1;} ?>" class="lightOn btn btn-primary">
											{{ __('PÅ') }}
										</button>
										<button type="submit" value="{{$user_device->id_in_residence}}" id="<?php if($i === 0) {echo $i+1;} else {echo $i+2;} ?>" class="lightOff btn btn-primary">
											{{ __('AV') }}
										</button>
										<br><br>
									</div>
								</div>
								@php ($i++)
							@endforeach
						@else
							<small>Du kan inte ändra någon enhet eftersom det finns ingen enhet registrerad på raspberryn med IP-adressen {{$ip}}. Ledsen {{Auth::user()->name}}.</small>
						@endif
					@endif
					@if  ($flag === 2)
						<small>Du kan inte ändra enheterna eftersom du inte har någon Raspberry registrerad. Ledsen {{Auth::user()->name}}.</small>
					@endif
					@if ($flag === 3)
						<small>Du kan inte ändra någon av enheterna eftersom du inte valt en av dina raspberrys. Ledsen {{Auth::user()->name}}.</small>
					@endif
				</div>
			</div>
			@if ($flag === 3 || $flag === 4)
				<div class="card">
					<div class="card-header">Ändra raspberry</div>
					<div class="card-body">
						<form method="POST" action="{{ route('severalRasps') }}">
						@csrf
						@php ($i*=2)
							@for($j = 0; $j < count($raspberries); $j++)
								<div class="form-group row mb-0">
									<div class="col-md-6 offset-md-4">
										<input type="hidden" ></input>
										<button name="ip_address" type="submit" value="{{$raspberries[$j]->ip_address}}" id="{{ $i }}" class="btn btn-primary">
												{{ __($raspberries[$j]->ip_address) }}
										</button>
										<br><br>
									</div>
								</div>
								@php ($i++)
							@endfor
						</form>
					</div>
				</div>
			@endif
        </div>
    </div>
</div>
@endsection
