<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\FileManagerDataImport\Business;

use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\FileManagerDataImport\Business\MimeType\MimeTypeExtensionsEncodeStep;
use Spryker\Zed\FileManagerDataImport\Business\MimeType\MimeTypeWriterStep;

/**
 * @method \Spryker\Zed\FileManagerDataImport\FileManagerDataImportConfig getConfig()
 */
class FileManagerDataImportBusinessFactory extends DataImportBusinessFactory
{
    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterAfterImportAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterBeforeImportAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    public function getFileManagerDataImport()
    {
        $dataImporter = $this->getCsvDataImporterFromConfig($this->getConfig()->getFileManagerDataImporterConfiguration());

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep($this->createMimeTypeExtensionsEncodeStep());
        $dataSetStepBroker->addStep($this->createMimeTypeWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    protected function createMimeTypeExtensionsEncodeStep(): DataImportStepInterface
    {
        return new MimeTypeExtensionsEncodeStep(
            $this->getUtilEncodingService(),
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    protected function createMimeTypeWriterStep(): DataImportStepInterface
    {
        return new MimeTypeWriterStep();
    }
}
