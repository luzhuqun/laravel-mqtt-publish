<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MqttServiceProvider extends ServiceProvider{
    /**
     * 在容器中注册绑定.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app instanceof LumenApplication) {
            $this->app->configure('mqtt');
        } else {
            $this->publishes([
                __DIR__ . '/../../config/mqtt.php' => config_path('mqtt.php'),
            ]);
        }
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/mqtt.php', 'mqtt'
        );

    }

    public function register()
    {
    	$this->app->singleton('Lzq\Mqtt\php_sam', function ($app) {
            return new SAMConnection();
        });
    }
}