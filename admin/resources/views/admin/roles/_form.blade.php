@csrf
@php($isProtected = isset($role) && $role->name === 'super-admin')

<div class="row g-4">
    <div class="col-12 col-lg-5">
        <label class="form-label">Role Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name ?? '') }}"
            placeholder="e.g. editor" {{ $isProtected ? 'readonly' : 'required' }}>
        @if ($isProtected)
            <div class="form-text">The Super Admin role name is protected and cannot be changed.</div>
        @else
            <div class="form-text">Use a short, lowercase name (e.g. <code>editor</code>, <code>support</code>).</div>
        @endif
    </div>

    <div class="col-12">
        <div class="form-section-title mb-2">Permissions</div>
        @if ($isProtected)
            <div class="alert alert-info d-flex align-items-center mb-0">
                <i class="bi bi-shield-check me-2 fs-5"></i>
                <span>Super Admin always has full access to every module.</span>
            </div>
        @else
            <div class="row g-2">
                @foreach ($permissions as $permission)
                    <div class="col-md-6 col-lg-4">
                        <label class="choice-tile" for="perm_{{ $permission->id }}">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                id="perm_{{ $permission->id }}"
                                {{ in_array($permission->name, old('permissions', $rolePermissions ?? [])) ? 'checked' : '' }}>
                            <span class="tile-label text-capitalize">{{ $permission->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
