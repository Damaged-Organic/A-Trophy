<?php
// ATrophy/Service/DataTransform.php
namespace ATrophy\Service;

class DataTransform
{
    public function transform(array $input_array, $transform_function)
    {
        if( !is_callable($transform_function) ) {
            throw new \InvalidArgumentException("Second parameter should be callable transform function");
        }

        return $transform_function($input_array);
    }
}