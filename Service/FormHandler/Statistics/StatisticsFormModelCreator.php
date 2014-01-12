<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\FormHandler\Statistics;

use Doctrine\ORM\EntityManager;
use KGzocha\ArduinoBundle\Model\StatisticsFormModel;

class StatisticsFormModelCreator
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var int difference between "date from" and "date to" in statistics forms in days
     */
    protected $dateRange;

    public function __construct(EntityManager $entityManager, $dateRange)
    {
        $this->entityManager = $entityManager;
        $this->dateRange = $dateRange;
    }

    /**
     * @param $entityName
     *
     * @return StatisticsFormModel
     */
    public function getModel($entityName = null)
    {
        $model = new StatisticsFormModel();

        if ($entityName) {
            $model->setEntity(
                $this->entityManager
                    ->getRepository($entityName)
                    ->findFirst()
            );
        }

        return $model
            ->setDateFrom(new \DateTime(sprintf('-%d days', $this->dateRange)))
            ->setDateTo((new \DateTime()));
    }

}
