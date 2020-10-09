<?php declare(strict_types=1);

namespace MoteqProductInquiry;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\DataAbstractionLayer\Indexing\EntityIndexerRegistry;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class MoteqProductInquiry extends Plugin
{
    public function activate(ActivateContext $activateContext): void
    {
        $registry = $this->container->get(EntityIndexerRegistry::class);
        $registry->sendIndexingMessage(['product.indexer']);
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);
        if ($uninstallContext->keepUserData()){
            return;
        }

        $productUpdateSql = "ALTER TABLE `product` DROP COLUMN `product_inquiries`";
        $dropDbSql = "DROP TABLE IF EXISTS `moteq_product_inquiry`";

        $connection = $this->container->get(Connection::class);

        $connection->executeUpdate($dropDbSql);
        $connection->executeUpdate($productUpdateSql);

    }
}
