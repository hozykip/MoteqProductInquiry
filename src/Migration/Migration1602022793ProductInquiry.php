<?php declare(strict_types=1);

namespace MoteqProductInquiry\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\InheritanceUpdaterTrait;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1602022793ProductInquiry extends MigrationStep
{
    use InheritanceUpdaterTrait;

    public function getCreationTimestamp(): int
    {
        return 1602022793;
    }

    public function update(Connection $connection): void
    {

        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `moteq_product_inquiry` (
              `id` BINARY(16) NOT NULL,
              `product_id` BINARY(16) NOT NULL,
              `product_version_id` BINARY(16) NOT NULL,
              `email` VARCHAR (255) NOT NULL,
              `inquiry` LONGTEXT NOT NULL,
              `response` LONGTEXT,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`id`),
              CONSTRAINT `fk.moteq_product_inquiry.product_id__product_version_id` FOREIGN KEY (`product_id`, `product_version_id`)
                REFERENCES `product` (`id`, `version_id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->updateInheritance($connection,'product','product_inquiries');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
