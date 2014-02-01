<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler\Processor;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\BooleanParameter;
use KGzocha\ArduinoBundle\Entity\BooleanParameterLog;

class LogBoolParametersProcessor implements ProcessorInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $responseFormat;

    /**
     * @var string
     */
    protected $defaultParamName;

    /**
     * @param EntityManager $entityManager
     * @param string        $responseFormat
     */
    public function __construct(EntityManager $entityManager, $responseFormat)
    {
        $this->entityManager = $entityManager;
        $this->responseFormat = $responseFormat;
    }

    /**
     * @param $text
     * @throws ProcessorException
     */
    public function process(&$text)
    {
        foreach (preg_split('/\n/', $text) as $line) {
            if ($this->supports($line)) {
                $params = $this->extractParams($line);

                for ($i=1; $i<=strlen($params); $i++) {
                    $boolParamLog = (new BooleanParameterLog())
                        ->setDate()
                        ->setValue($params[$i-1])
                        ->setBooleanParameter(
                            $this->getBoolParamBySystemId($i)
                        );

                    $this->entityManager->persist($boolParamLog);
                }

                try {
                    $this->entityManager->flush();
                } catch (DBALException $exception) {
                    throw new ProcessorException('Cant save bool parameter logs.',
                        500,
                        $exception
                    );
                }
            }
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
     * @param $defaultName
     */
    public function setDefaultParameterName($defaultName)
    {
        $this->defaultParamName = $defaultName;
    }

    /**
     * @param $systemId
     *
     * @return \KGzocha\ArduinoBundle\Entity\BooleanParameter
     */
    protected function getBoolParamBySystemId($systemId)
    {
        $param = $this->entityManager
            ->getRepository('ArduinoBundle:BooleanParameter')
            ->findOneBy(array(
                'systemId' => $systemId,
            ));

        if (!$param) {
            return (new BooleanParameter())
                ->setSystemId($systemId)
                ->setName(
                    sprintf($this->defaultParamName, $systemId)
                );
        }

        return $param;
    }

    /**
     * @param $line
     *
     * @return string
     */
    protected function extractParams($line)
    {
        $matches = array();
        preg_match($this->responseFormat, $line, $matches);

        return $matches[1];
    }
}
