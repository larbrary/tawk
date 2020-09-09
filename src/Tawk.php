<?php

namespace Larbrary\Tawk;

class Tawk
{
    /**
     * Return the full tawk js snippet.
     *
     * @return string
     */
    public static function snippet()
    {
        return '<script type="text/javascript">' . self::js() . '</script>';
    }

    /**
     * Return the tawk js code.
     *
     * @return string
     */
    public static function js() {
        $property_id = config('tawk.property_id');
        $chat_id = config('tawk.chat_id');
        $api_key = config('tawk.api_key');

        $js_code =
            'var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();';
        if ($api_key && auth()->check()) {
            $js_code .=
                'Tawk_API.visitor = {' .
                'name: "' . auth()->user()->name . '",' .
                'email: "' . auth()->user()->email . '",' .
                'hash: "' . hash_hmac("sha256", auth()->user()->email, $api_key) . '"' .
                '};';
        }
        $js_code .=
            '(function(){' .
            'var s1=document.createElement("script"),' .
            's0=document.getElementsByTagName("script")[0];' .
            's1.async=true;' .
            's1.src="https://embed.tawk.to/' . $property_id . '/' . $chat_id . '";' .
            's1.charset="UTF-8";' .
            's1.setAttribute("crossorigin","*");' .
            's0.parentNode.insertBefore(s1,s0);'.
            '})();';

        return $js_code;
    }
}
