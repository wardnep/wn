<?php

namespace App\Http\Controllers\CVM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CVM\Notification;
use App\Models\CVM\NotificationReleaseSaleLog;
use App\Models\CVM\SendToNotification;

class CvmController extends Controller
{
    public function index()
    {
        $send_to_notifications = SendToNotification::join('notifications', 'notifications.id', '=', 'send_to_notifications.notifications_id')
            ->join('log_contact_excels', 'log_contact_excels.id', '=', 'notifications.log_contact_excels_id')
            ->whereIn('log_contact_excels.contact_excels_id', [466464, 466467, 466469, 466472, 466473, 466476, 466499, 466502, 466479, 466480, 466490, 466492, 466481, 466482, 466493, 466483, 466484, 466489, 466494, 466491, 466496, 466501, 466497, 466506, 466509, 466513, 466515, 466519, 466521, 466525, 466526, 466529, 466533, 466542, 466549, 466552, 466554, 466557, 466560, 466524, 466527]);

        $notifications = Notification::join('log_contact_excels', 'log_contact_excels.id', '=', 'notifications.log_contact_excels_id')
            ->whereIn('log_contact_excels.contact_excels_id', [466464, 466467, 466469, 466472, 466473, 466476, 466499, 466502, 466479, 466480, 466490, 466492, 466481, 466482, 466493, 466483, 466484, 466489, 466494, 466491, 466496, 466501, 466497, 466506, 466509, 466513, 466515, 466519, 466521, 466525, 466526, 466529, 466533, 466542, 466549, 466552, 466554, 466557, 466560, 466524, 466527]);

        $logs = NotificationReleaseSaleLog::whereIn('contact_excels_id', [466464, 466467, 466469, 466472, 466473, 466476, 466499, 466502, 466479, 466480, 466490, 466492, 466481, 466482, 466493, 466483, 466484, 466489, 466494, 466491, 466496, 466501, 466497, 466506, 466509, 466513, 466515, 466519, 466521, 466525, 466526, 466529, 466533, 466542, 466549, 466552, 466554, 466557, 466560, 466524, 466527]);

        dd($send_to_notifications->count(), $notifications->count(), $logs->count());

        $send_to_notifications->delete();
        $notifications->delete();
        $logs->delete();

        dd('Done!');
    }
}
