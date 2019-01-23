<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class FilesNormalizer implements NormalizerInterface
{

    use SerializerAwareTrait;

    /**
     * @var DenormalizerInterface|NormalizerInterface
     */
    private $normalizer;

    /**
     *
     * @var Array
     */
    private $uploadbleFiles;

    /**
     * UserNormalizer constructor.
     * @param NormalizerInterface $normalizer
     */
    public function __construct(NormalizerInterface $normalizer)
    {
        if (!$normalizer instanceof DenormalizerInterface)
        {
            throw new \InvalidArgumentException('The normalizer must implement the DenormalizerInterface');
        }
        $this->normalizer = $normalizer;
        $this->uploadbleFiles = explode(",", str_replace(" ", "", getenv("UPLOADBLE_FILES")));
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $result = $this->normalizer->normalize($object, $format, $context);
        $base_url = getenv("BASE_URL");
        if ('json' !== $format || !is_array($result))
        {
            return $result;
        }
        foreach ($this->uploadbleFiles as $field)
        {
            if (isset($result[$field]) && !preg_match('/http:|https:/', $result[$field]))
            {
                $classNameArr = explode("\\", get_class($object));
                $className = $classNameArr[count($classNameArr) - 1];
                //get folder
                $folder = getenv(strtoupper("APP_" . $field . "_" . $className));
                //not has a specific folder, use default
                if (!$folder)
                {
                    $folder = getenv(strtoupper("APP_" . $field . "s"));
                }
                $result[$field] = join(
                        [
                    $base_url .
                    $folder,
                    $result[$field],
                        ], '/'
                );
            }
        }
        return $result;
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        if ($format == "json")
        {
            if ($this->uploadbleFiles && count($this->uploadbleFiles))
            {
                //die(var_dump($format,$this->uploadbleFiles));
                foreach ($this->uploadbleFiles as $field)
                {
                    if (method_exists($data, "get" . ucfirst($field)))
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}
