<form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-drawer-form>
    @isset($method) @method($method) @endisset
    @include('admin.treatment_categories._form', ['submitLabel' => $submitLabel])
</form>
