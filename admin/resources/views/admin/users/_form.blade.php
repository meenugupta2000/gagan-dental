@csrf
<div class="row g-4">
    <div class="col-12">
        <div class="form-section-title">Account Details</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name <span class="req">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" placeholder="e.g. Jane Cooper" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Address <span class="req">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" placeholder="name@gagandentalclinic.com" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" placeholder="+91 ...">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                        {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label ms-1" for="is_active">Active account <span class="text-muted small">(can sign in)</span></label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <hr class="my-1">
        <div class="form-section-title">{{ isset($user) ? 'Change Password' : 'Set Password' }}</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Password @unless(isset($user))<span class="req">*</span>@endunless</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" {{ isset($user) ? '' : 'required' }}>
                @isset($user)<div class="form-text">Leave blank to keep the current password.</div>@endisset
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password @unless(isset($user))<span class="req">*</span>@endunless</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" {{ isset($user) ? '' : 'required' }}>
            </div>
        </div>
    </div>

    <div class="col-12">
        <hr class="my-1">
        <div class="form-section-title">Roles</div>
        <div class="row g-2">
            @foreach ($roles as $role)
                <div class="col-6 col-md-4 col-lg-3">
                    <label class="choice-tile" for="role_{{ $role->id }}">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                            id="role_{{ $role->id }}"
                            {{ in_array($role->name, old('roles', $userRoles ?? [])) ? 'checked' : '' }}>
                        <span class="tile-label">{{ $role->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
