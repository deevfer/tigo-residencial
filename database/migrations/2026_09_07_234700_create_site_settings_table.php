<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Tigo Residencial');
            $table->string('meta_title')->default('Tigo | Plan de Internet Residencial');
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card')->default('summary_large_image');
            $table->string('header_logo')->default('site-settings/tigo-logo-white.svg');
            $table->string('header_logo_alt')->default('Tigo');
            $table->string('banner_image')->default('site-settings/banner-tigo-residencial.jpeg');
            $table->string('banner_alt')->default('Planes de Internet y TV sin contrato desde 100 megas hasta 500 megas con paquete Tigo 5GB');
            $table->string('banner_caption')->nullable();
            $table->string('headline_prefix')->default('Adquiere un');
            $table->string('headline_highlight')->default("Plan de Internet\nResidencial desde\n100 megas");
            $table->string('headline_suffix')->default('Sin salir de casa');
            $table->string('form_heading')->default('Ingresa tus datos para ser contactado');
            $table->string('name_label')->default('Nombre y apellido');
            $table->string('name_placeholder')->default('Nombre y apellido');
            $table->string('phone_label')->default('Numero de telefono');
            $table->string('phone_placeholder')->default('Ej: 4000 1234');
            $table->string('call_button_text')->default('Quiero que me llamen');
            $table->string('microcopy')->default('Un asesor te llama en minutos. Sin costo ni compromiso');
            $table->string('whatsapp_button_text')->default('Contratar por WhatsApp');
            $table->string('whatsapp_url')->default('https://api.whatsapp.com/send/?phone=50224280000&text=Quiero%20adquirir%20un%20producto%20Residencial');
            $table->text('google_tag_id')->nullable();
            $table->text('google_analytics_id')->nullable();
            $table->text('facebook_pixel_id')->nullable();
            $table->longText('head_scripts')->nullable();
            $table->longText('body_start_scripts')->nullable();
            $table->boolean('zapier_enabled')->default(false);
            $table->string('zapier_webhook_url')->nullable();
            $table->string('zapier_secret')->nullable();
            $table->string('footer_line_1')->default('Todos los derechos reservados 2026');
            $table->string('footer_line_2')->default('Privacidad - Legal y Regulatorio');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('site_settings')->insert([
            'site_name' => 'Tigo Residencial',
            'meta_title' => 'Tigo | Plan de Internet Residencial',
            'meta_description' => 'Adquiere un plan de Internet residencial Tigo desde 100 megas sin salir de casa.',
            'meta_keywords' => 'Tigo, Internet residencial, planes de internet, Guatemala, internet hogar',
            'robots_index' => true,
            'robots_follow' => true,
            'twitter_card' => 'summary_large_image',
            'header_logo' => 'site-settings/tigo-logo-white.svg',
            'header_logo_alt' => 'Tigo',
            'banner_image' => 'site-settings/banner-tigo-residencial.jpeg',
            'banner_alt' => 'Planes de Internet y TV sin contrato desde 100 megas hasta 500 megas con paquete Tigo 5GB',
            'headline_prefix' => 'Adquiere un',
            'headline_highlight' => "Plan de Internet\nResidencial desde\n100 megas",
            'headline_suffix' => 'Sin salir de casa',
            'form_heading' => 'Ingresa tus datos para ser contactado',
            'name_label' => 'Nombre y apellido',
            'name_placeholder' => 'Nombre y apellido',
            'phone_label' => 'Numero de telefono',
            'phone_placeholder' => 'Ej: 4000 1234',
            'call_button_text' => 'Quiero que me llamen',
            'microcopy' => 'Un asesor te llama en minutos. Sin costo ni compromiso',
            'whatsapp_button_text' => 'Contratar por WhatsApp',
            'whatsapp_url' => 'https://api.whatsapp.com/send/?phone=50224280000&text=Quiero%20adquirir%20un%20producto%20Residencial',
            'zapier_enabled' => false,
            'footer_line_1' => 'Todos los derechos reservados 2026',
            'footer_line_2' => 'Privacidad - Legal y Regulatorio',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
