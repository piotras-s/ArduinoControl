<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler\Processor;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\Pin;
use KGzocha\ArduinoBundle\Entity\PinStatusLog;

class LogPinStatusProcessor implements ProcessorInterface
{
    const DEFAULT_PIN_NUMBER_PLACE = 1;
    const DEFAULT_PIN_VALUE_PLACE = 2;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    protected $responseFormat;
    protected $pinNumberPlace;
    protected $pinValuePlace;

    public function __construct(
        EntityManager $entityManager,
        $responseFormat,
        $pinNumberPlace = self::DEFAULT_PIN_NUMBER_PLACE,
        $pinValuePlace = self::DEFAULT_PIN_VALUE_PLACE)
    {
        $this->entityManager = $entityManager;
        $this->responseFormat = $responseFormat;
        $this->pinNumberPlace = $pinNumberPlace;
        $this->pinValuePlace = $pinValuePlace;
    }

    /**
     * @param $text
     * @throws ProcessorException
     */
    public function process(&$text)
    {
        foreach (preg_split('/\n/', $text) as $line) {
            if ($this->supports($line)) {
                $pinStatusLog = (new PinStatusLog())
                    ->setDate(new \DateTime())
                    ->setPin(
                        $this->getPinBySystemId($this->extractPinNumber($line))
                    )
                    ->setValue($this->extractValue($line));
                $this->entityManager->persist($pinStatusLog);
            }
        }
        try {
            $this->entityManager->flush();
        } catch (DBALException $exception) {
            throw new ProcessorException('Cant save pin status log.', 500, $exception);
        }
    }

    /**
     * @param $text
     *
     * @return bool
     */
    public function supports(&$text)
    {
        return (bool) preg_match($this->responseFormat, $text);
    }

    /**
     * @param int $pinNumberPlace
     *
     * @return LogPinStatusProcessor
     */
    public function setPinNumberPlace($pinNumberPlace)
    {
        $this->pinNumberPlace = $pinNumberPlace;

        return $this;
    }

    /**
     * @param int $pinValuePlace
     *
     * @return LogPinStatusProcessor
     */
    public function setPinValuePlace($pinValuePlace)
    {
        $this->pinValuePlace = $pinValuePlace;

        return $this;
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
        preg_match($this->responseFormat, $text, $matches);

        if (array_key_exists($number, $matches)) {
            return $matches[$number];
        }

        return null;
    }

    /**
     * @param $text
     *
     * @return mixed|null
     * @throws ProcessorException
     */
    protected function extractPinNumber($text)
    {
        if (null !== ($result = $this->extract($text, $this->pinNumberPlace))) {
            return $result;
        }

        throw new ProcessorException("There is no pin number in given text");
    }

    /**
     * @param $text
     *
     * @return mixed|null
     * @throws ProcessorException
     */
    protected function extractValue($text)
    {
        if (null !== ($result = $this->extract($text, $this->pinValuePlace))) {
            return $result;
        }

        throw new ProcessorException("There is no pin number in given text");
    }

    /**
     * @param $systemId
     *
     * @return Pin
     */
    protected function getPinBySystemId($systemId)
    {
        $pin = $this->entityManager->getRepository('ArduinoBundle:Pin')->findOneBy(
            array(
                'systemId' => $systemId,
            )
        );

        if (!$pin) {
            $pin = (new Pin())->setSystemId($systemId);
            $this->entityManager->persist($pin);
            $this->entityManager->flush();
        }

        return $pin;
    }

}
