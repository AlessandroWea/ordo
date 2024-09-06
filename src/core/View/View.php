<?php

namespace Ordo\View;

use Ordo\View\ViewInterface;

class View implements ViewInterface
{
    static public string $layout = 'default.php';
    static public string $layoutFolder = APP_LAYOUT_FOULDER;
    static public string $viewsFolder = APP_VIEWS_FOLDER;

    public function render($path, $vars = [])
    {
		if($vars)
			extract($vars);

		$fullpath = self::$viewsFolder . $path;
		if(file_exists($fullpath))
		{
			ob_start();

			require $fullpath;
			$content = ob_get_clean();
			require self::$layoutFolder . self::$layout;
            $ret = ob_get_clean();
		}
		else
		{
			echo 'File: ' . $fullpath . ' was not found!';
		}

        echo $ret;
    }
}