<?php
namespace GlowGaia\Grabbit;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Collection;

class Grabbit extends Factory{
    private $it;

    public $gaia_sid;

    public function __construct(Dispatcher $dispatcher = null)
    {
        parent::__construct($dispatcher);

        //Some requests want a Gaia session ID, but don't seem to care whether it's still valid or not.
        $this->gaia_sid = 'nyls9ps8sy6494b6dc251b60a5afxqadufme6kq8b5u9l2i9';
    }

    /**
     * @param $toCollection - Object or array that will (recursively) be turned into a collection
     * @return Collection
     */
    private function recursive($toCollection){
        return $toCollection->map(function ($part){
            if(is_array($part) || is_object($part)){
                return $this->recursive(collect($part));
            }

            return $part;
        });
    }

    /**
     * @param $method - Method number. Ex: 102
     * @param $parameters - Parameters for the method call. Ex: "Lanzer"
     * @return string
     */
    private function buildMethod($method, $parameters = []){
        $parameters = collect($parameters)->escapeWhenCastingToString(false);

        return "[{$method},{$parameters}]";
    }

    /**
     * @return string
     */
    private function generateMethodUrl(){
        $methods = collect($this->it)->escapeWhenCastingToString(false);

        $methods = $methods->implode(',');

        return "[{$methods}]";
    }

    /**
     * @param $method - The method we're requesting. Ex: 102
     * @param $parameters - The parameters we're providing. Ex: "Lanzer"
     * @return $this
     */
    public function it($method, $parameters){
        $this->it = $this->buildMethod($method, $parameters);

        return $this;
    }

    /**
     * @return Collection - A collection equivalent to the JSON returned by Gaia's GSI
     */
    public function grab(){
        $url = 'https://www.gaiaonline.com/chat/gsi/index.php';

        $response = $this::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie' => "gaia55_sid={$this->gaia_sid}",
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