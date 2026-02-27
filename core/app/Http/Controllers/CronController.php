<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\Batch;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\EmailHistory;
use App\Models\SmsHistory;
use Carbon\Carbon;

class CronController extends Controller {
    public function cron() {

        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', Status::YES);
        }
        $crons = $crons->get();
        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds($cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->target == 'all') {
            $notify[] = ['success', 'Cron executed successfully'];
            return back()->withNotify($notify);
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }

    }

    public function sentScheduleEmail() {
        $date           = now()->format('Y-m-d H:i') . ':00';
        $scheduleEmails = EmailHistory::where('status', Status::SCHEDULED)->whereNotNull('schedule')->where('schedule', '<=', $date)->orderBy('last_cron')->take(100)->get();
        foreach ($scheduleEmails as $scheduleEmail) {
            $batch = Batch::where('id', $scheduleEmail->batch_id)->first();
            $user  = [
                'username' => $scheduleEmail->email,
                'email'    => $scheduleEmail->email,
                'fullname' => $scheduleEmail->email,
            ];
            notify($user, "DEFAULT", [
                'subject' => $scheduleEmail->subject,
                'message' => $scheduleEmail->message,
            ], ['email'], false);

            if (session()->has('mail_error')) {
                $scheduleEmail->status      = 9;
                $scheduleEmail->fail_reason = session()->get('mail_error');
                session()->forget('mail_error');
                $batch->total_fail++;
            } else {
                $scheduleEmail->status = 1;
                $batch->total_success++;
            }
            $scheduleEmail->sent_time = Carbon::now();
            $scheduleEmail->last_cron = time();
            $scheduleEmail->save();
            $batch->status = 1;
            $batch->save();
        }
    }

    public function sentScheduleSms() {

        $date        = now()->format('Y-m-d H:i') . ':00';
        $scheduleSms = SmsHistory::where('status', Status::SCHEDULED)->whereNotNull('schedule')->where('schedule', '<=', $date)->orderBy('last_cron')->take(100)->get();

        foreach ($scheduleSms as $scheduleMessage) {
            $batch = Batch::where('id', $scheduleMessage->batch_id)->first();
            $user  = [
                'username'     => $scheduleMessage->mobile,
                'mobileNumber' => $scheduleMessage->mobile,
                'fullname'     => $scheduleMessage->mobile,
            ];

            notify($user, "DEFAULT", [
                'subject' => $scheduleMessage->subject,
                'message' => $scheduleMessage->message,
            ], ['sms'], false);

            if (session()->has('sms_error')) {
                $scheduleMessage->status      = 9;
                $scheduleMessage->fail_reason = session()->get('sms_error');
                session()->forget('sms_error');
                $batch->total_fail++;
            } else {
                $scheduleMessage->status = Status::COMPLETED;
                $batch->total_success++;
            }
            $scheduleMessage->sent_time = Carbon::now();
            $scheduleMessage->last_cron = time();
            $scheduleMessage->save();
            $batch->status = 1;
            $batch->save();
        }
    }
}
