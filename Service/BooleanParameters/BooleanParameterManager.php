<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */
namespace KGzocha\ArduinoBundle\Service\BooleanParameters;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\BooleanParameter;
use KGzocha\ArduinoBundle\Entity\BooleanParameterLog;

class BooleanParameterManager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param BooleanParameter $booleanParameter
     *
     * @return BooleanParameterLog
     */
    public function getParametersLastLog(BooleanParameter $booleanParameter)
    {
        return $this->getRepository()->getLastParameterLog($booleanParameter);
    }

    /**
     * @return \KGzocha\ArduinoBundle\Repository\BooleanParameterLogRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository('ArduinoBundle:BooleanParameterLog');
    }
}
