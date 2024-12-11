<?php
namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckWorkingShift
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user) {
            if ($user->role == '1') {
                $workShift = $user->workShift;
                $now = Carbon::now();

                $startTime = Carbon::createFromFormat('H:i:s', $workShift->start_time);
                $endTime = Carbon::createFromFormat('H:i:s', $workShift->end_time);

                // Xử lý ca làm việc qua đêm (ví dụ: 18:00 - 00:00 hoặc 22:00 - 06:00)
                if ($endTime->lessThan($startTime)) {
                    if ($now->between($startTime, Carbon::createFromTime(23, 59, 59)) || $now->between(Carbon::createFromTime(0, 0, 0), $endTime)) {
                        return $next($request);
                    }
                } else {
                    // Xử lý ca làm việc trong cùng một ngày (ví dụ: 08:00 - 17:00)
                    if ($now->between($startTime, $endTime)) {
                        return $next($request);
                    }
                }
                Auth::logout();
                return redirect()->route('admin.loginForm')->with('warning', 'Bạn chỉ có thể đăng nhập trong giờ làm việc.');
            }

            return $next($request);
        }

        return redirect()->route('admin.loginForm')->with('warning', 'Bạn cần đăng nhập để truy cập.');
    }

}
