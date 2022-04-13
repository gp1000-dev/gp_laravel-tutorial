<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Folder;
use App\Policies\FolderPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     *  The policy mappings for the application.
     *  機能：ポリシーを AuthServiceProvider に登録する
     *  用途：ポリシーとモデルを紐づける
     *  @var array
     */
    protected $policies = [
        // フィルダーポリシーとフォルダーモデルを紐づける
        Folder::class => FolderPolicy::class,
    ];

    /**
     *  Register any authentication / authorization services.
     *
     *  @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
