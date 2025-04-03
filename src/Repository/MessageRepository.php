<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function getConversation(User $user1, User $user2): array
    {
        return $this->createQueryBuilder('m')
            ->where('(m.user_message = :user1 AND m.receiver = :user2)')
            ->orWhere('(m.user_message = :user2 AND m.receiver = :user1)')
            ->setParameter('user1', $user1)
            ->setParameter('user2', $user2)
            ->orderBy('m.created_at', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findConversationUsers(User $user): array
{
    return $this->createQueryBuilder('m')
        ->select('m')
        ->join('m.receiver', 'r')
        ->where('m.user_message = :user OR m.receiver = :user')
        ->setParameter('user', $user)
        ->orderBy('m.created_at', 'ASC')
        ->groupBy('r.id')
        ->getQuery()
        ->getResult();
}

    
    //    /**
    //     * @return Message[] Returns an array of Message objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Message
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
