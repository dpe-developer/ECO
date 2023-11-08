<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\UserSetting;
use App\Models\User;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            [
                'type' => 'company',
                'name' => 'company_logo',
                'value' => 'images/laravel-3d-logo.png',
                'default' => 'images/laravel-3d-logo.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_name',
                'value' => 'Laravel AdminLTE',
                'default' => 'Laravel AdminLTE',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_slogan',
                'value' => '"Lorem ipsum dolor sit amet."',
                'default' => '"Lorem ipsum dolor sit amet."',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_website',
                'value' => 'www.website.com',
                'default' => 'www.website.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_telephone',
                'value' => '1224567890',
                'default' => '1224567890',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_fax',
                'value' => '123345',
                'default' => '123345',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_email',
                'value' => 'company@email.com',
                'default' => 'company@email.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_address_1',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_address_2',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_city',
                'value' => 'Baguio',
                'default' => 'Baguio',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_state',
                'value' => 'Benguet',
                'default' => 'Benguet',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_country',
                'value' => 'Philippines',
                'default' => 'Philippines',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_postal_code',
                'value' => '2600',
                'default' => '2600',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_address_type',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_address_remarks',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'company',
                'name' => 'company_about',
                'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'system',
                'name' => 'users_can_customize_ui',
                'value' => '0',
                'default' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'system',
                'name' => 'send_sms_notification',
                'value' => '0',
                'default' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'system',
                'name' => 'send_email_notification',
                'value' => '0',
                'default' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_darkmode',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_header_fixed',
                'value' => 'layout-navbar-fixed',
                'default' => 'layout-navbar-fixed',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_header_dropdown_legacy_offset',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_header_no_border',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_collapsed',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_fixed',
                'value' => 'layout-fixed',
                'default' => 'layout-fixed',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_mini',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_mini_md',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_mini_xs',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_nav_flat_style',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_nav_legacy_style',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_nav_compact',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_nav_child_indent',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_nav_child_hide_on_collapse',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_disable_hover_focus_auto_expand',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_footer_fixed',
                'value' => 'layout-footer-fixed',
                'default' => 'layout-footer-fixed',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_small_text_body',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_small_text_navbar',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_small_text_brand',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_small_text_sidebar_nav',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_small_text_footer',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_navbar_variant',
                'value' => 'navbar-white navbar-light',
                'default' => 'navbar-white navbar-light',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_accent_color_variant',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_sidebar_variant',
                'value' => 'sidebar-dark-primary',
                'default' => 'sidebar-dark-primary',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'type' => 'ui',
                'name' => 'adminlte_brand_logo_variant',
                'value' => null,
                'default' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);

        foreach (User::get() as $user) {
            foreach (Setting::where('type', '!=', 'system')->where('type', '!=', 'company')->get() as $setting) {
                UserSetting::create([
                    'setting_id' => $setting->id,
                    'user_id' => $user->id,
                    'value' => $setting->default,
                ]);
            }
        }
    }
}