<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $status = $request->string('status')->toString();

        $members = TeamMember::query()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('sort_order')->orderByDesc('id')
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.team.index', compact('members', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.team._drawer', [
                'action' => route('admin.team.store'),
                'submitLabel' => 'Create Member',
            ]);
        }

        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('team', 'public');
        }
        unset($data['photo']);

        TeamMember::create($data);

        return $this->saved($request, 'admin.team.index', 'Team member added successfully.');
    }

    public function edit(Request $request, TeamMember $teamMember)
    {
        if ($request->header('X-Drawer')) {
            return view('admin.team._drawer', [
                'member' => $teamMember,
                'action' => route('admin.team.update', $teamMember),
                'method' => 'PUT',
                'submitLabel' => 'Update Member',
            ]);
        }

        return view('admin.team.edit', ['member' => $teamMember]);
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('photo')) {
            if ($teamMember->photo_path) {
                Storage::disk('public')->delete($teamMember->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('team', 'public');
        }
        unset($data['photo']);

        $teamMember->update($data);

        return $this->saved($request, 'admin.team.index', 'Team member updated successfully.');
    }

    public function toggle(TeamMember $teamMember)
    {
        $teamMember->update(['is_active' => ! $teamMember->is_active]);

        return back()->with('success', $teamMember->name . ' is now ' . ($teamMember->is_active ? 'Active' : 'Inactive') . '.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
