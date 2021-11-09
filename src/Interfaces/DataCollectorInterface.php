<?php

namespace RonasIT\Support\AutoDoc\Interfaces;

interface DataCollectorInterface
{
    /**
     * Save temporary data
     *
     * @param array $tempData
     */
    public function saveTmpData(array $tempData);

    /**
     * Get temporary data
     */
    public function getTmpData();

    /**
     * Save production data
     */
    public function saveData();

    /**
     * Get production documentation
     */
    public function getDocumentation();
}


