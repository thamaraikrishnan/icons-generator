<?php
namespace Icons;

use Icons\Exception\Exception;

interface IconsGenerator
{
    /**
     * @param string $filepath Filepath to file to generate icons, it will be overwrite if ticons succeed
     * @return void
     * @throws Exception
     */
    public function generateIcons($imageArrayList, $file, $transparencyFlag = false);
}
?>