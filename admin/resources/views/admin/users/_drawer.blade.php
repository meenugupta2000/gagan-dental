<form method="POST" action="{{ $action }}" data-drawer-form>
    @isset($method) @method($method) @endisset
    @include('admin.users._form', ['submitLabel' => $submitLabel])
</form>
