<x-layout-app page-title="Home">

    <h1 class="text-center my-5">DENTRO DA APP</h1>

    @can('admin')
        <h3 class="text-center mt-5"> User admin logado</h3>
    @endcan

</x-layout-app>