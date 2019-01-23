<?php

namespace App\Helpers;

class ObjectUtils
{
    /**
     * 
     * @param Entity $obj
     * @param array $data
     * @param string[] $exclude
     * @return Entity
     */
    public function initialize($obj, $data, array $exclude = [])
    {
        foreach ($data as $key => $value)
        {
            if (!in_array($key, $exclude))
            {
                $functionName = 'set' . ucfirst($key);
                if (method_exists($obj, $functionName))
                {
                    $obj->$functionName($value);
                }
            }
        }
        return $obj;
    }
}
