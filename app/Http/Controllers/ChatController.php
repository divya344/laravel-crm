<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Role-based visibility:
        // - Admin & Manager: can see all users except themselves
        // - Employee: can only see Admins & Managers in the user list
        $usersQuery = User::where('id', '!=', $user->id)->orderBy('name');

        if ($user->isEmployee()) {
            $usersQuery->whereIn('role', ['admin', 'manager']);
        }

        $users = $usersQuery->get();

        $activeUserId = request('user_id');
        $activeChannel = request('channel');

        $query = Message::query()->with(['sender', 'receiver']);

        if ($activeUserId) {
            // Direct chat between current user and selected user
            $query->where(function ($q) use ($user, $activeUserId) {
                $q->where(function ($q2) use ($user, $activeUserId) {
                    $q2->where('sender_id', $user->id)
                        ->where('receiver_id', $activeUserId);
                })->orWhere(function ($q2) use ($user, $activeUserId) {
                    $q2->where('sender_id', $activeUserId)
                        ->where('receiver_id', $user->id);
                });
            });
        } elseif ($activeChannel) {
            // Simple group channel chat by name
            $query->where('channel', $activeChannel);
        } else {
            // Default: last 50 messages where user is participant
            $query->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            });
        }

        $messages = $query->orderBy('created_at', 'asc')->limit(200)->get();

        return view('chat.index', [
            'user' => $user,
            'users' => $users,
            'messages' => $messages,
            'activeUserId' => $activeUserId,
            'activeChannel' => $activeChannel,
        ]);
    }

    public function fetch(Request $request)
    {
        $user = Auth::user();
        $activeUserId = $request->input('user_id');
        $activeChannel = $request->input('channel');

        $query = Message::query()->with(['sender', 'receiver']);

        if ($activeUserId) {
            $query->where(function ($q) use ($user, $activeUserId) {
                $q->where(function ($q2) use ($user, $activeUserId) {
                    $q2->where('sender_id', $user->id)
                        ->where('receiver_id', $activeUserId);
                })->orWhere(function ($q2) use ($user, $activeUserId) {
                    $q2->where('sender_id', $activeUserId)
                        ->where('receiver_id', $user->id);
                });
            });
        } elseif ($activeChannel) {
            $query->where('channel', $activeChannel);
        } else {
            $query->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            });
        }

        $messages = $query->orderBy('created_at', 'asc')->limit(200)->get();

        return response()->json([
            'messages' => $messages->map(function ($m) use ($user) {
                return [
                    'id' => $m->id,
                    'body' => $m->body,
                    'mine' => $m->sender_id === $user->id,
                    'sender' => $m->sender ? $m->sender->name : 'System',
                    'attachment_url' => $m->attachment_path ? Storage::url($m->attachment_path) : null,
                    'created_at' => $m->created_at->toDateTimeString(),
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'receiver_id' => 'nullable|exists:users,id',
            'channel' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240', // 10MB
        ]);

        if (!$data['body'] && !$request->hasFile('attachment')) {
            return back()->with('error', 'Please type a message or attach a file.');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat_attachments', 'public');
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $data['receiver_id'] ?? null,
            'channel' => $data['channel'] ?? null,
            'body' => $data['body'] ?? null,
            'attachment_path' => $attachmentPath,
        ]);

        MessageSent::dispatch($message);

        return redirect()->route('chat.index', [
            'user_id' => $data['receiver_id'] ?? null,
            'channel' => $data['channel'] ?? null,
        ])->with('success', 'Message sent.');
    }
}
