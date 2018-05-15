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
					@if ($flag === 1 || $flag === 4)
						@if (count($user_devices) > 0)
						
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
							<small>Du kan inte ändra någon lampa eftersom inga enheter finns registrerade. Ledsen {{Auth::user()->name}}.</small>
						@endif
					@endif
					@if  ($flag === 2)
						<small>Du kan inte ändra någon enhet eftersom du inte har någon Raspberry registrerad. Ledsen {{Auth::user()->name}}.</small>
					@endif
					@if ($flag === 3)
						<small>Du kan inte ändra någon enhet eftersom du inte har valt en av dina raspberrys. Ledsen {{Auth::user()->name}}.</small>
					@endif
					@if ($flag === 5)
						<small>Du kan inte ändra någon enhet eftersom inga lampor finns registrerade. Ledsen {{Auth::user()->name}}.</small>
					@endif
				</div>
			</div>
			@if ($flag === 3 || $flag === 4)
				<div class="card">
					<div class="card-header">Ändra rasp</div>
					<div class="card-body">
						<form method="POST" action="{{ route('severalRasps') }}">
						@csrf
						@php ($i*=2)
							@for($j = 0; $j < count($user_rasp_accesses); $j++)
								<div class="form-group row mb-0">
									<div class="col-md-6 offset-md-4">
										<input type="hidden" ></input>
										<button name="ip_address" type="submit" value="{{$user_rasp_accesses[$j]->ip_address}}" id="{{ $i }}" class="btn btn-primary">
												{{ __($user_rasp_accesses[$j]->ip_address) }}
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
