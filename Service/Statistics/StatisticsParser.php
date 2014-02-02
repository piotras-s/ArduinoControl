<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics;

use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormHandlerInterface;
use KGzocha\ArduinoBundle\Service\Statistics\Model\Variable2D;
use KGzocha\ArduinoBundle\Service\Statistics\Parsers\StatisticParserInterface;

class StatisticsParser
{
    /**
     * @var StatisticsProviderInterface
     */
    protected $statisticsProvider;

    /**
     * @var array
     */
    protected $parsers;

    /**
     * @param StatisticsProviderInterface $statisticsGiver
     */
    public function __construct(StatisticsProviderInterface $statisticsGiver)
    {
        $this->statisticsProvider = $statisticsGiver;
    }

    /**
     * @param StatisticsFormHandlerInterface $handler
     *
     * @return array
     */
    public function getStatisticsFromHandler(StatisticsFormHandlerInterface $handler)
    {
        return $this->getStatistics(
            $handler->getStatisticsEntityName(),
            $handler->getId(),
            $handler->getDateFrom(),
            $handler->getDateTo()
        );
    }

    /**
     * @param StatisticsFormHandlerInterface $handler
     *
     * @return string
     */
    public function getSquareWaveStatisticsFromHandler(StatisticsFormHandlerInterface $handler)
    {
        return $this->getSquareWaveStatistics(
            $handler->getStatisticsEntityName(),
            $handler->getId(),
            $handler->getDateFrom(),
            $handler->getDateTo()
        );
    }

    /**
     * @param           $entity
     * @param           $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return string
     */
    public function getStatistics($entity, $id, \DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $result = '';
        foreach ($this->statisticsProvider->giveStatistics($entity, $id, $dateFrom, $dateTo) as $variable) {

            $this->parse($variable);
            $result .= json_encode($variable). ",\n";

        }

        return $result;
    }

    /**
     * @param           $entity
     * @param           $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return string
     */
    public function getSquareWaveStatistics($entity, $id, \DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $result = '';
        foreach ($this->statisticsProvider->giveSquareWaveStatistics($entity, $id, $dateFrom, $dateTo) as $variable) {

            $this->parse($variable);
            $result .= json_encode($variable). ",\n";

        }

        return $result;
    }

    /**
     * @param StatisticParserInterface $parser
     */
    public function addParser(StatisticParserInterface $parser)
    {
        $this->parsers[] = $parser;
    }

    /**
     * @param Variable2D $variable
     */
    protected function parse(Variable2D $variable)
    {
        /** @var StatisticParserInterface $parser */
        foreach ($this->parsers as $parser) {
            if ($parser->support($variable)) {
                $parser->parse($variable);
            }
        }
    }
}
