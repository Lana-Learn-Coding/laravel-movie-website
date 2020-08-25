<v-row>
    <v-col class="d-flex pr-2 pr-sm-3 pr-md-5" cols="5" md="4" lg="3" xl="2">
        <v-card class="w-100" href="{{ route('user.detail', ['id' => $user->id]) }}">
            <v-img src="{{ $user->avatar ? url('storages/' . $user->avatar) : asset('img/avatar-placeholder.jpg') }}"
                   alt="{{ $user->username }}"
                   id="user-avatar"></v-img>
        </v-card>
    </v-col>
    <v-col class="d-flex pl-0" cols="7" md="8" lg="9" xl="10">
        <v-card class="w-100">
            <v-card-text class="pa-md-5 body-1">
                <div class="mb-3 text-break">
                    <span class="font-weight-bold mr-2">Username: </span>
                    <span>{{ $user->username ?: 'unknown' }}</span>
                </div>
                <div class="mb-3">
                    <span class="font-weight-bold mr-2">Name: </span>
                    <span>{{ ($user->detail ? $user->detail->name : '') ?: 'unknown' }}</span>
                </div>
                <div class="mb-3">
                    <span class="font-weight-bold mr-2">Gender: </span>
                    <span>{{ ($user->detail ? $user->detail->gender : '') ?: 'unknown' }}</span>
                </div>
                <div>
                    <span class="font-weight-bold mr-2">Since: </span>
                    <span>{{ $user->created_at ? date('Y-m-d', strtotime($user->created_at)): 'unknown' }}</span>
                </div>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>
