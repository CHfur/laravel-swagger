<?php

namespace RonasIT\Support\AutoDoc\DataCollectors;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use RonasIT\Support\AutoDoc\Interfaces\DataCollectorInterface;
use RonasIT\Support\AutoDoc\Exceptions\MissedProductionFilePathException;

class LocalDataCollector implements DataCollectorInterface
{
    public $prodFilePath;

    protected static $data;

    /**
     * @throws MissedProductionFilePathException
     */
    public function __construct()
    {
        $this->prodFilePath = config('local-data-collector.production_path');

        if (empty($this->prodFilePath)) {
            throw new MissedProductionFilePathException();
        }
    }

    public function saveTmpData(array $tempData)
    {
        self::$data = $tempData;
    }

    public function getTmpData()
    {
        return self::$data;
    }

    public function saveData()
    {
        $content = json_encode(self::$data);

        file_put_contents($this->prodFilePath, $content);

        self::$data = [];
    }

    /**
     * @throws FileNotFoundException
     */
    public function getDocumentation()
    {
        if (!file_exists($this->prodFilePath)) {
            throw new FileNotFoundException();
        }

        $fileContent = file_get_contents($this->prodFilePath);

        return json_decode($fileContent);
    }
}
