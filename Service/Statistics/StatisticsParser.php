<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\Statistics;

use KGzocha\ArduinoBundle\Service\FormHandler\Statistics\StatisticsFormHanlderInterface;
use KGzocha\ArduinoBundle\Service\Statistics\Model\Variable2D;
use KGzocha\ArduinoBundle\Service\Statistics\Parsers\StatisticParserInterface;

class StatisticsParser
{
    /**
     * @var StatisticsGiverInterface
     */
    protected $statisticsGiver;

    /**
     * @var array
     */
    protected $parsers;

    public function __construct(StatisticsGiverInterface $statisticsGiver)
    {
        $this->statisticsGiver = $statisticsGiver;
    }

    /**
     * @param StatisticsFormHanlderInterface $handler
     *
     * @return array
     */
    public function getStatisticsFromHandler(StatisticsFormHanlderInterface $handler)
    {
        return $this->getStatistics(
            $handler->getStatisticsEntityName(),
            $handler->getId(),
            $handler->getDateFrom(),
            $handler->getDateTo()
        );
    }

    /**
     * @param mixed     $entity
     * @param int       $id
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return array
     */
    public function getStatistics($entity, $id, \DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $result = '';
        foreach ($this->statisticsGiver->giveStatistics($entity, $id, $dateFrom, $dateTo) as $variable) {

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
