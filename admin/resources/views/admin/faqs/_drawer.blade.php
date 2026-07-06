<form method="POST" action="{{ $action }}" data-drawer-form>
    @isset($method) @method($method) @endisset
    @include('admin.faqs._form', ['submitLabel' => $submitLabel])
</form>
