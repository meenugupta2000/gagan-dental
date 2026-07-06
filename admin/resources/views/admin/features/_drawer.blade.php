<form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-drawer-form>
    @isset($method) @method($method) @endisset
    @include('admin.features._form', ['submitLabel' => $submitLabel])
</form>
