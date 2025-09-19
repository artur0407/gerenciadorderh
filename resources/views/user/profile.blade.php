<x-layout-app page-title="User Profile">
    <div class="w-100 p-4">
        <h3>Pefil do Usuário</h3>
        <hr>
        <x-profile-user-data />
        <hr>
        <div class="container-fluid m-0 p-0 mt-5">
            <div class="row">
                <x-profile-user-change-data :colaborator="$colaborator"></x-profile-user-change-data>
                <x-profile-user-change-address :colaborator="$colaborator"></x-profile-user-change-address>
                <x-profile-user-change-password></x-profile-user-change-password>
            </div>
        </div>
    </div>
</x-layout-app>
