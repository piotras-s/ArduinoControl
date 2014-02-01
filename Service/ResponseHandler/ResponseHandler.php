<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ResponseHandler;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Entity\ResponseLog;
use KGzocha\ArduinoBundle\Service\ResponseHandler\Processor\ProcessorException;
use KGzocha\ArduinoBundle\Service\ResponseHandler\Processor\ProcessorInterface;
use Psr\Log\LoggerInterface;

class ResponseHandler implements ResponseHandlerInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var array
     */
    protected $processors;

    /**
     * @param EntityManager   $entityManager
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManager $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->processors = array();
    }

    /**
     * @param $response
     * @param $query
     * @param $time
     */
    public function handle(&$response, $query = null, $time = null)
    {
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
                try {
                    $processor->process($response);
                } catch (ProcessorException $exception) {
                    $this->logger->error($exception->getMessage());
                }
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
