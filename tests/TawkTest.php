<?php

namespace Larbrary\Tawk\Tests;

use Orchestra\Testbench\TestCase;
use Larbrary\Tawk\TawkServiceProvider;

class TawkTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TawkServiceProvider::class
        ];
    }

    /** @test */
    public function it_compiles_the_blade_directive()
    {
        $string = "@tawk";
        $compiled = resolve('blade.compiler')->compileString($string);

        $property_id = config('tawk.property_id');
        $chat_id = config('tawk.chat_id');
        $api_key = config('tawk.api_key');

        $expected =
            'var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();';
        if ($api_key && auth()->check()) {
            $js_code .=
                'Tawk_API.visitor = {' .
                'name: "' . auth()->user()->name . '",' .
                'email: "' . auth()->user()->email . '",' .
                'hash: "' . hash_hmac("sha256", auth()->user()->email, config("tawk.api_key")) . '"' .
                '};';
        }
        $expected .=
            '(function(){' .
            'var s1=document.createElement("script"),' .
            's0=document.getElementsByTagName("script")[0];' .
            's1.async=true;' .
            's1.src="https://embed.tawk.to/' . $property_id . '/' . $chat_id . '";' .
            's1.charset="UTF-8";' .
            's1.setAttribute("crossorigin","*");' .
            's0.parentNode.insertBefore(s1,s0);'.
            '})();';
        $expected = '<script type="text/javascript">' . $expected . '</script>';
        $this->assertEquals($expected, $compiled);
    }
}
