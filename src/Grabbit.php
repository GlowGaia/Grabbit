<?php
namespace GlowGaia\Grabbit;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\Factory;

class Grabbit extends Factory{

    public function __construct(Dispatcher $dispatcher = null)
    {
        parent::__construct($dispatcher);
    }

    private $it;
    private function buildMethod($method, $parameters = []){
        $parameters = collect($parameters)->escapeWhenCastingToString(false);

        return "[{$method},{$parameters}]";
    }
    private function recursive($value){
        return $value->map(function ($value) {
            if (is_array($value) || is_object($value)) {
                return $this->recursive(collect($value));
            }

            return $value;
        });
    }
    protected function generateMethodUrl(){
        $methods = collect($this->it)->escapeWhenCastingToString(false);

        $methods = $methods->implode(',');

        return "[{$methods}]";
    }
    public function it($method, $parameters){
        $this->it = $this->buildMethod($method, $parameters);

        return $this;
    }
    public function grab(){
        $url = 'https://www.gaiaonline.com/chat/gsi/index.php';

        $response = $this::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie' => 'gaia55_sid=nyls9ps8sy6494b6dc251b60a5afxqadufme6kq8b5u9l2i9',
        ])->asForm()->post($url, [
            'v' => 'json',
            'X' => time(),
            'm' => $this->generateMethodUrl(),
        ]);

        return $this->recursive(collect($response->json()))->map(function ($item){
            return $item->get(2);
        });
    }
}