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
					
					@if  (isset($new_raspberry_message))
						@if (strcmp($new_raspberry_message,"New") === 0)
							<big>Ny raspberry registrerad med IP-adressen {{$this_ip}}</big> 
							<br>
						@elseif (strcmp($new_raspberry_message,"Same") === 0)
							<big>Du har redan en raspberry med IP-adressen {{$this_ip}}</big> 
							<br>
						@endif
					@endif
					@php ($i=0)
					@if ($show_devices)
						<p>Du hanterar nu raspberryn med IP-adressen {{$this_ip}}</p>
						@foreach($id_in_residences as $key => $value)
							<input type="hidden" id="ip-address" value="{{$this_ip}}">
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<small>{{$device_names[$key]}}  </small>
									<button type="submit" value="{{$id_in_residences[$key]}}" 
									id="<?php if($i === 0) {echo $i;} else {echo $i+1;} ?>" class="lightOn btn btn-primary">
										{{ __('PÅ') }}
									</button>
									<button type="submit" value="{{$id_in_residences[$key]}}" 
									id="<?php if($i === 0) {echo $i+1;} else {echo $i+2;} ?>" class="lightOff btn btn-primary">
										{{ __('AV') }}
									</button>
									<br><br>
								</div>
							</div>
							@php ($i++)
						@endforeach
					@endif
					@if  (!$show_devices && $show_raspberries && isset($new_raspberry_message))
						<small> Du kan inte ändra någon av enheterna eftersom du inte valt en av dina raspberrys. Ledsen {{Auth::user()->name}}.</small>
						
					@elseif (!$show_devices && $show_raspberries && !isset($new_raspberry_message))
						<small>Du kan inte ändra någon enhet eftersom det finns ingen enhet registrerad på raspberryn med IP-adressen {{$this_ip}}. Ledsen {{Auth::user()->name}}.</small>
						
					@elseif  (!$show_devices && !$show_raspberries)
						<small>Du kan inte ändra enheterna eftersom du inte har någon Raspberry registrerad. Ledsen {{Auth::user()->name}}.</small>
					@endif
				</div>
			</div>
			@if ($show_raspberries)
				<div class="card">
					<div class="card-header">Ändra raspberry</div>
					<div class="card-body">
						<form method="POST" action="{{ route('getDevicesWithSeveralRaspberries') }}">
						@csrf
						@php ($i*=2)
							@foreach($ip_addresses as $ip_address)
								<div class="form-group row mb-0">
									<div class="col-md-6 offset-md-4">
										<input type="hidden" ></input>
										<button name="ip_address" type="submit" value="{{$ip_address}}" 
										id="{{$i}}" class="btn btn-primary">
												{{ __($ip_address) }}
										</button>
										<br><br>
									</div>
								</div>
								@php ($i++)
							@endforeach
						</form>
					</div>
				</div>
			@endif
        </div>
    </div>
</div>
@endsection
