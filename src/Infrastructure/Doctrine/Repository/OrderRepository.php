<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\Order;
use App\Domain\Model\OrderInterface;
use App\Domain\Repository\OrderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    const ALIAS = 'o';

    private $queryBuilder;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);

        $this->queryBuilder = $this->createQueryBuilder(self::ALIAS);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OrderInterface $order): void
    {
        $this->_em->persist($order);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(OrderInterface $order): void
    {
        $this->_em->remove($order);
    }

    public function queryPaginated(int $page, int $pageSize): OrderRepositoryInterface
    {
        $offset = $page * $pageSize;

        $this->queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($pageSize);

        return $this;
    }

    public function querySortBy($column = 'id', $sort = 'DESC'): OrderRepositoryInterface
    {
        $this->queryBuilder->orderBy(
            sprintf('%s.%s',self::ALIAS, $column),
            $sort
        );

        return $this;
    }

    public function findOrders(): array
    {
        return $this->queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function flush()
    {
        $this->_em->flush();
    }

    public function findOrderById($orderId): ?OrderInterface
    {
        return $this->find($orderId);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getLastOrderId(): int
    {
        $result = $this->createQueryBuilder(self::ALIAS)
                ->select(sprintf('MAX(%s.id)', self::ALIAS))
                ->getQuery()
                ->getSingleScalarResult();

        return $result ? (int) $result : 0;
    }

    public function queryByCustomerName($customerName): OrderRepositoryInterface
    {
        if (empty($customerName)) {
            return $this;
        }

        $this->queryBuilder
            ->andWhere(sprintf('%s.customer like :customerName', self::ALIAS))
            ->setParameter('customerName', '%' . trim($customerName) . '%');

        return $this;
    }

    public function queryOrderByStatus($orderStatus): OrderRepositoryInterface
    {
        if (empty($orderStatus)) {
            return $this;
        }

        $this->queryBuilder
            ->andWhere(sprintf('%s.orderStatus = :orderStatus', self::ALIAS))
            ->setParameter('orderStatus', $orderStatus);

        return $this;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getTotalOrders(): int
    {
        $queryBuilder = clone $this->queryBuilder;

        return $queryBuilder
            ->select(sprintf('COUNT(%s.id)', self::ALIAS))
            ->getQuery()
            ->getSingleScalarResult();
    }
}
