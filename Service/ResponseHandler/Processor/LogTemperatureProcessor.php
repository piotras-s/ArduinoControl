<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler\Processor;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\TemperatureLog;
use KGzocha\ArduinoBundle\Entity\Thermometer;

class LogTemperatureProcessor implements ProcessorInterface
{

    const NEW_THERMOMETER_NAME = 'Unidentified thermometer %d.';

    /**
     * This processor will search for this pattern in arduino response string
     * @var string
     */
    protected $tempFormat;

    /**
     * @var int
     */
    protected $thermometerPlaceInFormat;

    /**
     * @var int
     */
    protected $tempValuePlaceInFormat;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $unidentifiedThermometerName;

    public function __construct(
        EntityManager $entityManager, $tempFormat,
        $thermometerPlaceInFormat = 1, $tempValuePlaceInFormat = 2,
        $unindetifiedThermometerName = self::NEW_THERMOMETER_NAME)
    {
        $this->entityManager = $entityManager;
        $this->tempFormat = $tempFormat;
        $this->thermometerPlaceInFormat = $thermometerPlaceInFormat;
        $this->tempValuePlaceInFormat = $tempValuePlaceInFormat;
        $this->unidentifiedThermometerName = $unindetifiedThermometerName;
    }

    /**
     * @param $text
     */
    public function process(&$text)
    {
        foreach (preg_split('/\n/', $text) as $line) {
            $tempLog = (new TemperatureLog())
                ->setDate(new \DateTime())
                ->setValue($this->extractTempValue($line))
                ->setThermometer(
                    $this->getThermometerBySystemId($this->extractThermometer($line))
                );

            $this->entityManager->persist($tempLog);
        }

        $this->entityManager->flush();
    }

    /**
     * @param $text
     *
     * @return int
     */
    public function supports(&$text)
    {
        return preg_match($this->tempFormat, $text);
    }

    /**
     * @param $text
     *
     * @return null
     * @throws ProcessorException
     */
    protected function extractTempValue($text)
    {
        if (null !== ($result = $this->extract($text, $this->tempValuePlaceInFormat))) {
            return $result;
        }

        throw new ProcessorException("There is no temp value in given text");
    }

    /**
     * @param $text
     *
     * @return null
     * @throws ProcessorException
     */
    protected function extractThermometer($text)
    {
        if (null !== ($result = $this->extract($text, $this->thermometerPlaceInFormat))) {
            return $result;
        }

        throw new ProcessorException("There is no termometer number in given text");
    }

    /**
     * @param $text
     * @param $number
     *
     * @return mixed|null
     */
    protected function extract($text, $number)
    {
        $matches = array();
        preg_match($this->tempFormat, $text, $matches);

        if (array_key_exists($number, $matches)) {
            return $matches[$number];
        }

        return null;
    }

    /**
     * @param $systemId
     *
     * @return Thermometer
     */
    protected function getThermometerBySystemId($systemId)
    {
        $thermometer = $this->entityManager->getRepository('ArduinoBundle:Thermometer')->findOneBy(
            array(
                'systemId' => $systemId,
            )
        );
        if (!$thermometer) {
            $thermometer = (new Thermometer())
                ->setSystemId($systemId)
                ->setName(sprintf($this->unidentifiedThermometerName, $systemId));
            $this->entityManager->persist($thermometer);
            $this->entityManager->flush();
        }

        return $thermometer;
    }

}
