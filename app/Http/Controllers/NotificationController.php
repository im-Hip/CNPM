<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Classes;
use App\Models\Schedule;
use App\Models\TeacherAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;  // Thêm để debug (xóa sau nếu không cần)

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin xem tất cả thông báo đã gửi
            $sentNotifications = Notification::where('sender_id', $user->id)
                ->orderBy('sent_at', 'desc')
                ->paginate(10);
        } elseif ($user->role === 'teacher') {
            // Teacher xem thông báo đã gửi của mình
            $sentNotifications = Notification::where('sender_id', $user->id)
                ->orderBy('sent_at', 'desc')
                ->paginate(10);
        } else {
            // Student xem thông báo nhận được
            $sentNotifications = Notification::where(function ($query) use ($user) {
                $query->where('recipient_type', 'App\Models\User')
                    ->where('recipient_id', $user->id);
            })
                ->orWhere('recipient_type', 'all')
                ->orWhere('recipient_type', 'students')
                ->orderBy('sent_at', 'desc')
                ->paginate(10);
        }

        // Dùng chung view history cho tất cả role
        return view('notifications.history', compact('sentNotifications'));
    }

    public function create()
    {
        if (Auth::user()->role === 'admin') {
            $classes = Classes::all();
            return view('notifications.create', compact('classes'));
        } elseif (Auth::user()->role === 'teacher') {
            $assignments = TeacherAssignment::where('teacher_id', Auth::id())->with('class')->get();
            $classes = $assignments->isNotEmpty() ? $assignments->pluck('class')->filter()->unique() : collect();
            return view('notifications.create', compact('classes'));
        }
        abort(403, 'Unauthorized action');
    }

    public function store(Request $request)
    {
        $sender = Auth::user();

        // Validation động theo role
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:exam,assignment,event,warning,scholarship',
            'recipient_type' => 'required|in:all,teachers,students,class,individual',
        ];

        if ($sender->role === 'admin') {
            //nếu chọn theo cá nhân
            $rules['recipient_id'] = 'nullable|required_if:recipient_type,individual|exists:users,id';
        } else {
            // Teacher chỉ gửi 'class'
            $rules['recipient_type'] = 'required|in:class';
            $rules['recipient_id'] = 'required|exists:classes,id';
        }

        $request->validate($rules);

        Log::info('Bắt đầu gửi thông báo từ user ' . $sender->id . ' (role: ' . $sender->role . ')');

        $createdCount = 0;

        if ($sender->role === 'admin') {
            // Admin: Xử lý tất cả cases
            if ($request->recipient_type === 'all') {
                $recipients = User::whereIn('role', ['teacher', 'student'])->get();
                Log::info('Admin gửi all: ' . $recipients->count() . ' recipients');
            } elseif ($request->recipient_type === 'teachers') {
                $recipients = User::where('role', 'teacher')->get();
                Log::info('Admin gửi teachers: ' . $recipients->count() . ' recipients');
            } elseif ($request->recipient_type === 'students') {
                $recipients = User::where('role', 'student')->get();
                Log::info('Admin gửi students: ' . $recipients->count() . ' recipients');
            } elseif ($request->recipient_type === 'class') {
                $class = Classes::find($request->class_id);
                if (!$class) {
                    abort(404, 'Lớp không tồn tại');
                }
                // Lấy students của class, rồi users
                $students = $class->students()->with('user')->get();  // Giả sử Classes có relationship students()
                $recipients = $students->pluck('user');  // Chỉ lấy users
                Log::info('Admin gửi class ' . $class->name . ': ' . $recipients->count() . ' recipients');
            } elseif ($request->recipient_type === 'individual') {
                $recipients = collect([User::find($request->recipient_id)]);
                Log::info('Admin gửi individual: 1 recipient');
            }
        } elseif ($sender->role === 'teacher') {
            // Teacher: Chỉ gửi đến class được assign
            $classId = $request->recipient_id;
            $class = Classes::find($classId);
            if (!$class) {
                abort(404, 'Lớp không tồn tại');
            }

            // Check assignment: Teacher có dạy lớp này không?
            $assignment = TeacherAssignment::where('teacher_id', $sender->id)
                ->where('class_id', $classId)
                ->first();
            if (!$assignment) {
                Log::error('Teacher ' . $sender->id . ' không được assign lớp ' . $classId);
                abort(403, 'Bạn chỉ có thể gửi thông báo đến lớp bạn đang dạy!');
            }

            // Lấy students của class, rồi users
            $students = $class->students()->with('user')->get();
            $recipients = $students->pluck('user');
            Log::info('Teacher gửi class ' . $class->name . ': ' . $recipients->count() . ' recipients');

            if ($recipients->isEmpty()) {
                Log::warning('Lớp ' . $class->name . ' không có học sinh!');
                return redirect()->back()->with('error', 'Lớp này chưa có học sinh nào để gửi thông báo.');
            }
        } else {
            abort(403, 'Chỉ admin và teacher mới gửi được thông báo.');
        }

        //Tạo notifications cho từng recipient
        foreach ($recipients as $recipient) {
            if ($recipient) {  // Đảm bảo không null
                $notification = Notification::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'type' => $request->type,
                    'sender_id' => $sender->id,
                    'recipient_type' => 'App\Models\User',
                    'recipient_id' => $recipient->id,
                    'sent_at' => now(),
                ]);
                if ($notification) {
                    $createdCount++;
                    Log::info('Tạo thành công cho recipient ' . $recipient->id);
                } else {
                    Log::error('Tạo thất bại cho recipient ' . $recipient->id);
                }
            }
        }

        Log::info('Kết thúc: Đã tạo ' . $createdCount . ' notifications');
        return redirect()->back()->with('success', 'Đã gửi thông báo thành công cho ' . $createdCount . ' người nhận.');
    }

    public function history()
    {
        if (in_array(Auth::user()->role, ['admin', 'teacher'])) {
            $sentNotifications = Notification::where('sender_id', Auth::id())->orderBy('sent_at', 'desc')->get();
        } else {
            $sentNotifications = collect();
        }
        return view('notifications.history', compact('sentNotifications'));
    }

    public function searchRecipients(Request $request)
    {
        $search = $request->search;
        $role = Auth::user()->role === 'admin' ? ['teacher', 'student'] : 'student';
        $results = User::whereIn('role', (array) $role)->where('email', 'like', '%' . $search . '%')->get(['id', 'email']);

        return response()->json($results);
    }
}
