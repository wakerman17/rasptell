@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ny Raspberry till dig') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('newRasp') }}">
                        @csrf
					
                        <div class="form-group row">
                            <label for="ip_address" class="col-md-4 col-form-label text-md-right">{{ __('IP-address') }}</label>

                            <div class="col-md-6">
                                <input id="ip_address" type="text" class="form-control{{ $errors->has('ip_address') ? ' is-invalid' : '' }}" name="ip_address" required>

                                @if ($errors->has('ip_address'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('ip_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Lägg till') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection