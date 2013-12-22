<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\ResponseLog;
use KGzocha\ArduinoBundle\Service\ResponseHandler\Processor\ProcessorInterface;

class ResponseHandler implements ResponseHandlerInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected $processors;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->processors = array();
    }

    /**
     * @param $response
     * @param $query
     * @param $time
     *
     * @throws ResponseHandlerException
     */
    public function handle(&$response, $query = null, $time = null)
    {
        if (!is_string($response)) {
            throw new ResponseHandlerException("Response should be a string");
        }

        $this->process($response);

        $responseLog = new ResponseLog();
        $responseLog->setDate(new \DateTime());
        $responseLog->setResponse($response);
        if ($query) {
            $responseLog->setQuery($query);
        }
        if ($time) {
            $responseLog->setTime($time);
        }
        $this->entityManager->persist($responseLog);
        $this->entityManager->flush();
    }

    /**
     * @param $response
     */
    protected function process(&$response)
    {
        /** @var ProcessorInterface $processor */
        foreach ($this->processors as $processor) {
            if ($processor->supports($response)) {
                $processor->process($response);
            }
        }
    }

    /**
     * @param ProcessorInterface $processor
     */
    public function addProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
    }

}
