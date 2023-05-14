@extends('layouts.auth')

@section('content')
    <div class="container container_login">
        <div class="box">

            @include('partials/_logo')

            <div class="inputs">

                <form id="form_register" type="POST" method="POST" action="{{route('register')}}">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-floating">
                                <input  id="username" name="username" type="text" class="form-control"  value="{{ old('username') }}" maxlength="25" placeholder="Username" autocomplete="username" autofocus required>
                                <label for="username">Username</label>
                            </div>
                            <p class="error-message text-danger" class="m-0 p-0" role="alert"></p>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-floating mb-3">
                            <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <label for="password">Password</label>
                            </div>

                            <p class="error-message text-danger" class="m-0 p-0" role="alert"></p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                            <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm">Confirm Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;" id="btn_submit">register</button>
                        </div>
                        
                        <a class="link_registration" href="{{ url('/') }}">
                            login
                        </a> 
                    </div> 

                </form>

            </div>
        </div>
    </div>


        <script src="{{ asset('js/jquery.min.js') }}"></script>

        {{-- LINK:https://sweetalert2.github.io/#examples --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                $('#form_register').submit(function(e){
                    e.preventDefault();
                    let csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Remove any previously displayed error messages
                    $('.validation-error').remove();

                    let formData = $(this).serialize();
                    
                    $.ajax({
                        url: "{{route('register')}}", 
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request header
                        },
                        success: function(response){

                            Swal.fire({
                                icon: 'success',
                                title: 'Registered Successfully!',
                                text: 'Please go to login page.',
                                confirmButtonColor: '#FF4651',
                            }).then((res) => {
                                $('input').val('');
                                $('.validation-error').remove();
                            })

                        },
                        error: function (response){
                            // If the server returns an error response, display the validation errors
                            var errors = response.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                var errorHtml = `<p class="text-danger validation-error"  role="alert">${messages.join('<br>')}</p>`;
                                $('[name="'+field+'"]').after(errorHtml);
                            });
                        }
                    });
                
                })
            })
            
        </script>

@endsection


{{-- 
    user-id generate
 --}}
