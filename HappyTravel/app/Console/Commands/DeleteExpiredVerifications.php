<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailVerification;

class DeleteExpiredVerifications extends Command
{
    protected $signature = 'verification:cleanup';
    protected $description = '만료된 이메일 인증을 삭제합니다';

    public function handle()
    {
        EmailVerification::where('expires_at', '<', now())->delete();
        $this->info('만료된 인증이 성공적으로 삭제되었습니다.');
    }
}
