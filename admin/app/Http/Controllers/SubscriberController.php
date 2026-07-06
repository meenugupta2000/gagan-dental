<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();

        $subscribers = Subscriber::query()
            ->when($search, fn ($query) => $query->where('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate(config('admin.per_page'))
            ->withQueryString();

        return view('admin.subscribers.index', compact('subscribers', 'search'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber removed.');
    }
}
