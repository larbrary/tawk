<?php

namespace Larbrary\Tawk\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Larbrary\Tawk\TawkServiceProvider;

class TawkTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            TawkServiceProvider::class
        ];
    }

    /** @test */
    public function it_compiles_the_blade_directive()
    {
        $expected =
            'var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();' .
            '(function(){' .
            'var s1=document.createElement("script"),' .
            's0=document.getElementsByTagName("script")[0];' .
            's1.async=true;' .
            's1.src="https://embed.tawk.to/' .

            'XXXXXX' . '/' . 'YYYYYY' .

            '";' .
            's1.charset="UTF-8";' .
            's1.setAttribute("crossorigin","*");' .
            's0.parentNode.insertBefore(s1,s0);'.
            '})();';

        $this->assertEquals(
            '<script type="text/javascript">' . $expected . '</script>',
            resolve('blade.compiler')->compileString('@tawk')
        );
    }

    /** @test */
    public function it_compiles_the_blade_directive_with_api_key_and_authenticated_user()
    {
        $expected =
            'var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();' .
            'Tawk_API.visitor = {' .
            'name: "' . auth()->user()->name . '",' .
            'email: "' . auth()->user()->email . '",' .
            'hash: "' . hash_hmac("sha256", auth()->user()->email, "ZZZZZZZ") . '"' .
            '};' .
            '(function(){' .
            'var s1=document.createElement("script"),' .
            's0=document.getElementsByTagName("script")[0];' .
            's1.async=true;' .
            's1.src="https://embed.tawk.to/' .

            'XXXXXX' . '/' . 'YYYYYY' .

            '";' .
            's1.charset="UTF-8";' .
            's1.setAttribute("crossorigin","*");' .
            's0.parentNode.insertBefore(s1,s0);'.
            '})();';

        $this->assertEquals(
            '<script type="text/javascript">' . $expected . '</script>',
            resolve('blade.compiler')->compileString('@tawk')
        );
    }
}
