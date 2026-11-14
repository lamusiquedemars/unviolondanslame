<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Preserve the account previously privileged by address as an explicit administrator.
        DB::table('users')->whereRaw('LOWER(email) = ?', ['ivo@maracujadigital.fr'])
            ->update(['role' => 'admin', 'is_admin' => true]);
    }

    public function down(): void
    {
        // Do not revoke a role that may have since been assigned deliberately.
    }
};
