<?php

namespace SO\Gauthenticator\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 * @package SO\Gauthenticator\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getTable('admin_user');

        $installer->getConnection()->addColumn(
            $table,
            'enable_gauth',
            [
                'type' => Table::TYPE_BOOLEAN,
                'nullable' => false,
                'default' => false,
                'comment' => 'Enable google authenticator'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'google_secret',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Google secret'
            ]
        );
        $installer->endSetup();
    }
}