<?php

namespace Larbrary\Tawk\Tests;

use Illuminate\Foundation\Auth\User;
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
    public function it_compiles_the_blade_directive_without_the_api_key_and_guest_user()
    {
        $expected =
            'var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();' .
            '(function(){' .
            'var s1=document.createElement("script"),' .
            's0=document.getElementsByTagName("script")[0];' .
            's1.async=true;' .
            's1.src="https://embed.tawk.to/' .
            env('TAWK_TO_PROPERTY_ID') .
            '/' .
            env('TAWK_TO_WIDGET_ID') .
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
        $test_user = new TestUser([
            'name' =>  'Test Name',
            'email' => 'test@email.com'
        ]);

        $this->be($test_user);

        $expected =
            'var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();' .
            'Tawk_API.visitor = {' .
            'name: "' . $test_user['name'] . '",' .
            'email: "' . $test_user['email'] . '",' .
            'hash: "' .
            hash_hmac(
                "sha256",
                $test_user['email'],
                env('TAWK_TO_API_KEY')
            ) .
            '"' .
            '};' .
            '(function(){' .
            'var s1=document.createElement("script"),' .
            's0=document.getElementsByTagName("script")[0];' .
            's1.async=true;' .
            's1.src="https://embed.tawk.to/' .
            env('TAWK_TO_PROPERTY_ID') .
            '/' .
            env('TAWK_TO_WIDGET_ID') .
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



class TestUser extends User {

    protected $fillable = [ 'name', 'email' ];

}
