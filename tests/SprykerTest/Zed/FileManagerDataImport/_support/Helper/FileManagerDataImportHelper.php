<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\FileManagerDataImport\Helper;

use Codeception\Module;
use Orm\Zed\FileManager\Persistence\SpyMimeTypeQuery;

class FileManagerDataImportHelper extends Module
{
    public function ensureDatabaseTableIsEmpty(): void
    {
        $this->getMimeTypeQuery()->deleteAll();
    }

    public function assertDatabaseTableContainsData(): void
    {
        $mimeTypeQuery = $this->getMimeTypeQuery();
        $this->assertTrue(($mimeTypeQuery->count() > 0), 'Expected at least one entry in the database table but database table is empty.');
    }

    protected function getMimeTypeQuery(): SpyMimeTypeQuery
    {
        return SpyMimeTypeQuery::create();
    }
}
