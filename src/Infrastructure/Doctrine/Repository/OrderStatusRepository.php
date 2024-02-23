<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\OrderStatus;
use App\Domain\Repository\OrderStatusRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderStatus>
 *
 * @method OrderStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderStatus[]    findAll()
 * @method OrderStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderStatusRepository extends ServiceEntityRepository implements OrderStatusRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderStatus::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OrderStatus $entity): void
    {
        $this->_em->persist($entity);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(OrderStatus $entity): void
    {
        $this->_em->remove($entity);
    }

    public function findAllOrderStatus(): array
    {
        return $this->findAll();
    }

    public function findOrderStatusByCode($code): ?OrderStatus
    {
        return $this->findOneBy(['code' => $code]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function flush()
    {
        $this->_em->flush();
    }
}
