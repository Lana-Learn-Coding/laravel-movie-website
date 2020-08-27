@extends('layouts.app')

@section('content')
    <v-container
        class="fill-height"
        fluid
    >
        <v-row justify="center">
            <v-col xl="4" lg="5" md="6" sm="9" cols="11">
                <v-card>
                    <v-card-title>Login</v-card-title>
                    <v-card-text>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <v-text-field
                                label="Email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autofocus
                                required
                                @error('email')
                                error
                                error-messages="{{ $message }}"
                                @enderror
                            >
                            </v-text-field>
                            <v-text-field
                                label="Password"
                                name="password"
                                type="password"
                                value="{{ old('password') }}"
                                required
                                @error('password')
                                error
                                error-messages="{{ $message }}"
                                @enderror
                            >
                            </v-text-field>
                            <v-checkbox

                                label="Remember Me"
                                v-model="rememberCheckbox"
                                true-value="on"
                                dense
                            >
                            </v-checkbox>
                            <input
                                type="checkbox"
                                class="d-none"
                                name="remember"
                                id="remember"
                                :checked="rememberCheckbox"
                                :value="rememberCheckbox ? 'on' : ''"
                            >
                            <div class="mt-3">
                                <v-btn type="submit" color="indigo darken-2 mr-4">Login</v-btn>
                                @if (Route::has('password.request'))
                                    <a class="text--primary text-decoration-none"
                                       href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                        </form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
@endsection

@section('vue')
    <script src="{{ asset('js/use.js') }}"></script>
    <script>
        const app = new Vue({
            el: '#app',
            vuetify,
            setup() {
                return {
                    ...useApplicationBase(),
                    ...useLogin(),
                };
            },
        });

        function useLogin() {
            const rememberCheckbox = ref({{ old('remember') ? 'true' : 'false' }});
            return {
                rememberCheckbox,
            };
        }
    </script>
@endsection
