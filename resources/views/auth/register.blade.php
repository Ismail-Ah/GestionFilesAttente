<x-layout2 action="register">
    <style>
        body {
            background-image: url('/img/blob2.svg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .card {
            background-color: #023047;
            color: #FFFFFF; 
            border-radius: 20px;
        }

        .card-header,
        .card-body,
        .form-control,
        .form-check-label {
            color: #FFFFFF; /* Set the text color to white */
        }

        .form-control {
            background-color: #023047; /* Matching the background of the input fields to the card */
            border: 1px solid #FFFFFF; /* Optional: Add a white border for the input fields */
        }

        .form-control::placeholder {
            color: #FFFFFF; /* Set the placeholder text color to white */
        }

        .btn-primary {
            background-color: #FB8500; /* Adjust button color if needed */
            border: none;
        }

        .btn-primary:hover {
            background-color: #FF9C2F; /* Optional: Add a hover color for the button */
        }

        .btn-link {
            color: #FFFFFF; /* Set the link color to white */
        }

        .btn-link:hover {
            color: #FF9C2F; /* Optional: Add a hover color for the link */
        }
    </style>

    <header id="header" class="ex-2-header">
        <div class="header-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __("S'inscrire") }}</div>
            
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
            
                                    <div class="row mb-3">
                                        <label for="nom" class="col-md-4 col-form-label text-md-end">{{ __('nom') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
            
                                            @error('nom')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
            
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __("S'inscrire") }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end of header-content -->
    </header> <!-- end of header -->

</x-layout2>