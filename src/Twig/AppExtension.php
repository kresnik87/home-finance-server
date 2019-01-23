<?php

// src/Twig/AppExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('env', 'getenv')
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter(
                    'cast_to_array', function ($stdClassObject) {
                        $response = array();
                        foreach ($stdClassObject as $key => $value)
                        {
                            $response[] = array($key, $value);
                        }
                        die(var_dump($stdClassObject));
                        return $response;
                    }
            )
        ];
    }

}
