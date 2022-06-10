<?php

namespace App\Providers;

use App\Models\DanhMucSanPham;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $menuCha = DanhMucSanPham::where('id_danh_muc_cha', 0)
                                 ->where('is_open', 1)
                                 ->get();
        $menuCon = DanhMucSanPham::where('id_danh_muc_cha', '<>', 0)
                                 ->where('is_open', 1)
                                 ->get();

        foreach($menuCha as $key => $value_cha) {
            $value_cha->tmp = $value_cha->id;
            foreach($menuCon as $key => $value_con) {
                if($value_con->id_danh_muc_cha == $value_cha->id) {
                    $value_cha->tmp =  $value_cha->tmp . ', ' . $value_con->id;
                }
            }
        }

        view()->share('menuCha', $menuCha);
        view()->share('menuCon', $menuCon);
    }
}
